<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\OrderTemplateData;
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
        $data['user_id'] = $request->user()->id;

        $order = $this->orderService->createOrder($data);
        if(!$order) {
            return response(['message' => 'error to create an order'], 400);
        }
        
        //TODO: remove hardcode
        SendgridService::send(
            'd-3ba931ea440e4c4b82c5c7a8ead37554',
            $order->email,
            $order->name,
            OrderTemplateData::transform($order),
        );
        return response(new OrderResource($order), 201);
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
