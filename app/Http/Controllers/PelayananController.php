<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\Harga;
use App\Models\User;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Http;
use Yajra\Datatables\Datatables;
use Carbon\carbon;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class PelayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Transaction Datatable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->level == 'karyawan') {
                $data = DetailOrder::groupBy('id_order')->with('order')->with('hargas')->with('customer')
                    ->whereHas('user', function ($query) {
                        $query->where('id_cabang', Auth::user()->id_cabang);
                    })
                    ->orderBy('id_order', 'DESC');
            } else {
                $data = DetailOrder::groupBy('id_order')->with('order')->with('hargas')->with('customer')
                    ->orderBy('id_order', 'DESC');
            }
            return Datatables::of($data)
                // ->addColumn('customer', function (DetailOrder $detail) {
                //     return $detail->customer->nama;
                // })
                ->addColumn('item', function (DetailOrder $detail) {
                    $item = DetailOrder::where('id_order', $detail->id_order)->count();
                    return $item;
                })
                ->addColumn('total', function (DetailOrder $detail) {
                    $eks = Order::where('id', $detail->id_order)->select('spotting', 'ongkir')->get();
                    $tot = DetailOrder::where('id_order', $detail->id_order)->sum('harga_akhir');
                    $total = $tot + $eks->sum('spotting') + $eks->sum('ongkir');
                    return $total;
                })

                ->filter(function ($instance) use ($request) {
                    if (Auth::user()->level == 'karyawan') {
                        if (!empty($request->get('id_karyawan'))) {
                            $instance->where('id_user', $request->get('id_karyawan'));
                        } else {
                            $instance->where('id_user', Auth::user()->id);
                        }
                    } else {
                        if (!empty($request->get('id_karyawan'))) {
                            $instance->where('id_user', $request->get('id_karyawan'));
                        } else {
                            $instance->where('id_user', '!=', 0);
                        }
                    }
                    if (!empty($request->get('search'))) {
                        $instance->whereHas('customer', function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->where('nama', 'LIKE', "%$search%");
                        })
                            ->orWhereHas('order', function ($q) use ($request) {
                                $search = $request->get('search');
                                $q->where('invoice', 'LIKE', "%$search%");
                            });
                    }
                })

                ->addColumn('action', function ($data) {
                    if (Auth::user()->level == 'karyawan') {
                        if ($data->order->status_order == "Selesai") {
                            $btn =  '<div class="btn-group"><a id="ambil" data-id-ambil="' . $data->id_order . '" class="btn btn-sm btn-dark" style="color:white"><i class="fas fa-dolly"></i> Diambil</a>';
                            $btn  .= '<a id="invoice" data-id-invoice="' . $data->order->invoice . '" class="btn btn-sm btn-primary" style="color:white">
                            <i class="fas fa-file-invoice "></i> Invoice</a></div>';
                            return $btn;
                        } elseif ($data->order->status_order == "Diproses") {
                            $btn =  '<div class="btn-group"><a id="selesai" data-id-selesai="' . $data->id_order . '"class="btn btn-sm btn-success" style="color:white"><i class="fas fa-check-circle "></i> Selesai</a>';
                            $btn  .= '<a  id="invoice" data-id-invoice="' . $data->order->invoice . '" class="btn btn-sm btn-primary" style="color:white">
                            <i class="fas fa-file-invoice "></i> Invoice</a>';
                            $btn  .= '<a id="delete" data-id-delete="' . $data->id_order . '" class="btn btn-sm btn-danger" style="color:white">
                                <i class="fa fa-trash "></i></a></div>';
                            return $btn;
                        } else {
                            $btn  = '<a id="invoice" data-id-invoice="' . $data->order->invoice . '" class="btn btn-sm btn-primary" style="color:white">
                                <i class="fas fa-file-invoice "></i> Invoice</a>';
                            return $btn;
                        }
                    } else {
                        $btn  = '<a id="invoice" data-id-invoice="' . $data->id_order . '" class="btn btn-sm btn-primary" style="color:white">
                                <i class="fas fa-file-invoice "></i> Invoice</a>';
                        return $btn;
                    }
                })
                ->toJson();
        }
        if (Auth::user()->level == "karyawan") {
            $filter = User::select('id', 'name')->where('level', 'karyawan')->where('id_cabang', Auth::user()->id_cabang)->get();
        } else {
            $filter = User::where('level', 'karyawan')->orderBy('id_cabang', 'asc')->get();
        }
        $transaksi = Transaksi::orderBy('id', 'asc')->get();
        return view('karyawan.transaksi.order', compact('transaksi', 'filter'));
    }
    // Transaction eloquent index
    public function index1(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->level == "karyawan") {
                //dd($request->id_karyawan);
                if ($request->method() == 'GET') {
                    if ($request->id_karyawan != null && $request->id_karyawan != 0) {
                        $detailOrder = DetailOrder::selectRaw('*,SUM(harga_akhir) as total, count(id_order) as item')
                            ->where('id_user', $request->id_karyawan)
                            ->groupBy('id_order')
                            ->orderBy('id', 'DESC')->paginate();
                    } else if ($request->id_karyawan == null) {
                        $detailOrder = DetailOrder::where('id_user', Auth::user()->id)
                            ->selectRaw('*,SUM(harga_akhir) as total, count(id_order) as item')
                            ->groupBy('id_order')
                            ->orderBy('id_order', 'desc')
                            ->paginate();
                    } else {
                        $detailOrder = DetailOrder::whereHas('user', function ($query) {
                            $query->where('id_cabang', Auth::user()->id_cabang);
                        })
                            ->selectRaw('*,SUM(harga_akhir) as total, count(id_order) as item')
                            ->groupBy('id_order')
                            ->paginate();
                    }
                } else {

                    $detailOrder = DetailOrder::where('id_user', Auth::user()->id)
                        ->selectRaw('*,SUM(harga_akhir) as total, count(id_order) as item')
                        ->groupBy('id_order')
                        ->paginate();
                }
                $transaksi = Transaksi::orderBy('id', 'asc')->get();

                $filter = User::select('id', 'name')->where('level', 'karyawan')->where('id_cabang', Auth::user()->id_cabang)->get();
                return view('karyawan.transaksi.order', compact('detailOrder', 'transaksi', 'filter'));
            } else {
                return redirect('home');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Create Transaction
    public function create()
    {
        if (Auth::user()->level == "karyawan") {
            //beda harga beda cabang
            // $harga = Harga::where('status', 'Aktif')->where('id_cabang', Auth::user()->id_cabang)->groupBy('jenis_cuci')->get();
            //harga sama di semua cabang
            $harga = Harga::where('status', 'Aktif')->groupBy('jenis_cuci')->get();
            $csr = Customer::whereHas('user', function ($query) {
                $query->where('id_cabang', Auth::user()->id_cabang);
            })->get();

            //('id_user', auth::user()->id)->get();
            return view('karyawan.transaksi.order-create', compact('harga', 'csr'));
        } else {
            return redirect('home');
        }
    }

    //Add more transaction (transaction detail)
    public function detailorder()
    {
        $detail = Transaksi::first();
        $details = Transaksi::orderBy('id', 'asc')->get();
        //harga beda setiap cabang
        // $cabang = User::where('id', Auth::user()->id)->first()->id_cabang;
        // $harga = Harga::where('status', 'Aktif')->where('id_cabang', $cabang)->groupBy('jenis_cuci')->get();
        //harga semua cabang sama
        // $cabang = User::where('id', Auth::user()->id)->first()->id_cabang;
        $harga = Harga::where('status', 'Aktif')->groupBy('jenis_cuci')->get();
        return view('karyawan.transaksi.order-detail', compact('details', 'harga', 'detail'));
    }
    //Store data to Transaction table
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_cuci' => 'required|string',
            'jenis' => 'required|string',
            'layanan' => 'required|string',
            'harga' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::user()->level == "karyawan") {
            try {
                $order = new Transaksi();
                $order->id_harga        = $request->id_harga;
                $order->id_customer     = $request->id_customer;
                $order->id_user         = Auth::user()->id;
                $order->jumlah          = $request->jumlah;
                $order->satuan          = $request->satuan;
                $order->harga           = $request->harga;
                $order->disc            = $request->disc;
                $hitung                 = ($order->jumlah * $order->harga);
                $disc                   = ($hitung * $order->disc) / 100;
                $total                  = $hitung - $disc;
                $order->harga_akhir     = $total;
                $order->save();

                return redirect()->route('detail.order')->with('success', 'Data Laundry Berhasil Ditambah');
            } catch (\Throwable $e) {
                return back()->withErrors(['error' => 'Gagal menyimpan data']);
            }
        } else {
            return redirect('/home');
        }
    }

    //Move data from Transaction table to order and order detail
    public function save(Request $request)
    {
        do {
            $code = mt_rand(1000, 9999) . '' . Auth::user()->id . '' . date('ys');
            $orders = Order::where('invoice', $code)->first();
        } while (!empty($orders));
        if ($request->jarak != null && $request->ongkir == null) {
            $ongkir = $request->jarak + $request->ongkir;
        } elseif ($request->jarak != null && $request->ongkir != null) {
            $request->jarak = null;
            $ongkir = $request->jarak + $request->ongkir;
        } else {
            $ongkir = null;
        }
        $spotting = $request->spotting;
        $order = new Order();
        $order->invoice = $code;
        $order->karyawan = Auth::user()->name;
        $order->ongkir = $ongkir;
        $order->spotting = $spotting;
        $order->status_order = 'Diproses';
        $order->tgl_transaksi = Carbon::now()->format('d-m-Y H:i:s');
        $order->save();

        $transaction = Transaksi::get();
        foreach ($transaction as $key => $value) {
            $detailOrder = array(
                'id_order' => $order->id,
                'id_customer' => $value->id_customer,
                'id_user' => $value->id_user,
                'id_harga' => $value->id_harga,
                'jumlah' => $value->jumlah,
                'satuan' => $value->satuan,
                'harga' => $value->harga,
                'disc' => $value->disc,
                'harga_akhir' => $value->harga_akhir,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );
            $detail = DetailOrder::insert($detailOrder);
            Transaksi::where('id', $value->id)->delete();
        }
        return redirect()->route('invoice', $order->invoice)->with('success', 'Data Laundry Berhasil Ditambah');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $detail = DetailOrder::where('id_order', $order->id)->delete();
        $order->delete();
        return redirect()->route('pelayanan.index')->with('success', 'Data Laundry Berhasil Dihapus');
    }

    public function destroyDetailOrder($id)
    {
        $transaksi = Transaksi::find($id)->delete();
        return back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Send transaction invoice to whatsapp
    public function sendWa($id)
    {
        $order = Order::find($id);
        $detail = DetailOrder::where('id_order', $order->id)->first();
        $curl = curl_init();
        if (substr(trim($detail->customer->hp), 0, 1) == '0') {
            $receiver = '62' . substr(trim($detail->customer->hp), 1);
        }
        $data = [
            'receiver' => $receiver,
            'device' => '6281328307609',
            'message' => $detail->order->invoice,
            'type' => 'image',
            'file_name' => $detail->order->invoice . '.png',
            'file_url' => '' . url("invoices/" . $detail->order->invoice . ".png") . ''
            //'file_url' => 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg'
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Bearer eU13vRAWaEjLbd22RP0ZVoZs8EK89PEuPDCDskyMVIfCn0Yh5R",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return redirect()->route('pelayanan.index')->with('success', 'Invoices berhasil dikirim');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function listcsr()
    {
        if (Auth::user()->level == "karyawan") {
            $customer = Customer::orderBy('id', 'DESC')->whereHas('user', function ($q) {
                $q->where('id_cabang', Auth::user()->id_cabang);
            })->paginate();
            return view('karyawan.customer.csr', compact('customer'));
        } else {
            return redirect('home');
        }
    }

    public function addcsr(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|unique:customer',
            //'hp' => 'required|numeric|unique:customer',
            'hp' => 'required|regex:/(08)[0-9]/|min:10|max:13|unique:customer',
            'alamat' => 'required|string',
        ], [
            'nama.unique' => 'Nama sudah terdaftar',
            'hp.size' => 'Nomor HP harus 10-13 digit',
            'hp.regex' => 'Nomor HP harus diawali dengan 08',
            'nama.string' => 'Nama harus berupa string',
            'hp.numeric' => 'Nomor HP harus berupa angka',
            'hp.unique' => 'Nomor HP sudah terdaftar',
            'alamat.string' => 'Alamat harus berupa string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::user()->level == "karyawan") {
            try {
                $addplg = new Customer();
                $addplg->id_user = Auth::user()->id;
                $addplg->nama = $request->nama;
                $addplg->alamat = $request->alamat;
                $addplg->hp =  $request->hp;
                $addplg->save();

                return back()->with('success', 'Data Customer Berhasil Ditambah');
            } catch (\Throwable $th) {
                return back()->with('errors', 'Data Customer Gagal Ditambah');
            }
        } else {
            return redirect('/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecsr(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            //'hp' => 'required|numeric|unique:customer',
            'hp' => 'required|regex:/(08)[0-9]/|min:10|max:13',
            'alamat' => 'required|string',
        ], [
            'hp.regex' => 'Nomor HP harus diawali dengan 08',
            'nama.string' => 'Nama harus berupa string',
            'hp.numeric' => 'Nomor HP harus berupa angka',
            'hp.unique' => 'Nomor HP sudah terdaftar',
            'alamat.string' => 'Alamat harus berupa string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::user()->level == 'karyawan') {
            $customer = Customer::find($id)->update($request->all());
        }
        return back()->with('success', ' Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroycsr($id)
    {
        $customer = Customer::find($id);
        if (DetailOrder::where('id_customer', $customer->id)->exists()) {
            return back()->withErrors(['error' => 'Data tidak dapat dihapus karena masih memiliki relasi']);
        }
        $customer->delete();
        return back()->with('success', 'Data Berhasil Dihapus!');
    }

    //mengubah status order
    public function ubahstatusorder(Request $request)
    {
        if (Auth::user()->level == "karyawan") {
            try {
                $statusorder = Order::find($request->id);
                $statusorder->update([
                    'status_order' => 'Selesai',
                ]);
                if ($statusorder->status_order == 'Selesai') {
                    $detail = DetailOrder::where('id_order', $statusorder->id)->first();
                    $curl = curl_init();
                    if (substr(trim($detail->customer->hp), 0, 1) == '0') {
                        $receiver = '62' . substr(trim($detail->customer->hp), 1);
                    }
                    $data = [
                        'receiver' => $receiver,
                        'device' => '6281328307609',
                        'message' => 'Halo kak, Laundry dengan nomor invoice ' . $detail->order->invoice . ' telah selesai, Silahkan diambil.
Buka setiap hari, 08.00 - 22.00         
Terima kasih, *King Laundry*',
                        'type' => 'chat'
                    ];
                    curl_setopt(
                        $curl,
                        CURLOPT_HTTPHEADER,
                        array(
                            "Accept: application/json",
                            "Content-Type: application/x-www-form-urlencoded",
                            "Authorization: Bearer eU13vRAWaEjLbd22RP0ZVoZs8EK89PEuPDCDskyMVIfCn0Yh5R",
                        )
                    );
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    $result = curl_exec($curl);
                    curl_close($curl);
                }
                return back()->with('success', 'Status Berhasil Diubah');
            } catch (\Throwable $th) {
                return back()->with('errors', 'SMTP MAIL BELUM DI SETTING !');
            }
        } else {
            return redirect('/home');
        }
    }

    // Proses Ubah Status Diambil
    public function ubahstatusambil(Request $request)
    {
        if (Auth::user()->level == "karyawan") {
            try {
                $statusbayar = Order::find($request->id);
                $statusbayar->update([
                    'tgl_ambil' => Carbon::today(),
                    'status_order' => 'Diambil'
                ]);

                return back()->with('success', 'Status Berhasil Diubah');
            } catch (\Throwable $th) {
                return back()->with('errors', 'SMTP MAIL BELUM DI SETTING !');
            }
        } else {
            return redirect('/home');
        }
    }

    public function invoicekar($invoice)
    {
        $orde = Order::where('invoice', $invoice)->first();
        $data = DetailOrder::where('id_order', $orde->id)->get();
        $order = DetailOrder::where('id_order', $orde->id)
            ->selectRaw('*,SUM(harga_akhir) as total_bayar')
            ->groupBy('id_order')
            ->first();

        return view('karyawan.laporan.invoice', compact('data', 'order'));
        // } else {'
        //     return redirect('/home');
        // }
    }
    public function cetakinvoice(Request $request)
    {
        //dd($request->all());
        $order = DetailOrder::where('id_order', $request->id)
            ->selectRaw('*,SUM(harga_akhir) as total_bayar')
            ->groupBy('id_order')
            ->first();

        $image = $request->image;
        $location = public_path('invoices/');
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $filename = $order->order->invoice . '.png';
        $file = $location . $filename;
        file_put_contents($file, $image_base64);
    }
    public function print($invoice)
    {
        $inv = Order::where('invoice', $invoice)->first();
        $data = DetailOrder::where('id_order', $inv->id)->get();
        $hitung = DetailOrder::where('id_order', $inv->id)->count();
        $order = DetailOrder::where('id_order', $inv->id)
            ->selectRaw('*,SUM(harga_akhir) as total_bayar')
            ->groupBy('id_order')
            ->first();

        $pdf = PDF::loadView('karyawan.laporan.ctk', ['data' => $data, 'order' => $order, 'hitung' => $hitung]);
        return $pdf->stream();
    }
}