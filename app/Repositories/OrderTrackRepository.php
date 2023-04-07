<?php

namespace App\Repositories;

use App\Models\OrderTrack;

class OrderTrackRepository extends BaseRepository 
{
    protected $model;

    public function __construct(OrderTrack $model)
    {
        $this->model = $model;
    }

    public function findByOrderId($orderId)
    {
        return $this->model->where(['order_id' => $orderId])->get();
    }
}