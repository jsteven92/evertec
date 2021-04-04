<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Model\Order;
use App\Services\Interfaces\IOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    function newOrder(OrderRequest $orderRequest)
    {
        $data = [
            'data' => $orderRequest->input(),
            'order' => $orderRequest->validated(),
        ];

        $response = $this->orderService->newOrder($data);
        $status = 200;
        if (!$response['status']) {
            $status = 500;
        }
        return response()->json($response, $status);
    }

    function informationOrder(Request $request): JsonResponse
    {
        $orderId = $request->input('orderId');
        if (!isset($orderId)) {
            return response()->json(__('order.orderId_error'), 500);
        }

        $response = $this->orderService->informationOrder($orderId);

        return response()->json($response['message'], 200);
    }

    function listOrder(): JsonResponse
    {
        $response = $this->orderService->listOrder();
        return response()->json($response['message'], 200);
    }
}
