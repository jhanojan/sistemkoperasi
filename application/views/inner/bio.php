<fieldset>
	<h4>Biodata Pegawai</h4>
			<table id="biodatas">

				<tr>

					<td>

						<?php echo form_hidden("id", isset($val["id"]) ? $val["id"] : '');?>
						<div class="clearfix">
							<label class="title">Nama</label>
							<?php 
								$nm_f = "nama";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='span5 validate[required]' readonly");
							?>
						</div>
                      </td>
                  </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title" style="float:left;">Jabatan</label>
							<?php 
								$nm_f = "kode_jabatan";
								echo form_input($nm_f, isset($bio[$nm_f]) ? GetValue('nama','tb_jabatan',array('id'=>'where/'.$bio[$nm_f])) : "", "id='".$nm_f."' class=' span5 validate[required]' readonly");
							?>
						</div>
                     <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Kelamin</label>
							<?php 
								$nm_f = "kelamin";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Tempat Lahir</label>
							<?php 
								$nm_f = "tmpt_lahir";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Tanggal Lahir</label>
							<?php 
								$nm_f = "tgl_lahir";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Agama</label>
							<?php 
								$nm_f = "agama";
								echo form_input($nm_f, isset($bio[$nm_f]) ? getAgama($bio[$nm_f]) : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Alamat</label>
							<?php 
								$nm_f = "alamat";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">No Telepon</label>
							<?php 
								$nm_f = "notel";
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
                  <tr>
                  	<td>
						<div class="clearfix">
							<label class="title">Status</label>
							<?php 
								$nm_f = "status";
								$bio[$nm_f]=='y' ? $bio[$nm_f]='Aktif' : $bio[$nm_f]='Tidak Aktif';
								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='validate[required]' readonly");
							?>
						</div>
                         <td>
                   </tr>
                    </tr>
						<!--<div class="clearfix">
							<label class="title">Tanggal Permohonan</label>
							<?php 
/*
								$nm_f = "tgl_permohonan";

								echo form_input($nm_f, isset($bio[$nm_f]) ? $bio[$nm_f] : "", "id='".$nm_f."' class='span5 required'");

								echo form_hidden($nm_f."_temp", isset($bio[$nm_f]) ? $bio[$nm_f] : "");
*/
							?>

						</div>-->
					</td>

				</tr>

			</table>

</fieldset>