<div class="modal fade myModal" id="modalEdit{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Edit Harga</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('harga-update', $data->id)}}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                {{ method_field('PUT') }}
                <div class="modal-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="form-body">
                        <div class="row">
                            <!-- <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" id="cabang" class="form-control" value="">
                                        <option value="">
                                            Pilih Cabang
                                        </option>
                                        @foreach ($cabang as $cabangs)
                                        <option value="{{ $cabangs->id }}"
                                            {{ $cabangs->id == $data->id_cabang ? 'selected' : '' }}>
                                            {{ $cabangs->nama_cabang}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="jenis_cuci">Jenis Cuci</label>
                                    <select name="jenis_cuci" id="jenis_cuci" class="form-control" required>
                                        <option value="">
                                            Pilih Jenis Cuci
                                        </option>
                                        <option value="Laundry Umum"
                                            {{ $data->jenis_cuci == 'Laundry Umum' ? 'selected' : '' }}>
                                            Laundry Umum</option>
                                        <option value="Laundry Hotel"
                                            {{ $data->jenis_cuci == 'Laundry Hotel' ? 'selected' : '' }}>
                                            Laundry Hotel</option>
                                        <option value="Dry Cleaning"
                                            {{ $data->jenis_cuci == 'Dry Cleaning' ? 'selected' : '' }}> Dry Cleaning
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class=" form-group">
                                    <label for="jenis">Jenis Pakaian </label>
                                    <input class="form-control" type="text" id="jenis" name="jenis" placeholder="Jenis"
                                        required value="{{$data->jenis}}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="layanan">Layanan </label>
                                    <select name="layanan" id="layanan" class="form-control" required>
                                        <option value="">
                                            Pilih Layanan
                                        </option>
                                        <option value="Reguler (2-3 Hari)"
                                            {{ $data->layanan ==  'Reguler (2-3 Hari)' ? 'selected' : ''}}> Reguler (2-3
                                            Hari) </option>
                                        <option value="One Day (1 hari)"
                                            {{ $data->layanan ==  'One Day (1 Hari)' ? 'selected' : ''}}> One Day (1
                                            Hari) </option>
                                        <option value="Express 6 Jam"
                                            {{ $data->layanan ==  'Express 6 Jam' ? 'selected' : ''}}> Express 6 Jam
                                        </option>
                                        <option value="Express 3 Jam"
                                            {{ $data->layanan ==  'Express 3 Jam' ? 'selected' : ''}}> Express 3 Jam
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="satuan">Satuan </label>
                                    <select name="satuan" id="satuan" class="form-control" required>
                                        <option value="">
                                            Pilih Satuan
                                        </option>
                                        <option value="Kg" {{ $data->satuan == 'Kg' ? 'selected' : '' }}> Kg </option>
                                        <option value="Biji" {{ $data->satuan == 'Biji' ? 'selected' : '' }}> Biji
                                        </option>
                                        <option value="m&sup2" {{ $data->satuan == 'm²' ? 'selected' : '' }}> m&sup2
                                        </option>
                                        <option value="Pasang" {{ $data->satuan == 'Pasang' ? 'selected' : '' }}> Pasang
                                        </option>
                                        <option value="Pcs" {{ $data->satuan == 'Pcs' ? 'selected' : '' }}> Pcs
                                        </option>
                                        <option value="Set" {{ $data->satuan == 'Set' ? 'selected' : '' }}> Set
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="harga">Harga Per-satuan</label>
                                    <input class="form-control" type="text" id="harga" name="harga" placeholder="Harga"
                                        value="{{$data->harga}}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Aktif" {{$data->status == 'Aktif' ? 'selected' : ''}}> Aktif
                                        </option>
                                        <option value="Tidak Aktif"
                                            {{$data->status == 'Tidak Aktif' ? 'selected' : ''}}> Tidak
                                            Aktif </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-btn fa-save text"></i>
                        Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>