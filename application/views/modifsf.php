<div class="container tt_inf" id="modF" style="margin-left: 20%; margin-right: 3%; width: 67%; ">
    <h2 align="center">Modifier sous famille </h2>
    <form action="" method="post" id="modifsF">
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
        <div>
            <label for="">Sous famille</label>
            <select name="idSF" id="idSF" class="form-control">
                <option value="">Select Famille first</option>
            </select>

        </div>
        <span class="text-danger"><?php echo form_error("idSF"); ?></span>
        <div class="form-group">
            <label for="">Libellé de la sous famille :</label>
            <input type="text" name="libSF" id="libSF" class="form-control">
        </div>
        <span class="text-danger"><?php echo form_error("libSF"); ?></span>
        <div class="form-group">
            <input type="submit" id="modifierF" name="modiferF" value="Modifier" class="form-control" style="background-color: #cbcbcb;">
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
    $(document).on('submit','#modifsF',function (event) {
        event.preventDefault();
        var libSF = $('#libSF').val();
        if (libSF != '')
        {
            if (confirm("Are you sure you want to update this ?"))
            {

                $.ajax({
                    url:"<?php echo base_url();?>Res/upSF",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData: false,
                    success:function (data) {
                        alert(data);
                        $('#modifsF')[0].reset();
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

