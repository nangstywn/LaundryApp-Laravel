<!-- Modal -->
<div class="modal fade myModal" id="modalEdit{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{route('csr.update', $data->id)}}" method="POST">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Customer</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input class="form-control" type="text" id="name" name="nama"
                                            placeholder="Nama Customer" value="{{$data->nama}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="hp">Nomor Whatsapp </label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input class="form-control" type="text" id="hp" name="hp"
                                            placeholder="Nomor Whatsapp" value="{{$data->hp}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat </label>
                                    <textarea class="form-control" type="text" id="alamat" name="alamat"
                                        placeholder="Alamat">{{$data->alamat}}</textarea>
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