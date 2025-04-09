<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LykdatService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class TestLykdatAPI extends Command
{
    protected $signature = 'test:lykdat {image_path? : Path to test image file} {--direct : Bypass service and call API directly}';
    protected $description = 'Test the Lykdat API integration with a single image';

    public function handle()
    {
        // Get the path to the image file
        $imagePath = $this->argument('image_path');
        
        if (!$imagePath) {
            // If no image path provided, use a sample image from storage if available
            if (Storage::disk('public')->exists('sample.jpg')) {
                $imagePath = storage_path('app/public/sample.jpg');
                $this->info("Using sample image from storage: $imagePath");
            } else {
                $this->error("No image path provided and no sample image found in storage.");
                $this->info("Please provide an image path: php artisan test:lykdat /path/to/your/image.jpg");
                return 1;
            }
        }
        
        if (!file_exists($imagePath)) {
            $this->error("Image file not found: $imagePath");
            return 1;
        }
        
        // Create an UploadedFile instance from the image path
        $file = new UploadedFile(
            $imagePath,
            basename($imagePath),
            mime_content_type($imagePath),
            null,
            true
        );
        
        if ($this->option('direct')) {
            // Call the API directly for debugging
            return $this->callApiDirectly($file);
        } else {
            // Use the service
            return $this->callViaService($file);
        }
    }
    
    protected function callViaService(UploadedFile $file)
    {
        try {
            // Get the LykdatService
            $lykdatService = app(LykdatService::class);
            
            // Test prompt
            $prompt = "Find similar clothing to this";
            
            $this->info("Sending request to Lykdat API via service...");
            
            // Call the analyzeImage method
            $result = $lykdatService->analyzeImage($file, $prompt);
            
            // Output the result
            $this->info("API Response received!");
            $this->info("Response through service:");
            $this->line(json_encode($result, JSON_PRETTY_PRINT));
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error in service: " . $e->getMessage());
            return 1;
        }
    }
    
    protected function callApiDirectly(UploadedFile $file)
    {
        try {
            $apiEndpoint = env('LYKDAT_API_ENDPOINT', 'https://cloudapi.lykdat.com/v1/detection/tags');
            $apiKey = env('LYKDAT_API_KEY');
            
            $this->info("API Endpoint: " . $apiEndpoint);
            $this->info("Using API Key: " . substr($apiKey, 0, 10) . "...");
            
            $this->info("Sending direct request to Lykdat API...");
            
            // Make the API request directly
            $response = Http::withHeaders([
                'X-Api-Key' => $apiKey,
            ])->attach(
                'image', 
                file_get_contents($file->getPathname()), 
                $file->getClientOriginalName()
            )->post($apiEndpoint);
            
            $this->info("HTTP Status: " . $response->status());
            
            if ($response->successful()) {
                $this->info("Direct API Response:");
                $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            } else {
                $this->error("API Error: " . $response->body());
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error calling API directly: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }
    }
}