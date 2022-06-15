<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Auth;

class AjaxController extends Controller
{
    public function listharga(Request $request)
    {
        if (Auth::user()->level == "karyawan") {
            // beda harga beda cabang
            // $cabang = User::where('id', Auth::user()->id)->first()->id_cabang;
            $id = Harga::where('jenis_cuci', $request->jenisCuci)
                ->where('jenis', $request->jenis)
                ->where('layanan', $request->layanan)
                // ->where('id_cabang', $cabang)
                ->where('status', 'Aktif')
                ->first()->id;
            $list_harga = Harga::select('id', 'harga')
                ->where('id', $id)
                ->get();
            $select = '';
            $select .= '
                        <div class="form-group has-success harga">
                        <label for="id" class="control-label">Harga</label>
                        <select id="harga" class="form-control" name="harga" value="harga">
                        ';
            foreach ($list_harga as $studi) {
                $select .= '<option value="' . $studi->harga . '">' . $studi->harga . '</option>';
            }
            '
                        </select>
                        </div>
                        </div>';
            return $select;
        } else {
            return redirect('/home');
        }
    }

    public function harga($layanan)
    {
        $harga = Harga::where('jenis_cuci', $layanan)->get();
        return response()->json($harga);
    }

    public function cat(Request $r)
    {
        $harga = Harga::where([
            "jenis_cuci" => $r->jenisCuci,
            "jenis" => $r->jenis
        ])
            //beda harga beda cabang
            // ->where('id_cabang', Auth::user()->id_cabang)
            ->get();
        if (count($harga) > 0) {
            $hargas = [
                [
                    "id" => "",
                    "layanan" => "Pilih Layanan"
                ]
            ];
            foreach ($harga as $i) {
                if ($i->status == 'Aktif') {
                    array_push($hargas, [
                        "layanan" => ucwords($i->layanan)
                    ]);
                }
            }
            return response()->json($hargas);
        } else {
            return response()->json([
                "layanan" => "Data tidak ditemukan"
            ]);
        }
    }

    public function getid(Request $request)
    {
        if (Auth::user()->level == "karyawan") {
            // beda harga beda cabang
            // $cabang = User::where('id', Auth::user()->id)->first()->id_cabang;
            $id = Harga::where('jenis_cuci', $request->jenisCuci)
                ->where('jenis', $request->jenis)
                ->where('layanan', $request->layanan)
                // ->where('id_cabang', $cabang)
                ->where('status', 'Aktif')
                ->first()->id;
            $list_harga = Harga::select('id')
                ->where('id', $id)
                ->get();
            $select = '';
            foreach ($list_harga as $studi) {
                $select .= '<input type="hidden" name="id_harga" value="' . $studi->id . '">';
            };

            return $select;
        } else {
            return redirect('/home');
        }
    }

    public function satuan(Request $request)
    {
        // beda harga beda cabang
        $cabang = User::where('id', Auth::user()->id)->first()->id_cabang;
        $id = Harga::where('jenis_cuci', $request->jenisCuci)
            ->where('jenis', $request->jenis)
            // ->where('id_cabang', $cabang)
            ->first()->id;
        $list_harga = Harga::select('id', 'satuan')
            ->where('id', $id)
            ->get();
        $select = '';
        $select .= '
                        <div class="form-group has-success">
                        <label for="id" class="control-label">Satuan</label>
                        <select id="satuan_ajax" class="form-control" name="satuan" value="satuan">
                        ';
        foreach ($list_harga as $studi) {
            $select .= '<option value="' . $studi->satuan . '">' . $studi->satuan . '</option>';
        }
        '
                        </select>
                        </div>';
        return $select;
    }

    public function jenis($jenisCuci)
    {
        //$jenis = Kategori::orderBy('created_at','DESC')->get();
        $jenis = Harga::where('jenis_cuci', $jenisCuci)
            //beda harga beda cabang
            // ->where('id_cabang', Auth::user()->id_cabang)
            ->groupBy('jenis')->get();
        $jenisPush = [
            [
                "id" => '',
                "jenis" => "Jenis Item"
            ]
        ];

        if (count($jenis) > 0) {
            foreach ($jenis as $jen) {
                $lay = Harga::where([
                    "jenis_cuci" => $jenisCuci,
                    "jenis" => $jen->jenis
                ])->get();
                array_push($jenisPush, ["jenis" => $jen->jenis/*,
                "item" => count($lay)*/]);
            }
            return response()->json($jenisPush);
        }
    }
}