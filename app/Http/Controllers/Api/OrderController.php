<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Http;
use App\Services\OrderService;
use Illuminate\Support\Facades\Log;
use App\Services\OrderTrackService;
use App\Http\Requests\CreateOrderRequest;

class OrderController extends ApiController
{
    protected $orderService;
    protected $orderTrackService;

    public function __construct(OrderService $orderService, OrderTrackService $orderTrackService)
    {
        $this->orderService = $orderService;
        $this->orderTrackService = $orderTrackService;
    }

    /**
     * Save the Order.
     *
     * @param  App\Http\Requests\CreateOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->all();
        $result = [];

        try {
            $order = $this->orderService->saveOrder($data);
            $result['data'] = $order;
        } catch (Exception $th) {
            Log::info($th->getMessage());

            $result['message'] = ['Create Order Failed!'];
            return response()->json($result, Http::HTTP_RESPONSE_SERVER_ERROR);
        }

        $result['message'] = ['Create Order Success!'];
        return response()->json($result, Http::HTTP_RESPONSE_SUCCESS);
    }

    /**
     * Get the Order detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderDetail($id)
    {
        $result = [];

        try {
            $order = $this->orderService->getOrderById($id);
            $result['data'] = $order;
        } catch (Exception $th) {
            Log::info($th->getMessage());

            $result['message'] = ['Get Order Failed!'];
            return response()->json($result, Http::HTTP_RESPONSE_SERVER_ERROR);
        }

        if (empty($order)) {
            $result['message'] = ['Order Not Found!'];
            return response()->json($result, Http::HTTP_RESPONSE_NOT_FOUND);
        }

        $result['message'] = ['Create Order Success!'];
        return response()->json($result, Http::HTTP_RESPONSE_SUCCESS);
    }

    /**
     * Get the order's tracks by Order ID.
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function orderTracks($orderId)
    {
        $result = [];

        try {
            $orderTracks = $this->orderTrackService->getOrderTrackByOrderId($orderId);
            $result['data'] = $orderTracks;
        } catch (Exception $th) {
            Log::info($th->getMessage());

            $result['message'] = ['Get Order tracks failed!'];
            return response()->json($result, Http::HTTP_RESPONSE_SERVER_ERROR);
        }

        if (count($orderTracks) == 0) {
            $result['message'] = ['Order tracks not found!'];
            return response()->json($result, Http::HTTP_RESPONSE_NOT_FOUND);
        }

        $result['message'] = ['Get Order tracks success!'];
        return response()->json($result, Http::HTTP_RESPONSE_SUCCESS);
    }
}
