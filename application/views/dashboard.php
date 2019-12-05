<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Tabs - Content via Ajax</title>
 <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  <script src="<?php echo site_url('assets')?>/js/jquery-ui-1.8.4.custom.min.js"></script>
  <link rel="stylesheet" href="<?php echo site_url('assets')?>/style/smoothness/jquery-ui-1.8.4.custom.css">
  <script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
  });
  </script>
	
<script src="<?php echo site_url('assets')?>/hichart/highcharts.js"></script>
<script src="<?php echo site_url('assets')?>/hichart/modules/data.js"></script>
<script src="<?php echo site_url('assets')?>/hichart/modules/exporting.js"></script>
</head>
<body>
 
<div id="tabs">
  <ul>
    <li><a href="<?php echo site_url('graph')?>/produk_terlaku">Produk Terlaku</a></li>
    <li><a href="<?php echo site_url('graph')?>/belanja_terbanyak">Karyawan Belanja Terbanyak</a></li>
    <li><a href="<?php echo site_url('graph')?>/stok_tersedikit">Produk Dengan Stok Terdikit</a></li>
    <li><a href="<?php echo site_url('graph')?>/laba">Laba 3 Bulan Terakhir</a></li>
  </ul>
</div>
 
 
</body>
</html>