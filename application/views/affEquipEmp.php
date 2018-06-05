<div class="container" style="margin-top: -32%; margin-left: 19%; width: 75%;">
    <h3 style="border-bottom: gray solid 3px; padding-bottom: 1%; margin-bottom: 2%;">Affecter des équipemets à un employé</h3>
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
        <div id="ok"></div>
        <div style="border-top: gray solid 2px; margin-bottom: 4%; margin-top: 3%; padding-top: 2%; width: 90%; margin-left: 5%;">
            <div class="form-group">
                <label for="">Sélectionner famille d'équipemet</label>
                <select name="idF" id="idF" class="form-control">
                    <?php
                    if ($f->num_rows() > 0)
                    {
                        echo "<option value=''>Select Famille</option>";
                        foreach ($f->result() as $v)
                        {
                            echo "<option value='$v->idF'>$v->libF</option>";
                        }
                    }
                    else
                    {
                        echo "<option value=''>Aucune famille sélectionné</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Sélectionner sous famille</label>
                <select name="idSF" id="idSF" class="form-control">
                    <option value="">Select sous famille</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Sélectionner marque</label>
                <select name="idMarque" id="idMarque" class="form-control">
                    <option value="">Select Marque</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Sélectionner modèle</label>
                <select name="idModele" id="idModele" class="form-control">
                    <option value="">Select Modele</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Sélectionner les équipements</label>
                <select name="numSerie" id="numSerie" class="form-control">
                    <option value="">Select Équipement</option>
                </select>
            </div>
        </div>
        <table id="tab" class="table table-responsive table-bordered">
            <tr>
                <th>Famille</th>
                <th>Sous Famille</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de serie</th>
            </tr>
        </table>
        <div id="erreur"></div>
        <div class="form-group">
            <input type="submit" name="affecter" value="Affecter" class="form-control">
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
                $('#mat').html(data);
            }
        });
    })
</script>
<script>
    $("#idF").on('change', function (event) {
        event.preventDefault();
        var idF = $('#idF').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupsf',
            data: {idF:idF},
            success : function (data) {
                $('#idSF').html(data);
                $('#erreur').html("");
            }
        });
    })
</script>
<script>
    $("#idSF").on('change', function (event) {
        event.preventDefault();
        var idSF = $('#idSF').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupMarque',
            data: {idSF:idSF},
            success : function (data) {
                $('#idMarque').html(data);
            }
        });
    })
</script>
<script>
    $("#idMarque").on('change', function (event) {
        event.preventDefault();
        var idSF = $('#idSF').val();
        var idMarque = $('#idMarque').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupModele',
            data: {idMarque:idMarque,idSF:idSF},
            success : function (data) {
                $('#idModele').html(data);
            }
        });
    })
</script>
<script>
    $("#idModele").on('change', function (event) {
        event.preventDefault();
        var idModele = $('#idModele').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupEquip',
            data: {idModele:idModele},
            success : function (data) {
                $('#numSerie').html(data);
            }
        });
    })
</script>
<script>
    $("#numSerie").on('change', function (event) {
        event.preventDefault();
        var numSerie = $('#numSerie').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/remplirTab',
            data: {numSerie:numSerie},
            success : function (data) {
               document.getElementById('tab').innerHTML += data;
            }
        });
    })
</script>
<script>
    $(document).on('submit','#affecE',function (event) {
        event.preventDefault();

        if ($('#mat').val() != '' )
        {
            if (confirm("Etes vous sure d'affecter ces équipements à cet employé ?"))
            {

                $.ajax({
                    url:"<?php echo base_url();?>AdminC/affec",
                    method:"POST",
                    data: $(this).serialize(),
                    dataType:"json",
                    success:function (data) {
                        if (data.er == 'erreur')
                        {
                            $('#erreur').html("<div class='alert alert-danger'>Vous avez rien sélectionner comme équipements <i class='fas fa-times fa-1x'></i></div>");
                        }
                        else
                        {
                            if (data.er == "emp")
                            {
                                $('#ok').html("<div class='alert alert-danger'>Champ employé vide<i class='fas fa-times fa-1x'></i></div>");

                            }
                            else
                            {
                                $('#ok').html("<div class='alert alert-success'>Affectation avec succés <i class='fas fa-check fa-1x'></i></div>");

                            }
                        }
                    }
                });
            }else
            {
                return false;
            }
        }
        else
        {
            alert("Le champ d'employé vide")
        }


    });
</script>