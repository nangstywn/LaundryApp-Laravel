@extends('layouts.master')
@section('content')
@section('title', 'Daftar Order')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="card-title">Daftar Transaksi
                    <div class="col-md-3" style="float:right;">
                        <form action="" method="POST">
                            {{ method_field('GET') }}
                            <select name="id_karyawan" id="id_karyawan" class="form-control"
                                onchange="this.form.submit()">
                                <option value="">-- Filter --</option>
                                <option value="0"> All </option>
                                @foreach ($filter as $item)
                                <option value="{{$item->id}}">{{$item->name}}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </h3>
            </div>
            @if(Auth::user()->level=='karyawan')
            @section('tambah')
            @if(!$transaksi->isEmpty())
            <a href="{{route('detail.order')}}" class="btn btn-success tambah">
                <i class="fa fa-plus"></i> Tambah Order
            </a>
            @else
            <a href="{{route('pelayanan.create')}}" class="btn btn-success tambah">
                <i class="fa fa-plus"></i>
                Tambah Order
            </a>
            @endif
            @endsection
            @endif

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
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Jumlah Item</th>
                                <th>Statu Order</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="refresh_body">
                            @php $i = 1; @endphp
                            @foreach($detailOrder as $orders)
                            <tr>
                                <td>{{ $detailOrder ->perPage()*($detailOrder->currentPage()-1)+$i }}</td>
                                <td>{{ $orders->order->id}}</td>
                                <td>{{ $orders->order->invoice}}</td>
                                <td>{{ $orders->customer->nama}}</td>
                                <td>{{ $orders->item.' item'}}</td>
                                <td>
                                    @if ($orders->order->status_order == 'Selesai')
                                    <span class="badge badge-success" style="border-radius:5px;">Selesai</span>
                                    @elseif($orders->order->status_order == 'Diambil')
                                    <span class="badge badge-default" style="border-radius:5px;">Sudah Diambil</span>
                                    @elseif($orders->order->status_order == 'Diproses')
                                    <span class="badge badge-danger" style="border-radius:5px;">Sedang Proses</span>
                                    @endif
                                </td>
                                <td>{{ Rupiah::getRupiah($orders->total)}}</td>
                                <td>
                                    @if ($orders->order->status_order == "Selesai")
                                    @if(Auth::user()->level=='karyawan')
                                    <a class="btn btn-sm btn-secondary" data-id-ambil="{{$orders->id_order}}" id="ambil"
                                        style="color:white">Ambil</a>
                                    @endif
                                    <a href="{{url('invoice-kar', $orders->id_order)}}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-file-invoice"></i>
                                        Invoice</a>
                                    @elseif($orders->order->status_order == "Diproses")
                                    @if(Auth::user()->level=='karyawan')
                                    <a class="btn btn-sm btn-success" data-id-selesai="{{$orders->id_order}}"
                                        id="selesai" style="color:white">Selesai</a>
                                    @endif
                                    <a href="{{url('invoice-kar', $orders->id_order)}}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-file-invoice"></i>
                                        Invoice</a>
                                    @elseif($orders->order->status_order == "Diambil")
                                    <a href="{{url('invoice-kar', $orders->id_order)}}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-file-invoice"></i>
                                        Invoice</a>
                                    @endif
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('karyawan.transaksi.status-order')
</div>
<script>
$(document).ready(function() {
    $('#datatable').DataTable({
        columnDefs: [{
            targets: [0, ],
            visible: true,
            searchable: false,
            orderable: false,
        }],
        pageLength: 5,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, 'All']
        ],
    });
});

// Tampilkan Modal Ubah Status Order
// $(document).on('click', '#klikmodal', function() {
//     var id = $(this).attr('data-id');
//     var customer = $(this).attr('data-id-nama');
//     var status_order = $(this).attr('data-id-order');
//     $("#id").val(id)
//     $("#customer").val(customer)
//     $("#status_order").val(status_order)
// });

// Ubah Status Menjadi Diambil
$(document).on('click', '#ambil', function() {
    var id = $(this).attr('data-id-ambil');
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin mengubah status menjadi Diambil ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#DC3545',
        confirmButtonText: 'Ya, ubah status!',
        cancelButtonText: 'Tidak, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.get(' {{Url("ubah-status-ambil")}}', {
                '_token': $('meta[name=csrf-token]').attr('content'),
                id: id
            }, function(resp) {
                location.reload();
            });
        }
    })
});

$(document).on('click', '#selesai', function() {
    var id = $(this).attr("data-id-selesai");
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin mengubah status menjadi Selesai ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#DC3545',
        confirmButtonText: 'Ya, ubah status!',
        cancelButtonText: 'Tidak, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.get('{{Url("ubah-status-order")}}', {
                '_token': $('meta[name=csrf-token]').attr('content'),
                id: id
            }, function(resp) {
                location.reload();
            });
        }
    })
});
</script>
@endsection