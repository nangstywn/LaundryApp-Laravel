<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\User;
use Auth;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Cabang::orderBy('id', 'desc')->paginate(10);
        return view('admin.cabang.cabang', compact('cabang'));
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
        $this->validate($request, [
            "nama_cabang" => "required",
            "alamat_cabang" => "required"
        ]);
        $addCabang = new Cabang;
        $addCabang->nama_cabang = $request->nama_cabang;
        $addCabang->alamat_cabang = $request->alamat_cabang;
        $addCabang->save();
        return redirect()->route('admin-cabang.index')->with('success', 'Berhasil menambahkan data!');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only('nama_cabang', 'alamat_cabang');
        $cabang = Cabang::find($id);
        $cabang->update($input);
        return back()
            ->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cabang = Cabang::find($id);
        if (User::where('id_cabang', $id)->exists()) {
            return back()->withErrors(['errors' => 'Gagal menghapus data, ' . $cabang->nama_cabang . ' masih memiliki relasi']);
        }
        $cabang->delete();
        return back()->with('success', 'Data Berhasil Dihapus!');
    }
}