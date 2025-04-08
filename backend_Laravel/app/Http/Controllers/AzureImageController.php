<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AzureImageController extends Controller
{
    public function analyzeImage(Request $request)
    {
        $image = $request->file('image');
        $imageContent = file_get_contents($image);
        
        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => 'YOUR_AZURE_SUBSCRIPTION_KEY', // Replace with actual subscription key
            'Content-Type' => 'application/octet-stream',
        ])->post('https://<region>.api.cognitive.microsoft.com/vision/v3.2/analyze?visualFeatures=Categories,Description,Color', $imageContent);

        return response()->json($response->json());
    }
}
