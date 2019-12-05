
<script type="text/javascript">
$(function () {
    $('#stok_tersedikit').highcharts({
        data: {
            table: document.getElementById('isi_stok')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: '100 Barang Dengan Stok Tersedikit'
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

<div id="stok_tersedikit" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="isi_stok">
	<thead>
		<tr>
			<th>Barang</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($isi as $stok){?>
		<tr>
			<th><?php echo $stok['kode_barang'].'-'.$stok['nama']?></th>
			<td><?php echo $stok['jumlah']?></td>
		</tr>
        <?php } ?>
	</tbody>
</table>
	</body>
</html>