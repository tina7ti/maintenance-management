<div class="container tt_inf" id="" style="margin-left: 20%; margin-right: 3%; width: 67%; ">
<h2 align="center">Ajouter famille  </h2>
<form action="" method="post" id="formaj">
	<label for="">Libellé de la famille</label>
	<div class="input-group" style="width: 100%;">
		<input type="text" class="form-control" name="libF" id="libF">
	</div>
	<span class="text-danger"><?php echo form_error("libF"); ?></span>
	<div class="input-group" style="width: 100%;">
		<input type="submit" class="form-control ajf" name="ajouterF" id="ajouterF" value="Ajouter">
	</div>
</form>
</div>
<script>
	$(document).on('submit','#formaj',function (event) {
		event.preventDefault();
		var libF = $('#libF').val();
		if (libF != '')
		{
			if (confirm("Are you sure you want to add this ?"))
			{

				$.ajax({
					url:"<?php echo base_url();?>Res/ajoutFamille",
					method:"POST",
					data: new FormData(this),
					contentType:false,
					processData: false,
					success:function (data) {
						alert(data);
						$('#formaj')[0].reset();
					}
				});
			}else
			{
				return false;
			}
		}
		else
		{
			alert("libellé field are required")
		}


	});
</script>
