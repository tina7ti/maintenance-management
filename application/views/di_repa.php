<?php
if (isset($etat))
{?>
<div class="container tt_inf" id="ressid" style="width: 100%; ">
    <h3>Identifier les matériaux utilisés :</h3>
    <div id="error"></div>
    <form action="" method="post" id="formu2">
        <div class="ress"  style="width: 27%; float: left; margin-right: 2%">
            <?php
            $id = $this->uri->segment(3);
            ?>
            <input type="hidden" value="<?php echo $id; ?>" name="idDI" id="idDI">
            <div class="form-group">
                <Label>Famille :</Label>
                <select type="text" name="idF" id="idF" class="form-control" autofocus>
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
                <Label>Sous famille :</Label>
                <select type="text" name="idSF" id="idSF" class="form-control">
                    <option value="">Select Famille first</option>
                </select>
            </div>
            <span class="text-danger"><?php echo form_error("idSF"); ?></span>
            <div class="form-group">
                <Label>Marque :</Label>
                <select type="text" name="idMarque" id="idMarque" class="form-control">
                    <option value="">Select all previous informations</option>
                </select>
            </div>
            <div class="form-group">
                <Label>Modèle :</Label>
                <select type="text" name="idModele" id="idModele" class="form-control" multiple>

                </select>
            </div>

        </div>
        <div class="form-group">
            <table class="table table-bordered table-responsive" style="width: 71%; float: left;" id="tabb">
                <tr>
                    <th colspan="4">Matériaux séléctionnés</th>
                    <th hidden></th>
                </tr>
                <tr>
                    <th>Famille</th>
                    <th>Sous famille</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th hidden></th>
                </tr>
            </table>
        </div>
        <div class="form-group">
            <input type="submit" name="enregistrer" value="Enregistrer" id="enregistrer" class="form-control">
        </div>
    </form>
</div>
    <?php
}else
{?>
    <div class="container" id="aff" style="margin-top: -25%; margin-left: 20%; width: 70%;">
        <button class="return"><i class="fas fa-arrow-left"></i></button>
        <?php
        if($di_sp->num_rows() >0) {
            foreach ($di_sp->result() as $v) {
                $id = $v->idDI;
                ?>
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 tt_inf" style="/*width: 320px;  float: right; */font-size: 1.5em;" >
                    <h3><?php echo $v->libSF.' - '.$v->libMarque.' - '.$v->libModele.' - '.$v->libS ; ?></h3>
                    <?php echo '<br/><span style="font-weight: bold;">Équipement (marque-modèle) :</span> '.$v->libMarque.' - '.$v->libModele ;?>
                    <?php echo '<br/><span style="font-weight: bold;">Famille et sous famille : </span>'.$v->libF.' - '.$v->libSF  ;?>
                    <?php echo '<br/><span style="font-weight: bold;">Numéro de bureau : </span>'.$v->local ;?>
                    <?php echo '<br/><span style="font-weight: bold;">Service : </span>'.$v->libS ;?>
                    <?php if($v->numArmoire != null) echo '<br/><span style="font-weight: bold;">Armoire : </span>'.$v->numArmoire;?>
                    <?php echo '<br/><span style="font-weight: bold;">Employé : </span>'.$v->nom.' '.$v->prenom ;?>
                    <?php echo '<br/><span style="font-weight: bold;">Signialé le : </span>'.$v->date ;?>
                    <?php echo '<br/><span style="font-weight: bold;">Panne : </span>'.$v->note;?>
                    <?php echo '<br/><span style="font-weight: bold;">Vos observations : </span>'.$v->observations;?>
                    <br/>
                </div>
                <?php
            }
        }
        ?>
        <div id="succes"></div>
        <h3>Identifier les ressourses nécessaires :</h3>
        <div id="error"></div>
        <form action="" method="post" id="formu">
            <div class="ress"  style="width: 27%; float: left; margin-right: 2%">
                <?php
                $id = $this->uri->segment(3);
                ?>
                <input type="hidden" value="<?php echo $id; ?>" name="idDI" id="idDI">
                <div class="form-group">
                    <Label>Famille :</Label>
                    <select type="text" name="idF" id="idF" class="form-control">
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
                    <Label>Sous famille :</Label>
                    <select type="text" name="idSF" id="idSF" class="form-control">
                        <option value="">Select Famille first</option>
                    </select>
                </div>
                <span class="text-danger"><?php echo form_error("idSF"); ?></span>
                <div class="form-group">
                    <Label>Marque :</Label>
                    <select type="text" name="idMarque" id="idMarque" class="form-control">
                        <option value="">Select all previous informations</option>
                    </select>
                </div>
                <div class="form-group">
                    <Label>Modèle :</Label>
                    <select type="text" name="idModele" id="idModele" class="form-control" multiple>

                    </select>
                </div>

            </div>
            <div class="form-group">
                <table class="table table-bordered table-responsive" style="width: 71%; float: left;" id="tabb">
                    <tr>
                        <th colspan="4">Matériaux séléctionnés</th>
                        <th hidden></th>
                    </tr>
                    <tr>
                        <th>Famille</th>
                        <th>Sous famille</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th hidden></th>
                    </tr>
                </table>
            </div>
            <div class="input-group" style="clear: both; font-weight: bold;">
                <button class="btn btn-default" type="button" id="saisie" data-toggle="modal" data-target="#myModal1" style="border: none; background-color: transparent; font-weight: bold;">
                    Marque et/ou Modèle n'existe pas ? Saisissez le(s).</button>
            </div>
            <div class="form-group">
                <input type="submit" name="enregistrer" value="Enregistrer" id="enregistrer" class="form-control">
            </div>
        </form>
        <!-- Modal1 -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Saisissez la marque et/ou Modèle</h4>
                    </div>
                    <div class="modal-body">
                        <button type="button" onclick="aff('saisMarq')" id="ajoutMarque" class="btn btn-default">Saisissez Marque et Modèle</button>
                        <button type="button" onclick="aff('saisModel')" id="ajoutModele" class="btn btn-default">Saisissez que le Modèle</button>
                        <div id="saisMarq" style="display: none;">
                            <form action="" method="post" id="marque_modal">
                                <div class="form-group">
                                    <label for="">Select Famille :</label>
                                    <select name="idF_m" id="idF_m" class="form-control">
                                        <?php
                                        if ($fam->num_rows() >0) { ?>
                                            <option value="">Select Famille</option>
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
                                <div class="form-group">
                                    <label for="">Select Sous famille :</label>
                                    <select name="idSF_m" id="idSF_m" class="form-control">
                                        <option value="">Select Famille First</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Saisissez libellé de la Marque :</label>
                                    <input type="text" class="form-control" name="libMarque_m" id="libMarque_m">
                                </div>
                                <div class="form-group">
                                    <label for="">Libéllé du modèle :</label>
                                    <input type="text" class="form-control" name="libModele_m" id="libModele_m">
                                </div>
                            </form>
                        </div>
                        <div id="saisModel" style="display: none;">
                            <form action="" method="post" id="modele_modal">
                                <div class="form-group">
                                    <label for="">Select Famille :</label>
                                    <select name="idF2_m" id="idF2_m" class="form-control">
                                        <?php
                                        if ($fam->num_rows() >0) { ?>
                                            <option value="">Select Famille</option>
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
                                <div class="form-group">
                                    <label for="">Select Sous famille :</label>
                                    <select name="idSF2_m" id="idSF2_m" class="form-control">
                                        <option value="">Select Famille First</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Select Marque :</label>
                                    <select name="idMarque2_m" id="idMarque2_m" class="form-control">
                                        <?php
                                        if ($marq->num_rows() >0) { ?>
                                            <option value="">Select Marque</option>
                                            <?php
                                            foreach ($marq->result() as $v) {
                                                ?>
                                                <option value="<?php echo $v->idMarque; ?>"><?php echo $v->libMarque; ?></option>
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
                                <div class="form-group">
                                    <label for="">Saisissez le libéllé du modèle :</label>
                                    <input type="text" class="form-control" name="libModele2_m" id="libModele2_m">
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        <button type="button" id="ajou" class="btn btn_ajmarque">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idF2_m').on('change',function () {
                var fid = $(this).val();
                if (fid){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Ges/fetch_sousF',
                        data: 'idF='+fid,
                        success: function (html) {
                            $('#idSF_m').html(html);
                            $('#idSF2_m').html(html);
                        }
                    });
                }else {
                    $('#idSF_m').html('<option value="">Select Famille first</option>');
                    $('#idSF2_m').html(html);
                }
            }

        );

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idF_m').on('change',function () {
                var fid = $(this).val();
                if (fid){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Ges/fetch_sousF',
                        data: 'idF='+fid,
                        success: function (html) {
                            $('#idSF_m').html(html);
                        }
                    });
                }else {
                    $('#idSF2_m').html('<option value="">Select Famille first</option>');
                    $('#idSF_m').html(html);
                }
            }

        );

    });
