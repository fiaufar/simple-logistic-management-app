<?php

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\OrderTrackRepository;
use Exception;

class OrderTrackService
{
    protected $orderTrackRepo;

    public function __construct(OrderTrackRepository $orderTrackRepo) 
    {
        $this->orderTrackRepo = $orderTrackRepo;
    }

    /**
     * Save the order track.
     *
     * @param  array  $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function saveOrderTrack($data) : Model
    {
        try {
            $orderTrack = $this->orderTrackRepo->create($data);
        } catch (Exception $th) {
            Log::info($th->getMessage());

            throw new InvalidArgumentException('Unable to save order track data');
        }

        return $orderTrack;
    }

    /**
     * Get Order tracks by Order ID.
     *
     * @param  int  $orderId
     * @return array
     */
    public function getOrderTrackByOrderId($orderId) : array
    {
        try {
            $orderTrack = $this->orderTrackRepo->findByOrderId($orderId);
        } catch (Exception $th) {
            Log::info($th->getMessage());

            throw new InvalidArgumentException('Unable to get order track data');
        }

        return $orderTrack;
    }
}
