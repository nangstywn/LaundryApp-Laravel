@extends('layouts.master')
@section('content')
@section('title', 'Harga Laundry')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Daftar Harga</h3>
            </div>
            @section('tambah')
            <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-success tambah">
                <i class="fa fa-plus"></i>
                Tambahkan Harga
            </a>
            @endsection
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
                                <th>Jenis Cuci</th>
                                <th>Jenis</th>
                                <th>Layanan</th>
                                <th>Harga per-satuan</th>
                                <th>Satuan</th>
                                <th>Status</th>
                                <!-- <th>Cabang</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($harga as $hargas)
                            <tr>
                                <td>{{ $harga ->perPage()*($harga->currentPage()-1)+$i }}</td>
                                <td>{{ $hargas->jenis_cuci }}</td>
                                <td>{{ $hargas->jenis }}</td>
                                <td>{{ $hargas->layanan }}</td>
                                <td>{{ Rupiah::getRupiah($hargas->harga) }}</td>
                                <td>{{ $hargas->satuan }}</td>
                                @if($hargas->status == 'Aktif')
                                <td><span class="badge badge-success"
                                        style="border-radius:5px;">{{$hargas->status}}</span></td>
                                @elseif($hargas->status == 'Tidak Aktif')
                                <td><span class="badge badge-danger"
                                        style="border-radius:5px;">{{$hargas->status}}</span></td>
                                @endif
                                <!-- <td>{{-- $hargas->cabang->nama_cabang --}}</td> -->
                                <td>
                                    <form class="btn-group" action="{{route('harga.destroy', $hargas->id)}}"
                                        method="POST">
                                        <a href="#" data-toggle="modal" data-target="#modalEdit{{$hargas->id}}"
                                            class=" btn btn-info btn-sm edit"><i class="fa fa-edit"></i></a>
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm delete"
                                            data-nama="{{$hargas->id}}"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            {!! $harga->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($harga as $data)
@include('admin.laundry.harga-edit')
@endforeach
@include('admin.laundry.harga-create')
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

$('.delete').click(function(e) {
    e.preventDefault();
    let form = $(this).closest('form');
    let id = $(this).attr('data-nama');
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin menghapus data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidaaak!!',
        confirmButtonText: 'Ya, hapus aja!!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});
</script>
@endsection