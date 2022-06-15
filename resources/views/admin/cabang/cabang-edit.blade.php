<div class="modal fade myModal" id="modalEdit{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Edit Cabang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('admin-cabang.update', $data->id)}}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Cabang</label>
                        <input class="form-control" type="text" id="nama" name="nama_cabang" value="{{$data->nama_cabang}}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Cabang</label>
                        <input class="form-control" type="text" id="alamat" name="alamat_cabang" value="{{$data->alamat_cabang}}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-btn fa-save text"></i>
                            Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>