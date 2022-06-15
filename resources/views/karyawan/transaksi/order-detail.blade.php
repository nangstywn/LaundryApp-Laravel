@extends('layouts.master')
@section('content')
@section('title', 'Detail Order')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="box-body">
                @if(!empty($detail))
                <table class="table table-bordered table-striped">
                    <!-- <tr>
                        <td>No. Invoice</td>
                        <td>:</td>
                        <td></td>
                    </tr> -->
                    <tr>
                        <td>Nama Customer</td>
                        <td>:</td>
                        <td>{{$detail->customer->nama}}</td>
                    </tr>
                    <tr>
                        <td>Nama Karyawan</td>
                        <td>:</td>
                        <td>{{auth()->user()->name}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Order</td>
                        <td>:</td>
                        <td> {{date('Y-m-d')}} </td>
                    </tr>
                    <!-- <tr>
                        <td>Status Payment</td>
                        <td>:</td>
                        <td></td>
                    </tr> -->
                </table>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if(!$details->isEmpty())
                <h4>Detail Pinjam</h4>
                <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-success tambah">
                    <i class="fa fa-plus"></i>Tambah Item</a>
                @else
                <h4>Detail Pinjam</h4>
                <a href="{{route('pelayanan.create')}}" class="btn btn-success tambah">
                    <i class="fa fa-plus"></i>Tambah Item</a>
                @endif
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Jenis Cuci</th>
                        <th>Item</th>
                        <th>Layanan</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($details as $row)
                        <tr>
                            <td>{{ $row->hargas->jenis_cuci }}</td>
                            <td>{{ $row->hargas->jenis }}</td>
                            <td>{{ $row->hargas->layanan }}</td>
                            <td>{{ $row->hargas->satuan }}</td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ Rupiah::getRupiah($row->harga) }}</td>
                            <td>{{ Rupiah::getRupiah($row->harga_akhir)}}</td>
                            <td>
                                <form action="{{route('destroy.detail.order', $row->id)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="box-footer">
                    <a href="" data-toggle="modal" data-target="#modalExtra" onclick="disableClicks(this);"
                        class=" btn btn-success float-right" style="margin:10px;"><i class="fa fa-btn fa-save text"></i>
                        Save</a>
                </div>
            </div>
        </div>
    </div>
    @include('karyawan.transaksi.detail-create')
    @include('karyawan.transaksi.extra')
</div>
<script>
function disableClicks(element) {
    element.onclick = function() {
        return false;
    };
}
</script>
@endsection