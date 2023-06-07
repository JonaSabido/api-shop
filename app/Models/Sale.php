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
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function details(){
        return $this->hasMany(SaleDetail::class, 'id_sale', 'id');
    }
}
