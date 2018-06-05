<?php
if ($this->uri->segment(2) == 'all_maint') $style = 'style="margin-top : -24%;"';
?>
<div class="container" id="all_r" <?php if (isset($style)) echo $style;?>>
	<?php
	if($di->num_rows() >0) {
		$id = 1;
		foreach ($di->result() as $v) {
			?>
			<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep" >
				<h3><?php echo $v->libSF.' - '.$v->libMarque.' - '.$v->libModele.' - '.$v->libS ; ?></h3>
                <?php
                if ($v->etat == 8)
                    echo "<h5 style='color: #97310e;'>Matériaux demandés pour la réparation non prêt.<i class='fas fa-times fa-1x'></i></h5>";
                elseif ($v->etat == 9)
                    echo "<h5 style='color: #3c763d;'>Matériaux demandés prêt.<i class='fas fa-check fa-1x'></i> Récupérez les au niveau de stock.</h5>";
                elseif ($v->etat == 50 || $v->etat == 70)
                    echo "<h5 style='color: #97310e;'>Aucun matériel de même modèle est disponible.<i class='fas fa-times fa-1x'></i></h5>";
                elseif ($v->etat == 51 || $v->etat == 71)
                    echo "<h5 style='color: #3c763d;'>Matériaux de même modèle disponible en stock.<i class='fas fa-check fa-1x'></i></h5>";
                ?>
				<a href="<?php echo base_url();?>Res/suite_di/<?php echo $v->idDI;?>/<?php echo $v->etat;?>"  class="lire">Lire la suite&rArr;</a>
			</div>
			<?php
			$id++;
		}
	}
	else
	{ ?>
		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 all_rep">
			<h3>Aucun demande d'intervention reçu</h3>
		</div>
		<?php
	}
	?>
</div>



