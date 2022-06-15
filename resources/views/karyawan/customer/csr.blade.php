@extends('layouts.master')
@section('content')
@section('title', 'Daftar Customer')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Daftar Customer</h3>
            </div>
            @section('tambah')
            <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-success tambah">
                <i class="fa fa-plus"></i>
                Tambahkan Customer
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
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($customer as $customers)
                            <tr>
                                <td>{{ $customer ->perPage()*($customer->currentPage()-1)+$i }}</td>
                                <td>{{ $customers->nama }}</td>
                                <td>{{ $customers->alamat }}</td>
                                <td>{{ $customers->hp }}</td>
                                <td>
                                    <form action="{{route('csr.destroy', $customers->id)}}" method="POST">
                                        <a href="#" data-toggle="modal" data-target="#modalEdit{{$customers->id}}"
                                            class=" btn btn-info btn-sm edit"><i class="fa fa-edit"></i></a>
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm delete"
                                            data-nama="{{$customers->nama}}"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            {!! $customer->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('karyawan.customer.csr-create')
@foreach ($customer as $data )
@include('karyawan.customer.csr-edit')
@endforeach
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
    let nama = $(this).attr('data-nama');
    e.preventDefault();
    Swal.fire({
        title: 'Yakin ?',
        text: "Ingin menghapus customer " + nama + "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#DC3545',
        cancelButtonText: 'Tidak, Cancel!',
        confirmButtonText: 'Ya, Hapus Aja!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});
</script>
@endsection