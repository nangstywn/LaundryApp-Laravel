<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $table = "order";
    use HasFactory;

    public function datailOrder()
    {
        return $this->hasMany('App\Models\DetailOrder');
    }
}