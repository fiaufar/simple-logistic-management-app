<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $order = Order::create($data);
            $orderTrack = OrderTrack::create([
                'order_id' => $order->id,
                'title' => 'Order picked up',
                'description' => 'Order picked up',
                'created_by' => auth()->user()->id
            ]);
        } catch (\Throwable $th) {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
