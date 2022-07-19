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
                        <!-- onchange="this.form.submit" -->
                        <select name="id_karyawan" id="id_karyawan" class="form-control">
                            <option value="">-- Filter --</option>
                            @foreach ($filter as $item)
                            <option value="{{$item->id}}">{{$item->name}}@if (Auth::user()->level == "admin")
                                {{ '('.$item->cabang->nama_cabang.')' }}
                                @endif
                            </option>
                            @endforeach
                        </select>
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
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Statu Order</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="refresh_body">

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
        processing: true,
        serverSide: true,
        "language": {
            "processing": "<img style='width:50px; height:50px;' src='{{ asset('images/hug.gif') }}' />",
        },
        ajax: {
            url: "{{ url('pelayanan') }}",
            data: function(d) {
                d.id_karyawan = $('#id_karyawan').val();
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [{
                "data": null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1

                }
            },
            {
                data: 'order.invoice',
                name: 'order.invoice'
            },
            {
                data: 'customer.nama',
                name: 'customer.nama'
            },
            {
                data: 'item',
                name: 'item'
            },
            {
                data: 'order.status_order',
                name: 'order.status_order',
                render: function(data, type, row) {
                    status = '';
                    switch (data) {
                        case 'Selesai':
                            status = '<span class="badge badge-warning badge-pill">' + data +
                                '</span>';
                            break;
                        case 'Diambil':
                            status = '<span class="badge badge-success badge-pill">' + data +
                                '</span>';
                            break;
                        case 'Diproses':
                            status = '<span class="badge badge-danger badge-pill">' + data +
                                '</span>';
                            break;
                    }
                    return status;
                }
            },
            {
                data: 'total',
                name: 'total',
                render: $.fn.dataTable.render.number('.', '.', 0, 'Rp ')
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
});
$('#id_karyawan').on('change', function() {
    $('#datatable').DataTable().draw(true);
});
// Tampilkan Invoice
$(document).on('click', '#invoice', function() {
    var invoice = $(this).attr('data-id-invoice');
    $.ajax({
        type: 'GET',
        url: "/invoice-kar/" + invoice,
        success: function(data) {
            window.location.href = "/invoice-kar/" + invoice;
        }
    });
});
//delete detail order
//

$(document).on('click', '#delete', function() {
    var id = $(this).attr('data-id-delete');
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin menghapus data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#DC3545',
        confirmButtonText: 'Ya, Hapus Aja!',
        cancelButtonText: 'Tidak, Cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/pelayanan/" + id,
                method: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Dihapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#datatable').DataTable().ajax.reload();
                },
            });
        }
    })
});

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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
</script> -->
@endsection