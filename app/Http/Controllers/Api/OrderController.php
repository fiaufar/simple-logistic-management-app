<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private $ORDER_TYPE = [
        'Order picked up',
        'Processed at warehouse',
        'Out for delivery',
        'Package Received'
    ];

    public function store(CreateOrderRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $order = Order::create($data);

            // Insert some random tracking updates
            $randomNum = rand(1,4);
            for ($i=0; $i < $randomNum; $i++) {
                $orderTrack = OrderTrack::create([
                    'order_id' => $order->id,
                    'title' => $this->ORDER_TYPE[$i],
                    'description' => $this->ORDER_TYPE[$i],
                    'created_by' => auth()->user()->id
                ]);
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'Create Order Failed!', 'success' => false], 500);
        }

        DB::commit();
        return response()->json(['message' => 'Create Order Success!', 'success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('orderTracks')->find($id);
        if (empty($order)) {
            return response()->json(['message' => 'Order Not Found!', 'success' => false], 404);
        }

        return response()->json(['data' => $order, 'success' => true], 200);
    }
}
