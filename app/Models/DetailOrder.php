<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = "detail_order";
    use HasFactory;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'id_order', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }
    public function hargas()
    {
        return $this->belongsTo('App\Models\Harga', 'id_harga', 'id');
    }
}