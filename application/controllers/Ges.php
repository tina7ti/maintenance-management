<?php
class Ges extends CI_Controller
{
	public function index()
	{
		$this->load->view('header');
        $this->test();
		$data['fonction'] = $this->get_menu();
		$data['title'] = "Gestionnaire";
		$data['style'] = "margin-top: 0.5% ;";
		$this->load->view('accueil',$data);
	}
	public function get_menu()
	{
		return array(
			'Ajouter Matériel' => array('<i class="fas fa-plus fa-3x"></i>', 'Ges/ajout'),
			'Modifier Matériel' => array('<i class="fas fa-edit fa-3x"></i>', 'Ges/modif'),
			' Supprimer Matériel' => array('<i class="fas fa-times fa-3x"></i>', 'Ges/supp'),
            'Matériaux demandés lors d\'une réparation '=> array('<i class="fas fa-desktop fa-3x"></i><i class="fas fa-search fa-2x seaPC" style="color: rgb(189,85,72); margin-left: -9%; margin-top: -1%"></i>', 'Ges/demMat','ges2'),
            'Matériaux en stock minimal' => array('<i class="fas fa-minus-circle fa-3x"></i>', 'Ges/stockM','ges1'),
			'Ajouter Demande d\'achat' => array('<i class="fas fa-plus fa-3x"></i>', 'Da/'),
			'Ajouter Demande d\'intervention' => array('<i class="fas fa-plus fa-3x"></i>', 'Ges/edit_di'),
			'Modifier les classes d\'article' => array('<i class="fas fa-pencil-alt fa-3x"></i>', 'Ges/modif_Class')
		);
	}
	public function ajout()
	{
		$data = $this->base();
		$data['title']="Ajouter Matériel";
        $data['cla'] = $this->mater_mod->selectC();
		$this->load->view('ajMat',$data);

	}
    public function test()
    {
        $this->load->model('mod');
        if (! $this->mod->retGes($this->session->userdata('mat'))) {
            redirect(base_url().'Login/pdPriv');
        }
    }
	public function base()
	{
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
		$data['fourn'] = $this->mater_mod->selectFourn();
        $data['marq'] = $this->mater_mod->selectMarque();
		return $data;
	}

    public function fetch_mode_sfMarque()
    {
		$sfid = $this->uri->segment(3);
		$marqid = $this->uri->segment(4);
        $this->load->model("mater_mod");
        $result = $this->mater_mod->fetch_mode_sfMarq($sfid,$marqid);
        if ($result->num_rows() >0)
		{
            echo '<option value="">..........</option>';
			foreach ($result->result() as $v)
			{
                echo '<option value="'.$v->idModele.'">'.$v->libModele.'</option>';
			}
		}
		else
		{
            echo '<option value="NULL">no row selected</option>';
		}
	}

    public function check_date($dat)
    {
		$datec = new DateTime(date('y-m-d'));
		$datechar = new DateTime($dat);
		if ($datec >= $datechar==false)
		{
			$this->form_validation->set_message('check_date','la date est invalide');
			return false;
		}else
		{
			return true;
		}
	}
	public function ajm_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("numSerie" , "Numéro de serie" ,'required|is_unique[materiel.numSerie]');
		$this->form_validation->set_rules("prixAchat" , "Prix d'achat" ,'required');
		$this->form_validation->set_rules("idMarque" , "Marque" ,'required');
		$this->form_validation->set_rules("idModele" , "Modèle" ,'required');
        $this->form_validation->set_rules("idF" , "Famille" ,'required');
        $this->form_validation->set_rules("idSF" , "Sous Famille" ,'required');
		$this->form_validation->set_rules("dateES" , "Date d'entré en stock" ,'required|callback_check_date');
		$this->form_validation->set_rules("idF" , "Famille" ,'required');
		$this->form_validation->set_rules("idSF" , "Sous Famille" ,'required');
		$this->form_validation->set_rules("idFourn" , "Fournisseur" ,'required');