</script>
<script>
	$(document).ready(function (){
		$('.return').click(function (){
            <?php
            if ($this->uri->segment(4) == 50 || $this->uri->segment(4) == 51 || $this->uri->segment(4) == 70 || $this->uri->segment(4) == 71)
            {
            ?>
            window.location = "<?php echo base_url();?>Res/di_nonrep";
            <?php
            }
            else
            {if ($this->uri->segment(4) == 3 || $this->uri->segment(4) == 6)
            {
            ?>
            window.location = "<?php echo base_url();?>Rep/all_maint";
            <?php
            }
            else
            {
            ?>
            window.location = "<?php echo base_url();?>Rep/di_affec";
            <?php
            }
            }
            ?>

		});
	});
</script>
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
                            $('#idMarque').html('<option value="">Select all previous informations</option>');
                            $('#idModele').html('');
						}
					});
				}else {
					$('#idSF').html('<option value="">Select Famille first</option>');
                    $('#idMarque').html('<option value="">Select all previous informations</option>');
                    $('#idModele').html('');
				}
			}

		);

	});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idSF').on('change',function () {
                var idsf = $(this).val();
                if (idsf){
                    $.ajax({
                        url: '<?php echo base_url();?>Rep/fetch_marqsf',
                        method: "POST",
                        data: {idsf:idsf},
                        success: function (data) {
                            $('#idMarque').html(data);
                            $('#idModele').html('');
                        }
                    });
                }else {
                    $('#idMarque').html('<option value="">Select all previous informations</option>');
                    $('#idModele').html('');
                }
            }

        );

    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#idMarque').on('change',function () {
				var idmarq = $(this).val();
				var idsf = $('#idSF').val();
				if (idmarq != "" && idsf){
					$.ajax({
						url: '<?php echo base_url();?>Rep/fetch_model_marqsf',
                        method: "POST",
						data: {idmarq:idmarq,idsf:idsf},
						success: function (data) {
							$('#idModele').html(data);
						}
					});
				}else {
					$('#idModele').html('<option value="">Select all previous informations</option>');
				}
			}

		);

	});
