<?php
if ($this->uri->segment(2) == "demMat")
{?>
    <div class="container" id="demMat">
        <?php
        if ($rep->num_rows() > 0)
        {
            $id = 1;
            foreach ($rep->result() as $r)
            {  ?>
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 stock_min">
                    <h4><badge class="badge" ><?php echo $r->nb;?></badge>&nbsp; <span style="font-weight: bold;"> Réparateur : &nbsp;</span><?php echo $r->nom.' '.$r->prenom;?></h4>
                    <button onclick="aff3('all<?php echo $id; ?>',<?php echo $r->numRep;?>)" class="lire">Voir les matériaux demandés&rArr;</button>
                   <div id="all<?php echo $id; ?>" style="display: none; margin-top: 6%;">

                   </div>
                </div>
            <?php $id++; }
        }
        else
        { ?>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 stock_min">
                <h3>Aucunne Demande de matériaux sélectionnées</h3>
            </div>
        <?php }
        ?>

    </div>
<?php }
elseif ($this->uri->segment(2) == "affNEC")
{?>
    <div class="container" id="all_r" style="margin-top: -25%;">
        <h3>Matériaux prêts ! Récupérez les au niveau du stock.</h3>
            <?php
            if ($res1->num_rows() > 0)
            {
                foreach ($res1->result() as $r1) {
                    echo "<div class=\" col-lg-12 col-md-12 col-sm-12 col-xs-12 stock_min\">";
                    if ($res2->num_rows() > 0)
                    {
                        foreach ($res2->result() as $r2)
                        {
                            if ($r1->idDI == $r2->idDI)
                            echo "<span style='color: #3c763d;'>$r2->libF - $r2->libSF - $r2->libMarque - $r2->libModele  <i class='fas fa-check fa-1x'></i></span><br/>";
                        }
                    }
                    echo "</div>";

                }
            }
            if ($res3->num_rows() > 0)
            {
                foreach ($res3->result() as $r3)
                {
                    echo "$r3->numSerie - $r3->libF - $r3->libSF - $r3->libMarque - $r3->libModele <br/>
<span style='color: #97310e;'> a été remplacé par :</span><span style='color: #3c763d;'> $r3->num2 - $r3->libF2 - $r3->libsf2 - $r3->libMar2 - $r3->libMod2 <i class='fas fa-check fa-1x'></i></span><br/>";
                }
            }
            if ($res3->num_rows() <= 0 && $res1->num_rows() <= 0)
            {
                echo "<h4 style='color: #97310e;'>Aucun matériau prêt.</h4>";
            }
            ?>
    </div>
<?php }
else
{?>
    <div class="container" id="stockM">
        <?php
        if ($matst->num_rows() > 0)
        {
            foreach ($matst->result() as $m)
            { ?>
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 stock_min">
                    <h3><?php echo "$m->libF - $m->libSF - $m->libMarque - $m->libModele";?></h3>
                    <h4><?php
                        if ($m->qteS == 0) echo "<span class='new' >La quantité en Stock est $m->qteS </span> - seuil du stock minimal : $m->seuil";
                        else echo "La quantité en Stock est <span style='color: #97310e;'>$m->qteS </span>- seuil du stock minimal : $m->seuil";
                        ?></h4>
                    <a href="<?php echo base_url();?>Da/editDa2/<?php echo $m->idModele;?>" class="lire">Éditer une demande d'achat de ce matériel</a>
                </div>
            <?php }
        }
        ?>
    </div>
<?php }
?>

<script>
    function aff3(id,numr) {
        var elmt = document.getElementById(id);
        toggleDisplayOn3(elmt,id,numr);
    }
    function toggleDisplayOn3(elmt,id,numr) {
        if (typeof elmt == "string")
            elmt = document.getElementById(elmt);
        if (elmt.style.display == "none"){
            elmt.style.display = "";
            $.ajax({
                type : "POST",
                url: "<?php echo base_url();?>Ges/demMat3",
                data: {numr:numr},
                success: function (data) {
                    document.getElementById(id).innerHTML = data;
                    }
            });
        }
        else {
            elmt.style.display = "none";
        }
    }
</script>