<div class="modal fade myModal" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin-cabang.store')}}" method="POST" onsubmit="save.disabled = true; return true;">
                @csrf
                <div class=" modal-body">
                    <div class="form-group mb-1">
                        <label for="nama">Nama Cabang</label>
                        <input class="form-control" type="text" id="nama" name="nama_cabang" required>
                    </div>
                    <div class="form-group mb-1">
                        <label for="alamat">Alamat Cabang</label>
                        <input class="form-control" type="text" id="alamat" name="alamat_cabang" required>
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