<!-- Modal -->
<div class="modal fade myModal" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Harga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('harga-store')}}" method="POST" onsubmit="save.disabled = true; return true;">
                @csrf
                <div class=" modal-body">
                    <div class="form-body">
                        <div class="row">
                            <!-- <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" id="cabang" class="form-control"
                                        value="{{old('id_cabang')}}">
                                        <option value="">
                                            Pilih Cabang
                                        </option>
                                        @foreach ($cabang as $cabangs)
                                        <option value="{{ $cabangs->id }}">{{ $cabangs->nama_cabang}}</option>
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
                                        <option value="Laundry Umum"> Laundry Umum </option>
                                        <option value="Laundry Hotel"> Laundry Hotel </option>
                                        <option value="Dry Cleaning"> Dry Cleaning </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class=" form-group">
                                    <label for="jenis">Jenis Pakaian </label>
                                    <input class="form-control" type="text" id="jenis" name="jenis" placeholder="Jenis"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="layanan">Layanan </label>
                                    <select name="layanan" id="layanan" class="form-control" required>
                                        <option value="">
                                            Pilih Layanan
                                        </option>
                                        <option value="Reguler (2-3 Hari)"> Reguler (2-3 Hari) </option>
                                        <option value="One Day (1 Hari)"> One Day (1 Hari) </option>
                                        <option value="Express 6 Jam"> Express 6 Jam </option>
                                        <option value="Express 3 Jam"> Express 3 Jam </option>
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
                                        <option value="Kg"> Kg </option>
                                        <option value="Biji"> Biji </option>
                                        <option value="m&sup2"> m&sup2 </option>
                                        <option value="Pasang"> Pasang </option>
                                        <option value="Pcs"> Pcs </option>
                                        <option value="Set"> Set </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="harga">Harga Per-satuan</label>
                                    <input class="form-control" type="text" id="harga" name="harga" placeholder="Harga"
                                        required value="">
                                </div>
                            </div>
                            <!-- <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Aktif"> Aktif</option>
                                        <option value="Tidak Aktif"> Tidak Aktif </option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
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