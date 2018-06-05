<?php
if ($this->uri->segment(2) == "modifEmp")
{ ?>
    <div style="width: 60%; margin-top: -32%; margin-left: 27%;">
    <h3 align="center">Modifier employé</h3>
    <form action="" method="post">
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
            <label for="">Sélectionner employé</label>
            <select name="matemp" id="matemp" class="form-control">
                <option value=''>Select Service first</option>
                <?php/*
                if ($emp->num_rows() > 0)
                {
                    echo "<option value=''>Select Employé</option>";
                    foreach ($emp->result() as $v)
                    {
                        echo "<option value='$v->mat'>$v->mat - $v->nom - $v->prenom</option>";
                    }
                }
                else
                {
                    echo "<option value=''>Aucun employé sélectionné</option>";
                }*/
                ?>
            </select>
        </div>
    </form>
    </div>
    <div id="infoEmp" style="width: 60%; margin-top: 2%; margin-left: 27%; border-top: gray solid 3px; padding: 2% 1%;">
    </div>
<?php }
elseif ($this->uri->segment(2) == "modifS")
    { ?>
<div style="width: 60%; margin-top: -28%; margin-left: 27%;">
    <h3 align="center">Modifier Service</h3><br/>
        <form action="">
            <div class="form-group">
                <select name="idS1" id="idS1" class="form-control">
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
        </form>
    <div id="modS" style="margin-top: 4%;  border-top: gray solid 3px; padding: 2% 1%;"></div>
</div>
    <?php }
?>
<script>
    $("#idS").on('change', function (event) {
        event.preventDefault();
        var idS = $('#idS').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recupEmp_s',
            data: {idS:idS},
            success : function (data) {
                $('#matemp').html(data);
            }
        });
    })
</script>
<script>
    $("#matemp").on('change', function (event) {
        event.preventDefault();
        var mat = $('#matemp').val();
        $.ajax({
            type : "POST",
            url : '<?php echo base_url();?>AdminC/returnInf',
            data: {mat:mat},
            success : function (data) {
               $('#infoEmp').html(data);
            }
        });
    })
</script>
<script>
    $(document).on('submit','#modif',function (event) {
        event.preventDefault();

        if ($('#nom').val() != '' && $('#prenom').val() != '' && $('#dateNaiss').val() != '' &&
            $('#adress').val() != '' && $('#tel').val() != '' && $('#email').val() != '' &&
            $('#dateRecrut').val() != '' && $('#username').val() != '' && $('#password').val() != '' &&
            $('#idS').val() != '' && $('#fonction').val() != '')
        {
            if (confirm("Are you sure you want to update this ?"))
            {

                $.ajax({
                    url:"<?php echo base_url();?>AdminC/updateE",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData: false,
                    success:function (data) {
                        $('#infoEmp').html("<div class='alert alert-success'>"+data+" <i class='fas fa-check fa-1x'></i></div>");
                    }
                });
            }else
            {
                return false;
            }
        }
        else
        {
            alert("L'un des champs est vide")
        }


    });
</script>
<script>
    $("#idS1").on('change', function (event) {
        event.preventDefault();
        var idS2 = $('#idS1').val();
        $.ajax({
            type: "POST",
            url : '<?php echo base_url();?>AdminC/recup_s',
            data: {idS2:idS2},
            success : function (data) {
                $('#modS').html(data);
            }
        });
    })
</script>
<script>
    $(document).on('submit','#modifS',function (event) {
        event.preventDefault();

        if ($('#libS2').val() != '' )
        {
            if (confirm("Are you sure you want to update this ?"))
            {

                $.ajax({
                    url:"<?php echo base_url();?>AdminC/updateS",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData: false,
                    success:function (data) {
                        $('#modS').html("<div class='alert alert-success'>"+data+" <i class='fas fa-check fa-1x'></i></div>");
                    }
                });
            }else
            {
                return false;
            }
        }
        else
        {
            alert("L'un des champs est vide")
        }


    });
</script>