<style>
.select2-selection__rendered {
    line-height: 36px !important;
}

.select2-container .select2-selection--single {
    height: 39px !important;
}

.select2-selection__arrow {
    height: 38px !important;
}
</style>
<div class="modal fade myModal" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('pelayanan.store')}}" method="POST" onsubmit="save.disabled = true; return true;">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row no-gutters">
                            @if(!empty($detail))
                            <input type="hidden" name="id_customer" value="{{$detail->customer->id}}">
                            @endif
                            <input type="hidden" name="status_order" value="Proses" class="form-control">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis_cuci">Jenis Cuci</label>
                                    <select name="jenis_cuci" id="jenis_cuci_ajax" class="form-control" required>
                                        <option value=""> Jenis Cuci </option>
                                        @foreach ($harga as $item)
                                        <option value="{{$item->jenis_cuci}}">{{$item->jenis_cuci}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jenis">Jenis Item</label>
                                    <select name="jenis" id="jenis_ajax" class="form-control jenis" required
                                        disabled="disabled">
                                        <option value=""> Jenis Item </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="layanan">Layanan</label>
                                    <select name="layanan" id="layanan_ajax" class="form-control" required
                                        disabled="disabled">
                                        <option value=""> Pilih Layanan </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="jumlah">Jumlah / Berat</label>
                                    <input type="number" class="form-control" id="jumlah" step="any" name="jumlah"
                                        placeholder="Jumlah/Berat Pakaian" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="disc">Disc</label>
                                    <input type="number" name="disc" placeholder="Disc" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span id="select-satuan"></span>
                            </div>
                            <div class="col-md-3">
                                <span id="select-harga"></span>
                            </div>
                        </div>

                        <span id="id_harga"></span>
                        <input type="hidden" name="tgl">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="save" id="input-order" class="btn btn-success"><i
                                class=" fa fa-btn fa-save text"></i> Save
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.jenis').select2({
        width: '100%'
    });
});

$('#refresh').click(function() {
    location.reload();
});
</script>