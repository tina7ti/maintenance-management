<?php
class Da extends CI_Controller
{
    public function index()
	{
	    if (isset($idDI) && ! empty($idDI))
        {
            $this->load->model('Res_model');
            $data['matAacheter'] = $this->Res_model->selectNMT($idDI);
        }
		$this->load->view('header');
        $data['fonc'] = array(
            "Ajouter Matériel" => "Ges/ajout",
            "Modifier Matériel" => "Ges/modif",
            "Supprimer Matériel" => "Ges/supp",
            'Matériaux demandés lors d\'une réparation '=> array('ges2','Ges/demMat'),
            'Matériaux en stock minimal' => array('ges1','Ges/stockM'),
            "Ajouter Demande d'achat" => "Da/",
            "Ajouter Demande d'intervention" => "Ges/edit_di",
            'Modifier les classes d\'article' => 'Ges/modif_Class');
		$data['title'] = "Gestionnaire";
		$this->load->view('menu', $data);
		$this->load->model('mater_mod');
		$data['fam'] = $this->mater_mod->selectF();
		$this->load->view('demAchat',$data);
	}

    public function editDa()
    {
        $idDI = $this->uri->segment(3);
        $this->load->view('header');
        $data['fonc'] = array(
            "Ajouter Matériel" => "Ges/ajout",
            "Modifier Matériel" => "Ges/modif",
            "Supprimer Matériel" => "Ges/supp",
            'Matériaux demandés lors d\'une réparation '=> array('ges2','Ges/demMat'),
            'Matériaux en stock minimal' => array('ges1','Ges/stockM'),
            "Ajouter Demande d'achat" => "Da/",
            "Ajouter Demande d'intervention" => "Ges/edit_di",
            'Modifier les classes d\'article' => 'Ges/modif_Class');
        $data['title'] = "Gestionnaire";
        $this->load->view('menu', $data);
        $this->load->model('mater_mod');
        $mataach = $this->mater_mod->selectNMTqte($idDI);
        if ($mataach->num_rows() <= 0)
        {
            $mataach = $this->mater_mod->selectnondis_aacheter($idDI);
        }
      $data['matAacheter'] = $mataach;
        $data['fam'] = $this->mater_mod->selectF();
        $this->load->view('demAchat',$data);
	}
    public function editDa2()
    {
        $idmod = $this->uri->segment(3);
        $this->load->view('header');
        $data['fonc'] = array(
            "Ajouter Matériel" => "Ges/ajout",
            "Modifier Matériel" => "Ges/modif",
            "Supprimer Matériel" => "Ges/supp",
            'Matériaux demandés lors d\'une réparation '=> array('ges2','Ges/demMat'),
            'Matériaux en stock minimal' => array('ges1','Ges/stockM'),
            "Ajouter Demande d'achat" => "Da/",
            "Ajouter Demande d'intervention" => "Ges/edit_di",
            'Modifier les classes d\'article' => 'Ges/modif_Class');
        $data['title'] = "Gestionnaire";
        $this->load->view('menu', $data);
        $this->load->model('mater_mod');
        $data['matAacheter'] = $this->mater_mod->selectmAcheter($idmod);
        $data['fam'] = $this->mater_mod->selectF();
        $this->load->view('demAchat',$data);
    }
	public function fetch_sousF()
	{
		$this->load->model("mater_mod");
		$id=$this->input->post("idF");
		if (isset($id) && !empty($id))
		{
			$query = $this->mater_mod->selectSF($this->input->post("idF"));
			if ($query->num_rows() >0) {
                echo '<option value="">.........</option>';
				foreach ($query->result() as $v) {

					echo '<option value="'.$v->idSF.'">'.$v->libSF.'</option>';

				}
			}else
			{
				echo '<option value="">no row selected</option>';
			}
		}else
		{

		}

	}

