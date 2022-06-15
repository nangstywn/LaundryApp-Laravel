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
    width: 60%;
    margin: 0 auto;
}

/* .price {
    font-size: 32px;
    color: #1572E8;
    font-weight: bold;
}

.tabel table {
    margin-top: 2px;
    table-layout: fixed;
    width: 100%;
    border-collapse: separate;
}

.card-headerr {
    display: inline;
    margin: 0;
    position: relative;

}
.invoice-desc {
    display: inline;
    position: fixed;
    top: -15px;
    right: 2px;
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
} */
.item {
    display: inline;
    width: 50%;
}


/* .total th {
    text-align: right;
} */

.detail th {
    font-weight: light;
}

h5 {
    font-weight: normal;
}
    </style>
    <div class="card card-invoicee">
        <div class="card-headerr" style="text-align:center">
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
        <div class="card-bodyy">
            <table class="detail" style="margin-left:0; margin-right:auto; width: 60%;">
                <tr>
                    <th>No Invoice</th>
                    <td> : </td>
                    <td>{{$order->order->invoice}}</td>
                </tr>
                <tr>
                    <th>Pelanggan</th>
                    <td> : </td>
                    <td>{{$order->customer->nama}}</td>
                </tr>
                <tr>
                    <th>Karyawan</th>
                    <td> : </td>
                    <td>{{$order->user->name}}</td>
                </tr>
                <tr>
                    <th>Hp Customer</th>
                    <td> : </td>
                    <td>{{$order->customer->hp}}</td>
                </tr>
                <tr>
                    <th>Tgl Transaksi</th>
                    <td> : </td>
                    <td><i class="far fa-calendar-alt"></i>
                        {{Carbon\Carbon::parse($order->order->tgl_transaksi)->isoFormat('D MMM Y H:m:s ')}}
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="invoice-detail mt-3">
                    <div class="invoice-itemm ml-3">
                        @foreach($data as $item)
                        <div class="harga mb-2 text-decoration-none">
                            <h5 class="mb-0"><b>{{$item->hargas->jenis}}</b> ({{ $item->hargas->jenis_cuci }},
                                @if($item->hargas->layanan == 'Reguler (2-3 Hari)')
                                Reguler)
                                @elseif($item->hargas->layanan == 'One Day (1 Hari)')
                                One Day)
                                @else
                                {{ $item->hargas->layanan }})
                                @endif

                            </h5>
                            <div class="item" style="width: 100%; clear:both;">
                                <span class="ml-3">{{$item->jumlah}} x
                                    {{ $item->harga }}</span>
                                <span
                                    style="position: absolute; right:0;">{{ Rupiah::getRupiah($item->harga_akhir) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div style="width:25%; margin-left:auto; margin-right:0" class="separator-solid"></div>

            <table class="ekstra" style="margin-left:auto; margin-right:auto; width: 100%;">
                <tr>
                    <th style="text-align:left; width:70px;">Total Item</th>
                    <td> : </td>
                    <td>{{$hitung}}</td>
                    <th style="text-align:right">Spotting </th>
                    <td colspan="2" style="width:5px; text-align:right;"> : </td>
                    @if ($item->order->spotting == null)
                    <td style="text-align: right"> 0 </td>
                    @else
                    <td style="text-align: right"> {{Rupiah::getRupiah($item->order->spotting)}}</td>
                    @endif
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <td></td>
                    <th style="text-align:right">Ongkos Kirim </th>
                    <td colspan="2" style="width:10px; text-align:right;"> : </td>
                    @if ($item->order->ongkir == null)
                    <td style="text-align: right"> 0 </td>
                    @else
                    <td style="text-align: right"> {{Rupiah::getRupiah($item->order->ongkir)}}</td>
                    @endif
                </tr>
            </table>
        </div>
        <div class="separator-solid mb-2 mt-3"></div>
        <div class="card-footerr">
            <div class="roww">
                <div class="col-sm-12 col-md-7 transfer-totall " style="text-align:right; margin-left:-15px">
                    <table class="total" style="margin-left:auto; margin-right:0; width: 70%;">
                        <tr>
                            <th style="text-align:right;">Total Bayar</th>
                            <td colspan="2" style="width:10px; text-align:right;"> : </td>
                            <td style="text-align:right;">
                                {{Rupiah::getRupiah($order->total_bayar + $item->order->ongkir + $item->order->spotting)}}
                            </td>
                        </tr>
                    </table>
                    <!-- <h5 class="sub mt-0"><strong>Total Bayar</strong></h5>
                    <div class="price">
                        {{Rupiah::getRupiah($order->total_bayar + $item->order->ongkir + $item->order->spotting)}}
                    </div> -->
                    <!-- <span>Taxes Included</span> -->
                </div>
            </div>
            <!-- <div class="separator-solid mb-0 mt-3"></div>
            <h6 class="text-uppercase mt-0 fw-bold">
                Catatan
            </h6>
            <p class="text-muted mb-0">
                Lacak status pengerjaan laundry melalui link dengan memasukkan nomor invoice/nota
                pada kolom pencarian.
            </p> -->
        </div>
    </div>