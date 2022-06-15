<!-- Modal -->
<div class="modal fade myModal" id="modalEdit{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('kry.update', $data->id)}}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Karyawan</label>
                                    <div class="position-relative has-icon-left">
                                        <input class="form-control" type="text" id="nama" name="name" value="{{$data->name}}">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class=" form-group">
                                    <label for="username">Username </label>
                                    <div class="position-relative has-icon-left">
                                        <input class="form-control" type="text" id="text" name="username" value="{{$data->username}}" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat </label>
                                    <textarea class="form-control" type="text" id="alamat" name="alamat" value="">{{$data->alamat}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="hp">Nomor Hp </label>
                                    <input class="form-control" type="text" id="hp" name="hp" value="{{$data->hp}}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Aktif" {{$data->status == 'Aktif' ? 'selected' : ''}}> Aktif
                                        </option>
                                        <option value="Tidak Aktif" {{$data->status == 'Tidak Aktif' ? 'selected' : ''}}> Tidak Aktif </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" id="cabang" class="form-control">
                                        <option value="">
                                            -- Pilih Cabang --
                                        </option>
                                        @foreach ($cabang as $cabangs)
                                        <option value="{{ $cabangs->id }}" {{$cabangs->id == $data->id_cabang ? 'selected':''}}>
                                            {{ $cabangs->nama_cabang}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-btn fa-save text"></i> Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>