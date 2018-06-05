<?php
if ($this->uri->segment(4) == 3 || $this->uri->segment(4) == 6 || $this->uri->segment(4) == 8 || $this->uri->segment(4) == 9)
{
    $style = 'style = "margin-top: -25%;"';
}
?>
<div class="container" id="aff" <?php if (isset($style)) echo $style;?>>
	<button class="return"><i class="fas fa-arrow-left"></i></button>
	<?php
	if($di_sp->num_rows() >0) {
		foreach ($di_sp->result() as $v) {
			$id = $v->idDI;
			?>
			<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 tt_inf" style="font-size: 1.5em;" >
				<h3><?php echo $v->libSF.' - '.$v->libMarque.' - '.$v->libModele.' - '.$v->libS ; ?></h3>
					<?php echo '<br/><span style="font-weight: bold;">Équipement (marque_modèle) :</span> '.$v->libMarque.' - '.$v->libModele ;?>
					<?php echo '<br/><span style="font-weight: bold;">Famille et sous famille : </span>'.$v->libF.' - '.$v->libSF  ;?>
					<?php echo '<br/><span style="font-weight: bold;">Numéro de bureau : </span>'.$v->local ;?>
					<?php echo '<br/><span style="font-weight: bold;">Service : </span>'.$v->libS ;?>
					<?php if($v->numArmoire != null) echo '<br/><span style="font-weight: bold;">Armoire : </span>'.$v->numArmoire;?>
					<?php echo '<br/><span style="font-weight: bold;">Employé : </span>'.$v->nom.' '.$v->prenom ;?>
					<?php echo '<br/><span style="font-weight: bold;">Signialé le : </span>'.$v->date ;?>
					<?php echo '<br/><span style="font-weight: bold;">Panne : </span>'.$v->note;?>
				<?php if(isset($v->repnom) && isset($v->repprenom)) echo '<br/><span style="font-weight: bold;">Réparateur : </span>'.$v->repnom.' '.$v->repprenom;?>
				<?php if($v->observations != null){ $obs = str_replace('\n',"<br/>",$v->observations); echo '<br/><span style="font-weight: bold;">Observations du réparateur : </span>'.$obs; }?>
					<br/>
                <?php
                if (isset($matNec))
                {
                    if ($matNec->num_rows() > 0)
                    {
                        echo "<span style='font-weight: bold;'>Matériaux nécessaires au réparation :</span>";
                     foreach ($matNec->result() as $m)
                     {
                         echo "<br/><span style=''>$m->libF - $m->libSF - $m->libMarque - $m->libModele </span>";
                     }
                    }
                }
                if (isset($matuti))
                {
                    if ($matuti->num_rows() > 0)
                    {
                        echo "<span style='font-weight: bold;'>Matériaux nécessaires au réparation :</span>";
                        foreach ($matuti->result() as $u)
                        {
                            echo "<br/><span style=''>$u->libF - $u->libSF - $u->libMarque - $u->libModele </span>";
                        }
                    }
                }
                if ( (( !isset($matNec) && !isset($matuti) ) || ($matNec->num_rows() <= 0 && $matuti->num_rows() <= 0) ) && $this->uri->segment(4) != 0 )
                {
                    echo "<span style='font-weight: bold;'>Aucun Matériaux nécessaires au réparation</span>";
                }
                ?>
			</div>
			<?php
		}
	}
	else
	{ ?>
		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
			<h3>Aucun demande d'intervention reçu</h3>
		</div>
		<?php
	}

		if ($this->uri->segment(4) == 50 || $this->uri->segment(4) == 70)
		{?>
            <h4 style="color: #97310e;">Aucun Matériel de même modèle est disponible en stock. <i class="fas fa-times fa-1x"></i></h4>
			<form action="" method="post">
				<div class="form-group">
					<input type="hidden" value="<?php echo $this->uri->segment(3);?>" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" class="form-control" value="Changer l'équipement" disabled>
				</div>
			</form>
			<?php }
            elseif($this->uri->segment(4) == 51 || $this->uri->segment(4) == 71) { ?>
                <h4 style="color: #3c763d;">Matériaux de même modèle sont disponible en stock.<i class="fas fa-check fa-1x"></i></h4>
                <form action="<?php echo base_url();?>Res/changer" method="post">
                    <div class="form-group">
                        <input type="hidden" name="idDI" value="<?php echo $this->uri->segment(3);?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control" value="Changer l'équipement">
                    </div>
                </form>
        <?php }
		else {
	    if ($this->uri->segment(4) == 3)
        {?>
            <form action="<?php echo base_url();?>Rep/commencer" method="post" id="comMaint">
                <div class="form-group">
                    <input type="hidden" name="idDI" value="<?php echo $v->idDI;?>" id="idd" class="form-control">
                </div>
                <div class="form-group">
                    <input type="hidden" name="etat" value="<?php echo $v->etat;?>" id="etat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Saisissez la date de début de la maintenance :</label>
                    <input type="datetime-local" class="form-control" name="dateD" id="dateD">
                </div>
                <?php
                if ($this->uri->segment(5) == "err") echo "<span class=\"text-danger\">Date invalide.</span>";
                ?>
                <div class="form-group">
                    <input type="submit" class="form-control" value="Enregister" name="enregister" id="enregister">
                </div>
            </form>
            <div class="erreur2"></div>
    <?php
        }elseif ($this->uri->segment(4) == 6)
        { ?>
            <form action="<?php echo base_url();?>Rep/finMaint" method="post" id="comMaint">
                <div class="form-group">
                    <input type="hidden" name="idDI" value="<?php echo $v->idDI;?>" id="idd" class="form-control">
                </div>
                <div class="form-group">
                    <input type="hidden" name="etat" value="<?php echo $v->etat;?>" id="etat" class="form-control">
                </div>
                <div class="form-group">
                    <input type="hidden" id="main" value="main" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Saissisez la date de fin de la maintenance :</label>
                    <input type="datetime-local" name="dateF" id="dateF" class="form-control">
                </div>
                <?php
                if ($this->uri->segment(5) == "err") echo "<span class=\"text-danger\">Date invalide.</span>";
                ?>
                <div class="form-group">
                    <input type="submit" class="form-control" value="Fin de la maintenance" id="fin">
                </div>
            </form>
            <form method="post" action="<?php echo base_url();?>Rep/annulMaint">
                <div class="form-group">
                    <input type="hidden" name="idDI" value="<?php echo $v->idDI;?>" id="idd" class="form-control">
                </div>
                <div class="form-group">
                    <input type="hidden" name="etat" value="<?php echo $v->etat;?>" id="etat" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control" value="Le matériel n'est plus réparable? Annuler la maintenance" id="ann">
                </div>
            </form>
            <div class="erreur2"></div>
    <?php
            }elseif ($this->uri->segment(4) == 8)
        {
            echo "<span style='color: #3c763d; font-weight: bold;'>&nbsp;&nbsp;La réparation a été validé par le responsable.<i class='fas fa-check fa-1x'></i></span><br/><span style='color: #97310e; font-weight: bold;'>Les Matériaux demandés ne sont pas prêt. <i class='fas fa-times fa-1x'></i></span>";
        }elseif ($this->uri->segment(4) == 9)
        {
            echo "<span style='color: #3c763d; font-weight: bold;'>&nbsp;&nbsp;Les matériaux demandés Prêts.<i class='fas fa-check fa-1x'></i></span><span style='color: #97310e; font-weight: bold;'>et non récupérés.<i class='fas fa-times fa-1x'></i></span>";
        }else
        {?>
            <form action="<?php echo base_url(); ?>Res/affec_validation/<?php echo $id; ?>" method="post">
                <h3>Affecter à</h3>
                <div class="form-group">
                    <select name="rep" id="rep" class="form-control" required>
                        <?php
                        if ($reparat->num_rows() > 0) { ?>
                            <option value="">Sélectionner un réparateur</option>
                            <?php
                            foreach ($reparat->result() as $v) {
                                ?>
                                <option
                                        value="<?php echo $v->numRep; ?>"><?php echo $v->numRep . ' - ' . $v->nom . ' ' . $v->prenom; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">no row selected</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="info tt_inf"></div>
                <div class="form-group">
                    <input type="submit" name="affecter" value="Affecter" class="form-control">
                </div>

            </form>
        <?php }

		}
	?>
</div>
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
			{if ($this->uri->segment(4) == 3 || $this->uri->segment(4) == 6 || $this->uri->segment(4) == 8 || $this->uri->segment(4) == 9 )
            {
            ?>
            window.location = "<?php echo base_url();?>Rep/all_maint";
            <?php
            }
            else
            {
            ?>
            window.location = "<?php echo base_url();?>Res/di_recu";
            <?php
            }
			}
			?>

		});
	});
	$(document).ready(function (){
		$('.info').hide();
		$('#rep').on('change',function (){
			var numrep= $(this).val();
			if (numrep){
				$.ajax({
					type:'POST',
					url: '<?php echo base_url();?>Res/info_rep/'+numrep,
					data: 'numRep ='+numrep,
					dataType: "json",
					success: function (data) {
						/*$('.dropdown-menu').html(data.notification);*/
							$('.info').html(data.inf);
						    $('.info').show();
					}
				});
			}else {
				/*$('#idSF').html('<option value="">Select Famille first</option>');
				$('#numSerie').html('<option value="">Select sous Famille first</option>');*/
			}
		});
	});
</script>
<script type="text/javascript">
 /*   $(document).ready(function () {
        $(document).on('submit','#comMaint',function (event) {
            event.preventDefault();
            var idd = $('#idd').val();
            var etat = $('#etat').val();
            $.ajax({
                url: "<?php echo base_url();?>Rep/commencer/"+idd+'/'+etat,
                cache : false,
                success: function (html) {
                    afficher(html);
                }
            });
            return false;
        });
    });
    $(document).ready(function () {
        var num = $('#main').val();
        var idd = $('#idd').val();
        var etat = $('#etat').val();
        if (num)
        {
            $.ajax({
                url: "<?php echo base_url();?>Rep/continuer/"+idd+'/'+etat,
                cache : false,
                success: function (html) {
                    afficher(html);
                }
            });
            return false;
        }
        });
    function afficher(data) {
        $('#ttinf').slideUp(200,function () {
            $('#ttinf').empty();
            $('#ttinf').append(data);
            $('#ttinf').slideDown(200);
        })
    } */
</script>

