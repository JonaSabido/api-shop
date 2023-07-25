<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'total',
        'sale_date',
        'subtotal',
        'discount_rate'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user')->select(['id', 'name', 'last_name', 'nick', 'email']);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'id_sale', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_sale', 'id')->select(['id', 'sale_hour_date', 'amount', 'street', 'status']);
    }
}
