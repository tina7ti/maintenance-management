<div class="container tt_inf" id="modF" style="margin-left: 20%; margin-right: 3%; width: 67%; ">
    <h2 align="center">Modifier famille </h2>
    <form action="" method="post" id="modifF">
        <div class="form-group">
			<label for="">Select Famille :</label>
			<select name="idF" id="idF" class="form-control">
				<?php
				if($fam->num_rows() >0)
				{
					foreach ($fam->result() as $v)
					{?>
						<option value="<?php echo $v->idF;?>"><?php echo $v->libF;?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
		<span class="text-danger"><?php echo form_error("idF"); ?></span>
		<br/> <br/>
		<div class="form-group">
			<label for="">Libellé de la famille :</label>
			<input type="text" name="libF" id="libF" class="form-control">
		</div>
		<span class="text-danger"><?php echo form_error("libF"); ?></span>
		<br/>
		<div class="form-group">
			<input type="submit" id="modifierF" name="modiferF" value="Modifier" class="form-control" style="background-color: #cbcbcb;">
		</div>
	</form>
</div>

<script>
    $(document).on('submit','#modifF',function (event) {
        event.preventDefault();
        var libF = $('#libF').val();
        if (libF != '')
        {
            if (confirm("Are you sure you want to update this ?"))
            {

                $.ajax({
                    url:"<?php echo base_url();?>Res/upFamille",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData: false,
                    success:function (data) {
                        alert(data);
                        $('#modifF')[0].reset();
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

