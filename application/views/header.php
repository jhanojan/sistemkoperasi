<div class="header-main-navigation">
	<div class="top">
		<div class="top-left">
			&nbsp;
			<img  src="<?php echo base_url();?>assets/images/<?php echo GetValue('foto','kode_koperasi',array('id'=>'where/1'));?>" alt="logo" width="100"/>
		</div>
		<div class="top-middle">
			<p class="judul_app"><?php echo strtoupper(GetValue('nama','kode_koperasi',array('id'=>'where/1')));?></p>
			<p class="judul_app" style="font-size:12px;"><?php echo strtoupper(GetValue('alamat','kode_koperasi',array('id'=>'where/1')));?></p>
		</div>
		<div class="top-right">
			<p style="<?php echo $dis_login;?>">Welcome <b><?php echo $nama_user;?></b> | <a href="<?php echo base_url();?>login/logout">Logout</a></p>
			<p style="<?php echo $dis_login;?>">
				<a href='#' data-controls-modal="modal-password"><b>Ganti Password</b></a>
			</p>
		</div>
	</div>
	<div class="clear"></div>
	<!--main navigation-->
	<div class="main-navigation">
		<ul class="main-nav">
			<?php $this->load->view($menu);?>
		</ul>
	</div>
</div>