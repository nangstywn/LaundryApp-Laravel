<style>
input[type="date"] {
    font-size: 16px;
}
</style>
@extends('layouts.master')
@section('content')
@section('title', 'Pendapatan')
<div class="row">
    <div class="col">
        <div class="card">
            <!--Card header -->
            <div style="display:inline;" class="card-header border-0">
                <h3 class="mb-0">Pendapatan
                    <div class="col-md-7" style="float:right; margin-right:15px; margin-left:auto; text-align:right;">
                        <form action="" method="POST">
                            {{ method_field('GET') }}
                            <label for="start">Date : </label>
                            <input type="date" id="start" name="start" value="">

                            <label for="end">To : </label>
                            <input type="date" id="end" name="end" value="">

                            <button type="submit" class="btn btn-sm btn-primary" name="search"><i
                                    class="fas fa-search"></i></button>
                        </form>
                    </div>
                </h3>
            </div>
            <div class="card-body">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover" id="datatable">
                        @if(empty($result))
                        <div class="alert alert-warning">
                            <strong>Maaf !</strong> Tidak Ada Data Ditemukan.
                        </div>
                        @else
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Cabang</th>
                                <th style="text-align:right">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($result as $row)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->nama_cabang}}</td>
                                <!--<td>{{ Rupiah::getRupiah($row->total_hari + $row->spot_hari + $row->ongkir_hari) }}</td>-->
                                <!--<td>{{ Rupiah::getRupiah($row->total_bulan + $row->spot_bulan + $row->ongkir_bulan) }}</td>-->
                                <td style="text-align:right">
                                    {{ Rupiah::getRupiah($row->total + $row->spot + $row->ongkir) }}
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                            @endif
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
    });
});
</script>
@endsection