@extends('layouts.master')
@section('content')
@section('title', 'Invoice')
<script src="{{asset('js/html2canvas.js')}}"></script>
<style>
.invoice-title {
    display: flex;
    justify-content: center;
    /* align horizontal */
    align-items: center;
    /* align vertical */
    color: #1572E8;
    font-weight: bold;
    /* margin-left: 13px; */
}

.price {
    font-size: 32px;
    color: #1572E8;
    font-weight: bold;
}

.ekstra th,
td {
    padding: 10px;
}
</style>
<script>
function capture() {
    html2canvas(document.getElementById("nota")).then(function(canvas) {
        let dataURL = canvas.toDataURL("image/png", 1.0);
        //console.log(dataURL)
        let token = '{{ csrf_token() }}';
        let id = <?php echo json_encode($order->order->id); ?>;
        $.ajax({
            url: '/cetak-invoice',
            header: {
                'contentType': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'GET, POST, PUT',
            },
            method: 'post',
            enctype: 'multipart/form-data',
            data: {
                _token: token,
                id: id,
                image: dataURL,
            },
            success: function(data) {
                console.log('berhasil')
                window.location.replace('/send-wa/' + id);
            },
            error: function(data) {
                console.log('gagal')
            }
        })
    });
}
</script>
{!! csrf_field() !!}
<div class="row">
    <div class="col-md-12" id="nota">
        <div class="card card-invoice ">
            <div class="card-header">
                <div class="invoice-header ml-4 mr-4" style="display:flex; justify-content:space-between;">
                    <h3 class="invoice-title" style="font-size:32px;">
                        Invoice
                    </h3>
                    <div class="invoice-desc">
                        <div class="invoice-logo ">
                            <img src="{{URL::asset('assets/img/fix.jpg')}}" width="150px" alt="company logo">
                        </div>
                        Ngestiharjo, Kasihan, Kab. Bantul,<br> Daerah Istimewa Yogyakarta, 55184
                    </div>
                </div>
            </div>
            @if (Auth::user()->level == 'karyawan')
            @section('invoice')
            <button class="btn btn-success" onclick="capture()">
                <i class="fab fa-whatsapp"></i>
                Send Invoice
            </button>
            @endsection
            @section('print')
            <a href="{{url('print', $order->order->id)}}" target="_blank" class="btn btn-secondary">
                <i class="fa fa-print"></i>
                Print
            </a>
            @endsection
            @endif
            <div class="card-body">
                <div class="row ml-3 mr-3">
                    <div class="col-md-4 info-invoice">
                        <h5 class="sub"><b>Customer</b></h5>
                        <p class="">Customer : {{$order->customer->nama}}<br>
                            Alamat : {{$order->customer->alamat}}<br>
                            Hp : {{$order->customer->hp}}</p>
                    </div>
                    <div class="col-md-4 info-invoice">
                        <h5 class="sub"><b>Detail Invoice</b> </h5>
                        <p>No : <b>{{$order->order->invoice}}</b><br>
                            Transaksi : <i class="far fa-calendar-alt"></i>
                            {{Carbon\Carbon::parse($order->order->tgl_transaksi)->isoFormat('D MMM Y')}}<br>
                            Diambil : <i class="far fa-calendar-alt"></i>
                            @if ($order->order->tgl_ambil == "")
                            Belum Diambil
                            @else
                            {{Carbon\Carbon::parse($order->order->tgl_ambil)->isoFormat('D MMM Y')}}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 info-invoice">
                        <h5 class="sub font-weight-bold">Karyawan</h5>
                        <p class="">Karyawan : {{$order->user->name}}<br>
                            Cabang : {{$order->user->cabang->nama_cabang}}<br>
                            Hp : {{$order->user->hp}}</p>
                    </div>
                </div>
                <div class="row ml-3 mr-3">
                    <div class="col-md-12">
                        <div class="invoice-detail">
                            <div class="invoice-top">
                                <h3 class="title" style="font-size:32px; color:#1572E8;"><strong>Detail
                                        Order</strong>
                                </h3>
                            </div>
                            <div class="invoice-item">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td><strong>No</strong></td>
                                                <td><strong>Jenis Cuci</strong></td>
                                                <td><strong>Item</strong></td>
                                                <td><strong>Layanan</strong></td>
                                                <td><strong>Harga</strong></td>
                                                <td><strong>Jumlah</strong></td>
                                                <td><strong>Disc</strong></td>
                                                <td><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$item->hargas->jenis_cuci}}</td>
                                                <td>{{$item->hargas->jenis}}</td>
                                                <td>{{$item->hargas->layanan}}</td>
                                                <td>{{Rupiah::getRupiah($item->harga)}}</td>
                                                <td>{{$item->jumlah}}</td>
                                                <td>
                                                    @if($item->disc == null)
                                                    <span class="badge badge-danger">Tidak ada</span>
                                                    @else
                                                    <span class="badge badge-success">{{$item->disc.' %'}}</span>
                                                    @endif
                                                </td>
                                                <td>{{Rupiah::getRupiah($item->harga_akhir )}}
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="separator-solid  mb-3"></div> -->
                        <table class="ekstra" style="margin-left:auto; width: 25%;">
                            <tr>
                                <th>Spotting :</th>
                                @if ($item->order->spotting == null)
                                <td> TIdak Ada</td>
                                @else
                                <td> {{Rupiah::getRupiah($item->order->spotting)}}</td>
                                @endif
                            </tr>
                            <tr>
                                <th>Ongkos Kirim :</th>
                                @if ($item->order->ongkir == null)
                                <td> Tidak Ada </td>
                                @else
                                <td> {{Rupiah::getRupiah($item->order->ongkir)}}</td>
                                @endif
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row ml-3 mr-3">
                    <div class="col-sm-7 col-md-5 mb-3 mb-md-0 transfer-to">
                        <h5 class="sub"></h5>
                        <div class="account-transfer">
                            <p class="">

                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 transfer-total" style="text-align:right;">
                        <h5 class="sub"><strong>Total Bayar</strong></h5>
                        <div class="price">
                            {{Rupiah::getRupiah($order->total_bayar + $item->order->ongkir + $item->order->spotting)}}
                        </div>
                        <!-- <span>Taxes Included</span> -->
                    </div>
                </div>
                <div class="separator-solid"></div>
                <h6 class="text-uppercase mt-4 mb-3 ml-4 mr-4 fw-bold">
                    Catatan
                </h6>
                <p class="text-muted mb-0 ml-4 mr-4">
                    Lacak status pengerjaan laundry melalui link dengan memasukkan nomor invoice/nota
                    pada kolom pencarian.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection