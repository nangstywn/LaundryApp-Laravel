@extends('layouts.master')
@section('content')
@section('title', 'Daftar Karyawan')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Daftar Karyawan</h3>
            </div>
            @section('tambah')
            <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-success tambah">
                <i class="fa fa-plus"></i>
                Tambahkan Karyawan
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Nama Cabang</th>
                                <th>No Telpon</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($kry as $krys)
                            <tr>
                                <td>{{ $kry ->perPage()*($kry->currentPage()-1)+$i }}</td>
                                <td>{{ $krys->name }}</td>
                                <td>{{ $krys->username }}</td>
                                <td>{{ $krys->cabang->nama_cabang }}</td>
                                <td>{{ $krys->hp }}</td>
                                @if($krys->status == 'Aktif')
                                <td><span class="badge badge-success"
                                        style="border-radius:5px;">{{$krys->status}}</span></td>
                                @elseif($krys->status == 'Tidak Aktif')
                                <td><span class="badge badge-danger" style="border-radius:5px;">{{$krys->status}}</span>
                                </td>
                                @endif
                                <td>
                                    <form class=" btn-group" action="{{route('kry.destroy', $krys->id)}}" method="POST">
                                        <a href="#" data-toggle="modal" data-target="#modalEdit{{$krys->id}}"
                                            class=" btn btn-info btn-sm edit"><i class="fa fa-edit"></i></a>
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm delete"
                                            data-nama="{{$krys->nama}}"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            {!! $kry->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($kry as $data)
@include('admin.pengguna.kry-edit')
@endforeach
@include('admin.pengguna.kry-create')
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
    let form = $(this).closest('form');
    let name = $(this).attr('name');
    let nama = $(this).attr('data-nama');
    e.preventDefault();
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin menghapus kategori " + nama + "",
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