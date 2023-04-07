<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Http extends Model
{
    public const HTTP_RESPONSE_SUCCESS      = 200;
    public const HTTP_RESPONSE_SERVER_ERROR = 500;
    public const HTTP_RESPONSE_BAD_REQUEST  = 400;
    public const HTTP_RESPONSE_UNAUTHORIZED = 401;
    public const HTTP_RESPONSE_NOT_FOUND    = 404;
}
