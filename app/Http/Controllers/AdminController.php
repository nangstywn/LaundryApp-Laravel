<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Harga;
use App\Models\Customer;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Carbon\carbon;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function kry()
    {
        if (Auth::user()->level === "admin") {
            $cabang = Cabang::orderBy('nama_cabang', 'asc')->get();
            $kry = User::where('level', 'karyawan')->paginate();
            return view('admin.pengguna.kry', compact('kry', 'cabang'));
        } else {
            return redirect('home');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->level === "admin") {
            if (User::where('username', $request->username)->exists()) {
                return redirect()->back()->withErrors(['errors' => 'Username ' . $request->username . ' sudah ada !!']);
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $ext = $file->getClientOriginalExtension();
                $fileFoto = $request->username . '.' . $ext;
                $request->file('foto')->move('images/', $fileFoto);
            } else {
                $fileFoto = null;
            }
            $adduser = new User();
            $adduser->name = $request->name;
            $adduser->username = $request->username;
            $adduser->level = $request->level;
            $adduser->status = 'Aktif';
            $adduser->alamat = $request->alamat;
            $adduser->hp = $request->hp;
            $adduser->password = bcrypt($request->password);
            $adduser->foto = $fileFoto;
            $adduser->id_cabang = $request->id_cabang;
            $adduser->save();
            return back()->with('success', 'Data Berhasil Ditambah!');
        } else {
            return redirect('home')->with('error', 'Data Gagal Ditambah!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.pengguna.detail-kry', compact('user'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => Rule::unique('users')->ignore($id),
        ], [
            'username.string' => 'Username harus berupa string',
            'username.unique' => 'Username sudah terdaftar',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::find($id);
        if ($request->hasFile('foto')) {
            $image_path = "images/" . $user->foto;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $fileFoto = $request->username . '.' . $ext;
            $destination = 'images/';
            $file->move($destination, $fileFoto);
        } else {
            $fileFoto = $user->foto;
        }
        $adduser = User::find($id);
        $adduser->name = $request->name;
        $adduser->username = $request->username;
        $adduser->status = $request->status;
        $adduser->alamat = $request->alamat;
        $adduser->hp = $request->hp;
        $adduser->foto = $fileFoto;
        $adduser->id_cabang = $request->id_cabang;
        $adduser->save();
        return back()->with('success', 'Data Berhasil Ditambah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kry = User::find($id);
        if (Customer::where('id_user', $kry->id)->exists()) {
            return redirect()->back()->withErrors(['errors' => 'Data gagal dihapus, data masih memiliki relasi. Jika tidak digunakan silahkan edit dan non aktifkan status']);
        }
        $path = public_path() . "/images/" . $kry->foto;
        if (File::exists($path)) {
            //File::delete($image_path);
            unlink($path);
        }
        $kry->delete();
        return back()->with('success', 'Data Berhasil Dihapus!');
    }

    public function dataharga()
    {
        if (Auth::user()->level == "admin") {
            // $harga = Harga::selectRaw('harga.*,c.nama_cabang')
            //     ->Join('cabang as c', 'c.id', '=', 'harga.id_cabang')
            //     ->orderBy('id', 'DESC')->paginate(); // Ambil data harga
            $harga = Harga::orderBy('status', 'asc')->paginate(); // Ambil data harga
            //$karyawan = User::where('level','karyawan')->first(); // Cek Apakah sudah ada karyawan atau belum 
            $cabang = Cabang::orderBy('nama_cabang', 'asc')->get();
            return view('admin.laundry.harga', compact('harga', 'cabang'));
        } else {
            return redirect('home');
        }
    }
    public function hargastore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_cuci' => 'required|string',
            'jenis' => 'required|string',
            'layanan' => 'required|string',
            'harga' => 'required|integer',
            'satuan' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        //dd($request->all());
        if (Auth::user()->level == "admin") {
            //check harga yang sudah ada
            if (Harga::where('jenis_cuci', $request->jenis_cuci)->where('jenis', $request->jenis)->where('layanan', $request->layanan)->exists()) {
                return back()->withErrors(['error' => 'Gagal Ditambah, Data Sudah Ada. Jika ingin mengubah silahkan edit harga']);
            }
            $addharga = new harga();
            $addharga->jenis_cuci = $request->jenis_cuci;
            $addharga->jenis = ucwords($request->jenis);
            $addharga->layanan = $request->layanan;
            $addharga->harga = $request->harga;
            $addharga->satuan = $request->satuan;
            $addharga->jumlah = 1; // satuan gram
            $addharga->status = 'aktif';
            $addharga->save();

            //alert()->success('Tambah Data Harga Berhasil');
            return redirect('data-harga')
                ->with(['success' => 'Tambah Data Harga Berhasil']);
        } else {
            return redirect('data-harga')
                ->with(['errors' => 'Tambah Data Harga Gagal']);
        }
    }

    public function hargaupdate(Request $request, $id)
    {
        // if (Harga::where('jenis_cuci', $request->jenis_cuci)->where('jenis', $request->jenis)->where('layanan', $request->layanan)->exists()) {
        //     return back()->withErrors(['error' => 'Gagal Ditambah, Data Sudah Ada. Jika ingin mengubah silahkan edit harga']);
        // }
        $harga = Harga::find($id);
        $input = $request->only('jenis_cuci', 'layanan', 'satuan', 'harga', 'status', 'jenis');
        $harga->update($input);
        return back()
            ->with(['success' => 'Edit Data Harga Berhasil']);
    }

    public function hargadestroy($id)
    {
        $harga = Harga::find($id);
        if (DetailOrder::where('id_harga', $harga->id)->exists()) {
            return back()->withErrors(['errors' => 'Gagal menghapus data, data ini masih memiliki relasi. Jika tidak digunakan silahkan edit dan non aktifkan status']);
        }
        $harga->delete();
        return back()->with('success', 'Data Berhasil Dihapus!');
    }

    public function pendapatan(Request $request)
    {
        if (Auth::user()->level == "admin") {
            // 
            if ($request->method() == 'GET') {
                if ($request->start != null && $request->end != null) {
                    $start = date("Y-m-d", strtotime($request->start));
                    $end = date("Y-m-d", strtotime($request->end));
                    $spot = DetailOrder::join('order', 'order.id', '=', 'id_order')->join('users', 'users.id', '=', 'id_user')->join('cabang', 'cabang.id', 'id_cabang')
                        ->selectRaw('cabang.nama_cabang, users.id_cabang, SUM(harga_akhir) as total, order.spotting as spot, order.ongkir as ongkir')->groupBy('order.id')
                        ->whereBetween('detail_order.created_at', [$start, $end])->orderBy('cabang.id', 'asc')
                        ->get()->groupBy('id_cabang');
                    if (!$spot->isEmpty()) {
                        foreach ($spot as $spt) {
                            foreach ($spt as $key => $s) {
                                $i[] =  $s;
                            }
                        }
                    } else {
                        $i = null;
                    }
                } else {
                    $spot = DetailOrder::join('order', 'order.id', '=', 'id_order')->join('users', 'users.id', '=', 'id_user')->join('cabang', 'cabang.id', 'id_cabang')
                        ->selectRaw('cabang.nama_cabang, users.id_cabang, SUM(harga_akhir) as total, order.spotting as spot, order.ongkir as ongkir')->groupBy('order.id')
                        ->get()->groupBy('id_cabang');

                    if (!$spot->isEmpty()) {
                        foreach ($spot as $spt) {
                            foreach ($spt as $key => $s) {
                                $i[] =  $s;
                            }
                        }
                    } else {
                        $i = null;
                    }
                }
            } else {
                $spot = DetailOrder::join('order', 'order.id', '=', 'id_order')->join('users', 'users.id', '=', 'id_user')->join('cabang', 'cabang.id', 'id_cabang')
                    ->selectRaw('cabang.nama_cabang, users.id_cabang, SUM(harga_akhir) as total, order.spotting as spot, order.ongkir as ongkir')->groupBy('order.id')
                    ->get()->groupBy('id_cabang');

                if (!$spot->isEmpty()) {
                    foreach ($spot as $spt) {
                        foreach ($spt as $key => $s) {
                            $i[] =  $s;
                        }
                    }
                } else {
                    $i = null;
                }
            }
            if (!empty($i)) {
                $result = array_reduce($i, function ($carry, $val) {
                    if (!isset($carry[$val['id_cabang']])) {
                        $carry[$val['id_cabang']] = $val;
                    } else {
                        $carry[$val['id_cabang']]['total'] += $val['total'];
                        $carry[$val['id_cabang']]['spot'] += $val['spot'];
                        $carry[$val['id_cabang']]['ongkir'] += $val['ongkir'];
                    }
                    return $carry;
                });
            } else {
                $result = null;
            }
            return view('admin.laundry.pendapatan', compact('result',));
        } else {
            return redirect('home');
        }
    }
}