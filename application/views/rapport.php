<div class="container" id="rapport1">
    <button class="return"><i class="fas fa-arrow-left"></i></button>
    <div class="container-fluid" id="rapport">
        <h2 align="center" style="font-weight: bold;">Rapport de fin de maintenance</h2> <br/>
<h4 style="font-weight: bold;">Maintenance N° : <?php echo $numMaint;?></h4>
       <h4 style="font-weight: bold;">Réparateur : </h4>
        <div style="margin-left: 10%;">
            <h5><span style="font-weight: bold;">Nom et Prénom : </span><?php echo $repname.' '.$repprenom; ?> </h5>
            <h5><span style="font-weight: bold;">N° Tel : </span><?php echo $repTel; ?> </h5>
            <h5><span style="font-weight: bold;">Email : </span><?php echo $repEmail; ?> </h5>
        </div>
        <h4 style="font-weight: bold;">Concerne :</h4>
        <div style="margin-left: 10%;">
            <h5><span style="font-weight: bold;">Demande d'intervention N° : </span><?php echo $idDI; ?> </h5>
            <div style="margin-left: 60%">
            <h5><span style="font-weight: bold;">Employé : </span><?php echo $empname.' '.$empprenom; ?> </h5>
            <div style="margin-left: 10%;">
                <h5><span style="font-weight: bold;">Bureau : </span><?php echo $local; ?> </h5>
                <h5><span style="font-weight: bold;">Service : </span><?php echo $s; ?> </h5>
            </div>
            </div>
            <div style="margin-top: -11%">
            <h5><span style="font-weight: bold;">Equipement N° : </span><?php echo $numSerie; ?> </h5>
            <div style="margin-left: 10%;">
                <h5><span style="font-weight: bold;"> </span><?php echo $f.' - '.$sf; ?> </h5>
                <h5><span style="font-weight: bold;">Marque et Modele : </span><?php echo $marq.' - '.$modele; ?> </h5>
            </div>
            </div><br/>
            <h5 style="font-weight: bold;">Panne signalé par l'employé :</h5>
            <?php echo $note;?> <br/>
            <span style="font-weight: bold;">Le : </span><?php echo $dateP;?> <br/>
        </div>
        <h4 style="font-weight: bold;">Les observations du réparateur :</h4>
        <?php $obs=str_replace('\n',"<br/>",$observ); echo $obs;?>
        <h4 style="font-weight: bold;">Matériaux ou pièces de rachange utilisés</h4>
        <?php
        if ($matutil->num_rows() > 0)
        {
            foreach ($matutil->result() as $v)
            {
                echo "<span>N° $v->numSerie : $v->libF - $v->libSF - $v->libMarque - $v->libModele </span><br/>";
            }
        }
        else
        {
            echo "<span>Aucun Matériau utilisé</span><br/>";
        }
        ?>
        <h4 style="font-weight: bold;">Réparation :</h4>
        <div style="margin-left: 10%;">
            <h5><span style="font-weight: bold;">Date début de la maintenance : </span><?php echo $dateD; ?> </h5>
            <h5><span style="font-weight: bold;">Date fin de la maintenance : </span><?php echo $dateF; ?> </h5>
            <h5><span style="font-weight: bold;">Coût de la maintenance : </span><?php echo $cout; ?> </h5>
        </div>
        <br/><br/>
        <span style="margin-left: 75%;"><span style="font-weight: bold;">Date : </span><?php echo date("y-m-d"); ?></span>
        <br/><br/>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('.return').click(function (){
            window.location = "<?php echo base_url();?>Res/di_rapport";
        });
    });
    </script>