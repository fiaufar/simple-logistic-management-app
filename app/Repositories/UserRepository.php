<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository 
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}