<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<title>Login</title>
	<link rel="icon" type="image/png" href="<?php echo base_url();?>fs/img/icon2.png">
	<link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>fs/css/style.css">

	<script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>
</head>
<body id="loginBody">
	<div class="con">
		<!--<i class="fas fa-user-circle fa-9x"></i>-->
		<img src="<?php echo base_url();?>fs/img/user2.png" class="user2" alt="">

        <form method="post" action="<?php echo base_url();?>Login/login_validation">
			<?php
			if (isset($msg))
			{
				echo $msg;
			}
			?>
		<div class="input-group input-group-lg">
  			<span class="input-group-addon" id="sizing-addon1"><i class="fas fa-at"></i></span>
 			 <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
		</div>
            <div class="text-danger"><?php echo form_error("username"); ?></div>
		<div class="input-group input-group-lg">
 			 <span class="input-group-addon" id="sizing-addon2"><i class="fas fa-key"></i></span>
  			<input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon1">
		</div>
            <div class="text-danger"><?php echo form_error("password"); ?></div>
			<input type="checkbox" name="rem" style="margin-bottom: 6%; margin-right: 0.5%; margin-top: 0%;"><span class="rem">Remember me</span>
		<button class="btn btn-default" type="submit">Login</button>
			<?php
			echo '<label class="text-danger" style="font-size: 1.3em;">'.$this->session->flashdata("error").'</label>';
			?>
        </form>
        <a href="<?php echo base_url();?>Login/motOublie" >mot de passe oublié ?</a>


	</div>
	
	<script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
</body>
</html>
