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
        // Handle the case where the service might not be registered yet
        $this->githubAIService = $githubAIService ?: new GithubAIService();
    }
    
    /**
     * Get AI recommendations for a clothing style
     */
    public function getRecommendations(Request $request)
    {
        // Add simple response for testing
        return response()->json([
            'success' => true,
            'recommendation_id' => 1,
            'message' => 'Test recommendation'
        ]);
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