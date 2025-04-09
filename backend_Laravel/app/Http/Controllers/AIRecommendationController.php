<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GithubAIService;
use Illuminate\Support\Facades\Log;

class AIRecommendationController extends Controller
{
    protected $githubAIService;
    
    public function __construct(GithubAIService $githubAIService)
    {
        $this->githubAIService = $githubAIService;
    }
    
    /**
     * Get AI recommendations for a clothing style
     */
    public function getRecommendations(Request $request)
    {
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
    
    public function show($id)
    {
        return view('ai_recommendation', ['id' => $id]);
    }
}