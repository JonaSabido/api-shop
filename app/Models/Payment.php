<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_sale',
        'sale_hour_date',
        'amount',
        'street',
        'status'
    ];
    public function sale()
    {
        return $this->hasOne(Sale::class, 'id', 'id_sale')->select(['id', 'id_user', 'total', 'sale_date']);
    }
}
