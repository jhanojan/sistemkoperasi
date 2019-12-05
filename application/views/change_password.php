
    	<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<link href="<?php echo base_url();?>assets/style/custom.css" rel="stylesheet">
		<script src="<?php echo base_url();?>assets/js/validation/jquery.validationEngine.js"></script>
		<script src="<?php echo base_url();?>assets/js/validation/jquery.validationEngine-id.js"></script>
    <link href="<?php echo base_url();?>assets/js/validation/validationEngine.jquery.css" rel="stylesheet">


<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#change_password").validationEngine('attach');
		});
</script>
<div>
  <form id="change_password" action="<?php echo base_url();?><?php echo $filename;?>/cek_password" method="post">
  		<div class="alert-message error fade in" style="padding-left:0px;color:'green';<?php echo $dis_error;?>">
        <p><?php echo $msg;?></p>
      </div><input type="hidden" name="id_user" value="<?php echo $iduser?>">
      <div class="clearfix">
        <label class="ganti_password">Password Lama</label>
        <input type="password" name="old_password" class="validate[required,minSize[8]]" id="old_password">
      </div>
      <div class="clearfix">
        <label class="ganti_password">Password Baru</label>
        <input type="password" name="new_password" class="validate[required,minSize[8]]" id="new_password">
      </div>
      <div class="clearfix">
        <label class="ganti_password">Ulangi Password Baru</label>
        <input type="password" name="u_new_password" class="validate[required,equals[new_password]]" id="u_new_password">
      </div>
      <div class="clearfix_button">
      	<input type="submit" value="Submit" class="btn">
      </div>
  </form>
</div>