<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'user_id',
        'name',
        'surname',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'single_price']);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function getOrderTaxAttribute()
    {
        $products = $this->products()->get();
        $sum = 0;

        foreach($products as $product) {
            $sum += $product->pivot->quantity * $product->pivot->single_price;
        }

        return $this->total - $sum;
    }

}
