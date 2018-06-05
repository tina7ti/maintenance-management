<div class="container" style="margin-top: -32%; margin-left: 19%; width: 75%;">
    <h3 style="border-bottom: gray solid 3px; padding-bottom: 1%; margin-bottom: 2%;">Consulter les équipemets d'un employé</h3>
    <form action="" method="post" id="affecE">
        <div class="form-group">
            <label for="">Sélectionner Service</label>
            <select name="idS" id="idS" class="form-control">
                <?php
                if ($s->num_rows() > 0)
                {
                    echo "<option value=''>Select Service</option>";
                    foreach ($s->result() as $v)
                    {
                        echo "<option value='$v->idS'>$v->libS</option>";
                    }
                }
                else
                {
                    echo "<option value=''>Aucun service sélectionné</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Sélectionner l'employé</label>
            <select name="mat" id="mat" class="form-control">
                <option value="">Select Employé</option>
            </select>
        </div>
    </form>

        <table id="tabl" class="table table-responsive table-bordered">

        </table>

</div>

<script>
    $("#idS").on('change', function (event) {
        event.preventDefault();
        var idS = $('#idS').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupEmp_s',
            data: {idS:idS},
            success : function (data) {
                $('#mat').html(data);
            }
        });
    })
</script>
<script>
    $("#mat").on('change', function (event) {
        event.preventDefault();
        var mat = $('#mat').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupMat_e',
            data: {mat:mat},
            success : function (data) {
                document.getElementById('tabl').innerHTML = data;
            }
        });
    });
</script>