<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HMService;

class HMController extends Controller
{
    protected $hmService;

    public function __construct(HMService $hmService)
    {
        $this->hmService = $hmService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 36);
        
        $results = $this->hmService->searchProducts($query, $page, $perPage);
        
        return response()->json($results);
    }

    public function productDescription(Request $request)
    {
        $productId = $request->input('productId', '');
        
        $description = $this->hmService->getProductDescription($productId);
        
        return response()->json($description);
    }

    public function newArrivals(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 12);
        
        $results = $this->hmService->getNewArrivals($page, $perPage);
        
        return response()->json($results);
    }
}
