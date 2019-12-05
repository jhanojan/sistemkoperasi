
<script type="text/javascript">
$(function () {
    $('#produk_terlaku').highcharts({
        data: {
            table: document.getElementById('laku_produk')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Barang Terlaku'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Units'
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name.toLowerCase() +'</b><br/>'+
                    this.point.y +' '+ 'Buah';
            }
        },
		credits:{
			enabled: false,
			href: '',
			text : "Fauzan Rabbani"	
			
		}
    });
});
		</script>

<div id="produk_terlaku" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="laku_produk">
	<thead>
		<tr>
			<th>Barang</th>
			<th>Terjual</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($isi as $stok){?>
		<tr>
			<th><?php echo $stok['kode_barang'].'-'.GetValue('nama','tb_inventory',array('kode_barang'=>'where/'.$stok['kode_barang']));
			?></th>
			<td><?php echo $stok['jumlah']?></td>
		</tr>
        <?php } ?>
	</tbody>
</table>
	</body>
</html>