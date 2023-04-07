<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'sender_name',
        'sender_address',
        'sender_phone',
        'reciever_name',
        'reciever_address',
        'reciever_phone',
        'created_by',
        'updated_by',
    ];

    public static $rules = [
        'weight' => 'required|integer',
        'sender_name' => 'required|string|max:25',
        'sender_address' => 'required|string',
        'sender_phone' => 'required|string|max:15',
        'reciever_name' => 'required|string|max:25',
        'reciever_address' => 'required|string',
        'reciever_phone' => 'required|string|max:15',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
    ];

    /**
     * Get all of the orderTrack for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderTracks(): HasMany
    {
        return $this->hasMany(OrderTrack::class, 'order_id', 'id')->orderBy('created_at');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
