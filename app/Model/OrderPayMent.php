<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderPayMent extends Model
{
    protected $table = 'orders_payments';

    protected $fillable = [
        'order_id',
        'request_id',
        'process_url',
        'internal_reference',
        'status',
        'product_id',
        'called_api_at',
        'created_at',
        'updated_at',
        ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    function order(){
        return $this->belongsTo(Order::class);
    }

}
