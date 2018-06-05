<?php
if ($this->uri->segment(3) == "nonrep")
{
	echo '<script> alert("La demande a été envoyée vers le responsable");</script>';
}
if($this->uri->segment(3) == "BilanEnvoye")
{ ?>
    <script> alert("Le Bilan a été envoyé"); </script>
    <?php
}
?>

	<?php
	if( $this->uri->segment(2) == 'all_rep') {?>
        <div class="container" id="all_r">
            <?php
		if ($reparat->num_rows() > 0) {
			$id = 1;
			foreach ($reparat->result() as $v) {
				?>
				<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
					<h3><?php echo $v->mat . ' - ' . $v->nom; ?></h3>
					<button onclick="aff('<?php echo 'div' . $id; ?>')" class="lire">Lire la suite&rArr;</button>
					<div id="<?php echo 'div' . $id; ?>" style="display: none;">
						<?php echo '<br/><span style="font-weight: bold;">Nom et prenom : </span>' . $v->nom . ' ' . $v->prenom; ?>
						<?php echo '<br/><span style="font-weight: bold;">Fonction :</span> ' . $v->fonction; ?>
						<?php echo '<br/><span style="font-weight: bold;">Email : </span>' . $v->email; ?>
						<?php echo '<br/><span style="font-weight: bold;">Téléphone : </span>' . $v->tel; ?>
						<?php /*echo '<br/><span style="font-weight: bold;">Nombre d\'affectation en cours : </span>' . $v->nb; */?>
						<br/>
						<button onclick="hide('<?php echo 'div' . $id; ?>')" class="retour">&lArr; Retour</button>
					</div>
				</div>
				<?php
				$id++;
			}
		} else { ?>
			<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
				<h3>Aucun réparateur séléctionné</h3>
			</div>
			<?php
		}
            ?>
        </div>
        <?php
	}
	else
	{
		if ($this->uri->segment(2) == 'di_affec')
		{
		    	?>
		<div class="container" id="all_r2">
            <?php
			if ($di_attente->num_rows() > 0) {
				$id = 1;
				foreach ($di_attente->result() as $v) {
					?>
					<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
						<h3><?php echo $v->libSF.' - '.$v->libMarque.' - '.$v->libModele.' - '.$v->libS ; ?></h3>
						<button onclick="aff('<?php echo 'div' . $id; ?>')" class="lire">Lire la suite&rArr;</button>
						<div id="<?php echo 'div'.$id;?>" style="display: none; background-color: #f3f3f3; padding: 2% 5%; border-radius: 10px 10px; box-shadow: 4px 4px 6px gray; margin-bottom: 2%;">
							<?php echo '<br/><span style="font-weight: bold;">Équipement (marque-modèle) :</span> '.$v->libMarque.' - '.$v->libModele ;?>
							<?php echo '<br/><span style="font-weight: bold;">Famille et sous famille : </span>'.$v->libF.' - '.$v->libSF  ;?>
							<?php echo '<br/><span style="font-weight: bold;">Numéro de bureau : </span>'.$v->local ;?>
							<?php echo '<br/><span style="font-weight: bold;">Service : </span>'.$v->libS ;?>
							<?php if($v->numArmoire != null) echo '<br/><span style="font-weight: bold;">Armoire : </span>'.$v->numArmoire;?>
							<?php echo '<br/><span style="font-weight: bold;">Employé : </span>'.$v->nom.' '.$v->prenom ;?>
							<?php echo '<br/><span style="font-weight: bold;">Signialé le : </span>'.$v->date ;?>
							<?php echo '<br/><span style="font-weight: bold;">Panne : </span>'.$v->note;?>
							<br/><br><br>
							<form action="<?php echo base_url();?>Rep/repat_validation/<?php echo $v->idDI;?>" method="post" id="form_obser">
								<input type="text" name="<?php echo $v->idDI;?>" value="<?php echo $v->idDI;?>" id="hide_id" hidden >
								<div class="form-group">
									<label for="">Observations</label>
									<textarea name="observations" id="observations" placeholder="Vos observations" cols="25" rows="9" class="form-control" required style="margin-bottom: 3%;"></textarea>
								</div>
								<div class="form-group" style="display: flex; flex-wrap: wrap;">
									<input type="submit" name="nonreparable" value="Non réparable" class="form-control" style="width: 40%; margin-left: 6%; margin-right: 8%; background-color: #cbcbcb;">
									<input type="submit" name="reparable" value="Réparable" class="form-control" style="width: 40%; background-color: #cbcbcb;">
								</div>
							</form>
						</div>
					</div>
					<?php
					$id++;
				}
			} else { ?>
				<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
					<h3>Aucunne demande d'intervention séléctionnée</h3>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		}else
        {
            if ($this->uri->segment(2) == 'di_att')
            {
                ?>
                <div class="container" id="all_r2" style="margin-top: -36%;">
                    <?php
                    if ($di_att->num_rows() > 0) {
                        $id = 1;
                        foreach ($di_att->result() as $v) {
                            ?>
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
                                <h3><?php echo $v->libSF.' - '.$v->libMarque.' - '.$v->libModele.' - '.$v->libS ; ?></h3>
                                <button onclick="aff2('<?php echo 'div' . $id; ?>','<?php echo 'div2'.$id;?>',<?php echo $v->idDI;?>)" class="lire">Lire la suite&rArr;</button>
                                <div id="<?php echo 'div'.$id;?>" style="display: none; background-color: #f3f3f3; padding: 2% 5%; border-radius: 10px 10px; box-shadow: 4px 4px 6px gray; margin-bottom: 2%;">
                                    <?php echo '<br/><span style="font-weight: bold;">Équipement (marque-modèle) :</span> '.$v->libMarque.' - '.$v->libModele ;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Famille et sous famille : </span>'.$v->libF.' - '.$v->libSF  ;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Numéro de bureau : </span>'.$v->local ;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Service : </span>'.$v->libS ;?>
                                    <?php if($v->numArmoire != null) echo '<br/><span style="font-weight: bold;">Armoire : </span>'.$v->numArmoire;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Employé : </span>'.$v->empnom.' '.$v->empprenom ;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Signialé le : </span>'.$v->date ;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Panne signalé par l\'employé: </span>'.$v->note;?>
                                    <?php echo '<br/><span style="font-weight: bold;">Réparateur : </span>'.$v->nom.' '.$v->prenom ;?>
                                    <?php $obs=str_replace('\n',"<br/>",$v->observations); echo '<br/><span style="font-weight: bold;">observations du réparateur : </span>'.$obs ;?>
                                    <div id="<?php echo 'div2'.$id;?>"></div>
                                    <br/><br><br>
                                    <form action="<?php echo base_url();?>Res/avis_validation/<?php echo $v->idDI;?>" method="post">
                                        <div class="form-group" style="display: flex; flex-wrap: wrap;">
                                        <input type="submit" value="Continuer la réparation" id="positif" name="positif" class="form-control" style="width: 40%; margin-left: 6%; margin-right: 8%; font-weight: bold;">
                                        <input type="submit" value="Annuler la réparation" id="negatif" name="negatif" class="form-control" style="width: 40%; font-weight: bold;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            $id++;
                        }
                    } else { ?>
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
                            <h3>Aucunne demande d'intervention séléctionnée</h3>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }elseif ($this->uri->segment(2) == "di_rapport")
            { ?>
                <div class="container" id="all_r">
                    <?php
                    if ($di_r->num_rows() > 0)
                    {
                        $id = 1;
                        foreach ($di_r->result() as $r) {
                            ?>
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
                                <h4><?php echo "<span style='font-weight: bold;'>Maintenance N° $r->numMaint :</span> $r->libF - $r->libSF - $r->libMarque - $r->libModele ";  if ($r->etat == 4) echo "<span class='new' style='font-weight: bold; '>&nbsp;&nbsp;&nbsp; NEW</span>";?></h4>
                                <h5><?php echo "N° Série du matériel : $r->numSerie";?></h5>
                                <a href="<?php echo base_url();?>Res/affRapport/<?php echo $r->idDI; ?>" class="lire">Voir le Rapport&rArr;</a>
                            </div>
                            <?php
                            $id++;
                        }
                    }else
                    {
                        ?>
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
                            <h3>Aucunne Maintenance sélectionnés</h3>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
        }

	}
	?>



<script>

	function aff(id) {
		var elmt = document.getElementById(id);
		toggleDisplayOn(elmt);
	}
	function toggleDisplayOn(elmt)
	{
		if(typeof elmt == "string")
			elmt = document.getElementById(elmt);
		if(elmt.style.display == "none")
			elmt.style.display = "";
		else
			elmt.style.display = "none";
	}
	function hide(id) {
		var elmt = document.getElementById(id);
		toggleDisplayOff(elmt);
	}
	function toggleDisplayOff(elmt)
	{
		if(typeof elmt == "string")
			elmt = document.getElementById(elmt);
		if(elmt.style.display == "")
			elmt.style.display = "none";
		else
			elmt.style.display = "";
	}
</script>
<script>
    function aff2(id,id2,iddi) {
        var elmt = document.getElementById(id);
        toggleDisplayOn2(elmt,id,id2,iddi);
    }
    function toggleDisplayOn2(elmt,id,id2,iddi) {
        if (typeof elmt == "string")
            elmt = document.getElementById(elmt);
        if (elmt.style.display == "none"){
            elmt.style.display = "";
        $.ajax({
            url: "<?php echo base_url();?>Res/recupMat",
            method: "POST",
            data: {iddi: iddi},
            dataType: "json",
            success: function (data) {
                if (data.mat_sel =="")
                {
                    document.getElementById(id2).innerHTML += "<span style='font-weight: bold;'>Aucun matériel sélectionné</span>";
                }else
                {
                    document.getElementById(id2).innerHTML += "<span style='font-weight: bold;'>Les matériaux sélectionnés : <br/></span>";
                    document.getElementById(id2).innerHTML += data.mat_sel;
                }

            }
        });
    }
        else
            elmt.style.display = "none";
        document.getElementById(id2).innerHTML = "";
    }
    /*
	$(document).ready(function () {
		function load_unseen_notification(view = '') {
			$.ajax({
				url : "<?php echo base_url();?>Rep/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {
					if (data.unseen_notificationrep1 >0)
					{
						$('.badgerep1').html(data.unseen_notificationrep1);
					}
					if (data.unseen_notificationrep2 >0)
					{
						$('.badgerep2').html(data.unseen_notificationrep2);
					}
				}
			})
		}
		load_unseen_notification();
		$('#form_obser').on('submit',function (event) {
			event.preventDefault();
			if ($('#observations').val() != '')
			{
				var form_data = $(this).serialize();
				$.ajax({
					url : "<?php echo base_url();?>Rep/up/"+$('#hide_id').val(),
					method:"POST",
					data: form_data,
					success: function (data) {
						$('#form_obser')[0].reset();
						load_unseen_notification();
					}
				})
			}
			else
			{
				alert("both fields are required");
			}
		});*/
</script>
<script>
 /*  var elem = document.getElementById('new');
   setInterval(function (args) {
       elem.style.color= "white";
       elem.style.width = "25px";
   },500);
   setInterval(function (args) {
       elem.style.color= "#97310e";
       elem.style.width = "25px";
   },500);*/
</script>
