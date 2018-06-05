<?php
class AdminC extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $data['fonction'] = $this->get_menu();
        $data['title'] = "Admin";
        $this->load->view('admin', $data);
    }
    public function get_menu()
    {
        return array(
            'Ajouter employé' => array('<i class="fas fa-plus-circle fa-3x"></i>', 'AdminC/ajEmp'),
            'Modifier employé' => array('<i class="fas fa-edit fa-3x"></i>', 'AdminC/modifEmp'),
            'Bloquer employé' => array('<i class="fas fa-times fa-3x"></i>', 'AdminC/bloqEmp'),
            "Ajouter service" => array('<i class="fas fa-plus-circle fa-3x"></i>', 'AdminC/ajS'),
            'Modifier service' => array('<i class="fas fa-edit fa-3x"></i>', 'AdminC/modifS'),
            'Affecter équipement à un employé' => array('<i class="fas fa-desktop fa-3x"></i>', 'AdminC/Affecter'),
            'Consulter les équipement d\'un employé' => array('<i class="fas fa-desktop fa-3x"></i>', 'AdminC/cons'),
            "Éditer demande d'intervention" => array('<i class="fas fa- fa-3x"></i>', 'AdminC/edit_di','res2')
        );
    }
    public function base()
    {
        $this->load->view('header');
        $data['fonc'] = array(
            "Ajouter employé" => 'AdminC/ajEmp',
            "Modifier employé" => 'AdminC/modifEmp',
            "Bloquer employé" => 'AdminC/bloqEmp',
            "Ajouter service" => 'AdminC/ajS',
            "Modifier service" => 'AdminC/modifS',
            "Affecter équipement à un employé" => 'AdminC/Affecter',
            "Consulter équipement d'un employé" => 'AdminC/cons',
            "Éditer DI" => 'AdminC/edit_di'
        );
        $data['title'] = "Admin";
        $this->load->view('menu', $data);
    }
    public function edit_di()
    {
        $this->base();
        $this->load->model('Di_model');
        $query = $this->Di_model->matsf($this->session->userdata('mat'));
        $data['matsf'] = $query;
        $data['title'] = 'Admin';
        $this->load->view('ajDI' , $data);
    }
    public function DI_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("equip" , "Equipement" ,'required');
        $this->form_validation->set_rules("date" , "Date" ,'required|callback_check_date');
        $this->form_validation->set_rules("note" , "Note" ,'required');

        if($this->form_validation->run())
        {
            $this->load->model("Di_model");
            $data = array(
                'numSerie' =>$this->input->post("equip") ,
                'date' =>$this->input->post("date"),
                'note' =>$this->input->post("note"),
                'etat' => 0
            );

            if ($this->input->post("ajouter")){
                $this->Di_model->insert_data($data);

                redirect(base_url()."AdminC/Diajoutee");
            }

        }
        else
        {
            $this->edit_di();
        }

    }
    public function Diajoutee()
    {
        $this->edit_di();
    }
    public function check_date($dat)
    {
        $datec = new DateTime(date('y-m-d'));
        $datechar = new DateTime($dat);
        if ($datec > $datechar==false)
        {
            $this->form_validation->set_message('check_date','la date est invalide');
            return false;
        }else
        {
            return true;
        }
    }
    public function ajEmp()
    {
        $this->base();
        $this->load->model('Adm_model');
        $data['s'] = $this->Adm_model->selectS();
        $data['fon'] = $this->Adm_model->selectfon();
        $this->load->view('ajEmp',$data);
    }
    public function ajoutEmp()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("mat" , "Matricule" ,'required|is_numeric|is_unique[employe.mat]');
        $this->form_validation->set_rules("username" , "username" ,'required|is_unique[employe.username]');
        $this->form_validation->set_rules("password" , "password" ,'required|is_unique[employe.password]');
        $this->form_validation->set_rules("nom" , "nom" ,'required');
        $this->form_validation->set_rules("prenom" , "prenom" ,'required');
        $this->form_validation->set_rules("tel" , "téléphone" ,'required|is_numeric');
        $this->form_validation->set_rules("email" , "Email" ,'required');
        $this->form_validation->set_rules("dateNaiss" , "Date de naissance" ,'required');
        $this->form_validation->set_rules("dateRecrut" , "Date de recrutement" ,'required|callback_check_date');
        $this->form_validation->set_rules("adress" , "Adresse" ,'required');
        $this->form_validation->set_rules("fonction" , "fonction" ,'required');
        $this->form_validation->set_rules("idS" , "service" ,'required');

        if($this->form_validation->run())
        {
            $data = array(
                "mat" => $this->input->post("mat"),
                "nom" => $this->input->post("nom"),
                "prenom" => $this->input->post("prenom"),
                "dateNaiss" => $this->input->post("dateNaiss"),
                "adress" => $this->input->post("adress"),
                "tel" => $this->input->post("tel"),
                "email" => $this->input->post("email"),
                "dateRecrut" => $this->input->post("dateRecrut"),
                "fonction" => $this->input->post("fonction"),
                "idS" => $this->input->post("idS"),
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
            );
            if ($this->input->post("ajouter")){
                $this->load->model('Adm_model');
                $this->Adm_model->ajEmp($data);
                redirect(base_url()."AdminC/ajEmp/empajoute");
            }

        }
        else
        {
            $this->ajEmp();
        }
    }

    public function empajoute()
    {
        $this->ajEmp();
    }
    public function ajS()
    {
        $this->base();
        $this->load->view('ajEmp');
    }
    public function ajoutS()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("libS" , "Libéllé du service" ,'required');

        if ($this->form_validation->run())
        {
            $data['libS'] = $this->input->post('libS');
            if ($this->input->post('ajouter'))
            {
                $this->load->model("Adm_model");
                $this->Adm_model->insertS($data);
                redirect(base_url()."AdminC/ajS/ajoute");
            }
        }
        else
        {
            $this->ajS();
        }

    }

    public function modifEmp()
    {
        $this->base();
        $this->load->model("Adm_model");
        $data['emp'] = $this->Adm_model->selectEmp();
        $data['s'] = $this->Adm_model->selectS();
        $data['fon'] = $this->Adm_model->selectfon();
        $this->load->view("modifEmp",$data);
    }

    public function recupEmp_s()
    {
        $idS = $_POST['idS'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->selectEmp_s($idS);

            if ($query->num_rows() >0) {
                echo '<option value="">..........</option>';

                foreach ($query->result() as $v) {

                    echo "<option value='$v->mat'>$v->mat - $v->nom - $v->prenom</option>";

                }
            }else
            {
                echo '<option value="NULL">Aucun employé sélectionné</option>';
            }

    }
    public function returnInf()
    {
        $mat = $_POST['mat'];
        $this->load->model("Adm_model");
        $res = $this->Adm_model->returnEmp($mat);
        $s = $this->Adm_model->selectS();
        $fon = $this->Adm_model->selectfon();
        if ($fon->num_rows() > 0)
        { $id =0;
            foreach ($fon->result() as $v)
            {
               $fon1[$id] = "<option value='$v->fonction'>$v->fonction</option>";
               $id++;
            }
        }
        $data['form'] = "";
        if ($res->num_rows() > 0)
            {
            foreach ($res->result() as $v)
                {
                $data['form'] = " <form action=\"<?php echo base_url();?>/\" method=\"post\" id=\"modif\" 
 style='margin-top: 1%;'>
            <div class=\"form-group\">
                <input type=\"hidden\" id=\"mat\" name=\"mat\" value='$v->mat' class=\"form-control\">
            </div>
<div class=\"form-group\">
    <label for=\"\">Nom</label>
    <input type=\"text\" id=\"nom\" name=\"nom\" class=\"form-control\" value='$v->nom'>
</div>
<span class=\"text-danger\"><?php echo form_error(\"nom\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Prénom</label>
    <input type=\"text\" id=\"prenom\" name=\"prenom\" value='$v->prenom' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"prenom\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Date Naissance</label>
    <input type=\"date\" id=\"dateNaiss\" name=\"dateNaiss\" value='$v->dateNaiss' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"dateNaiss\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Adresse</label>
    <input type=\"text\" id=\"adress\" name=\"adress\" value='$v->adress' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"adress\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Télephone</label>
    <input type=\"tel\" id=\"tel\" name=\"tel\" value='$v->tel' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"tel\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Email</label>
    <input type=\"email\" id=\"email\" name=\"email\" value='$v->email' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"email\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Date recrutement</label>
    <input type=\"date\" id=\"dateRecrut\" name=\"dateRecrut\" value='$v->dateRecrut' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"dateRecrut\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Username</label>
    <input type=\"text\" id=\"username\" name=\"username\" value='$v->username' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"username\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Password</label>
    <input type=\"password\" id=\"password\" name=\"password\" value='$v->password' class=\"form-control\">
</div>
<span class=\"text-danger\"><?php echo form_error(\"password\"); ?></span>
<div class=\"form-group\">
    <label for=\"\">Affecter au service</label>
    <select name=\"idS\" id=\"idS\" class=\"form-control\">
    <option value='$v->idS'>$v->libS</option> ";
        if ($s->num_rows() > 0)
        {
            foreach ($s->result() as $q)
            {
                if ($v->idS != $q->idS)
                $data['form'] .= "<option value='$q->idS'>$q->libS</option>";
            }

           
        }
        $data['form'] .= "
    </select>
</div>
<span class=\"text-danger\"><?php echo form_error(\"idS\"); ?></span>
<div class=\"form - group\">
    <label for=\"\">Fonction</label>
    <select name=\"fonction\" id=\"fonction\" class=\"form-control\">
    <option value = '$v->fonction' > $v->fonction</option>  ";
        if ($fon->num_rows() > 0)
        {
            //$data['form'] += \"<option value ='$v->fonction'>$v->fonction</option >\";
           foreach($fon->result() as $r)
           {
               if ($r->fonction != $v-> fonction)
               $data['form'] .= " <option value = '$r->fonction' > $r->fonction</option>";
           }
        }
        $data['form'] .=   " ?>
    </select>
</div>
<span class=\"text - danger\"><?php echo form_error(\"fonction\"); ?></span> <br/>
<div class=\"form-group\">
    <input type=\"submit\" id=\"modifier\" name=\"modifer\" value=\"Modifier\" class=\"form-control\">
</div>
</form>";
                }

            }
            echo $data['form'];

    }

    public function updateE()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("username" , "username" ,'required');
        $this->form_validation->set_rules("password" , "password" ,'required');
        $this->form_validation->set_rules("nom" , "nom" ,'required');
        $this->form_validation->set_rules("prenom" , "prenom" ,'required');
        $this->form_validation->set_rules("tel" , "téléphone" ,'required|is_numeric');
        $this->form_validation->set_rules("email" , "Email" ,'required');
        $this->form_validation->set_rules("dateNaiss" , "Date de naissance" ,'required');
        $this->form_validation->set_rules("dateRecrut" , "Date de recrutement" ,'required|callback_check_date');
        $this->form_validation->set_rules("adress" , "Adresse" ,'required');
        $this->form_validation->set_rules("fonction" , "fonction" ,'required');
        $this->form_validation->set_rules("idS" , "service" ,'required');

        if($this->form_validation->run())
        {
            $data = array(
                "nom" => $this->input->post("nom"),
                "prenom" => $this->input->post("prenom"),
                "dateNaiss" => $this->input->post("dateNaiss"),
                "adress" => $this->input->post("adress"),
                "tel" => $this->input->post("tel"),
                "email" => $this->input->post("email"),
                "dateRecrut" => $this->input->post("dateRecrut"),
                "fonction" => $this->input->post("fonction"),
                "idS" => $this->input->post("idS"),
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
            );
            $mat = $this->input->post('mat');
                $this->load->model('Adm_model');
                $this->Adm_model->updateE($mat,$data);
               echo "Employé modifié";

    }
    else
    {
        echo "erreur";
    }
    }

    public function modifS()
    {
        $this->base();
        $this->load->model("Adm_model");
        $data['s'] = $this->Adm_model->selectS();
        $this->load->view("modifEmp",$data);
    }

    public function recup_s()
    {
        $idS = $_POST['idS2'];
        $this->load->model('Adm_model');
        $res = $this->Adm_model->recupS($idS);
        $form ="";
        if ($res->num_rows() > 0)
        {
            foreach ($res->result() as $v)
            {
                $form = " <form action=\"\" id=\"modifS\">
        <div class=\"form-group\">
            <input type=\"hidden\" value=\"$v->idS\" name=\"idS2\">
        </div>
        <div class=\"form-group\">
            <label for=\"\">Nouveau libéllé de service</label>
            <input type=\"text\" value=\"$v->libS\" name=\"libS2\" class=\"form-control\" required>
        </div>
        <div class=\"form-group\">
    <input type=\"submit\" id=\"modifier\" name=\"modifer\" value=\"Modifier\" class=\"form-control\">
</div>
    </form>";
            }
        }
        echo $form;
    }
    public function updateS()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("libS2" , "Libéllé du service" ,'required');

        if ($this->form_validation->run())
        {
            $data['libS'] = $this->input->post('libS2');
        $idS = $this->input->post('idS2');
                $this->load->model("Adm_model");
                $this->Adm_model->updateS($idS,$data);
               echo "Service modifié";
        }
        else
        {
            echo "erreur";
        }

    }

    public function Affecter()
    {
        $this->base();
        $this->load->model('Adm_model');
        $data['s'] = $this->Adm_model->selectS();
        $data['f'] = $this->Adm_model->selectF();
        $this->load->view('affEquipEmp',$data);
    }
    public function recupsf()
    {
        $idF = $_POST['idF'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->selectsf($idF);

        if ($query->num_rows() >0) {
            echo '<option value="">..........</option>';

            foreach ($query->result() as $v) {

                echo "<option value='$v->idSF'>$v->libSF</option>";

            }
        }else
        {
            echo '<option value="NULL">Aucune sous famille sélectionnée</option>';
        }

    }

    public function recupMarque()
    {
        $idSF = $_POST['idSF'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->selectMarq($idSF);

        if ($query->num_rows() >0) {
            echo '<option value="">..........</option>';

            foreach ($query->result() as $v) {

                echo "<option value='$v->idMarque'>$v->libMarque</option>";

            }
        }else
        {
            echo '<option value="NULL">Aucune Marque sélectionnée</option>';
        }
    }
    public function recupModele()
    {
        $idSF = $_POST['idSF'];
        $idMarque = $_POST['idMarque'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->selectModele($idSF,$idMarque);

        if ($query->num_rows() >0) {
            echo '<option value="">..........</option>';

            foreach ($query->result() as $v) {

                echo "<option value='$v->idModele'>$v->libModele</option>";

            }
        }else
        {
            echo '<option value="NULL">Aucun modele sélectionné</option>';
        }
    }
    public function recupEquip()
    {
        $idModele = $_POST['idModele'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->selectEquip($idModele);

        if ($query->num_rows() >0) {
            echo '<option value="">..........</option>';

            foreach ($query->result() as $v) {

                echo "<option value='$v->numSerie'>$v->numSerie - $v->libF - $v->libSF - $v->libMarque - $v->libModele</option>";

            }
        }else
        {
            echo '<option value="NULL">Aucun Equipement sélectionné</option>';
        }
    }

    public function remplirTab()
    {
        $numSerie = $_POST['numSerie'];
        $this->load->model("Adm_model");
        $query = $this->Adm_model->remptab($numSerie);
        if ($query->num_rows() >0) {
            foreach ($query->result() as $v) {

                echo "<tr>
<td>$v->libF</td>
<td>$v->libSF</td>
<td>$v->libMarque</td>
<td>$v->libModele</td>
<td>$v->numSerie<input type='hidden' value='$v->numSerie' name='n[]' id='n'></td>
</tr>";

            }
        }
    }

    public function affec()
    {
        $tab = $this->input->post('n[]');
        $mat = $this->input->post('mat');
       if ($mat == '')
       {
           $data['er'] = "emp";
       }else
       {
           if ($tab[0] == null)
           {
               $data['er'] = 'erreur';
           }
           else
           {
               $this->load->model('Adm_model');
               $res = $this->Adm_model->selectE($mat);
               if ($res->num_rows() > 0)
               {
                   foreach ($res->result() as $v)
                   {
                       foreach ($tab as $num)
                       {
                           $data['local'] = $v->loc;
                           $data['mat'] = $mat;
                           $this->Adm_model->updateMat($num,$data);
                       }
                   }
               }
           }
       }
        echo json_encode($data);
    }
    /**********/
    public function bloqEmp()
    {
        $this->base();
        $this->load->model('Adm_model');
        $data['s']=$this->Adm_model->selectS();
        $this->load->view('bloqEmp',$data);
    }
    public function bloquer()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("emp" , "Employé" ,'required');
        $this->load->model("Adm_model");
        $emp=$this->input->post("emp");
        if($this->form_validation->run())
        {
            $data['actif'] = 0;
            $this->Adm_model->updateE($emp,$data);
            redirect(base_url()."AdminC/bloqEmp/bloque");
        }
        else
        {
            $this->bloqEmp();
        }
    }
    /*********/
    public function cons()
    {
        $this->base();
        $this->load->model('Adm_model');
        $data['s']=$this->Adm_model->selectS();
        $this->load->view('consE',$data);
    }

    public function recupMat_e()
    {
        $mat = $_POST['mat'];
        $this->load->model('Adm_model');
        $res = $this->Adm_model->SelectMat_e($mat);
        if ($res->num_rows() > 0)
        {
            $t = "<tr>
<th>Famille</th>
<th>Sous famille</th>
<th>Marque</th>
<th>Modèle</th>
<th>Numéro de série</th>
</tr>";
            foreach ($res->result() as $r)
            {
                $t .= "<tr>
<td>$r->libF</td>
<td>$r->libSF</td>
<td>$r->libMarque</td>
<td>$r->libModele</td>
<td>$r->numSerie</td>
<td><a href='".base_url()."AdminC/edit/$r->numSerie'>Edit</a></td>
</tr>";
            }
        }
        else
        {
            $t = "<div class='alert alert-danger'>Aucun matériau est affecté à cet employé</div>";
        }
        echo $t;
    }

    public function edit()
    {
        $this->load->view('edit');
    }

}
?>