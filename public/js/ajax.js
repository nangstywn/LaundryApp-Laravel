$(document).ready(function(){
    var jenisCuci = $("#jenis_cuci_ajax option:selected").text();
    var jenis = $("#jenis_ajax option:selected").text();
    var layanan = $("#layanan_ajax option:selected").text();
        $.ajax({
            url:'/listharga/',
            data: {
                jenisCuci: jenisCuci,
                jenis: jenis,
                layanan: layanan
            },
            type:'get',
            dataType: 'html'
        }).done(function(data){
            $("#select-harga").html(data);
        });
        $.ajax({
            url:'/satuan/',
            data: {
                jenisCuci: jenisCuci,
                jenis: jenis
            },
            type:'get',
            dataType: 'html'
        }).done(function(data){
            $("#select-satuan").html(data);
        });
});

$("#layanan_ajax").on('change',function(){
    let jenisL = $(this).children("option:selected").val();
    let jenisCuci = $('#jenis_cuci_ajax option:selected').text();
    let jenis = $('#jenis_ajax option:selected').text();
    let layanan = $(this).children("option:selected").text();
    console.log(jenisL)
    if(jenisL != ""){
        $.ajax({
            url:'/listharga/',
            data: {
                jenisCuci: jenisCuci,
                jenis: jenis,
                layanan: layanan
            },
            type:'get',
            dataType: 'html'
        }).done(function(data){
            console.log(data)
            $("#select-harga").html(data);
        });
        $.ajax({
            url:'/getid/',
            data: {
                jenisCuci: jenisCuci,
                jenis: jenis,
                layanan: layanan
            },
            type:'get',
            dataType: 'html'
        }).done(function(data){
            console.log(data)
            $("#id_harga").html(data);
        });
    }else{
        // $('.harga').remove();
        $('#harga').attr('disabled','disabled')
        $('#input-order').attr('disabled','disabled')
    }
});

$("#jenis_cuci_ajax").on('change',function(){
    id = $(this).children("option:selected").val();
    jenisCuci = $(this).children("option:selected").text();
    if(id != ""){
        $.ajax({
            url:'/harga/jenis/'+jenisCuci,
            type:'get',
            dataType: 'html'
        }).done(function(data){
            json = JSON.parse(data);
            console.log(json)
            componentJenis(json);
            $('#jenis_ajax').removeAttr('disabled');
        });
    }else {
        // $("#jenis_ajax").prop('required',true);
        // $("#jenis_ajax option[value='Jenis']").attr('selected','selected').change();
        $("#jenis_ajax").attr('disabled','disabled')
        $("#layanan_ajax").attr('disabled','disabled')
    }
})

$('#jenis_ajax').on('change',function(){
    let id_kategori = $(this).children("option:selected").val();
    let jenis = $(this).children("option:selected").text();
    let jenisCuci = $('#jenis_cuci_ajax option:selected').text();
    //id_ruang = $('#id_ruang_selected').children("option:selected").val();
    jenisCuci = $('#jenis_cuci_ajax').children("option:selected").text();
    console.log(id_kategori)
    console.log(jenis)
    if(id_kategori != ""){
        $.ajax({
            url:'/harga/?jenis='+jenis+'&jenisCuci='+jenisCuci,
            type:'get',
            dataType: 'html'
        }).done(function(data){
            json = JSON.parse(data)
            console.log(json)
            componentLayanan(json)
            $("#layanan_ajax").removeAttr('disabled')
        });
        $.ajax({
            url:'/satuan/',
            data: {
                jenisCuci: jenisCuci,
                jenis: jenis
            },
            type:'get',
            dataType: 'html'
        }).done(function(data){
            console.log(data)
            $("#select-satuan").html(data);
        });
    }else {
        // $("#layanan_ajax option[value='Pilih']").attr('selected','selected').change();
        $("#layanan_ajax").attr('disabled','disabled')
        $("#satuan_ajax").attr('disabled','disabled')
        $("#harga").attr('disabled','disabled')
    }
})


function componentLayanan(data){
    target = $('#layanan_ajax')

    target.empty()
    data.forEach(d => {
        if(d.id == ""){
            mockup = "<option value="+d.id+">"+d.layanan+" </option>"
            $('#layanan_ajax').prop('required',true);
        }else{
            mockup = "<option value="+d.layanan+">"+d.layanan+" </option>"
        }
        target.append(mockup)
    });
}

function componentJenis(data){
    target = $('#jenis_ajax')

    target.empty();

    data.forEach(d => {
        if(d.id == ""){
            mockup = "<option value="+d.id+">"+d.jenis+" </option>"
            $('#jenis_ajax').prop('required',true);
        }else{
            mockup = "<option value="+d.jenis+">"+d.jenis+" </option>"
        }
        target.append(mockup)
    });
}

$('#jenis_ajax').change(function() {
    var jenis_cuci = $('#jenis_cuci_ajax option:selected').val();
    var jenis = $('#jenis_ajax option:selected').val();
    if (jenis_cuci == "Laundry Umum" && jenis == "Pakaian") {
        $('#jumlah').attr('min', 2);
    }else if (jenis_cuci == "Laundry Hotel" && jenis == "Pakaian") {
        $('#jumlah').attr('min', 3);
    } else {
        $('#jumlah').attr('min', 0);
    }
});



