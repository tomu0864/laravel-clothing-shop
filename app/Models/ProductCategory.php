<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = "product_category";

    public $timestamps = false;
    protected $fillable = ['category_id', 'product_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
