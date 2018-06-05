<div class="container" style="margin-top: -25%; margin-left: 30%; width: 50%;">
    <h3 align="center">Bloquer un employé</h3><br/>
    <?php
    if ($this->uri->segment(3) == "bloque")
        echo "<div class='alert alert-danger'>Employé bloqué <i class='fas fa-times fa-1x'></i></div>";
    ?>
    <form method="post" action="<?php echo base_url();?>AdminC/bloquer">
<div class="form-group">
    <select id="idS" class="form-control" name="idS">
        <?php
        if ($s->num_rows() > 0)
        {
            echo "<option value=''>Select Service</option>";
            foreach ($s->result() as $v)
            {
                echo "<option value='$v->idS'>$v->libS</option>";
            }
        }
        ?>
    </select>
</div>
        <div class="form-group">
            <select id="emp" name="emp" class="form-control" required>
                <option value=""> select Employe</option>
            </select>
        </div>
    <div class="form-group">
        <input id="submit" type="submit" value="Bloquer" class="form-control">
    </div>
    </form>
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
                $('#emp').html(data);
            }
        });
    })
</script>
