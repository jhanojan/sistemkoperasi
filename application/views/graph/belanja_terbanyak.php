
<script type="text/javascript">
$(function () {
    $('#belanja_terbanyak').highcharts({
        data: {
            table: document.getElementById('banyak_belanja')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Karyawan Belanja Terbanyak'
        },
        yAxis: { 
            allowDecimals: false,
            title: {
                text: 'Rupiah'
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name.toLowerCase() +'</b><br/>'+
                    this.point.y +' '+ 'Rupiah';
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

<div id="belanja_terbanyak" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="banyak_belanja">
	<thead>
		<tr>
			<th>Karyawan</th>
			<th>Jumlah Belanja</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($isi as $stok){?>
		<tr>
			<th><?php echo $stok['id_karyawan'].'-'.str_replace('0',GetValue('nama','tb_karyawan',array('kode_karyawan'=>'where/'.$stok['id_karyawan'])),GetValue('nama','tb_karyawan',array('nik'=>'where/'.$stok['id_karyawan'])));
			?></th>
			<td><?php echo $stok['jumlah']?></td>
		</tr>
        <?php } ?>
	</tbody>
</table>
	</body>
</html>