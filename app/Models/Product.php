<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Product extends Model
{
    use HasFactory, Rateable;

    protected $fillable = [
        'id',
        'category_id',
        'title',
        'description',
        'short_description',
        'SKU',
        'price',
        'discount',
        'in_stock',
        'thumbnail'
    ];

    public function gallery()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function getPrice()
    {
        $price = is_null($this->discount) ? $this->price : ($this->price - ($this->price * ($this->discount / 100)));
        $price = round($price, 2);
        return $price < 0 ? 0 : $price;
    }

    public function setThumbnailAttribute($image)
    {
        if (!empty($this->attributes['thumbnail'])) {
            ImageService::remove($this->attributes['thumbnail']);
        }
        $this->attributes['thumbnail'] = ImageService::upload($image);
    }

    public function followers()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'wishlist',
            'product_id',
            'user_id'
        );
    }

    public function getUserRatingForCurrentProduct()
    {
        $ratings = $this->ratings()->where('rateable_id', '=', $this->id)->get();

        return $ratings->where('user_id', '=', auth()->id())->first();
    }
}
