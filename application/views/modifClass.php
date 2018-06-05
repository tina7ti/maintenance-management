<div class="container" style="margin-top: -26%; width: 65%; margin-left: 22%;">
    <div id="succes"></div>
    <h2 align="center">Modifier Classe</h2>
    <form action="" method="post" id="formaj">
        <div class="form-group">
            <label for="">Classe</label>
            <select name="idC" id="idC" class="form-control">
					<?php
					if ($idC->num_rows() >0) { ?>
						<option value="">............</option>
						<?php
						foreach ($idC->result() as $v) {
							?>
							<option value="<?php echo $v->idC; ?>"><?php echo $v->idC; ?></option>
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
        <span class="text-danger"><?php echo form_error("idC"); ?></span>
        <div class="form-group">
            <label for="">seuil </label>
            <input type="text" class="form-control" name="seuil" id="seuil">
        </div>

        <span class="text-danger"><?php echo form_error("seuil"); ?></span>
        <div class="form-group" style="width: 100%;">
            <input type="submit" class="form-control" name="modifier" id="modifier" value="Modifier">
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#idC').on('change', function() {
                var fid = $(this).val();
                if (fid != '') {
                    $.ajax({
                        url: '<?php echo base_url();?>Ges/fetch_seuilC/'+fid,
                        method: 'POST',
                        data: $('#formaj').serialize(),
                        dataType: "json",
                        success: function(data) {
                            $('#seuil').val(data.seuil);
                        }
                    });
                } else {
                    $('#seuil').val(-2);
                }
            }

        );

    });

</script>
<script>
    $(document).on('submit', '#formaj', function(event) {
        event.preventDefault();
        var seuil = $('#seuil').val();
        if (seuil != '') {
            if (confirm("Are you sure you want to add this ?")) {

                $.ajax({
                    url: "<?php echo base_url();?>Ges/modifClass",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#succes').html("<div class='alert alert-success' style='font-weight: bold;'><i class=\"fas fa-check fa-2x\"></i>"+data+"</div>")
                        $('#formaj')[0].reset();
                    }
                });
            } else {
                return false;
            }
        } else {
            alert("seuil field is required")
        }


    });

</script>
