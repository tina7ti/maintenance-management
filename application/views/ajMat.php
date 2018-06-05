<div class="container" id="ajmater">
    <?php
    if ($this->uri->segment(3) == "ajoutee")
    {
        echo '<div class="alert alert-success"><i class="fas fa-check fa-2x"></i>Matériel ajouté</div>';
    }
    ?>
	<h2 align="center"><?php echo $title;?></h2>
	<?php
	$url = '';
	if ($this->uri->segment(2) == 'ajout')
	{
		$url .= 'Ges/ajm_validation';
	}
	else
	{
		$url .= 'Ges/ajm_validation_update';
	}
	?>
	<form method="post" action="<?php echo base_url().$url;?>">
		<?php
		if (isset($inf_mater))
		{
			if ($inf_mater->num_rows() > 0)
			{
			foreach ($inf_mater->result() as $rows) {
				?>
				<div class="form-group">
					<label for="">Famille</label>

						<select name="idF" id="idF" class="form-control" required>
							<?php
							if ($fam->num_rows() > 0) { ?>
								<option value="<?php echo $idF; ?>"><?php echo $libF; ?></option>
								<?php
								foreach ($fam->result() as $v) {
								    if ( $v->idF != $idF) {
                                        ?>
                                        <option value="<?php echo $v->idF; ?>"><?php echo $v->libF; ?></option>
                                        <?php
                                    }
								}
							} else {
								?>
								<option value="">no row selected</option>
								<?php
							}
							?>
						</select>
				</div>
				<span class="text-danger"><?php echo form_error("idF"); ?></span>
				<div class="form-group">
					<label for="">Sous famille</label>
						<select name="idSF" id="idSF" class="form-control" required>
                            <?php
                            if ($sf->num_rows() > 0) { ?>
                                <option value="<?php echo $idSF; ?>"><?php echo $libSF; ?></option>
                                <?php
                                foreach ($sf->result() as $v) {
                                    if ( $v->idSF != $idSF) {
                                        ?>
                                        <option value="<?php echo $v->idSF; ?>"><?php echo $v->libSF; ?></option>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <option value="">no row selected</option>
                                <?php
                            }
                            ?>
						</select>
				</div>
				<span class="text-danger"><?php echo form_error("idSF"); ?></span>
				<div class="form-group">
					<label for="">Marque :</label>
					<div class="input-group">
						<select name="marq" id="marq" class="form-control">
                            <?php
                            if ($marq->num_rows() > 0) { ?>
                                <option value="<?php echo $idMarque; ?>"><?php echo $libMarque; ?></option>
                                <?php
                                foreach ($marq->result() as $v) {
                                    if ( $v->idMarque != $idMarque) {
                                        ?>
                                        <option value="<?php echo $v->idMarque; ?>"><?php echo $v->libMarque; ?></option>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <option value="">no row selected</option>
                                <?php
                            }
                            ?>
						</select>
						<span class="input-group-btn">
        		<button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal1"><i class="fas fa-plus fa-1x"></i></button>
	</span>
					</div>
				</div>
				<span class="text-danger"><?php echo form_error("idSF"); ?></span>
				<div class="form-group">
					<label for="">Modèle :</label>
					<div class="input-group">
						<select name="modele" id="modele" class="form-control">
                            <?php
                            if ($mod->num_rows() > 0) { ?>
                                <option value="<?php echo $idModele; ?>"><?php echo $libModele; ?></option>
                                <?php
                                foreach ($mod->result() as $v) {
                                    if ( $v->idModele != $idModele) {
                                        ?>
                                        <option value="<?php echo $v->idModele; ?>"><?php echo $v->libModele; ?></option>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <option value="">no row selected</option>
                                <?php
                            }
                            ?>
						</select>
						<span class="input-group-btn">
        		<button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal2"><i class="fas fa-plus fa-1x"></i></button>
	</span>
					</div>
				</div>
				<span class="text-danger"><?php echo form_error("idSF"); ?></span>
				<div class="form-group">
					<label for="">Numéro de série</label>
					<input type="text" name="numSerie" value="<?php echo $rows->numSerie; ?>" class="form-control" required>
				</div>
				<span class="text-danger"><?php echo form_error("numSerie"); ?></span>
				<div class="form-group">
					<label for="">Prix d'achat</label>
					<input type="text" name="prixAchat" value="<?php echo $rows->prixAchat; ?>" class="form-control" required>
				</div>
				<span class="text-danger"><?php echo form_error("prixAchat"); ?></span>
				<div class="form-group">
					<label for="">Date d'entré en stock</label>
					<input type="date" name="dateES" class="form-control" value="<?php echo $rows->dateES; ?>" required>
				</div>
				<span class="text-danger"><?php echo form_error("dateES"); ?></span>
				<div class="form-group">
					<label for="">Fournisseur</label>
					<select name="idFourn" id="idFourn" class="form-control">
						<?php
						if ($fourn->num_rows() > 0) { ?>
							<option value="<?php echo $rows->idFourn; ?>"><?php echo $rows->idFourn.', '.$nomFourn; ?></option>
							<?php
							foreach ($fourn->result() as $v) {
								if($v->idFourn != $rows->idFourn){
								?>
								<option
									value="<?php echo $v->idFourn; ?>"><?php echo $v->idFourn . ', ' . $v->nom; ?></option>
								<?php
							}}
						} else {
							?>
							<option value="NULL">no row selected</option>
							<?php
						}
						?>
					</select>
				</div>
				<span class="text-danger"><?php echo form_error("idFourn"); ?></span>
                <input type="hidden" name="hidden_id" value="<?php echo $rows->numSerie; ?>">
				<div class="form-group">
					<input type="submit" value="Modifier" name="modifier" class="form-control">
				</div>
				<?php
			}
			}
		}
		else
		{ ?>
			<div class="form-group">
				<label for="">Famille</label>

					<select name="idF" id="idF" class="form-control">
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
			<span class="text-danger"><?php echo form_error("idF"); ?></span>
			<div class="form-group">

				<label for="">Sous famille</label>
					<select name="idSF" id="idSF" class="form-control">
						<option value="">Select Famille first</option>
					</select>
			</div>
			<span class="text-danger"><?php echo form_error("idSF"); ?></span>
<div class="form-group">
	<label for="">Marque :</label>
	<div class="input-group">
	<select name="idMarque" id="idMarque" class="form-control">
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
	<span class="input-group-btn">
        		<button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal1"><i class="fas fa-plus fa-1x"></i></button>
	</span>
	</div>
</div>
			<span class="text-danger"><?php echo form_error("idMarque"); ?></span>
			<div class="form-group">
				<label for="">Modèle :</label>
				<div class="input-group">
					<select name="idModele" id="idModele" class="form-control">
						<option value="">Select all previous informations</option>
					</select>
					<span class="input-group-btn">
        		<button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal2"><i class="fas fa-plus fa-1x"></i></button>
	</span>
				</div>
			</div>
			<span class="text-danger"><?php echo form_error("idModele"); ?></span>
			<div class="form-group">
			<label for="">Numéro de série</label>
			<input type="text" name="numSerie" class="form-control">
		</div>
		<span class="text-danger"><?php echo form_error("numSerie"); ?></span>
		<div class="form-group">
			<label for="">Prix d'achat</label>
			<input type="text" name="prixAchat" class="form-control">
		</div>
		<span class="text-danger"><?php echo form_error("prixAchat"); ?></span>
		<div class="form-group">
			<label for="">Date d'entré en stock</label>
			<input type="date" name="dateES" class="form-control">
		</div>
		<span class="text-danger"><?php echo form_error("dateES"); ?></span>
		<div class="form-group">
			<label for="">Fournisseur</label>
			<select name="idFourn" id="idFourn" class="form-control">
				<?php
				if ($fourn->num_rows() >0) { ?>
					<option value="">Select fournisseur</option>
					<?php
					foreach ($fourn->result() as $v) {
						?>
						<option value="<?php echo $v->idFourn; ?>"><?php echo $v->idFourn . ', ' . $v->nom; ?></option>
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
		<span class="text-danger"><?php echo form_error("idFourn"); ?></span>
		<div class="form-group">
			<input type="submit" value="Ajouter" name="ajouter" class="form-control">
		</div>
		<?php
		}
		?>
	</form>
    <!-- Modal1  marque -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ajouter une nouvelle Marque</h4>
      </div>
      <div class="modal-body">
		<h4>Libellé de la marque : </h4>
		  <form action="" method="post" id="marque_modal">
			  <div class="form-group" style="width: 100%;">
				  <input type="text" class="form-control" name="libMarque" id="libMarque_m">
			  </div>
              <span><?php echo form_error('libMarque');?></span>
		  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" id="ajouMar" class="btn btn_ajmarque">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
    <!-- Modal2  modele -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ajouter un nouveau modèle</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="modele_modal">
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
                        <span><?php echo form_error('idF_m');?></span>
                        <div class="form-group">
                            <label for="">Select Sous famille :</label>
                            <select name="idSF_m" id="idSF_m" class="form-control">
                                <option value="">Select Famille First</option>
                            </select>
                        </div>
                        <span><?php echo form_error('idSF_m');?></span>
                        <div class="form-group">
                            <label for="">Select Marque :</label>
                            <select name="idMarque_m" id="idMarque_m" class="form-control">
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
                        <span><?php echo form_error('idMarque_m');?></span>
                        <div class="form-group">
                            <label for="">Select Classe :</label>
                            <select name="idC_m" id="idC_m" class="form-control">
                                <?php
                                if ($cla->num_rows() >0) { ?>
                                    <option value="">Select Classe</option>
                                    <?php
                                    foreach ($cla->result() as $v) {
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
                        <span><?php echo form_error('idC');?></span>
                        <div class="form-group" style="width: 100%;">
                            <label for="">Libéllé du modèle :</label>
                            <input type="text" class="form-control" name="libModele_m" id="libModele_m">
                        </div>
                        <span><?php echo form_error('libModele_m');?></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" id="ajouMod" class="btn btn_ajmodele">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
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
                    $('#idSF_m').html('<option value="">Select Famille first</option>');
                }
            }

        );

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#idMarque').on('change',function () {
                var sfid = $('#idSF').val();
                var marqid = $(this).val();
                if (sfid != ''){
                    $.ajax({
                        type:'POST',
                        url: '<?php echo base_url();?>Ges/fetch_mode_sfMarque/'+sfid+'/'+marqid,
                        data: "idSF ="+sfid,
                        success: function (html) {
                            $('#idModele').html(html);
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
	$(document).ready(function () {
	$('#ajouMar').on('click',function (event) {
		event.preventDefault();
		if ($('#libMarque_m').val() != '')
		{
			var form_data = $('#marque_modal').serialize();
			$.ajax({
				url : "<?php echo base_url();?>Ges/ajoutm",
				method:"POST",
				data: form_data,
				success: function () {
				    alert("Marque Ajoutée");
					window.location = "<?php base_url();?>ajout";
				}
			})
		}
		else
		{
			alert("libellé marque field is required");
		}
	})
	});

</script>

<script>
    $(document).ready(function () {
        $('#ajouMod').on('click',function (event) {
            event.preventDefault();
            if ($('#idMarque_m').val() != '' && $('#idF_m').val() != '' && $('#idSF_m').val() != '' && $('#idC_m').val() != '')
            {
                var form_data = $('#modele_modal').serialize();
                $.ajax({
                    url : "<?php echo base_url();?>Ges/ajoutmodel",
                    method:"POST",
                    data: form_data,
                    success: function () {
                        alert("Modèle Ajouté");
                        window.location = "<?php base_url();?>ajout";
                    }
                });
            }
            else
            {
                alert("l'un des champs est vide");
            }
        })
    });
</script>