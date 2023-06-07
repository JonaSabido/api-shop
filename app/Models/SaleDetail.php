<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_sale',
        'id_product',
        'amount',
        'total',
    ];
    public function sale()
    {
        return $this->hasOne(Sale::class, 'id', 'id_sale');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }
}
