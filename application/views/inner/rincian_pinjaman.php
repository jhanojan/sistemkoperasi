<?php
$nama=GetValue('nama','tb_karyawan',array('kode_karyawan'=>'where/'.$rincian['id_karyawan']));
if($nama=='0'){
$nama=GetValue('nama','tb_karyawan',array('nik'=>'where/'.$rincian['id_karyawan']));	
}
?>                           
                           
                           
<table style="width:100%;">
<tr><td colspan="2"><h4>Rincian Peminjaman</h4></td></tr>
<tr><td>
							<label class="title">Tanggal Peminjaman</label></td><td>
							<?php 
								$nm_f = "waktu";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Tipe Peminjaman</label></td><td>
							<?php 
								$nm_f = "tipe";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? GetValue('nama','tb_tipe_simpan_pinjam',array('id'=>'where/'.$rincian[$nm_f])) : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Nama Peminjam</label></td><td>
							<?php 
								$nm_f = "id_karyawan";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $nama : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">ID Penjualan</label></td><td>
							<?php 
								$nm_f = "id_penjualan";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Jumlah Angsuran</label></td><td>
							<?php 
								$nm_f = "jml_angsuran";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]' disabled");
							?> kali</td></tr>
                            <tr><td>
							<label class="title">Bunga</label></td><td>
							<?php 
								$nm_f = "bunga";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]' disabled");
							?> %</td></tr>
                            <tr><td>
							<label class="title">Jatuh Tempo</label></td><td>
							<?php 
								$nm_f = "tgl_jatuh_tempo";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span3 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Total Pinjaman</label></td><td>
							<?php 
								$nm_f = "debit";
								echo form_input($nm_f, isset($rincian['total_debit']) ? rupiah($rincian['total_debit']*100/(100+$rincian['bunga'])) : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Total Yang Harus Dibayar</label></td><td>
							<?php 
								$nm_f = "total_debit";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? rupiah($rincian[$nm_f]) : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Total Sudah Dibayar</label></td><td>
							<?php 
								$nm_f = "total_kredit";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? rupiah($rincian[$nm_f]) : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Sisa Hutang</label></td><td>
							<?php 
								$nm_f = "total_debit";
								echo form_input($nm_f, isset($rincian[$nm_f]) ? rupiah($rincian[$nm_f]-$rincian['total_kredit']) : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                            <tr><td>
							<label class="title">Status</label></td><td>
							<?php 
								$nm_f = "status";
								$rincian[$nm_f]=='b' ? $rincian[$nm_f]='Belum Lunas' : $rincian[$nm_f]='Lunas' ; 
								echo form_input($nm_f, isset($rincian[$nm_f]) ? $rincian[$nm_f] : "", "id='".$nm_f."' class='span7 validate[required]' disabled");
							?></td></tr>
                           </table>                                                      