    public function fetch_marque()
    {
        $this->load->model("mater_mod");
            $query = $this->mater_mod->selectMarque();
            if ($query->num_rows() >0) {
                echo '<option value="">.........</option>';
                foreach ($query->result() as $v) {

                    echo '<option value="'.$v->idMarque.'">'.$v->libMarque.'</option>';

                }
            }else
            {
                echo '<option value="">no row selected</option>';
            }
	}
	public function fetch_modele()
	{
		$this->load->model("mater_mod");
		$idmarq=$this->input->post("idMarque");
        $idsf=$this->input->post("idSF");
		if (isset($idsf) && !empty($idsf) && isset($idmarq) && !empty($idmarq))
		{
			$query = $this->mater_mod->fetch_mode_sfMarq($idsf,$idmarq);
			if ($query->num_rows() >0) {
				foreach ($query->result() as $v) {

					echo '<option value="'.$v->idModele.'">'.$v->libModele.'</option>';

				}
			}else
			{
				echo '<option value="">no row selected</option>';
			}
		}else
		{
            echo '<option value="">something wrong</option>';
		}

	}
    public function tab2()
    {
        $id = $this->uri->segment(3);
        $data['erreur'] = '';
        if (!isset($_POST['model']))
		{
            $this->load->model('Mater_mod');
            $result = $this->Mater_mod->selectLib($id);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $v) {
                    $data['pr'] = "<tr>
						<td><input type='text' name='mar[]' value='$v->libMarque' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='marq[]' value=\"$v->idMarque\"></td>
						<td><input type='text' name='mode[]' value='$v->libModele' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='model[]' value=\"$v->idModele\"></td>
						<td><input type='text' name='qte[]' class=\"form-control\" id='qte'>
						</td>
						<td><a href='#'>Delete</a></td>
						</tr>";
                }
            }
		}else {
            $model = $_POST['model'];
            if (in_array($id, $model)) {
                $data['erreur'] = "Ce Matériel est séléctionné déjà ";
            } else {
                $this->load->model('Mater_mod');
                $result = $this->Mater_mod->selectLib($id);
                if ($result->num_rows() > 0) {
                    foreach ($result->result() as $v) {
                        $data['pr'] = "<tr>
						<td><input type='text' name='mar[]' value='$v->libMarque' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='marq[]' value=\"$v->idMarque\"></td>
						<td><input type='text' name='mode[]' value='$v->libModele' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='model[]' value=\"$v->idModele\"></td>
						<td><input type='text' name='qte[]' class=\"form-control\" id='qte'>
						</td>
						<td><a href='#'>Delete</a></td>
						</tr>";
                    }
                }
            }
        }
        echo json_encode($data);
    }
	public function da_validation()
	{
        $data['er'] = '';
        $this->load->model('DemA');
        if (isset($_POST['model'])) {
            $qte = $_POST['qte'];
            $marq = $_POST['marq'];
            $model = $_POST['model'];
            $i = 0;
            foreach ($model as $v) {
                if (empty($qte[$i])) {
                	$result= $this->DemA->sel_lib_marq($marq[$i]);
                	$mar ='';
                	if ($result->num_rows() >0)
					{
						foreach ($result->result() as $f)
						{
							$mar = $f->libMarque;
						}
					}
                    $result2= $this->DemA->sel_lib_mod($v);
                    $mode ='';
                    if ($result2->num_rows() >0)
                    {
                        foreach ($result2->result() as $f)
                        {
                            $mode = $f->libModele;
                        }
                    }
                    $data['er'] .= "Quantité du matériel \" $mar - $mode \" est vide <br/>";
                } elseif (!is_numeric($qte[$i]) || is_double($qte[$i]) || is_float($qte[$i])) {
                    $result= $this->DemA->sel_lib_marq($marq[$i]);
                    $mar ='';
                    if ($result->num_rows() >0)
                    {
                        foreach ($result->result() as $f)
                        {
                            $mar = $f->libMarque;
                        }
                    }
                    $result2= $this->DemA->sel_lib_mod($v);
                    $mode ='';
                    if ($result2->num_rows() >0)
                    {
                        foreach ($result2->result() as $f)
                        {
                            $mode = $f->libModele;
                        }
                    }
                    $data['er'] .= "Quantité du matériel \" $mar - $mode \" doit contenir que des chiffres entier<br/>";
                }elseif ($qte[$i] <= 0)
                {
                    $result= $this->DemA->sel_lib_marq($marq[$i]);
                    $mar ='';
                    if ($result->num_rows() >0)
                    {
                        foreach ($result->result() as $f)
                        {
                            $mar = $f->libMarque;
                        }
                    }
                    $result2= $this->DemA->sel_lib_mod($v);
                    $mode ='';
                    if ($result2->num_rows() >0)
                    {
                        foreach ($result2->result() as $f)
                        {
                            $mode = $f->libModele;
                        }
                    }
                    $data['er'] .= "Quantité du matériel \" $mar - $mode \" doit être strictement supérieure à 0<br/>";
                }
                $i++;
            }
        }else
		{
            $data['er'] .= "Aucun matérieu séléctionné";
		}
        if ($data['er'] == '')
        {
            $query1 = $this->DemA->selectnum_ges($this->session->userdata['mat']);
            if ($query1->num_rows() >0)
            {
                foreach ($query1->result() as $v)
                {
                    $numGes = $v->numGes;
                    $data1 = array(
                        "dateDA" => date("y-m-d"),
                        "numGes" => $numGes
                    );

                }
                $this->DemA->insertDa($data1);

                    $query2 = $this->DemA->selectnum_da();
                    if ($query2->num_rows() >0)
                    {
                        foreach ($query2->result() as $v)
                        {
                            $numDA = $v->numDA;
                        }
                        $j=0;
                        foreach ($model as $v) {
                            $data2 = array(
                                "numDA" => $numDA,
                                "idModele" =>$v,
                                "qtedemande" => $qte[$j]
                            );
                            $this->DemA->insertqteDa($data2);
                            $j++;
                        }
                    }
            }
        	$data['er'] = 'OK';
        	echo json_encode($data);
        }else
        {
            echo json_encode($data);
        }




/*

		if($this->form_validation->run())
		{
			$this->load->model("demA");
			$query1 = $this->demA->selectnum_ges($this->session->userdata['mat']);
			if ($query1->num_rows() >0)
			{
				foreach ($query1->result() as $v)
				{
					$numGes = $v->numGes;
					$data1 = array(
						"dateDA" => date("y-m-d"),
						"numGes" => $numGes
					);
				}

				if ($this->input->post("ajouter"))
				{
					$this->demA->insertDa($data1);
					$query2 = $this->demA->selectnum_da();
					if ($query2->num_rows() >0)
					{
						foreach ($query2->result() as $v)
						{
							$numDA = $v->numDA;
						}
						$data2 = array(
							"numDA" => $numDA,
							"idModele" =>$this->input->post("idSF") ,
							"qtedemande" => $this->input->post("qtedemande")
						);
					}
					$this->demA->insertqteDa($data2);
					redirect(base_url()."Ges/DAajoute");
				}

			}else
			{

			}
		}
		else
		{
			$this->index();
		}*/

	}

}

