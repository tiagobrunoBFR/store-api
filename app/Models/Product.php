<?php

namespace App\Models;

use App\Events\EventNotificationProductCreate;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $dispatchesEvents = [
        'created' => EventNotificationProductCreate::class,
        'updated' => EventNotificationProductCreate::class,
    ];

    protected $fillable = [
        'name',
        'price',
        'store_id',
        'active',
    ];

    public function getPriceAttribute($value)
    {
        $value = 'R$ '.number_format($value, 2, ',', '.');
        return $this->attributes['price'] = $value;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
