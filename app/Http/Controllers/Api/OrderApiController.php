<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreOrderRequest, StoreUpdateVimeoSlotRequest};
use App\Http\Resources\OrderResource;
use App\Jobs\{OrderCreatedJob, OrderCreatedResponderJob, OrderDeniedJob, VimeoProcessingStatusJob};
use App\Models\{Order, Video};
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\OrderTemplateData;
use App\Services\OrderService;
use App\Services\Vimeo\{VimeoResponse, VimeoSlotService};
use Exception;
use Illuminate\Http\Request;
use Vimeo\Exceptions\VimeoUploadException;

class OrderApiController extends Controller
{

    public function __construct(
        private OrderService $orderService,
        private Order $order,
        private Video $video,
    ) {}

    /**
     * 
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = (int) $request->per_page ?? 10;
        $orders = $this->order->
            where('responder_id', $user->id)
            ->whereIn('status', ['open', 'sended'])
            ->paginate($perPage);
        return OrderResource::collection($orders);
    }

    /**
     * 
     */
    public function getByUserId(Request $request)
    {
        $user = $request->user();
        $perPage = (int) $request->per_page ?? 10;
        $orders = $this->order->where('user_id', $user->id)->paginate($perPage);
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        if(!$order = $this->orderService->getOrderById($id)) {
            return response(['message' => 'order not founded'], 404);
        }

        return response()->json(new OrderResource($order));
    }

    /**
     * 
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();
        
        $data['responder_id'] = $data['product_id'];
        $data['user_id'] = $request->user()->id;

        try {
            $order = $this->orderService->createOrder($data);
            if(!$order) {
                return response(['message' => 'error to create an order'], 400);
            }

            OrderCreatedJob::dispatch($order);
            OrderCreatedResponderJob::dispatch($order);
            
            return response(new OrderResource($order), 201);
        } catch (Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 
     */
    public function getByRespondeId(StoreOrderRequest $request)
    {
        $user = $request->user();
        return $this->orderService->getOrderByResponderId($user->id);
    }

    /**
     * 
     */
    public function createSlot(StoreUpdateVimeoSlotRequest $request, $id)
    {

        $order = $this->orderService->getOrderById($id);
        $fileSize = $request['file_size'];
        $vs = new VimeoSlotService();
        try {

            $responseRaw = $vs->createSlot($order->id, $fileSize, $order->name);
            $vimeoResponse = new VimeoResponse($responseRaw);
            $dataVideo = $vimeoResponse->convertIntoVimeoModel($order);
            $this->video->updateOrCreate(['order_id' => $order->id], $dataVideo);
            return response($responseRaw, 201);
        } catch (VimeoUploadException $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 
     */
    public function denyOrder(StoreUpdateVimeoSlotRequest $request, $id)
    {
        $order = $this->orderService->getOrderById($id);
        $order->status = 'denied';
        $order->save();
        
        OrderDeniedJob::dispatch($order);

        return response(['message' => 'status changed with success'], 200);
    }

    /**
     * 
     */
    public function videoFileSended(StoreUpdateVimeoSlotRequest $request, $id)
    {
        $order = $request->order;

        $video = $order->video;
        if(!$video) {
            return response(['message' => 'vimeo informations not founded'], 404);
        }

        $order->status = 'sended';
        $order->save();
        $video->status = Video::STATUS_NO;
        $video->save();

        return response(['message' => 'video sended'], 200);
    }
}
