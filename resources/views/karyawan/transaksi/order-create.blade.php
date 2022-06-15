@extends('layouts.master')
@section('content')
@section('title', 'Tambah Order')
<style>
.select2-selection__rendered {
    line-height: 36px !important;
}

.select2-container .select2-selection--single {
    height: 39px !important;
}

.select2-selection__arrow {
    height: 38px !important;
}
</style>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="row" style="display:flex; justify-content:space-between; align-items: left;">
                    <div class="col-md-3">
                        <h5 class="modal-title" style="display:flex; align-items:center;">Tambah
                            Order</h5>
                    </div>
                    <div class="col-md-3" style="margin-left:auto;">
                        <a href="" class="btn btn-default center-block" id="refresh">Refresh</a>
                    </div>
                </div>
            </div>
            <form action="{{route('pelayanan.store')}}" method="POST" onsubmit="save.disabled = true; return true;">
                @csrf
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-body">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Nama Customer</label>
                                    <select name="id_customer" id="id_customer" class="form-control" required>
                                        <option value=""> Pilih Customer </option>
                                        @foreach ($csr as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="jenis_cuci">Jenis Cuci</label>
                                    <select name="jenis_cuci" id="jenis_cuci_ajax" class="form-control" required>
                                        <option value=""> Jenis Cuci </option>
                                        @foreach ($harga as $item)
                                        <option value="{{$item->jenis_cuci}}">{{$item->jenis_cuci}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis">Jenis Item</label>
                                    <select name="jenis" id="jenis_ajax" class="form-control" disabled="disabled"
                                        class="required">
                                        <option value=""> Jenis Item</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="layanan">Layanan</label>
                                    <select name="layanan" id="layanan_ajax" class="form-control" disabled="disabled"
                                        class="required">
                                        <option value=""> Pilih Layanan </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" step="any" name="jumlah"
                                        placeholder="Jumlah/Berat Pakaian" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <span id="select-satuan"></span>
                            </div>
                            <div class="col-md-2">
                                <span id="select-harga"></span>
                            </div>
                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <label class="jarak">Jarak Pengantaran</label>
                                    <select name="jarak" onchange="yesnoCheck(this);" class="form-control" value="">
                                        <option value="">Jarak </option>
                                        <option value="10000">1 - 5 Km</option>
                                        <option value="15000">5 - 10 Km</option>
                                        <option value="20000">10 - 20 Km</option>
                                        <option value="other">Diatas 20 Km</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <label class="spotting">Spotting</label>
                                    <select name="spotting" id="spotting" class="form-control">
                                        <option value="">Spotting</option>
                                        <option value="15000"> Ringan </option>
                                        <option value="20000"> Sedang </option>
                                        <option value="50000"> Berat </option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="disc">Diskon</label>
                                    <input type="number" name="disc" placeholder="Diskon %" class="form-control">
                                </div>
                            </div>
                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <div id="ifYes" style="display: none;">
                                        <label for="Ongkir">Masukkan Ongkos Kirim</label>
                                        <input type="text" name="ongkir" class="form-control" /><br />
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <span id="id_harga"></span>
                        <input type="hidden" name="tgl">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="save" id="input-order" class="btn btn-success"><i
                                class="fa fa-btn fa-save text"></i> Save
                        </button>
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#id_customer, #jenis_ajax').select2();
});



function yesnoCheck(that) {
    if (that.value == "other") {
        // alert("check");
        document.getElementById("ifYes").style.display = "block";
    }
}

$('#refresh').click(function() {
    location.reload();
});
</script>
@endsection