@extends('frontend.welcome')
@section('title','Selamat Datang')
@section('header')
@include('frontend.header')
@endsection
@section('scripts')
<script>
$(document).on('click', '.search-btn', function(e) {
    _curr_val = $('#search_status').val();
    $('#search_status').val(_curr_val + $(this).html());
});
$(document).on('click', '#search-btn', function(e) {
    var search_status = $("#search_status").val();
    $.get('pencarian-laundry', {
        '_token': $('meta[name=csrf-token]').attr('content'),
        search_status: search_status
    }, function(resp) {
        if (resp != 0) {
            $(".modal_status").show();
            $("#customer").html(resp.customer.nama);
            $("#tgl_transaksi").html(resp.order.tgl_transaksi);
            $("#status_order").html(resp.order.status_order);
        } else {
            Swal.fire({
                html: "No Invoice Tidak Terdaftar!"
            })
        }
    });
});

function close_dlgs() {
    $(".modal_status").hide();
    $("#search_status").val("");
}
</script>
@endsection