
<div class="container" style="margin-left: 20%; margin-right: 3%; width: 67%; ">
	<h2 align="center">Ajouter sous famille  </h2>
	<form action="" method="post" id="formaj">
		<div class="form-group">
			<label for="">Famille</label>
				<select name="idF" id="idF" class="form-control">
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
		<label for="">Libellé de la sous famille</label>
		<div class="input-group" style="width: 100%;">
			<input type="text" class="form-control" name="libSF" id="libSF">
		</div>
		</div>
		<span class="text-danger"><?php echo form_error("libSF"); ?></span>
		<div class="input-group" style="width: 100%;">
			<input type="submit" class="form-control" name="ajouterF" id="ajouterF" value="Ajouter">
		</div>
	</form>
</div>

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
						}
					});
				}else {
					$('#idSF').html('<option value="">Select Famille first</option>');
				}
			}

		);

	});
</script>
<script>
    $(document).on('submit', '#formaj', function(event) {
        event.preventDefault();
        var libSF = $('#libSF').val();
        if (libSF != '') {
            if (confirm("Are you sure you want to add this ?")) {

                $.ajax({
                    url: "<?php echo base_url();?>Res/ajout_sf",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        $('#formaj')[0].reset();
                    }
                });
            } else {
                return false;
            }
        } else {
            alert("libellé field are required")
        }


    });

</script>
