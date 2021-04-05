<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IstoreServices;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    protected $storeServices;

    function __construct(IstoreServices $storeServices)
    {
        $this->storeServices = $storeServices;
    }

    /**
     * @return JsonResponse
     */
    function getListProducts(): JsonResponse
    {
        $response = $this->storeServices->getListProducts();
        
        return response()->json($response['message'], 200);
    }

    /**
     * @param int $id
     * @param JsonResponse
     */
    function getProduct(int $id): JsonResponse
    {
        $response = $this->storeServices->getProduct($id);
        return response()->json($response['message'], 200);
    }
}
