<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function getActualPrice()
    {
        $actual_price = $this->price - $this->price * ($this->discount / 100);
        return number_format($actual_price, 2);
    }

    public function getDiscount()
    {
        $discount = $this->price * ($this->discount / 100);
        return number_format($discount, 2);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartadded()
    {
        return $this->carts()->where('user_id', Auth::user()->id)->exists();
    }
}
