<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Accueil</title>
	<link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>fs/css/style.css">

	<script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>
</head>
<body>
<div class="container" id="demAchat">
	<h2 align="center">select Matériel</h2>
	<form method="post" action="<?php echo base_url();?>Ges/select_validation">
		<div class="form-group">
			<label for="">Famille</label>
			<select name="idF" id="idF" class="form-control" required>
				<?php
				if ($fam->num_rows() >0) { ?>
					<option value="">............</option>
					<?php
					foreach ($fam->result() as $v) {
						?>
						<option value="<?php echo $v->idF; ?>"><?php echo $v->libF; ?></option>
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
		<span class="text-danger"><?php echo form_error("idF"); ?></span>
		<div class="form-group">
			<label for="">Sous famille</label>
			<select name="idSF" id="idSF" class="form-control" required>
				<option value="">Select Famille first</option>
			</select>
		</div>
		<span class="text-danger"><?php echo form_error("idSF"); ?></span>
        <div class="form-group">
            <label for="">Marque</label>
            <select name="idMarque" id="idMarque" class="form-control" required>
                <option value="">Select Sous Famille first</option>
            </select>
        </div>
        <span class="text-danger"><?php echo form_error("idMarque"); ?></span>
        <div class="form-group">
            <label for="">Modèle</label>
            <select name="idModele" id="idModele" class="form-control" required>
                <option value="">Select Marque first</option>
            </select>
        </div>
        <span class="text-danger"><?php echo form_error("idModele"); ?></span>
		<div class="form-group">
			<label for="">Materiel</label>
			<select name="numSerie" id="numSerie" class="form-control" required>
				<option value="">Select all previous informations</option>
			</select>
		</div>
		<span class="text-danger"><?php echo form_error("numSerie"); ?></span>
		<div class="form-group" style="display: flex; flex-wrap: wrap;">
			<input type="submit" value="Modifier" name="modifier" class="form-control" style="width: 40%; margin-left: 6%; margin-right: 8%;">
			<input type="submit" value="Supprimer" name="supprimer" class="form-control supp" style="width: 40%;">
		</div>
	</form>
</div>

<script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() { $(".dropdown-toggle").dropdown(); });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#idF').on('change',function () {
			var fid = $(this).val();
			if (fid){
				$.ajax({
					type:'POST',
					url: '<?php echo base_url();?>Ges/fetch_sousF',
					data: 'idF='+fid,
					success: function (html) {
						$('#idSF').html(html);
                        $('#idMarque').html('<option value="">Select sous famille first</option>');
                        $('#idModele').html('<option value="">Select Marque first</option>');
						$('#numSerie').html('<option value="">Select Modele first</option>');
					}
				});
			}else {
				$('#idSF').html('<option value="">Select Famille first</option>');
                $('#idMarque').html('<option value="">Select sous famille first</option>');
                $('#idModele').html('<option value="">Select Marque first</option>');
                $('#numSerie').html('<option value="">Select Modele first</option>');
			}
		});
	});

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idSF').on('change',function () {
                var idsf = $(this).val();
                if (idsf){
                    $.ajax({
                        url: '<?php echo base_url();?>Rep/fetch_marqsf',
                        method: "POST",
                        data: {idsf:idsf},
                        success: function (data) {
                            $('#idMarque').html(data);
                            $('#idModele').html('<option value="">Select Marque first</option>');
                            $('#numSerie').html('<option value="">Select Modele first</option>');
                        }
                    });
                }else {
                    $('#idMarque').html('<option value="">Select sous famille first</option>');
                    $('#idModele').html('<option value="">Select Marque first</option>');
                    $('#numSerie').html('<option value="">Select Modele first</option>');
                }
            }

        );

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idMarque').on('change',function () {
                var idmarq = $(this).val();
                var idsf = $('#idSF').val();
                if (idmarq != "" && idsf){
                    $.ajax({
                        url: '<?php echo base_url();?>Ges/fetch_model_marqsf',
                        method: "POST",
                        data: {idmarq:idmarq,idsf:idsf},
                        success: function (data) {
                            $('#idModele').html(data);
                            $('#numSerie').html('<option value="">Select Modele first</option>');
                        }
                    });
                }else {
                    $('#idModele').html('<option value="">Select Marque first</option>');
                    $('#numSerie').html('<option value="">Select Modele first</option>');
                }
            }

        );

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idModele').on('change',function () {
                var idmod = $(this).val();
                var idsf = $('#idSF').val();
                if (idmod != "" && idsf){
                    $.ajax({
                        url: '<?php echo base_url();?>Ges/fetch_mater',
                        method: "POST",
                        data: {idmod:idmod,idsf:idsf},
                        success: function (data) {
                            $('#numSerie').html(data);
                        }
                    });
                }else {
                    $('#numSerie').html('<option value="">Select all previous informations</option>');
                }
            }

        );

    });
</script>
<script>
	$(document).ready(function (){
		$('.supp').click(function (){
			if ( confirm("Are you sure you want to delete this materiel ?"))
			{
				window.location = "<?php echo base_url(); ?>Ges/select_validation";
			}
			else
			{
				return false;
			}
		});
	});
</script>


</body>
</html>


