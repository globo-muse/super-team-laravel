<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\Vimeo\VimeoSlotService;
use Illuminate\Http\Request;
use Vimeo\Exceptions\VimeoUploadException;

class OrderApiController extends Controller
{

    public function __construct(
        private OrderService $orderService,
        private Order $order,
    ) {}

    public function index()
    {
        return $this->orderService->getAllOrders();
    }


    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();
        $data['responder_id'] = $data['product_id'];
        return $this->orderService->createOrder($data);
    }



    public function getByRespondeId(StoreOrderRequest $request)
    {
        $user = $request->user();
        return $this->orderService->getOrderByResponderId($user->id);
    }

    public function createSlot($id, Request $request)
    {
        $order = $this->order->where('id', $id)->first();
        if(!$order) {
            return response()->json(['message' => 'order not founded'], 404);
        }
        $fileSize = $request['file_size'];
        $vs = new VimeoSlotService();
        try {
            return $vs->createSlot($order->id, $fileSize, $order->name);
        } catch (VimeoUploadException $e) {
            return $e->getMessage();
        }
    }
}
