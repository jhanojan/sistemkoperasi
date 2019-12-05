<div class="hero-unit" style="margin:0 auto; margin-top:5%;">
  <h2><?php echo $title;?></h2>
  <form action="<?php echo base_url();?><?php echo $filename;?>/cek_login" method="post">
  	<fieldset>
  		<div class="alert-message error fade in" style="<?php echo $dis_error;?>">
        <a href="#" class="close">&times;</a>
        <p><?php echo $msg;?></p>
      </div>
  		<div class="clearfix">
        <label class="login">Username</label>
        <input type="text" name="username" class="span4">
      </div>
      <div class="clearfix">
        <label class="login">Password</label>
        <input type="password" name="password" class="span4" autocomplete="off">
      </div>
      <div class="clearfix_button">
      	<input type="submit" value="Submit" class="btn">
      </div>
    </fieldset>
  </form>
</div>