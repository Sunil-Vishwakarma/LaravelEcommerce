<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'product_name',
        'images',
        'product_description',
        'price',
        'discount',
        'quantity',
        'stock',
        'createdby',
    ];
                            
}
