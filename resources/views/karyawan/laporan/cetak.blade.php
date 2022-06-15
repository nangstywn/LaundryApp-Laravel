    <script src="{{URL::asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
WebFont.load({
    google: {
        "families": ["Lato:300,400,700,900"]
    },
    custom: {
        "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
            "simple-line-icons"
        ],
        urls: ['{{URL::asset("assets/css/fonts.min.css")}}']
    },
    active: function() {
        sessionStorage.fonts = true;
    }
});
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{public_path('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{public_path('assets/css/atlantis.min.css')}}">
    <style>
body {
    background-color: white;
}

.price {
    font-size: 32px;
    color: #1572E8;
    font-weight: bold;
}

.tabel table {
    margin-top: 2px;
    table-layout: fixed;
    width: 100%;
    border-collapse: separate;
    /*border-spacing: 50px 0;*/
}

.card-headerr {
    display: inline;
    margin: 0;
    position: relative;

}

.invoice-desc {
    display: inline;
    /*margin-left: 500px;*/
    position: fixed;
    top: -15px;
    right: 2px;
    /*backgound: #1572E8;*/
}

.invoice-title {
    margin-left: -15px;
}

.table-striped td {
    word-break: break-word;
    white-space: normal;

}

img {
    width: 100px;
}
    </style>
    <div class="card card-invoicee">
        <div class="card-headerr">
            <div class="invoice-title" style="font-size:32px;">
                Invoice
            </div>
            <div class="invoice-desc">
                <div class="invoice-logo">
                    <img src="{{public_path('assets/img/fix.jpg')}}" alt="company logo">
                </div>
                Ngestiharjo, Kasihan, Kab. Bantul,<br> Daerah Istimewa Yogyakarta, 55184
            </div>
        </div>
        <div class="separator-solid mb-3 mt-4"></div>
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
        <div class="card-bodyy m-0">
            <div class="row tabel ">
                <table class="">
                    <tr>
                        <th>Customer</th>
                        <th>Invoice</th>
                        <th>Karyawan</th>
                    </tr>
                    <tr>
                        <td>Customer : {{$order->customer->nama}}</td>
                        <td>No : <b>{{$order->order->invoice}}</td>
                        <td>Karyawan : {{$order->user->name}}</td>
                    </tr>
                    <tr>
                        <td>Alamat : {{$order->customer->alamat}}</td>
                        <td>Transaksi : <i class="far fa-calendar-alt"></i>
                            {{Carbon\Carbon::parse($order->order->tgl_transaksi)->isoFormat('D MMM Y')}}
                        </td>
                        <td>Cabang : {{$order->user->cabang->nama_cabang}}</td>
                    </tr>
                    <tr>
                        <td>Hp : {{$order->customer->hp}}</td>
                        <td>Diambil : <i class="far fa-calendar-alt"></i>
                            @if ($order->order->tgl_ambil == "")
                            Belum Diambil
                            @else
                            {{Carbon\Carbon::parse($order->order->tgl_ambil)->isoFormat('D MMM Y')}}
                            @endif
                        </td>
                        <td>Hp : {{$order->user->hp}}</td>
                    </tr>

                </table>
                <!--<div class="col-md-4 info-invoice">-->
                <!--    <h5 class="sub"><b>Customer</b></h5>-->
                <!--    <p class="">Customer : {{$order->customer->nama}}<br>-->
                <!--        Alamat : {{$order->customer->alamat}}<br>-->
                <!--        Hp : {{$order->customer->hp}}</p>-->
                <!--</div>-->
                <!--<div class="col-md-4 info-invoice">-->
                <!--    <h5 class="sub"><b>Detail Invoice</b> </h5>-->
                <!--    <p>No : <b>{{$order->order->invoice}}</b><br>-->
                <!--        Transaksi : <i class="far fa-calendar-alt"></i>-->
                <!--        {{Carbon\Carbon::parse($order->order->tgl_transaksi)->isoFormat('D MMM Y')}}<br>-->
                <!--        Diambil : <i class="far fa-calendar-alt"></i>-->
                <!--        @if ($order->order->tgl_ambil == "")-->
                <!--        Belum Diambil-->
                <!--        @else-->
                <!--        {{Carbon\Carbon::parse($order->order->tgl_ambil)->isoFormat('D MMM Y')}}-->
                <!--        @endif-->
                <!--    </p>-->
                <!--</div>-->
                <!--<div class="col-md-4 info-invoice">-->
                <!--    <h5 class="sub font-weight-bold">Karyawan</h5>-->
                <!--    <p class="">Karyawan : {{$order->user->name}}<br>-->
                <!--        Cabang : {{$order->user->cabang->nama_cabang}}<br>-->
                <!--        Hp : {{$order->user->hp}}</p>-->
                <!--</div>-->
            </div>
            <div class="row">
                <div class="invoice-detail">
                    <div class="invoice-top">
                        <h3 class="title mt-3" style="font-size:32px; color:#1572E8;"><strong>Detail
                                Order</strong>
                        </h3>
                    </div>
                    <div class="invoice-item">
                        <div class="table-responsive">
                            <table class="table table-striped" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <!--<td><strong>No</strong></td>-->
                                        <td><strong>Deskripsi</strong></td>
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
                                        <!--<td>{{$i}}</td>-->
                                        <td>{{$item->hargas->jenis}}</td>
                                        <td>{{Rupiah::getRupiah($item->harga)}}</td>
                                        <td>{{$item->jumlah}} {{$item->satuan}}</td>
                                        <td>
                                            @if($item->disc == null)
                                            <span class="badge badge-danger">Tidak ada</span>
                                            @else
                                            <span class="badge badge-success">{{$item->disc.' %'}}</span>
                                            @endif
                                        </td>
                                        <td>{{Rupiah::getRupiah($item->harga_akhir)}}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--<div class="separator-solid  mb-3"></div> -->
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
        <div class="separator-solid mb-0 mt-3"></div>
        <div class="card-footerr">
            <div class="row">
                <div class="col-sm-7 col-md-5">
                    <h5 class="sub"></h5>
                    <div class="account-transfer">
                        <p class="">

                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 transfer-total" style="text-align:right; margin-left:-15px">
                    <h5 class="sub mt-0"><strong>Total Bayar</strong></h5>
                    <div class="price">
                        {{Rupiah::getRupiah($order->total_bayar + $item->order->ongkir + $item->order->spotting)}}
                    </div>
                    <!-- <span>Taxes Included</span> -->
                </div>
            </div>
            <div class="separator-solid mb-0 mt-3"></div>
            <h6 class="text-uppercase mt-0 fw-bold">
                Catatan
            </h6>
            <p class="text-muted mb-0">
                Lacak status pengerjaan laundry melalui link dengan memasukkan nomor invoice/nota
                pada kolom pencarian.
            </p>
        </div>
    </div>