<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = "transaksi";
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer', 'id');
    }
    public function hargas()
    {
        return $this->belongsTo('App\Models\Harga', 'id_harga', 'id');
    }
}