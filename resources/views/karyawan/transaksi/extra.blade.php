<div class="modal fade" id="modalExtra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Ongkir dan Spotting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{route('save.order')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="jarak">Jarak Pengantaran</label>
                                    <select name="jarak" id="jarak" onchange="yesnoCheck(this);" class="form-control"
                                        value="">
                                        <option value="">Jarak </option>
                                        <option value="0">
                                            < 5 Km</option>
                                        <option value="15000">6 - 7 km</option>
                                        <option value="20000">8 - 9 km</option>
                                        <option value="25000">10 - 11 km</option>
                                        <option value="30000">12 - 13 km</option>
                                        <option value="50000">14 - 15 km</option>
                                        <option value="other"> > 16 km</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="spotting">Spotting</label>
                                    <select name="spotting" id="spotting" class="form-control">
                                        <option value="">Spotting</option>
                                        <option value="5000"> Ringan </option>
                                        <option value="10000"> Medium </option>
                                        <option value="15000"> Berat </option>
                                        <option value="20000"> Sangat Berat </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div id="ifYes" style="display: none;">
                                        <label for="Ongkir">Biaya Ongkir</label>
                                        <input type="text" name="ongkir" id="ongkir" class="form-control" /><br />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="save">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function yesnoCheck(that) {
    if (that.value == "other") {
        // alert("check");
        document.getElementById("ifYes").style.display = "block";
    }
}
</script>