</script>
<script>
   /* $(document).ready(function () {
      $('#idModele').multiselect({
      nonSelectedText: "Select Marque First",
      buttonWidth: '400px'
    });
    });*/
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#idModele').on('change',function (event) {
            event.preventDefault();
			$.ajax({
				url : "<?php echo base_url();?>Rep/aj_tab",
				method:"POST",
				data: $('#formu').serialize(),
				dataType:"json",
				success: function (data) {
                    if (data.erreur == '') {
                        document.getElementById('tabb').innerHTML += data.inf_tab;
                        $('#error').html("");
                    } else
                        $('#error').html("<div class=\"alert alert-danger\" style='font-weight: bold;'>" + data.erreur + "</div>");

                }
			});
			});
	});
</script>
<script type="text/javascript">/*
    $(document).ready(function () {
        $('#idModele').on('change',function (event) {
            event.preventDefault();
            $.ajax({
                url : "<?php echo base_url();?>Rep/aj_tab",
                method:"POST",
                data: $('#formu2').serialize(),
                dataType:"json",
                success: function (data) {
                    if (data.erreur == '') {
                        document.getElementById('tabb').innerHTML += data.inf_tab;
                        $('#error').html("");
                    } else
                        $('#error').html("<div class=\"alert alert-danger\" style='font-weight: bold;'>" + data.erreur + "</div>");

                }
            });
        });
    });*/
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('submit','#formu',function (event) {
            event.preventDefault();
            $.ajax({
                url : '<?php echo base_url();?>Rep/bilanPre_validation',
                method:"POST",
                data: $(this).serialize(),
                dataType:"json",
                success: function (resultat) {
                    if(resultat.er =='OK')
                    {
                        window.location = "<?php echo base_url(); ?>Rep/di_affec/BilanEnvoye";
                    }else
                    {
                        $('#error').html("<div class=\"alert alert-danger\" style='font-weight: bold;'>"+resultat.er+"</div>");
                    }

                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('submit','#formu2',function (event) {
            event.preventDefault();
            $.ajax({
                url : '<?php echo base_url();?>Rep/enrMatUti',
                method:"POST",
                data: $(this).serialize(),

                success: function () {
                   alert('huuiuh');
                }
            });
        });
    });
</script>
<script>
	$(document).ready(function () {
		setInterval(function (view = '') {

		}, 1000); });
</script>
<script>

    function aff(id) {
        var elmt = document.getElementById(id);
        toggleDisplayOn(elmt,id);
    }
    function toggleDisplayOn(elmt,id)
    {
        if (id =='saisMarq' && elmt.style.display == "none") {
            elmt.style.display = "";
            var elmt2 = document.getElementById('saisModel');
            elmt2.style.display ="none";
        }
        if (id =='saisModel' && elmt.style.display == "none") {
            elmt.style.display = "";
            var elmt2 = document.getElementById('saisMarq');
            elmt2.style.display ="none";
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#ajou').on('click',function (event) {
            event.preventDefault();
            if ($('#libModele2_m').val() != '' && $('#idMarque2_m').val() != '' && $('#idF2_m').val() != '' && $('#idSF2_m').val() != '')
            {
                var form_data = $('#modele_modal').serialize();
                $.ajax({
                    url : "<?php echo base_url();?>Ges/ajoutmodel2",
                    method:"POST",
                    data: form_data,
                    success: function () {
                        alert("Modèle Ajouté");
                        window.location = "<?php base_url();?><?php echo $this->uri->segment(3)?>";
                    }
                })
            }
            else
            {
                if ($('#libMarque_m').val() != "" && $('#libModele_m').val() != '' && $('#idF_m').val() != '' && $('#idSF_m').val() != '')
                {
                    var form_data = $('#marque_modal').serialize();
                    $.ajax({
                        url : "<?php echo base_url();?>Ges/ajoutmarque2",
                        method:"POST",
                        data: form_data,
                        success: function () {
                            alert("Marque et Modèle Ajoutés");
                            window.location = "<?php base_url();?><?php echo $this->uri->segment(3)?>";
                        }
                    })
                }
                else
                {
                    alert("l'un des champs est vide");
                }
            }
        })
    });
</script>

