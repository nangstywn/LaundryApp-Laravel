@extends('layouts.master')
@section('title','Profile')
@section('content')

<body>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-with-nav">
                <div class="card-header">
                    <div class="row row-nav-line">
                        <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                            <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home"
                                    role="tab" aria-selected="true">Timeline</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"
                                    aria-selected="false">Profile</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab"
                                    aria-selected="false">Settings</a> </li>
                        </ul>
                    </div>
                </div>
                <form action="{{route('kry.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    {{ method_field('PUT') }}
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="{{$user->username}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group form-group-default">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        value="{{$user->level}}" style="background-color:white;" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default">
                                    <label>Status</label>
                                    <input type="text" class="form-control" id="status" name="status"
                                        value="{{$user->status}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="{{$user->hp}}" name="hp"
                                        placeholder="Contoh: 08xxx">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{$user->alamat}}" name="alamat">
                                </div>
                            </div>
                        </div>
                        <div class=" row mt-3 mb-1">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Tempat Kerja</label>
                                    <select name="id_cabang" id="cabang" class="form-control">
                                        @if($user->level == 'karyawan')
                                        <option value="{{$user->id_cabang}}">{{$user->cabang->nama_cabang}}
                                        </option>
                                        @else
                                        <option value="0">Pemilik King Laundry</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-default">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto"
                                value="{{URL::asset('images/'.$user->foto)}}">
                        </div>
                        <div class="text-right mt-3 mb-3">
                            <button class="btn btn-success">Update</button>
                            <button class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            @if(empty($user->foto))
                            <img src="{{URL::asset('assets/img/profile.jpg')}}" alt="..."
                                class="avatar-img rounded-circle">
                            @else
                            <img src="{{URL::asset('images/'.$user->foto)}}" alt="..."
                                class="avatar-img rounded-circle">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{$user->name}}</div>
                        <div class="job">{{$user->level}}</div>
                        @if (Auth::user()->level == "karyawan")
                        <div class="desc">{{$user->cabang->nama_cabang}}</div>
                        @else
                        <div class="desc">Pemilik King Laundry</div>
                        @endif
                        <div class="social-media">
                            <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                <span class="btn-label just-icon"><i class="flaticon-twitter"></i>
                                </span>
                            </a>
                            <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="flaticon-google-plus"></i>
                                </span>
                            </a>
                            <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="flaticon-facebook"></i>
                                </span>
                            </a>
                            <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="flaticon-dribbble"></i>
                                </span>
                            </a>
                        </div>
                        <div class="view-profile">
                            <a href="#" class="btn btn-secondary btn-block">View Full Profile</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row user-stats text-center">
                        <div class="col">
                            <div class="number">125</div>
                            <div class="title">Post</div>
                        </div>
                        <div class="col">
                            <div class="number">25K</div>
                            <div class="title">Followers</div>
                        </div>
                        <div class="col">
                            <div class="number">134</div>
                            <div class="title">Following</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection