<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "customer";

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi');
    }
    public function detail()
    {
        return $this->hasMany('App\Models\DetailOrder');
    }
}