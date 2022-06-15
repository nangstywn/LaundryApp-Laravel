{{-- header --}}
<!-- <div class="bg-cover">
    <img src="{{asset('frontend/img/header/header.jpg')}}" alt="" />
</div> -->
<!-- end bg-cover -->
<!-- begin container -->
<style>
h3 {
    -webkit-text-stroke: 1px black;
    color: white;
    text-shadow:
        3px 3px 0 #000,
        -1px -1px 0 #000,
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
}
</style>
<div class="container">
    <h3 class="mb-3" style="text-align:center; font-size:36px;"><b>Lacak Status Laundry Kamu Disini...</b>
    </h3>
    <div class="col-md-6 mx-auto">
        <div class="input-group-btn" style="text-align:center">
            <input type="text" class="form-control-lg input" id="search_status" placeholder="Contoh : TR0392928" />
            <span class="input-group-btn">
                <button type="submit" class="btn btn-lg btn-primary mb-2" id="search-btn"><i class="fa fa-search"></i>
                    Search</button>
            </span>
        </div>
    </div>
    @include('frontend.modal')
</div>
{{-- End Header --}}