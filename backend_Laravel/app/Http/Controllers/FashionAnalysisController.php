<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HMService;
use App\Services\LykdatService;

class FashionAnalysisController extends Controller
{
    protected $hmService;
    protected $lykdatService;

    public function __construct(HMService $hmService, LykdatService $lykdatService)
    {
        $this->hmService = $hmService;
        $this->lykdatService = $lykdatService;
    }

    public function analyze(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'nullable|image|max:5120', // 5MB max (matches frontend MAX_FILE_SIZE)
            'prompt' => 'required|string|max:1000',
        ]);

        try {
            // Process image if uploaded
            $image = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
            }

            $prompt = $request->input('prompt');
            
            // Get analysis from Lykdat API
            $analysisResult = $this->lykdatService->analyzeImage($image, $prompt);
            
            // Based on analysis, determine if we should return similar items or style analysis
            if (isset($analysisResult['itemType'])) {
                // Search for similar items using H&M API
                $searchResults = $this->hmService->searchProducts($analysisResult['searchQuery'] ?? $prompt);
                
                // Format response to match SimilarItemsResult interface
                $items = collect($searchResults['results'] ?? [])->take(5)->map(function($item) {
                    return [
                        'id' => $item['articleCode'] ?? uniqid(),
                        'name' => $item['name'] ?? 'Product',
                        'description' => $item['description'] ?? 'No description available',
                        'price' => $item['price'] ?? 'Price not available',
                        'image' => $item['images'][0]['url'] ?? '/api/placeholder/300/300',
                        'shopUrl' => $item['linkPdp'] ?? '#',
                    ];
                })->toArray();
                
                return response()->json([
                    'items' => $items
                ]);
            } else {
                // Return style analysis
                $styleAnalysis = [
                    'description' => $analysisResult['styleDescription'] ?? 'Style analysis not available',
                    'recommendations' => $analysisResult['recommendations'] ?? ['No recommendations available'],
                    'alternativeStyles' => $this->getAlternativeStyles($prompt)
                ];
                
                return response()->json($styleAnalysis);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Analysis failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getAlternativeStyles($query)
    {
        // Get alternative style suggestions
        try {
            $searchResults = $this->hmService->searchProducts($query, 1, 3);
            
            return collect($searchResults['results'] ?? [])->take(2)->map(function($item) {
                return [
                    'id' => $item['articleCode'] ?? uniqid(),
                    'name' => $item['name'] ?? 'Style suggestion',
                    'description' => $item['description'] ?? 'Try this alternative style',
                    'image' => $item['images'][0]['url'] ?? '/api/placeholder/100/100',
                ];
            })->toArray();
        } catch (\Exception $e) {
            return [
                [
                    'id' => 'casual1',
                    'name' => 'Casual Weekend Look',
                    'description' => 'For a more relaxed take, pair with white sneakers and a denim jacket',
                    'image' => '/api/placeholder/100/100',
                ],
                [
                    'id' => 'evening1',
                    'name' => 'Evening Elegance',
                    'description' => 'Transform this with statement earrings and strappy heels for evening events',
                    'image' => '/api/placeholder/100/100',
                ]
            ];
        }
    }
}