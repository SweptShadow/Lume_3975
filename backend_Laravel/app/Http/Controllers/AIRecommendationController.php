<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Services\GithubAIService;
use Illuminate\Support\Facades\Log;

class AIRecommendationController extends Controller
{
    protected $githubAIService;
    
    public function __construct(GithubAIService $githubAIService)
    {
        $this->githubAIService = $githubAIService;
    }
    
=======
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AIRecommendationController extends Controller
{
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
    /**
     * Get AI recommendations for a clothing style
     */
    public function getRecommendations(Request $request)
    {
<<<<<<< HEAD
        // Log that the request has been received
        Log::info('AI recommendation request received');
        
        // Validate the request
        $request->validate([
            'image_base64' => 'required|string',
        ]);
        
        try {
            // Get the base64 image data
            $imageBase64 = $request->input('image_base64');
            
            Log::info('Image base64 data received (length): ' . strlen($imageBase64));
            
            // Get recommendations
            $response = $this->githubAIService->getRecommendations($imageBase64);
            
            Log::info('AI recommendation response: ', [
                'success' => $response['success'],
                'recommendation_id' => $response['recommendation_id'] ?? null,
            ]);
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting AI recommendations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error getting recommendations: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getRecommendationById($id)
    {
        Log::info('Getting recommendation by ID: ' . $id);
        
        try {
            $response = $this->githubAIService->getRecommendationById($id);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting recommendation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error getting recommendation: ' . $e->getMessage()
            ], 500);
        }
    }
    
=======
        Log::info('AI recommendation request received');
        
        try {
            // Get base64 string from request
            $imageBase64 = $request->input('image_base64');
            $prompt = $request->input('prompt', 'Here is a clothing item, can you suggest a few outfit ideas recommend clothing which the same style?');
            
            if (!$imageBase64) {
                return response()->json([
                    'success' => false,
                    'error' => 'Missing image data'
                ], 400);
            }
            
            // For development only: Skip SSL verification
            $httpClient = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . env('GITHUB_AI_KEY', ''),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]);
            
            Log::info('Making API request to GitHub');
            
            // Create a direct API call to GitHub's GPT-4o model
            $response = $httpClient->post('https://api.github.com/copilot/chat/completions', [
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful fashion assistant that provides style recommendations.'
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $prompt
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:image/jpeg;base64,' . $imageBase64
                                ]
                            ]
                        ]
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000
            ]);
            
            Log::info('API response status: ' . $response->status());
            
            if (!$response->successful()) {
                Log::error('API error: ' . $response->body());
                
                // For testing: Return mock data if API fails
                $recommendation = $this->getMockRecommendation();
                
                // Store in database instead of session
                $recommendationId = $this->storeRecommendation($recommendation);
                
                return response()->json([
                    'success' => true,
                    'recommendation_id' => $recommendationId,
                    'message' => 'Mock recommendation generated (API failed)'
                ]);
            }
            
            $responseData = $response->json();
            $recommendation = $responseData['choices'][0]['message']['content'] ?? 'No recommendations available';
            
            // Store in database instead of session
            $recommendationId = $this->storeRecommendation($recommendation);
            
            return response()->json([
                'success' => true,
                'recommendation_id' => $recommendationId,
                'message' => 'Recommendation generated successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting AI recommendations: ' . $e->getMessage());
            
            // For testing: Return mock data if there's an exception
            $recommendation = $this->getMockRecommendation();
            
            // Store in database instead of session
            $recommendationId = $this->storeRecommendation($recommendation);
            
            return response()->json([
                'success' => true,
                'recommendation_id' => $recommendationId,
                'message' => 'Mock recommendation generated (exception occurred)'
            ]);
        }
    }
    
    /**
     * Store recommendation in database and return ID
     */
    private function storeRecommendation($content)
    {
        try {
            return DB::table('ai_recommendations')->insertGetId([
                'content' => $content,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            // If database storage fails, return a fallback ID
            Log::error('Failed to store recommendation: ' . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Get a mock recommendation for testing
     */
    private function getMockRecommendation()
    {
        return "# Style Recommendation\n\n" .
               "Based on the image you shared, here are some outfit ideas in a similar style:\n\n" .
               "## Outfit Idea 1: Casual Minimalist\n" .
               "- **Top**: Plain white crewneck t-shirt with a relaxed fit\n" .
               "- **Bottom**: Medium-wash straight leg jeans\n" .
               "- **Outerwear**: Light beige or tan unstructured blazer\n" .
               "- **Shoes**: White minimalist sneakers\n" .
               "- **Accessories**: Simple leather watch with a brown strap\n\n" .
               "## Outfit Idea 2: Smart Casual\n" .
               "- **Top**: Light blue Oxford button-down shirt\n" .
               "- **Bottom**: Navy chino pants\n" .
               "- **Shoes**: Brown leather loafers\n" .
               "- **Accessories**: Minimal silver bracelet\n\n" .
               "## Outfit Idea 3: Weekend Comfort\n" .
               "- **Top**: Gray cotton henley\n" .
               "- **Bottom**: Black slim-fit jeans\n" .
               "- **Outerwear**: Navy bomber jacket\n" .
               "- **Shoes**: Low-top canvas sneakers\n" .
               "- **Accessories**: Simple nylon strap watch\n\n" .
               "## Where to Shop\n" .
               "You can find these items at retailers like Uniqlo, H&M, Zara, J.Crew, and COS that all carry versatile basics in similar styles.";
    }
    
    /**
     * Get recommendation by ID
     */
    public function getRecommendationById($id)
    {
        try {
            // Get recommendation from database
            $recommendation = DB::table('ai_recommendations')->find($id);
            
            if (!$recommendation) {
                // If not found, return mock data
                return response()->json([
                    'success' => true,
                    'recommendations' => $this->getMockRecommendation(),
                    'created_at' => now()->toDateTimeString()
                ]);
            }
            
            return response()->json([
                'success' => true,
                'recommendations' => $recommendation->content,
                'created_at' => $recommendation->created_at
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting recommendation: ' . $e->getMessage());
            
            // Return mock data as fallback
            return response()->json([
                'success' => true,
                'recommendations' => $this->getMockRecommendation(),
                'created_at' => now()->toDateTimeString()
            ]);
        }
    }
    
    /**
     * Show the recommendation page
     */
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
    public function show($id)
    {
        return view('ai_recommendation', ['id' => $id]);
    }
}