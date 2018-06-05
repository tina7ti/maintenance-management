<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Demande d'intervention</title>
	<link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>fs/css/style.css">

	<script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>
</head>
<body>
<section>
    <?php
    $style = 'margin-top : -2%;';
    if ( $this->uri->segment(1) == "Res")
        $style = 'margin-top : -42%; margin-left : 25%;';
    elseif ($this->uri->segment(1) == "Rep" ) $style = 'margin-top : -30%; margin-left : 25%;';
    elseif ($this->uri->segment(1) == "Ges") $style = 'margin-top : -42%; margin-left : 25%;';
    elseif ($this->uri->segment(1) == "AdminC") $style = 'margin-top : -34%; margin-left : 25%;';
    ?>
	<div class="container" id="insertDI" style="<?php echo $style;?>">
		<?php
		if ($this->uri->segment(2) == "ajoutee" || $this->uri->segment(2) == "Diajoutee")
		{
			echo "<div class='alert alert-success'><i class=\"fas fa-check fa-2x\"></i>Demande d'intervention ajoutée</div>";
		}

		if (isset($type))
		{
			echo "<div class='alert alert-success'><i class=\"fas fa-check fa-2x\"></i></div>";
		}

		?>

		<h2 align="center">Demande d'intervention</h2>
		<form method="post" action="<?php echo base_url().$this->uri->segment(1)."/"; ?>DI_validation" >
			<div class="form-group">
				<label for="">Equipement</label>
				<select name="idSF" id="idSF" class="form-control">
				<?php
				if ($matsf->num_rows() >0) { ?>
					<option value="">............</option>
					<?php
					foreach ($matsf->result() as $v) {
						?>
						<option
							value="<?php echo $v->idSF; ?>"><?php echo $v->libSF ; ?></option>
						<?php
					}
				}else
				{?>
					<option value="">no row selected</option>
				<?php
				}
				?>
				</select>
			</div>
            <div class="form-group">
                <label for="">Marque :</label>
                <select name="idMarque" id="idMarque" class="form-control">
                        <option value="">Select equipement first</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Modele :</label>
                <select name="idModele" id="idModele" class="form-control">
                    <option value="">Select marque first</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Numéro :</label>
                <select name="equip" id="equip" class="form-control">
                    <option value="">Select modele first</option>
                </select>
                <span class="text-danger"><?php echo form_error("equip"); ?></span>
            </div>
			<div class="form-group">
				<label for="">Date</label>
				<input type="date" name="date" class="form-control">
			</div>
			<span class="text-danger"><?php echo form_error("date"); ?></span>
			<div class="form-group">
				<label for="">Note</label>
				<textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
			</div>
			<span class="text-danger"><?php echo form_error("note"); ?></span>
			<div class="form-group">
				<input type="submit" value="Ajouter" name="ajouter" class="form-control ajouter">
			</div>
		</form>
	</div>
</section>
<script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function (){
		$('.ajouter').click(function (){
			if ( confirm("Etes vous sure des données insérés ?"))
			{
				window.location = "<?php echo base_url().$this->uri->segment(1)."/";?>DI_validation";
			}
			else
			{
				return false;
			}
		});
	});
</script>
<script>
	$(document).ready(function () {
		function load_unseen_notification(view = '') {
			$.ajax({
				url : "<?php echo base_url();?>Res/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {
					/*$('.dropdown-menu').html(data.notification);*/
					if (data.unseen_notification >0)
					{
						$('.badgeres1').html(data.unseen_notification);
					}
					if (data.unseen_notification2 >0)
					{
						$('.badgeres2').html(data.unseen_notification2);
					}
				}
			})
		}
		load_unseen_notification();
		$('#comment_form').on('submit',function (event) {
			event.preventDefault();
			if ($('#subject').val() != '' && $('#comment').val() != '')
			{
				var form_data = $(this).serialize();
				$.ajax({
					url : "<?php echo base_url();?>Notification/insert",
					method:"POST",
					data: form_data,
					success: function (data) {
						$('#comment_form')[0].reset();
						load_unseen_notification();
					}
				})
			}
			else
			{
				alert("both fields are required");
			}
		});
	});
</script>
<script>
	$(document).ready(function () {
		function load_unseen_notification(view = '') {
			$.ajax({
				url : "<?php echo base_url();?>Rep/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {
					/*$('.dropdown-menu').html(data.notification);*/
					if (data.unseen_notificationrep1 >0)
					{
						$('.badgerep1').html(data.unseen_notificationrep1);
					}
					if (data.unseen_notificationrep2 >0)
					{
						$('.badgerep2').html(data.unseen_notificationrep2);
					}
				}
			})
		}
		load_unseen_notification();
		$('#comment_form').on('submit',function (event) {
			event.preventDefault();
			if ($('#subject').val() != '' && $('#comment').val() != '')
			{
				var form_data = $(this).serialize();
				$.ajax({
					url : "<?php echo base_url();?>Notification/insert",
					method:"POST",
					data: form_data,
					success: function (data) {
						$('#comment_form')[0].reset();
						load_unseen_notification();
					}
				})
			}
			else
			{
				alert("both fields are required");
			}
		});
	});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idSF').on('change',function () {
                var sfid = $(this).val();
                if (sfid){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Di/fetch_mar',
                        data: {sfid:sfid},
                        success: function (html) {
                            $('#idMarque').html(html);
                            $('#idModele').html('<option value="">Select marque first</option>');
                        }
                    });
                }else {
                    $('#idMarque').html('<option value="">Select équipement first</option>');
                }
            }

        );

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idMarque').on('change',function () {
                var idmar = $(this).val();
            var sfid = $('#idSF').val();
                if (idmar && sfid){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Di/fetch_mod',
                        data: {idmar:idmar,sfid:sfid},
                        success: function (html) {
                            $('#idModele').html(html);
                            $('#equip').html('<option value="">Select modele first</option>');
                        }
                    });
                }else {
                    $('#idModele').html('<option value="">Select marque first</option>');
                    $('#equip').html('<option value="">Select modele first</option>');
                }
            }

        );

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idModele').on('change',function () {
                var idmod = $(this).val();
                if (idmod){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Di/fetch_equip',
                        data: {idmod:idmod},
                        success: function (html) {
                            $('#equip').html(html);
                        }
                    });
                }else {
                    $('#equip').html('<option value="">Select modele first</option>');
                }
            }

        );

    });
</script>
</body>
</html>
