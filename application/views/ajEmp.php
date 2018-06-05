<?php
if ( $this->uri->segment(2) =="ajEmp" || $this->uri->segment(2) == "ajoutEmp")
{     ?>
    <div class="container" style="margin-top: -32%; margin-left: 30%; width: 50%;">
        <?php
        if ($this->uri->segment(3) =="empajoute")
        {
            echo "<div class='alert alert-success' style='font-weight: bold;'>Employé ajouté avec succés</div>";
        }
        ?>
        <h3 align="center">Ajouter Employé</h3>
        <form action="<?php echo base_url();?>AdminC/ajoutEmp" method="post" id="ajE">
            <div class="form-group">
                <label for="">Matricule</label>
                <input type="text" id="mat" name="mat" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("mat"); ?></span>
            <div class="form-group">
                <label for="">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("nom"); ?></span>
            <div class="form-group">
                <label for="">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("prenom"); ?></span>
            <div class="form-group">
                <label for="">Date Naissance</label>
                <input type="date" id="dateNaiss" name="dateNaiss" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("dateNaiss"); ?></span>
            <div class="form-group">
                <label for="">Adresse</label>
                <input type="text" id="adress" name="adress" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("adress"); ?></span>
            <div class="form-group">
                <label for="">Télephone</label>
                <input type="tel" id="tel" name="tel" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("tel"); ?></span>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("email"); ?></span>
            <div class="form-group">
                <label for="">Date recrutement</label>
                <input type="date" id="dateRecrut" name="dateRecrut" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("dateRecrut"); ?></span>
            <div class="form-group">
                <label for="">Fonction</label>
                <select name="fonction" id="fonction" class="form-control">
                    <?php
                    if ($fon->num_rows() > 0)
                    {
                        echo "<option value=''>Select Fonction</option>";
                        foreach ($fon->result() as $v)
                        {
                            echo "<option value='$v->fonction'>$v->fonction</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <span class="text-danger"><?php echo form_error("fonction"); ?></span>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" id="username" name="username" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("username"); ?></span>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("password"); ?></span>
            <div class="form-group">
                <label for="">Affecter au service</label>
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
                    ?>
                </select>
            </div>
            <span class="text-danger"><?php echo form_error("idS"); ?></span>
            <div class="form-group">
                <input type="submit" id="ajouter" name="ajouter" value="Ajouter" class="form-control">
            </div>
        </form>
    </div>
<?php }
elseif ($this->uri->segment(2) == "ajS" || $this->uri->segment(2) == "ajoutS")
{ ?>
    <div class="container" style="margin-top: -22%; margin-left: 30%; width: 50%;">
        <?php
        if ($this->uri->segment(3) == "ajoute")
            echo "<div class='alert alert-success' style='font-weight: bold;'>Service ajouté avec succés</div>";
        ?>
        <h3 align="center">Ajouter Service</h3>
        <form action="<?php echo base_url(); ?>AdminC/ajoutS" method="post">
            <div class="form-group">
                <label for="">Libellé  du service</label>
                <input type="text" id="libS" name="libS" class="form-control">
            </div>
            <span class="text-danger"><?php echo form_error("libS"); ?></span>
            <div class="form-group">
                <input type="submit" id="ajouter" name="ajouter" value="Ajouter" class="form-control">
            </div>
        </form>
    </div>
<?php }
?>
