@extends('layouts.master')
@section('content')
@section('title', 'Daftar Cabang')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Daftar Cabang</h3>
            </div>
            @section('tambah')
            <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-success tambah">
                <i class="fa fa-plus"></i>
                Tambahkan Cabang
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
                                <th>Nama Cabang</th>
                                <th>Alamat Cabang</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($cabang as $cabangs)
                            <tr>
                                <td>{{ $cabang ->perPage()*($cabang->currentPage()-1)+$i }}</td>
                                <td>{{ $cabangs->nama_cabang }}</td>
                                <td>{{ $cabangs->alamat_cabang }}</td>
                                <td>{{ $cabangs->created_at->Format('Y-m-d') }}</td>
                                <td>
                                    <form class="btn-group" action="{{route('admin-cabang.destroy', $cabangs->id)}}" method="POST">
                                        <a href="#" data-toggle="modal" data-target="#modalEdit{{$cabangs->id}}" class=" btn btn-info btn-sm edit"><i class="fa fa-edit"></i></a>
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm delete" data-nama="{{$cabangs->nama_cabang}}"><i class="fa fa-trash"></i></button>
                                    </form>
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
</div>
@foreach($cabang as $data)
@include('admin.cabang.cabang-edit')
@endforeach
@include('admin.cabang.cabang-create')
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
            text: "Ingin menghapus cabang " + nama + "",
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