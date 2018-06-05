<div class="container tt_inf" id="suppSF" style="margin-left: 20%; margin-right: 3%; width: 67%; ">
    <h2 align="center">Supprimer sous famille</h2>
    <form method="post" action="" id="supp_form">
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
        <div>
            <label for="">Sous famille</label>
            <select name="idSF" id="idSF" class="form-control">
						<option value="">Select Famille first</option>
					</select>

        </div>
        <span class="text-danger"><?php echo form_error("idSF"); ?></span>

        <div class="input-group" style="width: 100%;">
            <input type="submit" class="form-control suppf" name="supF" id="supF" value="supprimer">
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#idF').on('change', function() {
                var fid = $('#idF').val();


                if (fid != '') {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>Res/fetch_sfVide',
                        data: 'idF=' + fid,
                        success: function(html) {
                            $('#idSF').html(html);
                        }
                    });
                } else {
                    $('#idSF').html('<option value="">Select Famille first </option>');
                }
            }

        );

    });

</script>

<script>
    $(document).on('submit', '#supp_form', function(event) {
        event.preventDefault();
        var idsf = $('#idSF').val();
        if (confirm("Are you sure you want to delete this ?")) {
            $.ajax({
                url: "<?php echo base_url();?>Res/suppSF",
                method: "POST",
                data: {
                    idsf: idsf
                },
                success: function(data) {
                    alert(data);
                    $('#supp_form')[0].reset();
                }
            });
        } else {
            return false;
        }
    });

</script>
