<?php
$s = $this->session->userdata('mat');
if (!isset($s))
{
    redirect(base_url());
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" type="image/png" href="<?php echo base_url();?>fs/img/icon2.png">
	<link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>fs/css/style.css">

	<script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>
</head>
<body>
<header>

	<div class="nv">
        <img src="<?php echo base_url();?>/fs/img/user.png" alt="" class="img-circle">
		<div class="us">
			<h4><?php echo $this->session->userdata('username');?></h4>

					<a href="<?php echo base_url();?>login/logout" class="logout"><img src="<?php echo base_url();?>fs/img/logout4.png" alt=""></a>
		</div>
	</div>
</header>
<script src="<?php echo base_url();?>fs/js/Chart.min.js"></script>
<script src="<?php echo base_url();?>fs/js/Chart.PieceLabel.js"></script>
<script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() { $(".dropdown-toggle").dropdown(); });
</script>

</body>
</html>
