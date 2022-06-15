<!-- Modal -->
<div class="modal fade myModal" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{route('kry.store')}}" method="POST" enctype="multipart/form-data"
                onsubmit="save.disabled = true; return true;">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input class="form-control" type="text" id="nama" name="name"
                                            placeholder="Nama Karyawan" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class=" form-group">
                                    <label for="user">Username </label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input class="form-control" type="text" id="username" name="username"
                                            placeholder="Username" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat </label>
                                    <textarea class="form-control" type="text" id="alamat" name="alamat"
                                        placeholder="Alamat" value=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="hp">Nomor Hp </label>
                                    <div class="input-group mb-3">

                                        <input class="form-control" type="text" id="hp" name="hp"
                                            placeholder="Contoh: 08xxx" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="passwod">Password </label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="Password" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" id="cabang" class="form-control" value="" required>
                                        <option value="">
                                            Pilih Cabang
                                        </option>
                                        @foreach ($cabang as $cabangs)
                                        <option value="{{ $cabangs->id }}">{{ $cabangs->nama_cabang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="foto">Foto </label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="icon-picture"></i>
                                        </span>
                                        <input class="form-control" type="file" id="foto" name="foto" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="level" value="karyawan">
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-success"> <i class="fa fa-btn fa-save text"></i>
                        Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>