<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>King Laundry & Dry Cleaning</title>
    <link rel="icon" href="{{ asset('assets/img/ico_bg.png') }}">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="icon" href="{{URL::asset('assets/img/icon.ico')}}" type="image/x-icon" /> -->

    <!-- Fonts and icons -->

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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/atlantis.min.css')}}">
    <link href="{{URL::asset('assets/styles.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/prism.css')}}" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/demo.css')}}">
    <script src="{{URL::asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    tbody tr td {
        word-break: normal;
    }

    .checkbox {
        opacity: 0;
        position: absolute;
    }

    .dark .label {
        background-color: #111;
        border-radius: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
        position: relative;
        height: 19px;
        width: 40px;
        transform: scale(1.5);
    }

    .dark .label .ball {
        background-color: #fff;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
        height: 15px;
        width: 15px;
        transform: translateX(0px);
        transition: transform 0.2s linear;
    }

    .checkbox:checked+.label .ball {
        transform: translateX(21px);
    }


    .fa-moon {
        color: #f1c40f;
        font-size: 12px;
    }

    .fa-sun {
        color: #f39c12;
        font-size: 12px;
    }
    </style>
</head>

<body data-background-color="bg3" id="content">
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">

                <a href="index.html" class="logo">
                    <img src="{{URL::asset('assets/img/fix-bg.png')}}" alt="navbar brand" height="50px"
                        class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2" id="nav">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <div class="dark" style="margin-right:20px;">
                            <input type="checkbox" class="checkbox" id="chk" />
                            <label class="label" for="chk">
                                <i class="fas fa-sun"></i>
                                <i class="fas fa-moon"></i>
                                <div class="ball"></div>
                            </label>
                        </div>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="notification">4</span>
                            </a>
                            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <div class="dropdown-title">You have 4 new notification</div>
                                </li>
                                <li>
                                    <div class="notif-scroll scrollbar-outer">
                                        <div class="notif-center">
                                            <a href="#">
                                                <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        New user registered
                                                    </span>
                                                    <span class="time">5 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-success"> <i class="fa fa-comment"></i>
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Rahmad commented on Admin
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="{{URL::asset('assets/img/profile2.jpg')}}"
                                                        alt="Img Profile">
                                                </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Reza send messages to you
                                                    </span>
                                                    <span class="time">12 minutes ago</span>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
                                                <div class="notif-content">
                                                    <span class="block">
                                                        Farrah liked Admin
                                                    </span>
                                                    <span class="time">17 minutes ago</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="javascript:void(0);">See all notifications<i
                                            class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    @if(empty(Auth::user()->foto))
                                    <img src="{{URL::asset('assets/img/profile.jpg')}}" alt="..."
                                        class="avatar-img rounded-circle">
                                    @else
                                    <img src="{{URL::asset('images/'.Auth::user()->foto)}}" alt="..."
                                        class="avatar-img rounded-circle">
                                    @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                @if(empty(Auth::user()->foto))
                                                <img src="{{URL::asset('assets/img/profile.jpg')}}" alt="image profile"
                                                    class="avatar-img rounded">

                                            </div>
                                            @else
                                            <img src="{{URL::asset('images/'.Auth::user()->foto)}}" alt="image profile"
                                                class="avatar-img rounded">
                                        </div>
                                        @endif
                                        <div class="u-text">
                                            <h4>{{Auth::user()->name}}</h4>
                                            <p class="text-muted">{{Auth::user()->email}}</p><a href="profile.html"
                                                class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                        </div>
                                </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('kry.show')}}">My Profile</a>
                            <a class="dropdown-item" href="#">My Balance</a>
                            <a class="dropdown-item" href="#">Inbox</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
                        </li>
                </div>
                </ul>
                </li>
                </ul>
        </div>
        </nav>
        <!-- End Navbar -->
    </div>

    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="white" id="side">
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        @if(empty(Auth::user()->foto))
                        <img src="{{URL::asset('assets/img/profile.jpg')}}" alt="..." class="avatar-img rounded-circle">
                        @else
                        <img src="{{URL::asset('images/'. Auth::user()->foto)}}" alt="..."
                            class="avatar-img rounded-circle">
                        @endif
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                            <span>
                                {{Auth::user()->name}}
                                @if(Auth::user()->level=='karyawan')
                                <span class="user-level"><i class="badge badge-success"
                                        style="border-radius:5px; font-style:normal;">Karyawan</i>
                                </span>
                                @elseif(Auth::user()->level=='admin')
                                <span class="user-level"><i class="badge badge-success"
                                        style="border-radius:5px; font-style:normal;">Administrator</i>
                                </span>
                                @endif
                                <span class="caret"></span>
                            </span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="{{route('kry.show')}}">
                                        <span class="link-collapse">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('logout')}}">
                                        <span class="link-collapse">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->level=='admin')
                <ul class="nav nav-primary">
                    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::is('admin-cabang.index') ? 'active' : '' }}">
                        <a href="{{route('admin-cabang.index')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Cabang</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('kry') ? 'active' : '' }}">
                        <a href="{{route('kry')}}">
                            <i class="fas fa-user-friends"></i>
                            <p>Karyawan</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('data-harga') ? 'active' : '' }}">
                        <a href="{{route('data-harga')}}">
                            <i class="fas fa-tags"></i>
                            <p>Harga</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('pelayanan.index') ? 'active' : '' }}">
                        <a href="{{route('pelayanan.index')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('pendapatan') ? 'active' : '' }}">
                        <a href="{{route('pendapatan')}}">
                            <i class="fas fa-dollar-sign"></i>
                            <p>Pendapatan</p>
                        </a>
                    </li>

                </ul>
                @endif
                @if(Auth::user()->level == 'karyawan')
                <ul class="nav nav-primary">
                    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::is('pelayanan.index') ? 'active' : '' }}">
                        <a href="{{route('pelayanan.index')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('csr.index') ? 'active' : '' }}">
                        <a href="{{route('csr.index')}}">
                            <i class="fas fa-user-friends"></i>
                            <p>Customer</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/')}}">
                            <i class="fas fa-tags"></i>
                            <p>Frontend</p>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="content">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5" id="inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div class="page-header text-white">
                            <h4 class="page-title text-white">@yield('title')</h4>
                            <ul class="breadcrumbs text-white">
                                <li class="nav-home">
                                    <a href="{{route('home')}}">
                                        <i class="flaticon-home text-white"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a class="text-white" href="#">@yield('title')</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="ml-md-auto py-2 py-md-0">
                            <!-- <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a> -->
                            @yield('tambah')
                            @yield('invoice')
                            @yield('print')
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">
                    2018, made with <i class="fa fa-heart heart text-danger"></i> by <a
                        href="https://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{URL::asset('js/darkMode.js')}}"></script>

    <script src="{{URL::asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{URL::asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{URL::asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


    <!-- Chart JS -->
    <script src="{{URL::asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{URL::asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{URL::asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{URL::asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{URL::asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{URL::asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{URL::asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Atlantis JS -->
    <script src="{{URL::asset('assets/js/atlantis.min.js')}}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{URL::asset('js/ajax.js')}}"></script>
    <script src="{{URL::asset('assets/js/setting-demo.js')}}"></script>
    <!-- <script src="{{URL::asset('assets/js/demo.js')}}"></script> -->
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{URL::asset('assets/prism.js')}}"></script>
    <script src="{{URL::asset('assets/prism-normalize-whitespace.min.js')}}"></script>

    <script>
    // ES6 Modules or TypeScript
    import Swal from 'sweetalert2';
    // CommonJS
    const Swal = require('sweetalert2')

    Circles.create({
        id: 'circles-1',
        radius: 45,
        value: 60,
        maxValue: 100,
        width: 7,
        text: 5,
        colors: ['#f1f1f1', '#FF9E27'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    Circles.create({
        id: 'circles-2',
        radius: 45,
        value: 70,
        maxValue: 100,
        width: 7,
        text: 36,
        colors: ['#f1f1f1', '#2BB930'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    Circles.create({
        id: 'circles-3',
        radius: 45,
        value: 40,
        maxValue: 100,
        width: 7,
        text: 12,
        colors: ['#f1f1f1', '#F25961'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

    var mytotalIncomeChart = new Chart(totalIncomeChart, {
        type: 'bar',
        data: {
            labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
            datasets: [{
                label: "Total Income",
                backgroundColor: '#ff9e27',
                borderColor: 'rgb(23, 125, 255)',
                data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false //this will remove only the label
                    },
                    gridLines: {
                        drawBorder: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false
                    }
                }]
            },
        }
    });
    </script>
</body>

</html>