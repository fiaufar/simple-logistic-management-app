<?php

namespace App\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository) 
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Get User by email.
     *
     * @param  string  $email
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getUserbyEmail($email) : Model
    {
        try {
            $user = $this->userRepo->getUserByEmail($email);
        } catch (Exception $th) {
            Log::info($th->getMessage());

            throw new InvalidArgumentException('Unable to get user');
        }

        return $user;
    }

    /**
     * Get Order by ID.
     *
     * @param  int  $orderId
     * @return Illuminate\Database\Eloquent\Model
     */
    public function registerUser($data) : Model
    {
        try {
            $user = $this->userRepo->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
        } catch (Exception $th) {
            Log::info($th->getMessage());

            throw new InvalidArgumentException('Unable to create user');
        }

        return $user;
    }
}
