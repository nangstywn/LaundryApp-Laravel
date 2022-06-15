<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DetailOrder;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\Dd;
use Illuminate\Support\Carbon;

//use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Admin
        $order = Order::orderBy('id', 'asc')->get()->count();
        $user = User::where('level', 'karyawan')->where('status', 'Aktif')->get()->count();
        $customer = Customer::orderBy('id', 'asc')->get()->count();
        $eks_adm = Order::select('spotting', 'ongkir')->get();
        $total = DetailOrder::orderBy('id', 'asc')->get('harga_akhir');
        //Karyawan
        $kry_order = Order::orderBy('id', 'asc')->where('karyawan', Auth::user()->name)->get()->count();
        // $kry_customer = Customer::orderBy('id', 'asc')->where('id_cabang', Auth::user()->id_cabang)->get()->count();
        $kry_customer = Customer::orderBy('id', 'asc')->whereHas('user', function ($q) {
            $q->where('id_cabang', Auth::user()->id_cabang);
        })->get()->count();
        $eks = Order::where('karyawan', Auth::user()->name)->select('spotting', 'ongkir')->get();
        $kry_total = DetailOrder::orderBy('id', 'asc')->where('id_user', Auth::user()->id)->get('harga_akhir');

        //chart
        //pie chart
        $detail = DetailOrder::join('users', 'users.id', '=', 'detail_order.id_user')
            ->join('cabang', 'cabang.id', '=', 'users.id_cabang')
            ->selectRaw('*,sum(harga_akhir) as total')
            ->whereYear('detail_order.created_at', date('Y'))
            ->groupBy('id_user')->get('id_user', 'total')->groupBy('users.id_cabang');
        foreach ($detail as $details) {
            foreach ($details as $det) {
                $jumlah[] = $det->total;
                $alamat[] = $det->alamat_cabang;
            }
        }

        if (!empty($alamat)) {
            $pie = array_combine($alamat, $jumlah);
        } else {
            $pie = [];
        }

        //bar chart
        if (Auth::user()->level == 'admin') {
            $bulan = DetailOrder::selectRaw('*,sum(harga_akhir) as total')
                ->selectRaw('DATE_FORMAT(created_at,"%m") as months')
                ->selectRaw('DATE_FORMAT(created_at,"%b") as month')->whereYear('created_at', date('Y'))
                ->groupBy('months')->orderBy('months', 'asc')->get('total');
        } else {
            $bulan = DetailOrder::join('users', 'users.id', '=', 'detail_order.id_user')
                ->join('cabang', 'cabang.id', '=', 'users.id_cabang')
                ->selectRaw('sum(harga_akhir) as total')
                ->selectRaw('DATE_FORMAT(detail_order.created_at,"%m") as months')
                ->selectRaw('DATE_FORMAT(detail_order.created_at,"%b") as month')->whereYear('detail_order.created_at', date('Y'))
                ->where('id_cabang', Auth::user()->id_cabang)
                ->groupBy('months')->orderBy('months', 'asc')->get('total');
        }
        foreach ($bulan as $bulans) {
            $name[] = $bulans->month;
            $tot[] = $bulans->total;
        }
        if (!empty($name)) {
            $bar = array_combine($name, $tot);
        } else {
            $bar = [];
        }

        //line chart
        if (Auth::user()->level == 'karyawan') {
            $trx = DetailOrder::join('order', 'order.id', '=', 'detail_order.id_order')
                ->join('users', 'users.id', '=', 'detail_order.id_user')
                ->join('cabang', 'cabang.id', '=', 'users.id_cabang')
                ->selectRaw('DATE_FORMAT(order.created_at,"%m") as months, DATE_FORMAT(order.created_at,"%b") as mon')
                ->whereYear('order.created_at', date('Y'))
                ->where('id_cabang', Auth::user()->id_cabang)
                ->groupBy('id_order')->orderBy('months', 'asc')->get('months')->groupBy('months');
            foreach ($trx as $trxs) {
                $r[] = $trxs->count();
                foreach ($trxs as $tr) {
                    $nama[] = $tr->mon;
                }
            }
            if (!empty($nama)) {
                $nama = array_unique($nama);
                $line = array_combine($nama, $r);
            } else {
                $line = [];
            }
        } else {
            $line = null;
        }

        return view('home', compact(
            'order',
            'customer',
            'user',
            'total',
            'kry_order',
            'kry_customer',
            'kry_total',
            'eks',
            'eks_adm',
            'pie',
            'bar',
            'line',
        ));
    }
}