<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GithubAIService
{
    protected $apiEndpoint;
    protected $apiKey;
    
    public function __construct()
    {
        // Load from env or config
        $this->apiEndpoint = env('GITHUB_AI_ENDPOINT', 'https://models.inference.ai.azure.com');
<<<<<<< HEAD
        $this->apiKey = env('GITHUB_AI_KEY', '');
=======
        $this->apiKey = env('GITHUB_AI_KEY');
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
    }
    
    /**
     * Get style recommendations based on image
     * 
     * @param string $imageBase64 Base64 encoded image
     * @return array The recommendations and success status
     */
    public function getRecommendations($imageBase64)
    {
        try {
            // Call the AI API with the image
            $response = $this->callGithubAI($imageBase64);
            
            // Store the recommendation in the database
            $recommendationId = $this->storeRecommendation($response);
            
            return [
                'success' => true,
                'recommendation_id' => $recommendationId,
                'recommendations' => $response,
            ];
            
        } catch (\Exception $e) {
            Log::error('GitHub AI recommendation error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'recommendations' => $this->getFallbackRecommendations()
            ];
        }
    }
    
    /**
     * Store the recommendation in the database
     */
    protected function storeRecommendation($recommendation)
    {
        $id = DB::table('ai_recommendations')->insertGetId([
            'content' => $recommendation,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return $id;
    }
    
    /**
     * Call the GitHub AI API with the image
     */
    protected function callGithubAI($imageBase64)
    {
<<<<<<< HEAD
        // Construct the correct endpoint URL - this is the key change
        $url = $this->apiEndpoint . '/chat/completions';
        
=======
        // Construct the correct endpoint URL
        $url = $this->apiEndpoint . '/chat/completions';
        
        // Add detailed debug logging
        Log::info('Calling GitHub AI API', [
            'url' => $url,
            'image_base64_length' => strlen($imageBase64),
        ]);
        
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
        // Create structured messages with image
        $messages = [
            [
                'role' => 'system',
                'content' => 'You are an expert in recommending clothing style matching the request description, provide detailed style recommendations, including matching clothing pieces, and accessories. Be helpful, creative, and up-to-date with modern fashion trends.'
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Here is a clothing item, can you suggest a few outfit ideas and recommend clothing with the same style?'
                    ],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => "data:image/jpeg;base64," . $imageBase64
                        ]
                    ]
                ]
            ]
        ];
        
        $payload = [
            'messages' => $messages,
            'model' => 'gpt-4o',
            'temperature' => 0.8,
            'max_tokens' => 2000,
            'top_p' => 1
        ];
        
<<<<<<< HEAD
        Log::info('Calling GitHub AI API...');
=======
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->apiKey
        ])->post($url, $payload);
        
        if (!$response->successful()) {
            Log::error('GitHub AI API error: ' . $response->body());
            throw new \Exception('Error calling GitHub AI: ' . $response->status() . ' - ' . $response->body());
        }
        
        $responseData = $response->json();
<<<<<<< HEAD
        Log::info('GitHub AI API response received');
=======
        Log::info('GitHub AI API response received', [
            'status' => $response->status(),
            'has_choices' => isset($responseData['choices']),
        ]);
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
        
        // Extract the actual message content
        if (isset($responseData['choices'][0]['message']['content'])) {
            return $responseData['choices'][0]['message']['content'];
        }
        
        throw new \Exception('Invalid response format from GitHub AI');
    }
    
    /**
     * Get fallback recommendations when AI API fails
     */
    protected function getFallbackRecommendations()
    {
        return "# Style Recommendation

Based on the image you shared, here are some outfit ideas in a similar style:

## Outfit Idea 1: Casual Minimalist
- **Top**: Plain white crewneck t-shirt with a relaxed fit
- **Bottom**: Medium-wash straight leg jeans
- **Outerwear**: Light beige or tan unstructured blazer
- **Shoes**: White minimalist sneakers (like Common Projects or Veja)
- **Accessories**: Simple leather watch with a brown strap

## Outfit Idea 2: Smart Casual
- **Top**: Light blue Oxford button-down shirt
- **Bottom**: Navy chino pants
- **Shoes**: Brown leather loafers
- **Accessories**: Minimal silver bracelet and a quality leather belt

## Outfit Idea 3: Weekend Comfort
- **Top**: Gray cotton henley
- **Bottom**: Black slim-fit jeans
- **Outerwear**: Navy bomber jacket
- **Shoes**: Low-top canvas sneakers
- **Accessories**: Simple nylon strap watch

## Where to Shop
You can find these items at retailers like Uniqlo, H&M, Zara, J.Crew, and COS that all carry versatile basics in similar styles.";
    }
    
    /**
     * Retrieve a recommendation by ID
     */
    public function getRecommendationById($id)
    {
        $recommendation = DB::table('ai_recommendations')->where('id', $id)->first();
        
        if (!$recommendation) {
            return [
                'success' => false,
                'error' => 'Recommendation not found',
            ];
        }
        
        return [
            'success' => true,
            'recommendations' => $recommendation->content,
            'created_at' => $recommendation->created_at,
        ];
    }
}