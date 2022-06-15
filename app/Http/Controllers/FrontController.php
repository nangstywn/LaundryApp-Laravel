<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DetailOrder;
use App\Models\Order;

class FrontController extends Controller
{
    public function search(Request $request)
    {
        $search = Order::where('invoice', $request->search_status)->first();
        if ($search == null) {
            $return = 0;
        } else {
            $detail = DetailOrder::where('id_order', $search->id)->groupBy('id_order')
                ->with('order')
                ->with('customer')
                ->first();
            $return = $detail;
        }
        return $return;
    }
}