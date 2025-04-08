<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LykdatService
{
    protected $apiEndpoint;
    protected $apiKey;
    
    public function __construct()
    {
        // Load from env or config
        $this->apiEndpoint = env('LYKDAT_API_ENDPOINT', 'https://cloudapi.lykdat.com/v1/detection/tags');
        $this->apiKey = env('LYKDAT_API_KEY', 'YOUR_LYKDAT_API_KEY');
    }
    
    public function analyzeImage($imageFile = null, $prompt)
    {
        // If we have an image, analyze it with Lykdat API
        if ($imageFile) {
            try {
                $tags = $this->getLykdatImageTags($imageFile);
                
                // Determine if we should return similar items or style analysis based on prompt
                if (preg_match('/(find|similar|like this|matching)/i', $prompt)) {
                    return $this->generateSimilarItemsAnalysis($tags, $prompt);
                } else {
                    return $this->generateStyleAnalysis($tags, $prompt);
                }
            } catch (\Exception $e) {
                //Log::error('Lykdat API error: ' . $e->getMessage());
                // Fall back to text-based analysis
            }
        }
        
        // If no image or API call failed, fall back to prompt-based analysis
        if (preg_match('/(find|similar|like this|matching)/i', $prompt)) {
            return $this->generateSimilarItemsAnalysis(null, $prompt);
        } else {
            return $this->generateStyleAnalysis(null, $prompt);
        }
    }
    
    private function getLykdatImageTags($imageFile)
    {
        // Initialize form data for API request
        $formData = [];
        
        // For local file upload
        if ($imageFile) {
            $formData = [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($imageFile->getPathname(), 'r'),
                        'filename' => $imageFile->getClientOriginalName()
                    ]
                ]
            ];
        }
        
        // Make the API request
        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->post($this->apiEndpoint, $formData);
        
        if (!$response->successful()) {
            throw new \Exception('Failed to get tags from Lykdat API: ' . $response->body());
        }
        
        return $response->json();
    }
    
    private function generateSimilarItemsAnalysis($tags = null, $prompt)
    {
        // Extract item type and color from tags if available
        $itemType = null;
        $color = null;
        
        if ($tags && isset($tags['data'])) {
            // Extract main item type from the labels
            $apparelLabels = array_filter($tags['data']['labels'] ?? [], function($label) {
                return $label['classification'] === 'apparel' && $label['confidence'] > 0.7;
            });
            
            if (!empty($apparelLabels)) {
                $topApparel = array_shift($apparelLabels);
                $itemType = $topApparel['name'];
            }
            
            // Extract main color
            if (!empty($tags['data']['colors'])) {
                $topColor = $tags['data']['colors'][0];
                $color = $topColor['name'];
            }
        }
        
        // If no tags available, extract from prompt
        if (!$itemType) {
            $itemTypes = ['dress', 'shirt', 'pants', 'jacket', 'shoes', 'sweater', 'skirt', 'top', 'jeans'];
            foreach ($itemTypes as $type) {
                if (stripos($prompt, $type) !== false) {
                    $itemType = $type;
                    break;
                }
            }
        }
        
        if (!$color) {
            $colors = ['red', 'blue', 'green', 'black', 'white', 'yellow', 'purple', 'pink', 'brown', 'silver', 'gray', 'orange'];
            foreach ($colors as $c) {
                if (stripos($prompt, $c) !== false) {
                    $color = $c;
                    break;
                }
            }
        }
        
        // Build search query
        $searchQuery = '';
        if ($color) {
            $searchQuery .= $color . ' ';
        }
        
        if ($itemType) {
            $searchQuery .= $itemType;
        } else {
            $searchQuery = trim($prompt);
        }
        
        return [
            'itemType' => $itemType ?? 'clothing',
            'searchQuery' => $searchQuery,
        ];
    }
    
    private function generateStyleAnalysis($tags = null, $prompt)
    {
        // Generate style descriptions based on tags
        $styleDescription = 'This outfit has a modern look with clean lines.';
        $recommendations = [
            'Try accessorizing with minimal jewelry for a clean look.',
            'Adding a belt would help define the silhouette further.',
            'Consider layering with a light jacket for versatility.',
            'This would pair well with ankle boots for a modern edge.',
            'A structured bag would complement this outfit nicely.'
        ];
        
        if ($tags && isset($tags['data'])) {
            // Extract style elements from tags
            $styleElements = [];
            $patternInfo = null;
            $silhouetteInfo = [];
            $colorInfo = [];
            
            // Process labels
            foreach ($tags['data']['labels'] as $label) {
                if ($label['classification'] === 'textile pattern' && $label['confidence'] > 0.7) {
                    $patternInfo = $label['name'];
                }
                
                if ($label['classification'] === 'silhouette' && $label['confidence'] > 0.6) {
                    $silhouetteInfo[] = $label['name'];
                }
                
                if ($label['classification'] === 'length' && $label['confidence'] > 0.6) {
                    $styleElements[] = $label['name'];
                }
            }
            
            // Process colors
            if (!empty($tags['data']['colors'])) {
                foreach (array_slice($tags['data']['colors'], 0, 2) as $color) {
                    $colorInfo[] = $color['name'];
                }
            }
            
            // Build custom style description
            $styleDescription = 'This outfit features ';
            
            if ($patternInfo) {
                $styleDescription .= "a $patternInfo pattern";
            } else {
                $styleDescription .= "a clean design";
            }
            
            if (!empty($colorInfo)) {
                $styleDescription .= " in " . implode(" and ", $colorInfo) . " tones";
            }
            
            if (!empty($silhouetteInfo)) {
                $styleDescription .= " with a " . implode(", ", $silhouetteInfo) . " silhouette";
            }
            
            if (!empty($styleElements)) {
                $styleDescription .= ". Notable elements include " . implode(", ", $styleElements);
            }
            
            $styleDescription .= ". The style can be categorized as contemporary with a balanced aesthetic.";
            
            // Generate custom recommendations based on tags
            $customRecommendations = [];
            
            // Add color-based recommendations
            if (!empty($colorInfo)) {
                $complementaryColors = $this->getComplementaryColors($colorInfo[0]);
                $customRecommendations[] = "Try pairing with $complementaryColors accessories to create a balanced look.";
            }
            
            // Add silhouette-based recommendations
            if (in_array('loose (fit)', $silhouetteInfo)) {
                $customRecommendations[] = "Balance the loose silhouette with fitted accessories or footwear.";
            } elseif (in_array('regular (fit)', $silhouetteInfo)) {
                $customRecommendations[] = "This balanced silhouette pairs well with both statement and subtle accessories.";
            }
            
            if (!empty($customRecommendations)) {
                $recommendations = array_merge($customRecommendations, array_slice($recommendations, 0, 3));
            }
        }
        
        return [
            'styleDescription' => $styleDescription,
            'recommendations' => array_slice($recommendations, 0, rand(3, 5))
        ];
    }
    
    private function getComplementaryColors($color)
    {
        $complementaryColors = [
            'silver' => 'burgundy or navy',
            'black' => 'gold or silver',
            'white' => 'bold color like red or cobalt blue',
            'red' => 'gold or neutral',
            'blue' => 'tan or orange',
            'green' => 'pink or burgundy',
            'yellow' => 'navy or purple',
            'purple' => 'gold or yellow',
            'pink' => 'green or charcoal',
            'brown' => 'turquoise or light blue',
            'gray' => 'lavender or coral',
            'orange' => 'navy or teal',
            'sienna' => 'turquoise or cream',
            'gainsboro' => 'burgundy or forest green',
            'darkgray' => 'blush pink or light yellow',
            'rosybrown' => 'sage green or navy blue'
        ];
        
        return $complementaryColors[$color] ?? "contrasting";
    }
}