		if($this->form_validation->run())
		{
			$this->load->model("mater_mod");
			$data = array(
			"numSerie" =>$this->input->post("numSerie") ,
			"prixAchat" =>$this->input->post("prixAchat") ,
			"idModele" =>$this->input->post("idModele") ,
			"dateES" =>$this->input->post("dateES") ,
			"idFourn"=>$this->input->post("idFourn")
			);


			if ($this->input->post("modifier"))
			{
				$this->mater_mod->update_data($data,$this->input->post("hidden_id"));
				redirect(base_url()."Ges/modifie");
			}
			if ($this->input->post("ajouter")){
				$this->mater_mod->insert_data($data);
				redirect(base_url()."Ges/ajout/ajoutee");
			}

		}
		else
		{
			$this->ajout();
		}

	}
	public function ajm_validation_update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("numSerie" , "Numéro de serie" ,'required');
		$this->form_validation->set_rules("prixAchat" , "Prix d'achat" ,'required');
		$this->form_validation->set_rules("marq" , "Marque" ,'required');
		$this->form_validation->set_rules("modele" , "Modèle" ,'required');
		$this->form_validation->set_rules("dateES" , "Date d'entré en stock" ,'required');
		$this->form_validation->set_rules("idF" , "Famille" ,'required');
		$this->form_validation->set_rules("idSF" , "Sous Famille" ,'required');
		$this->form_validation->set_rules("idFourn" , "Fournisseur" ,'required');

		if($this->form_validation->run())
		{
			$this->load->model("mater_mod");
			$data = array(
				"numSerie" =>$this->input->post("numSerie") ,
				"prixAchat" =>$this->input->post("prixAchat") ,
				"idModele" =>$this->input->post("modele") ,
				"dateES" =>$this->input->post("dateES") ,
				"idFourn"=>$this->input->post("idFourn")
			);


			if ($this->input->post("modifier"))
			{
				$this->mater_mod->update_data($data,$this->input->post("hidden_id"));
				redirect(base_url()."Ges/modifie");
			}
			if ($this->input->post("ajouter")){
				$this->mater_mod->insert_data($data);
				redirect(base_url()."Ges/ajoutee");
			}

		}
		else
		{
			$this->ajout();
		}

	}
	public function fetch_sousF()
	{
		$this->load->model("mater_mod");
		$id=$this->input->post("idF");
		if (isset($id) && !empty($id))
		{
			$query = $this->mater_mod->selectSF($this->input->post("idF"));
			if ($query->num_rows() >0) {
				echo '<option value="">..........</option>';

				foreach ($query->result() as $v) {

					echo '<option value="'.$v->idSF.'">'.$v->libSF.'</option>';

				}
			}else
			{
				echo '<option value="NULL">no row selected</option>';
							}
		}else
		{

		}

	}
	public function fetch_mater()
	{
		$this->load->model("mater_mod");
		$id=$_POST['idsf'];
		$idmod = $_POST['idmod'];
		if (isset($id) && !empty($id) && isset($idmod) && !empty($idmod))
		{
			$query = $this->mater_mod->selectmater_en_stock($id,$idmod);
			if ($query->num_rows() >0) {
				echo '<option value="">..........</option>';

				foreach ($query->result() as $v) {

					echo '<option value="'.$v->numSerie.'">'.$v->numSerie.', '.$v->libMarque . ', ' . $v->libModele.'</option>';

				}
			}else
			{
				echo '<option value="">no row selected</option>';
			}
		}else
		{
			echo '<option value="">no row selected</option>';
		}

	}
    public function fetch_model_marqsf()
    {
        $idmarq = $_POST['idmarq'];
        $idsf = $_POST['idsf'];
        $this->load->model('Rep_model');
        $result = $this->Rep_model->fetch_mode_sfMarq($idsf,$idmarq);
        $output = '';
        if ($result->num_rows() > 0)
        {
            $output .= '<option value="">..........</option>';
            foreach ($result->result() as $v)
            {
                $output .= '<option value="'.$v->idModele.'">'.$v->libModele.'</option>';
            }
        }else
        {
            $output .= '<option value="">no row selected</option>';
        }
        echo $output;
    }
	public function ajoutee()
	{
		$this->index();
	}

	public function DAajoute()
	{
		$this->index();
	}
	public function modif()
	{
		$data = $this->base();
		$this->load->view('selectMat',$data);

	}
	public function select_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("idF" , "Famille" ,'required');
		$this->form_validation->set_rules("idSF" , "Sous Famille" ,'required');
        $this->form_validation->set_rules("idMarque" , "Marque" ,'required');
        $this->form_validation->set_rules("idModele" , "Modèle" ,'required');
		$this->form_validation->set_rules("numSerie" , "Matériel" ,'required');

		if($this->form_validation->run())
		{
			$this->load->model("mater_mod");
           // $this->base();
			$data = $this->base();
			$data['idF'] = $this->input->post("idF") ;
			$data["idSF"] =$this->input->post("idSF") ;
            $data['idMarque'] = $this->input->post("idMarque") ;
            $data["idModele"] =$this->input->post("idModele") ;
			$data["numSerie"] =$this->input->post("numSerie");
            $data['cla']=$this->mater_mod->selectC();

			if ($this->input->post("modifier"))
			{
				$data['title']="Modifier Matériel";
				$data['inf_mater'] = $this->mater_mod->selectMat($data['numSerie']);
				$data['sf'] = $this->mater_mod->selectSF($data['idF']);
                $data['marq'] = $this->mater_mod->fetch_marq_sf($data['idSF']);
                $data['mod'] = $this->mater_mod->fetch_mode_sfMarq($data['idSF'],$data['idMarque']);
				$q2 =$this->mater_mod->selectSF_id($data['idSF']);
				if ($q2->num_rows() >0)
				{
					foreach ($q2->result() as $v)
					{
						$data['libSF'] = $v->libSF;
					}
				}
				$q3 = $this->mater_mod->selectLibMarq_modele($data['idMarque'],"marque","idMarque");
				if ($q3->num_rows() >0)
				{
					foreach ($q3->result() as $v)
					{
						$data['libMarque'] = $v->libMarque;
					}
				}
                $q4 = $this->mater_mod->selectLibMarq_modele($data['idModele'],"modele","idModele");
                if ($q4->num_rows() >0)
                {
                    foreach ($q4->result() as $v)
                    {
                        $data['libModele'] = $v->libModele;
                    }
                }
				$q1 = $this->mater_mod->selectF_id($data['idF']);
				if ($q1->num_rows() >0)
				{
					foreach ($q1->result() as $v)
					{
						$data['libF'] = $v->libF;
					}
				}
				$q3 =$this->mater_mod->selectmat($data['numSerie']);
				if ($q3->num_rows() >0)
				{
					foreach ($q3->result() as $v)
					{
						$data['idFourn'] = $v->idFourn;
						$q4 =$this->mater_mod->selectFourn_id($data['idFourn']);
						if ($q4->num_rows() >0)
						{
							foreach ($q4->result() as $v)
							{
								$data['nomFourn'] = $v->nom;
							}
						}
					}
				}
				$this->load->view('ajMat',$data);
			}
			if ($this->input->post("supprimer"))
			{
				$numSerie = $this->input->post('numSerie');
				$this->load->model("mater_mod");
				$this->mater_mod->delete_data($numSerie);
				echo "rgsrgsd";
				redirect(base_url()."Ges/supprime");
			}
		}
		else
		{
			$this->modif();
		}

	}
	public function modifie()
	{
		$this->index();
	}
	public function supp()
	{
		$data = $this->base();
		$this->load->view('selectMat',$data);

	}
	public function supprime()
	{
		$this->index();
	}
	public function di()
	{
		$data = $this->base();
		$this->load->view('ajDI',$data);

	}


	/*public function ajoutF()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("libF_m" , "libellé famille " ,'required|alphanumeric');

		if($this->form_validation->run())
		{
			$data['libF'] = $this->input->post('libF_m');
			$this->load->model('Mater_mod');
			$this->Mater_mod->insertF($data);
		}
		else
		{
			$this->ajout();
		}
	}*/
	public function fetch_marq_sf()
	{
		$idSF = $this->uri->segment(3);
		$this->load->model('Mater_mod');
		$result = $this->Mater_mod->fetch_marq_sf($idSF);
		if ($result->num_rows() >0)
		{
			echo '<option value="">..........</option>';
			foreach ($result->result() as $v)
			{
				echo '<option value="'.$v->idMarque.'">'.$v->libMarque.'</option>';
			}
		}
		else
		{
			echo '<option value="NULL">no row selected</option>';
		}
	}
    public function modif_Class()
    {
    	$this->base();
        $this->load->model('Mater_mod');
        $data['idC']=$this->Mater_mod->selectC();
        // $data['seuil']=$this->Mater_mod->getSeuil($data);
        $this->load->view('modifClass',$data);


    }
    public function modifClass()
    {
        $idc =$_POST['idC'];
        $data['seuil'] = $_POST['seuil'];
        $this->load->model('Mater_mod');
        $this->Mater_mod->modC($data,$idc);
        echo "Seuil modifié";

    }
    public function fetch_seuilC()
    {
    	$idc = $_POST['idC'];
    	$this->load->model('Mater_mod');
    	$result = $this->Mater_mod->getSeuil($idc);
    	$data['seuil'] = -1;
    	if ($result->num_rows() >0)
		{
			foreach ($result->result() as $v)
			{
				$data['seuil'] = $v->seuil;
			}
		}
        echo json_encode($data);
    }

    public function fetch_notif()
    {
        $this->load->model('mater_mod');
        $result1 = $this->mater_mod->selectStock();
            $data['unseen_notificationges1'] = $result1->num_rows();
            $result2 = $this->mater_mod->selectcountDem();
        $data['unseen_notificationges2'] = $result2->num_rows();
            echo json_encode($data);
	}
    public function stockM()
    {
        $this->base();
        $this->load->model("Mater_mod");
        $data['matst'] = $this->Mater_mod->matstock();
		$this->load->view('notifGes',$data);
    }
    public function edit_di()
    {
        $this->base();
        $this->load->model('Di_model');
        $query = $this->Di_model->matsf($this->session->userdata('mat'));
        $data['matsf'] = $query;
        $data['title'] = 'Gestionnaire de stock';
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

                redirect(base_url()."Ges/Diajoutee");
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

    public function ajoutm()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('libMarque','libellé de la marque','required');
		if ($this->form_validation->run())
		{
			$this->load->model("Mater_mod");
			$data['libMarque'] = $this->input->post('libMarque');
			$this->Mater_mod->ajoutMarque($data);
		}else
		{
			return false;
		}

    }
    public function ajoutmodel()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('libModele_m','libellé du modele','required');
        $this->form_validation->set_rules('idMarque_m','Marque','required');
        $this->form_validation->set_rules('idF_m','Famille','required');
        $this->form_validation->set_rules('idSF_m','Sous Famille','required');
        $this->form_validation->set_rules('idC_m','Classe','required');
        if ($this->form_validation->run())
        {
            $this->load->model("Mater_mod");
            $data['idMarque'] = $this->input->post('idMarque_m');
            $data['idSF'] = $this->input->post('idSF_m');
            $data['idC'] = $this->input->post('idC_m');
            $data['libModele'] = $this->input->post('libModele_m');
            $this->Mater_mod->ajoutModele($data);
        }else
        {
            return false;
        }

    }
    public function ajoutmodel2()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('libModele2_m','libellé du modele','required');
        $this->form_validation->set_rules('idMarque2_m','Marque','required');
        $this->form_validation->set_rules('idF2_m','Famille','required');
        $this->form_validation->set_rules('idSF2_m','Sous Famille','required');

        if ($this->form_validation->run())
        {
            $this->load->model("Mater_mod");
            $data['idMarque'] = $this->input->post('idMarque2_m');
            $data['idSF'] = $this->input->post('idSF2_m');
            $data['idC'] = "C";
            $data['libModele'] = $this->input->post('libModele2_m');
            $this->Mater_mod->ajoutModele($data);
        }else
        {
            return false;
        }
    }

    public function ajoutmarque2()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('libModele_m','libellé du modele','required');
        $this->form_validation->set_rules('libMarque_m','Marque','required');
        $this->form_validation->set_rules('idF_m','Famille','required');
        $this->form_validation->set_rules('idSF_m','Sous Famille','required');

        if ($this->form_validation->run())
        {
            $this->load->model("Mater_mod");
            $mar['libMarque'] = $this->input->post('libMarque_m');
            $this->Mater_mod->ajoutMarque($mar);
            $re = $this->Mater_mod->selectLastMar();
            if ($re->num_rows() > 0)
			{
				foreach ($re->result() as $i)
				{
					$idM = $i->idMarque;
				}
			}
			$data['idMarque'] = $idM;
            $data['idSF'] = $this->input->post('idSF_m');
            $data['idC'] = "C";
            $data['libModele'] = $this->input->post('libModele_m');
            $this->Mater_mod->ajoutModele($data);
        }else
        {
            return false;
        }
    }
    public function demMat()
    {
    	$this->base();
    	$this->load->model('Mater_mod');
    	$data['rep'] = $this->Mater_mod->selectDemMat();
    	$this->load->view('notifGes', $data);

    }
    public function demMat3()
    {
    	$this->load->model('Mater_mod');
    	$numRep = $_POST['numr'];
    	$inf = $this->Mater_mod->selectDemMat3($numRep);
    	$cont = "";
    	if ($inf->num_rows() > 0)
		{
			foreach ($inf->result() as $i)
			{
			$cont .= "<div style='background-color: #f3f3f3; padding: 2% 5%; border-radius: 10px 10px; box-shadow: 4px 4px 6px gray; margin-bottom: 2%;'>
 <span style='border-bottom: gray solid 1px;'><span style='font-weight: bold; color: #2e6da4; '> Intervention n°: </span><span style='font-weight: bold; '> $i->idDI </span></span><br/>";
			$data = $this->recupMat($i->idDI);
			/********/
                if ($data['mat_sel'] =="")
                {
                    $cont .= "<span style='font-weight: bold;'>Aucun matériel sélectionné</span>";
                }else
                {
                    $cont .= "<span style='font-weight: bold;'>Les matériaux demandés : <br/></span>";
                    $cont .= $data['mat_sel'];
                    if ($data['good'] == 0)
                    {
                        $cont .= "<form action='".base_url()."Ges/repNotif/".$i->idDI."' method='post' style='margin-top: 3%;'>
						<div class='form-group'>
							<input type=\"submit\" value=\"Matériaux prêts. Envoyez notification au réparateur.\" class=\"form-control\">
						</div> 
						</form>";
                    }else
                    {
                        if ($data['good'] == 1)
                        {
                            $cont .= "<form action='".base_url()."Da/editDa/".$i->idDI."' method='post'  style='margin-top: 3%;'>
<div class='form-group'>
<input type=\"submit\" value=\"Matériaux manquants. Editer demande d'achat.\" class=\"form-control\">
                                    </div> </form>";
                        }else {
                            if ($data['good'] == 3)
                            {
                                $cont .= "<form action='".base_url()."Ges/upDI/".$i->idDI."' method='post'  style='margin-top: 3%;'><div class='form-group'>
                                   <input type=\"submit\" value=\"Matériel prêt, notifier le responsable.\" class=\"form-control\">
                                    </div>
                                     </form>";
                            }
                            else
                            {
                                if ($data['good'] == 4)
                                {
                                    $cont .= "<form action='".base_url()."Ges/upDI2/".$i->idDI."' method='post' style='margin-top: 3%;'><div class='form-group'>
                                         <input type=\"submit\" value=\"Matériel récupéré. Mettre à jour le stock.\" class=\"form-control\">
                                         </div>
                                        </form>";
                                }
                                else {
                                    $cont .= "<form action='".base_url()."Ges/maj/".$i->idDI."' method='post'  style='margin-top: 3%;'><div class='form-group'>
                                        <input type=\"submit\" value=\"Matériaux récupérés ? Mettre à jour votre stock.\" class=\"form-control\">
                                         </div>
                                       </form>";
                                }
                            }
                        }
                    }
                }
			/********/
		$cont .= "</div>";
				}
		}
		echo $cont;

    }
    public function recupMat($idDI)
    {
        $this->load->model('Res_model');
        $mate = $this->Res_model->selectNMT($idDI);
        $data['mat_sel'] ="";
        if ($mate->num_rows() > 0)
        {
            $data['good'] = 0;
            foreach ($mate->result() as $v)
            {
            	if ($v->etat == 8) {
                    if ($v->qteS > 0) {
                        $data['mat_sel'] .= "<span style='color: #3c763d;'>$v->libF - $v->libSF - $v->libMarque - $v->libModele  <i class='fas fa-check fa-1x'></i></span><br/>";
                    } else {
                        $data['mat_sel'] .= "<span style='color: #97310e;'>$v->libF - $v->libSF - $v->libMarque - $v->libModele  <i class='fas fa-times fa-1x'></i></span><br/>";
                        $data['good'] = 1;
                    }
                }else
				{
                    $data['mat_sel'] .= "<span style='color: #3c763d;'>$v->libF - $v->libSF - $v->libMarque - $v->libModele  <i class='fas fa-check fa-1x'></i></span><br/>";
					$data['good'] = 2;
				}

            }
        }else
		{
            $this->load->model('Mater_mod');
			$res = $this->Mater_mod->selectnonDispo($idDI);
            if ($res->num_rows() > 0)
            {
                $data['good'] = 0;
                foreach ($res->result() as $v)
                {
                        if ($v->qteS > 0 && $v->etat != 11) {
                            $data['mat_sel'] .= "<span style='color: #3c763d;'>$v->libF - $v->libSF - $v->libMarque - $v->libModele  <i class='fas fa-check fa-1x'></i></span><br/>";
                            $data['good'] = 3;
                        } elseif($v->qteS <= 0 && $v->etat != 11) {
                            $data['mat_sel'] .= "<span style='color: #97310e;'>$v->libF - $v->libSF - $v->libMarque - $v->libModele  <i class='fas fa-times fa-1x'></i></span><br/>";
                            $data['good'] = 1;
                        }
                }
            }
            $res = $this->Mater_mod->selectmatPret3($idDI);
            if ($res->num_rows() > 0)
            {
                $data['good'] = 0;
                foreach ($res->result() as $v)
                {
                        $data['mat_sel'] .= "$v->libF - $v->libSF - $v->libMarque - $v->libModele - $v->numSerie <br/>
 <span style='color: #97310e;'>a été remplacé par :</span><span style='color: #3c763d;'>$v->libF2 - $v->libsf2 - $v->libMar2 - $v->libMod2 - $v->num2 
 <i class='fas fa-check fa-1x'></i></span><br/>";
                        $data['good'] = 4;
                }
            }
		}
        return $data;
    }

    public function repNotif()
    {
		$idDI = $this->uri->segment(3);
		$data['etat'] = 9;
		$this->load->model('Rep_model');
		$this->Rep_model->updateDi($idDI,$data);
		redirect(base_url()."Ges/demMat");

    }

    public function maj()
    {
		$idDI = $this->uri->segment(3);
        $data['etat'] = 3;
        $this->load->model('Rep_model');
        $res = $this->Rep_model->selectNmaint($idDI);
        if ($res->num_rows() > 0)
        {
            foreach ($res->result() as $r)
            {
                $numMaint = $r->numMaint;
            }
        }
        $this->Rep_model->updateDi($idDI,$data);
        $this->load->model('mater_mod');
        $this->load->model('Res_model');
        $modele = $this->Res_model->selectNMT($idDI);
        $resul = $this->mater_mod->selectDI_mat($idDI);
        if ($resul->num_rows() > 0)
		{
			foreach ($resul->result() as $v)
			{
				// pour chaque modele selectionnés
				if ($modele->num_rows() > 0)
				{
					foreach ($modele->result() as $m)
					{
						// materiel d modele ....
						$mat = $this->mater_mod->selectmo_mat1($m->idModele);
						if ($mat->num_rows() > 0)
						{
							foreach ($mat->result() as $ma)
							{
                                $mj['dateSS'] = date("y-m-d");
                                $mj['local'] = $v->local;
                                $mj['numArmoire'] = $v->numArmoire;
                                $mj['mat'] = $v->mat;
                                $mj['numMaint'] = $numMaint;
                                $this->mater_mod->updateMat($ma->numSerie,$mj);
							}
						}
					}
				}

			}
		}
        $this->Res_model->deletenmt($idDI);
        redirect(base_url()."Ges/demMat");

    }

    public function upDI()
    {
		$idDI = $this->uri->segment(3);
		$this->load->model('Rep_model');
		$res = $this->Rep_model->select_di($idDI);
		if ($res->num_rows() > 0)
		{
			foreach ($res->result() as $v)
			{
				$etat = $v->etat;
			}
		}
		if (isset($etat))
		{
			if ($etat = 50) $e = 51;
			elseif ($etat = 70) $e = 71;
			$data['etat'] = $e;
			$this->Rep_model->updateDi($idDI,$data);
		}
		redirect(base_url()."Ges/demMat");
    }
    public function upDI2()
    {
        $idDI = $this->uri->segment(3);
        $this->load->model('Rep_model');
        $this->load->model('Mater_mod');
        //$res = $this->Rep_model->select_di($idDI);
        $res = $this->Mater_mod->selectmatPret3($idDI);
        if ($res->num_rows() > 0)
        {
            foreach ($res->result() as $v)
            {
                $reforme = $v->num2;
                $mj['local'] = $v->local;
                $mj['numArmoire'] = $v->numArmoire;
                $mj['mat'] = $v->mat;
            }
        }
        $mj['dateSS'] = date("y-m-d");
        $this->Mater_mod->updateMat($reforme,$mj);
        $data['etat'] = 12;
        $this->Rep_model->updateDi($idDI,$data);
        redirect(base_url()."Ges/demMat");
    }
}
?>
