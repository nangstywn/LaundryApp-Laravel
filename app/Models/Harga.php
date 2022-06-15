<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $table = "harga";
    protected $guarded = [];
    public function cabang()
    {
        return $this->belongsTo('App\Models\Cabang', 'id_cabang', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany('App\Models\Transaksi');
    }
    public function detail()
    {
        return $this->hasMany('App\Models\Harga');
    }
}