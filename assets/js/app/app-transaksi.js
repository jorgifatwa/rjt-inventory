define([
    "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "jqvalidate",
    "toastr",
    "select2"
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    jqvalidate,
    toastr,
    select2
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initTable();
            App.initValidation();
            App.initConfirm();
            App.initEvent();
            App.changeBarang();
            $(".loadingpage").hide();
        },
        initEvent : function(){
            $('#id_barang').select2({
                width: "100%",
                placeholder: "Pilih Barang",
            });  
            $('#id_warna').select2({
                width: "100%",
                placeholder: "Pilih Warna",
            });  
            $('#ukuran').select2({
                width: "100%",
                placeholder: "Pilih Ukuran",
            });  
        },
        changeBarang : function(){
            $('#id_barang').on('change', function () {
                var id_barang = $(this).val();
                var id_transaksi = $('#id_transaksi').val();
                $.ajax({
                    method: "POST",
                    url: App.baseUrl+'transaksi/getWarna',
                    data : {id_barang : id_barang, id_transaksi : id_transaksi}
                }).done(function( data ) {
                    var data = JSON.parse(data);
                    var data_warna = data.data;
                    var html = `<select name="id_warna" id="id_warna" class="form-control">
                    `;
                    var option = "<option value=''>Pilih Warna </option>";
                    for (var index = 0; index < data_warna.length; index++) {
                            option += "<option value="+data_warna[index].id_warna+"> "+data_warna[index].warna_name+"</option>";
                    }
                    html += option;
                    html += `</select>`;
                    $('.warna').html(html)
                    $('#id_warna').select2({
                        width: "100%",
                        placeholder: "Pilih Warna",
                    });

                    $('#id_warna').on('change', function () {
                        console.log('masuk')
                        var id_warna = $(this).val();
                        var id_transaksi = $('#id_transaksi').val();
                        var id_barang = $('#id_barang').val();
                        $.ajax({
                            method: "POST",
                            url: App.baseUrl+'transaksi/getUkuran',
                            data : {id_barang : id_barang, id_transaksi : id_transaksi, id_warna: id_warna}
                        }).done(function( data ) {
                            var data = JSON.parse(data);
                            var data_ukuran = data.data;
                            var html = `<select name="ukuran" id="ukuran" class="form-control">
                            `;
                            var option = "";
                            for (var index = 0; index < data_ukuran.length; index++) {
                                    option += "<option value="+data_ukuran[index].ukuran+"> "+data_ukuran[index].ukuran+"</option>";
                            }
                            html += option;
                            html += `</select>`;
                            $('.ukuran').html(html)
                            $('#ukuran').select2({
                                width: "100%",
                                placeholder: "Pilih Warna",
                            });
                        })
                    })
                })
            })

        },
        initTable : function(){
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Lihat _MENU_ data",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data di dalam tabel",
                    "infoFiltered": "(cari dari _MAX_ total catatan)",
                    "loadingRecords": "Loading...",
                    "processing": "Processing...",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelumnya"
                    },
                },
                "order": [[ 0, "asc" ]], //agar kolom id default di order secara desc
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+"transaksi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "no_resi" },
                    { "data": "tanggal" },
                    { "data": "action" ,"orderable": false}
                ]
            });
        },
        initValidation : function(){
            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Harus Diisi"
                        },
                    },
                    debug:true,

                    errorPlacement: function(error, element) {
                        var name = element.attr('name');
                        var errorSelector = '.form-control-feedback[for="' + name + '"]';
                        var $element = $(errorSelector);
                        if ($element.length) {
                            $(errorSelector).html(error.html());
                        } else {
                            if ( element.prop( "type" ) === "select-one" ) {
                                error.appendTo(element.parent());
                            }else if ( element.prop( "type" ) === "select-multiple" ) {
                                error.appendTo(element.parent());
                            }else if ( element.prop( "type" ) === "checkbox" ) {
                                error.insertBefore( element.next( "label" ) );
                            }else if ( element.prop( "type" ) === "radio" ) {
                                error.insertBefore( element.parent().parent().parent());
                            }else if ( element.parent().attr('class') === "input-group" ) {
                                error.appendTo(element.parent().parent());
                            }else{
                                error.insertAfter(element);
                            }
                        }
                    },
                    submitHandler : function(form) {
                        form.submit();
                    }
                });
            }
        },
        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                console.log(url);
                App.confirm("Apakah anda yakin untuk mengubah ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        var data = JSON.parse(msg);
                        if (data.status == false) {
                            toastr.error(data.msg);
                        } else {
                            toastr.success(data.msg);
                            App.table.ajax.reload(null, true);
                        }
                    });
                })
            });
        }
	}
});
