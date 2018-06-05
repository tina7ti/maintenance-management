<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title> Mot de passe oublie </title>
    <link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>fs/css/style.css">
    <script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>

</head>

<body>
    <div class="con">
        <form action="<?php echo base_url();?>Mail/" method="post">
            <div class="input-group input-group-lg">

                <span class="input-group-addon" id="sizing-addon1"><i class="fas fa-at"></i></span>
                <input placeholder="username" id="username" type="text " name="username" class="form-control" aria-describedby="sizing-addon1">
            </div>
            <span class="text-danger"><?php echo form_error("username") ?></span>

            <button class="btn btn-default" type="submit">Envoyer</button>


				<?php
				if (isset($error) && isset($info))
				{
					echo '<label class="text-danger" style="font-size: 1.3em;">'.$error.'</label>';
					echo '<div class="alert alert-danger">'.$info.'</div>';
				}
				?>

        </form>
    </div>

    <script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
</body>

</html>
