<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
.bg-image {
    background: scroll center url('images/king_bg.jpg');
    background-size: cover;
}
</style>
<div class="container-fluid">
    <div class="row no-gutter">
        <div class="col-md-10 col-lg-10 col-xl-10 mx-auto">
            <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image">
                </div>

                <!-- The content half -->
                <div class="col-md-6 bg-light">
                    <div class="login d-flex align-items-center py-5">

                        <!-- Demo content-->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 col-xl-7 mx-auto">
                                    <img src="{{URL::asset('assets/img/fix.jpg')}}" alt="">
                                    <h2 class="mt-3">Selamat Datang!</h2>
                                    <p class="text-muted mb-4">Masukkan username dan password untuk mengakses panel
                                        admin
                                        dan
                                        karyawan</p>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input id="inputUser" type="text" placeholder="Username" required=""
                                                autofocus=""
                                                class="form-control shadow-sm px-4 @error('username') is-invalid @enderror"
                                                name="username">
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input id="inputPassword" type="password" placeholder="Password" required=""
                                                class="form-control shadow-sm px-4 text-primary @error('password') is-invalid @enderror"
                                                name="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                        <div>
                                            <button type="submit"
                                                class="btn btn-primary btn-block text-uppercase shadow-sm">Log
                                                in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- End -->
                    </div>
                </div><!-- End -->
            </div>
        </div>
    </div>
</div>