<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = "cabang";
    protected $guarded = [];

    public function user(){
    return $this->hasMany('App\Models\User');
    }
    public function harga(){
    return $this->hasMany('App\Models\Harga');
    }

}