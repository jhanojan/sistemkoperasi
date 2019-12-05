
<script type="text/javascript">
$(function () {
    $('#laba').highcharts({
        data: {
            table: document.getElementById('isi_laba')
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Laba 3 Bulan Terakhir'
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

<div id="laba" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="isi_laba">
	<thead>
		<tr>
			<th>Bulan</th>
			<th>Laba</th>
		</tr>
	</thead>
	<tbody>
    <?php
	 foreach($p as $stok){
		 $bln=explode('-',$stok);
		 ?>
		<tr>
			<th><?php echo getBulan($bln[1]).' '.$bln[0];
			?></th>
			<td><?php echo GetLabaBulan($stok)?></td>
		</tr>
        <?php } ?>
	</tbody>
</table>
	</body>
</html>