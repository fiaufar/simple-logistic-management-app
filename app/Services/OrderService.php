<?php

namespace App\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    const ORDER_TYPE = [
        'Order picked up',
        'Processed at warehouse',
        'Out for delivery',
        'Package Received'
    ];

    protected $orderRepo;
    protected $orderTrackService;

    public function __construct(OrderRepository $orderRepository, OrderTrackService $orderTrackService) 
    {
        $this->orderRepo = $orderRepository;
        $this->orderTrackService = $orderTrackService;
    }

    public function saveOrder($data)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepo->create($data);

            // Insert some random tracking updates
            $randomNum = rand(1,4);
            for ($i=0; $i < $randomNum; $i++) {
                $this->orderTrackService->saveOrderTrack([
                    'order_id' => $order->id,
                    'title' => self::ORDER_TYPE[$i],
                    'description' => self::ORDER_TYPE[$i],
                ]);
            }
        } catch (Exception $th) {
            Log::info($th->getMessage());
            DB::rollBack();

            throw new InvalidArgumentException('Unable to save order data');
        }
        DB::commit();

        return $order;
    }

    /**
     * Get Order by ID.
     *
     * @param  int  $orderId
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getOrderById($orderId) : Model
    {
        try {
            $order = $this->orderRepo->find($orderId);
        } catch (Exception $th) {
            Log::info($th->getMessage());

            throw new InvalidArgumentException('Unable to get order data');
        }

        return $order;
    }
}
