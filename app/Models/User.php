<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'surname',
        'phone',
        'email',
        'birthdate',
        'password',
        'balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function instanceCartName()
    {
        $userName = [
            $this->id,
            $this->surname
        ];

        return implode('_', $userName);
    }

    public function wishes()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'wishlist',
            'user_id',
            'product_id'
        );
    }

    public function addToWish(Product $product)
    {
        $this->wishes()->attach($product);
    }

    public function removeFromWish(Product $product)
    {
        $this->wishes()->detach($product);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }
}
