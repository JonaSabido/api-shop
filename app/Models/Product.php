<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_category',
        'name',
        'description',
        'price',
        'stock',
        'url',
        'active'
    ];
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'id_category');
    }
}
