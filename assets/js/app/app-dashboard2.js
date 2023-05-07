define([
    "jQuery",
	"bootstrap", 
    "highcharts3d",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "select2",
    "toastr",
	], function (
    $,
	bootstrap, 
    highcharts3d,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    select2,
    toastr,
	) {
    return {  
        table:null,
        init: function () { 
        	App.initFunc(); 
            App.initEvent(); 
            App.initData();
            App.initTable();
            console.log("LOADED");
            $(".loadingpage").hide();
         
            
		}, 
        initEvent : function(){   
            

        },
        initData : function(){

            //grafik pendapatan
            $.ajax({
                url : App.baseUrl+"dashboard/grafikPendapatan",
                type : "GET",
                success : function(data) {
                    var data = JSON.parse(data);
                    App.grafikPendapatan(data.grafik);
                },
                error : function(data) {
                    // do something
                }
            });

            //grafik pendapatan marketplace
            $.ajax({
                url : App.baseUrl+"dashboard/grafikPendapatanMarketplace",
                type : "GET",
                success : function(data) {
                    var data = JSON.parse(data);
                    App.grafikPendapatanMarketplace(data.grafik);
                },
                error : function(data) {
                    // do something
                }
            });

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
                    "url": App.baseUrl+"dashboard/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "nomor" },
                    { "data": "barang_name" },
                    { "data": "total" },
                ]
            });

        },
        
        grafikPendapatan : function(data) {
            
            Highcharts.chart('container-grafik-pendapatan', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Pendapatan Kotor Perbulan'
                },
                subtitle: {
                    text: 'RJT Inventory'
                },

                xAxis: {
                    categories: [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Barang Terjual'
                    }
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true
                    }
                },
            
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br />',
                    pointFormat: 'Pendapatan = {point.y}'
                },
            
                series: [{
                    name: data.tahun,
                    data: [data.pendapatan[1],data.pendapatan[2],data.pendapatan[3],data.pendapatan[4],data.pendapatan[5],data.pendapatan[6],data.pendapatan[7],data.pendapatan[8],data.pendapatan[9],data.pendapatan[10],data.pendapatan[11],data.pendapatan[12],],
                    pointStart: 0,
                }]
            });
        },

        grafikPendapatanMarketplace : function(data) {
            Highcharts.chart('container-grafik-pendapatan-marketplace', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Pendapatan Berdasarkan Marketplace'
                },
                subtitle: {
                    text: 'RJT Inventory'
                },
                xAxis: {
                    categories: [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Barang Terjual'
                    }
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true
                    }
                },
            
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br />',
                    pointFormat: 'Pendapatan = {point.y}'
                },
            
                series: [
                    {
                        name: 'Lazada',
                        data: [data.pendapatan_lazada[1],data.pendapatan_lazada[2],data.pendapatan_lazada[3],data.pendapatan_lazada[4],data.pendapatan_lazada[5],data.pendapatan_lazada[6],data.pendapatan_lazada[7],data.pendapatan_lazada[8],data.pendapatan_lazada[9],data.pendapatan_lazada[10],data.pendapatan_lazada[11],data.pendapatan_lazada[12]],
                        pointStart: 0,
                    }, 
                    {
                        name: 'Tiktok',
                        data: [data.pendapatan_tiktok[1],data.pendapatan_tiktok[2],data.pendapatan_tiktok[3],data.pendapatan_tiktok[4],data.pendapatan_tiktok[5],data.pendapatan_tiktok[6],data.pendapatan_tiktok[7],data.pendapatan_tiktok[8],data.pendapatan_tiktok[9],data.pendapatan_tiktok[10],data.pendapatan_tiktok[11],data.pendapatan_tiktok[12]],
                        pointStart: 0,
                    },
                    {
                        name: 'Tokopedia',
                        data: [data.pendapatan_tokopedia[1],data.pendapatan_tokopedia[2],data.pendapatan_tokopedia[3],data.pendapatan_tokopedia[4],data.pendapatan_tokopedia[5],data.pendapatan_tokopedia[6],data.pendapatan_tokopedia[7],data.pendapatan_tokopedia[8],data.pendapatan_tokopedia[9],data.pendapatan_tokopedia[10],data.pendapatan_tokopedia[11],data.pendapatan_tiktok[12]],
                        pointStart: 0,
                    },
                    {
                        name: 'Shopee',
                        data: [data.pendapatan_shopee[1],data.pendapatan_shopee[2],data.pendapatan_shopee[3],data.pendapatan_shopee[4],data.pendapatan_shopee[5],data.pendapatan_shopee[6],data.pendapatan_shopee[7],data.pendapatan_shopee[8],data.pendapatan_shopee[9],data.pendapatan_shopee[10],data.pendapatan_shopee[11],data.pendapatan_shopee[12]],
                        pointStart: 0,
                    },
                ]
            });
        },
	}
});