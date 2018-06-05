<?php
class Res extends CI_Controller
{
	public function index()
	{
		$this->load->view('header');
        $this->test();
		$data['fonction'] = $this->get_menu();
		$data['title'] = "Responsable";
		$this->load->view('accueil', $data);
	}

    public function test()
    {
        $this->load->model('mod');
        if (! $this->mod->retRes($this->session->userdata('mat'))) {
            redirect(base_url().'Login/pdPriv');
        }
	}
	public function get_menu()
	{
		return array(
			'&nbsp;Les demandes reçues' => array('<i class="fas fa-clipboard-list fa-3x"></i>', 'Res/di_recu','res1'),
			'Équipements en attente (changement)'=> array('<i class="fas fa-exchange-alt fa-3x"></i>', 'Res/di_nonrep','res3'),
            "Maintenances en attente (validation)" => array('<i class="fas fa-stopwatch fa-3x"></i>', 'Res/di_att','res2'),
            'Maintenance effectuées' => array('<i class="fas fa-wrench fa-3x"></i><i class="fas fa-check fa-2x nnrep2"></i>', 'Res/di_rapport','res4'),
            '&nbsp;Mes réparateurs' => array('<i class="fas fa-id-card fa-3x"></i>', 'Res/all_rep'),
			'&nbsp;Tableau de bord' => array('<i class="fas fa-chart-bar fa-3x"></i>', 'Res/tb1'),
            'Éditer Demande d\'intervention' => array('<i class="fas fa-plus fa-3x"></i>', 'Res/edit_di'),
			'&nbsp;Gérer la nomenclature d\'articles' => array('<i class="fas fa-sitemap fa-3x"></i>', 'Res/nomenclature')
		);
	}
	public function base()
	{
		$this->load->view('header');
		$data['fonc'] = array(
			"DI reçues" => array('res1','Res/di_recu'),
			"Équipements en attente de changement" => array('res3','Res/di_nonrep'),
            "Maintenances en attente de validation" => array('res2','Res/di_att'),
            "Maintenances effectuées" => array('res4','Res/di_rapport'),
            "Mes réparateurs" => 'Res/all_rep',
			"Tableau de bord" => 'Res/tb1',
            "Éditer DI" => 'Res/edit_di',
			"Gérer la nomenclature d'articles" => 'Res/nomenclature'
		);
		$data['title'] = "Responsable";
		$this->load->view('menu', $data);
	}
	public function all_rep()
	{
		$this->base();
		$this->load->model('Res_model');
		$data['reparat'] = $this->Res_model->selectall_rep_actif();
		$this->load->view('all_rep',$data);
	}
	public function di_recu()
	{
		$this->base();
		$this->load->model('Res_model');
		$data['di'] = $this->Res_model->select_di();
		$this->load->view('di_recu',$data);
	}
	public function suite_di()
	{
		$this->base();
		$idDI = $this->uri->segment(3);
        $etat = $this->uri->segment(4);
		$this->load->model('Res_model');
		if ($this->uri->segment(4) == 50 || $this->uri->segment(4) == 51 || $this->uri->segment(4) == 70 || $this->uri->segment(4) == 71)
		{
			$data['di_sp'] = $this->Res_model->select_di_nonrepID($idDI);
		}else
		{
            if ($this->uri->segment(4) == 3 || $this->uri->segment(4) == 6 || $this->uri->segment(4) == 8 || $this->uri->segment(4) == 9)
            {
                redirect(base_url().'Rep/suite_di2/'.$idDI.'/'.$etat);
            }else
            {
                $data['di_sp'] = $this->Res_model->select_di_sp($idDI);
            }
		}
		$data['reparat'] = $this->Res_model->selectall_rep_actif();
		$this->load->view('aff_di',$data);
	}

	public function fetch_notif()
	{

		$this->load->model('Res_model');
		$result = $this->Res_model->select_di();

		$result1 = $this->Res_model->select_count();
		$data['unseen_notification'] = $result1->num_rows();
		$result2 = $this->Res_model->select_count2();
		$data['unseen_notification2'] = $result2->num_rows();
		$result3 = $this->Res_model->select_count3();
		$data['unseen_notification3'] = $result3->num_rows();
        $result4 = $this->Res_model->select_count4();
        $data['unseen_notification4'] = $result4->num_rows();
		echo json_encode($data);

	}
	public function info_rep()
	{
		$numrep = $this->uri->segment(3);
		$this->load->model('Res_model');
		$qr = $this->Res_model->select_repinfo($numrep);
		$data['inf'] ='';
		$qr2 = $this->Res_model->select_main($numrep);
        if ($qr2->num_rows() > 0)
        {
            foreach ($qr2->result() as $f)
            {
                $nbmaint = $f->nb;
            }
        }
        $qr3 = $this->Res_model->select_rep($numrep);
        if ($qr3->num_rows() > 0)
        {
            foreach ($qr3->result() as $f)
            {
                $nbaff = $f->nb;
            }
        }
		if($qr->num_rows() > 0)
		{
			foreach ($qr->result() as $v)
			{
				$data['inf'] .= "<span style=\"font-weight: bold;\">Nom et prenom : </span> $v->nom $v->prenom 
							<br/><span style=\"font-weight: bold;\">Nombre d'affectation en cours :</span>  $nbaff
							<br/><span style=\"font-weight: bold;\">Nombre de Réparation en cours :</span>  $nbmaint
						<br/><span style=\"font-weight: bold;\">Fonction :</span>  $v->fonction
						<br/><span style=\"font-weight: bold;\">Email : </span> $v->email 
						<br/><span style=\"font-weight: bold;\">Téléphone : </span> $v->tel ";
			}
		}
		echo json_encode($data);
	}
	public function affec_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("rep" , "Réparateur" ,'required');

		if($this->form_validation->run())
		{
			if($this->input->post('rep'))
			{
				$idDI= $this->uri->segment(3);
				$this->load->model('Res_model');
				$data = array(
					'numRep' => $this->input->post('rep'),
					'etat' => 1
				);
				$this->load->model('Rep_model');
				$this->Rep_model->updateDi($idDI,$data);
				redirect(base_url().'Res/di_recu');
			}

		}else
		{
			$this->index();
		}


	}
	public function di_nonrep()
	{
		$this->base();
		$this->load->model('Res_model');
		$data['di'] = $this->Res_model->select_di_nonrep();
		$this->load->view('di_recu',$data);
	}
	public function tb1()
	{
		$this->base();
		$this->load->view('TB1');
	}
	public function nomenclature()
	{
		$this->base();
		$data['fonction'] = array(
		'Gérer les familles' => array('<i class="fas fa-sitemap fa-3x"></i><i class="fas fa-pencil-alt fa-3x penc"></i>','Res/gfamille')	,
		'Gérer les sous familles' => array('<i class="fas fa-sitemap fa-3x"></i><i class="fas fa-pencil-alt fa-3x penc"></i>','Res/gsousf')
		);
		$data['style'] = "margin-left : 25%; margin-top: -37%";
		$data['title'] = "Responsable";
		$this->load->view('accueil', $data);
	}

	public function gfamille()
	{
		$this->nomenclature();
		$data['boutons'] = array(
			'<i class="fas fa-plus-square fa-3x"></i> Famille',
			'<i class="fas fa-edit fa-3x"></i> Famille',
			'<i class="fas fa-times-circle fa-3x"></i> Famille'
		);
		$data['f'] = 'f';
		$this->load->view('bout',$data);
	}
	public function gsousf()
	{
		$this->nomenclature();
		$data['boutons'] = array(
			'<i class="fas fa-plus-square fa-3x"></i> Sous famille',
			'<i class="fas fa-edit fa-3x"></i> Sous famille',
			'<i class="fas fa-times-circle fa-3x"></i> Sous famille'
		);
		$data['s'] = 's';
		$this->load->view('bout',$data);
	}

	public function modif_f()
	{
		$this->load->model('mater_mod');
		$data['fam'] = $this->mater_mod->selectF();
		$this->load->view('modif_fam',$data);
	}
    public function modifSF()
    {
        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectF();
        $this->load->view('modifsf',$data);
    }
	/*public function supp_f()
	{
		$this->load->model('mater_mod');
		$data['fam'] = $this->mater_mod->selectF();
		$this->load->view('suppF',$data);
	}

	public function suppF()
	{
		$this->load->model('Res_model');
		$this->Res_model->suppf($_POST["idf"]);
		echo "Famille supprimée";
	}*/
    public function supp_f()
    {
        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectFVide();
        $this->load->view('suppF',$data);
    }

    public function suppF()
    {
        $this->load->model('Res_model');
        $this->Res_model->suppf($_POST["idf"]);
        echo "Famille supprimée";
    }
	public function ajoutFam()
	{
		$this->load->view('ajFamille');
	}

	public function ajoutFamille()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("libF" , "libellé famille " ,'required');

		if($this->form_validation->run())
		{
			$data['libF'] = $this->input->post('libF');
			$this->load->model('Res_model');
			$this->Res_model->insertF($data);
			echo "famille ajoutée";
		}
		else
		{
			$this->ajoutFam();
		}
	}
	public function fetch_equip_panne()
	{
		$this->load->model('Res_model');
		$result1 = $this->Res_model->fetch_equip_panne();
		$data['equip_en_panne'] = $result1->num_rows();
		$result2 = $this->Res_model->fetch_equip_panne_nn_maint();
		$data['equip_en_panne_nn_maint'] = $result2->num_rows();
		$result3 = $this->Res_model->fetch_equip_panne_nn_rep();
		$data['equip_en_panne_nn_rep'] = $result3->num_rows();
		$result4 = $this->Res_model->fetch_equip_panne_nn_affec();
		$data['equip_en_panne_nn_affec'] = $result4->num_rows();
        $result5 = $this->Res_model->fetch_equip_panne_ER();
        $data['equip_en_panne_ER'] = $result5->num_rows();
		echo json_encode($data);
	}
   /* public function supp_SF()
    {
        $this->load->model('mater_mod');
        $data['sf']=$this->mater_mod->selectSFVide();
        $this->load->view('suppSF',$data);
    }
*/
    public function suppSF()
    {
        $this->load->model('Res_model');
        $this->Res_model->suppsf($_POST["idsf"]);
        echo "Sous Famille supprimée";
    }
    public function ajout_sf(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("libSF" , "libellé sous famille " ,'required');
        $this->form_validation->set_rules("idF" , "famille " ,'required');

        if($this->form_validation->run())
        {
            $data['libSF'] = $_POST['libSF'];
            $data['idF'] = $_POST['idF'];
            $data['qteStock'] = 0;
            $this->load->model('Res_model');
            $this->Res_model->insertSF($data);
            echo "Sous famille ajoutée";
        }
        else
        {
            $this->ajoutSF();
        }
    }
    public function ajoutSF()
    {
        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectF();
        $this->load->view('ajSousF',$data);
    }

    public function di_att()
    {
        $this->base();
        $this->load->model('Res_model');
        $data['di_att'] = $this->Res_model->selectDI_att();
        $this->load->view('all_rep',$data);
    }

    public function recupMat()
    {
        $idDI = $_POST['iddi'];
        $this->load->model('Res_model');
        $mate = $this->Res_model->selectNMT($idDI);
        $data['mat_sel'] ="";
        if ($mate->num_rows() > 0)
        {
            foreach ($mate->result() as $v)
            {
                $data['mat_sel'] .= $v->libF.' - '.$v->libSF.' - '.$v->libMarque.' - '.$v->libModele.'<br/>';
            }
        }
        echo json_encode($data);
    }

    public function avis_validation()
    {
        $idDI = $this->uri->segment(3);
        $this->load->model('Rep_model');
        $this->load->model('Res_model');
        if($this->input->post('positif'))
        {
            $mate = $this->Res_model->selectNMT($idDI);
            if ($mate->num_rows() >0)
            {
                $data['etat'] = 8;
            }else
            {
                $data['etat'] = 3;
            }
            $inf1 = array(
                'idDI' => $idDI
            );
            $this->load->model('Rep_model');
            $this->Rep_model->insertMaint($inf1);
            $res = $this->Rep_model->selectNmaint($idDI);
            if ($res->num_rows() > 0)
            {
                foreach ($res->result() as $r)
                {
                    $data['numMaint'] = $r->numMaint;
                }
            }
            $this->Rep_model->updateDi($idDI,$data);
        }
        if($this->input->post('negatif'))
        {
            $this->load->model('Rep_model');
            $res = $this->Rep_model->selectMatdi($idDI);
            if ($res->num_rows() > 0)
            {
                foreach ($res->result() as $v)
                {
                    $idModele = $v->idModele;
                }
            }
            $res2 = $this->Rep_model->matDispo($idModele);
            if ($res2->num_rows() > 0)
            {
                $etat2 = 71;
            }else $etat2 = 70;
            $data['etat'] = $etat2;
            $this->Rep_model->updateDi($idDI,$data);
            $this->Res_model->deletenmt($idDI);
        }
        redirect(base_url().'Res/di_att');
    }
    public function edit_di()
    {
        $this->base();
        $this->load->model('Di_model');
        $query = $this->Di_model->matsf($this->session->userdata('mat'));
        $data['matsf'] = $query;
        $data['title'] = 'Responsable';
        $this->load->view('ajDI' , $data);
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

                    redirect(base_url()."Res/Diajoutee");
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
    public function selectMarque()
    {
        $this->load->model('Mater_mod');
        $query=$this->Mater_mod->selectMarque();

        if ($query->num_rows() >0) {
            echo '<option value="">Select Marque</option>';

            foreach ($query->result() as $v) {

                echo '<option value="'.$v->idMarque.'">'.$v->libMarque.'</option>';

            }
        }else
        {
            echo '<option value="NULL">no row selected</option>';
        }
    }

    public function selectModele()
    {$this->load->model('Mater_mod');
        $idMarq=$this->input->post('idMarq');
        $result=$this->Mater_mod->selectModele_id($idMarq);
        if ($result->num_rows() > 0)
        {
            echo '<option value="">Select Modele</option>';
            foreach ($result->result() as $v)
            {
                echo'<option value="'.$v->idModele.'">'.$v->libModele.'</option>';
            }
        }else
        {
            echo'<option value="">no row selected</option>';
        }
    }
    public function selectFamille()
    {
        $this->load->model('Mater_mod');
        $fam=$this->Mater_mod->selectF();
        if ($fam->num_rows() >0) {
            echo '<option value="">Select Famille</option>';

            foreach ($fam->result() as $v) {

                echo   '<option value="'.$v->idF.'">'.
                    $v->libF.' 
        </option>';

            }

        }
        else{
            echo '<option value="NULL">no row selected</option>';

        }
    }

    public function selectSF()
    {
        $this->load->model("mater_mod");
        $id=$this->input->post("idF");
        if (isset($id) && !empty($id))
        {
            $query = $this->mater_mod->selectSF($this->input->post("idF"));
            if ($query->num_rows() >0) {
                echo '<option value="">Select Sous famille</option>';

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

    public function di_rapport()
    {
        $this->base();
        $this->load->model('Res_model');
        $data['di_r'] = $this->Res_model->selectDI_r();
        $this->load->view('all_rep',$data);
    }

    public function affRapport()
    {
        $this->base();
        $idDI = $this->uri->segment(3);
        $up['etat'] = 10;
        $this->load->model("Res_model");
        $this->load->model('Rep_model');
        $this->Rep_model->updateDi($idDI,$up);
        $di = $this->Res_model->selectDIRap($idDI);
         if ($di->num_rows() > 0)
        {
            foreach ($di->result() as $d)
            {
                $main = $this->Rep_model->selectNmaint($idDI);
                if ($main->num_rows() > 0)
                {
                    foreach ($main->result() as $v)
                    {
                        $data = array(
                            "numMaint" => $d->numMaint,
                            "idDI" => $d->idDI,
                            "repname" => $d->nom,
                            "repprenom" => $d->prenom,
                            "empname" => $d->empnom,
                            "empprenom" => $d->empprenom,
                            "local" => $d->local,
                            "s" => $d->libS,
                            "numSerie" => $d->numSerie,
                            "repTel" => $d->tel,
                            "repEmail" => $d->email,
                            "f" => $d->libF,
                            "sf" => $d->libSF,
                            "marq" => $d->libMarque,
                            "modele" => $d->libModele,
                            "note" => $d->note,
                            "observ" => $d->observations,
                            "dateP" => $d->date,
                            "dateD" => $v->dateD,
                            "dateF" => $v->dateF,
                            "cout" => $v->cout,
                            "matutil" => $this->Rep_model->selectMatmaint3($d->numMaint)
                        );
                    }
                }

            }
        }
        $this->load->view('rapport',$data);
    }
    /***************************************************/


    public function fetch_equip_panneMarque()
    {

        $idM=$this->input->post('idMarq');

        $this->load->model('Res_model');
        $result1 = $this->Res_model->fetch_equip_panneM($idM);
        $data['equip_en_panne'] = $result1->num_rows();
        $result2 = $this->Res_model->fetch_equip_panne_nn_maintM($idM);
        $data['equip_en_panne_nn_maint'] =$result2->num_rows();
        $result3 = $this->Res_model->fetch_equip_panne_nn_repM($idM);
        $data['equip_en_panne_nn_rep'] =$result3->num_rows();
        $result4 = $this->Res_model->fetch_equip_panne_nn_affecM($idM);
        $data['equip_en_panne_nn_affec'] =$result4->num_rows();
        /*$result5=$this->Res_model->fetch_equip_panne_ANM($idM);
        $data['equip_en_panne_AN']=$result5->num_rows();*/
        $result6=$this->Res_model->fetch_equip_panne_en_maintM($idM);
        $data['equip_en_panne_en_maint']=$result6->num_rows();

        echo json_encode($data);
    }
    public function fetch_equip_panneModele()
    {

        $idM=$this->input->post('idMod');

        $this->load->model('Res_model');
        $result1 = $this->Res_model->fetch_equip_panneMod($idM);
        $data['equip_en_panne'] = $result1->num_rows();
        $result2 = $this->Res_model->fetch_equip_panne_nn_maintMod($idM);
        $data['equip_en_panne_nn_maint'] =$result2->num_rows();
        $result3 = $this->Res_model->fetch_equip_panne_nn_repMod($idM);
        $data['equip_en_panne_nn_rep'] =$result3->num_rows();
        $result4 = $this->Res_model->fetch_equip_panne_nn_affecMod($idM);
        $data['equip_en_panne_nn_affec'] =$result4->num_rows();
        /*  $result5=$this->Res_model->fetch_equip_panne_ANMod($idM);
         $data['equip_en_panne_AN']=$result5->num_rows();*/
         $result6=$this->Res_model->fetch_equip_panne_en_maintMod($idM);
         $data['equip_en_panne_en_maint']=$result6->num_rows();

        echo json_encode($data);
    }

    public function fetch_equip_panneFamille()
    {

        $idM=$this->input->post('idf');

        $this->load->model('Res_model');
        $result1 = $this->Res_model->fetch_equip_panneFamille($idM);
        $data['equip_en_panne'] = $result1->num_rows();
        $result2 = $this->Res_model->fetch_equip_panne_nn_maintFamille($idM);
        $data['equip_en_panne_nn_maint'] =$result2->num_rows();
        $result3 = $this->Res_model->fetch_equip_panne_nn_repFamille($idM);
        $data['equip_en_panne_nn_rep'] =$result3->num_rows();
        $result4 = $this->Res_model->fetch_equip_panne_nn_affecFamille($idM);
        $data['equip_en_panne_nn_affec'] =$result4->num_rows();
        /* $result5=$this->Res_model->fetch_equip_panne_ANFamille($idM);
          $data['equip_en_panne_AN']=$result5->num_rows();*/
          $result6=$this->Res_model->fetch_equip_panne_en_maintFamille($idM);
          $data['equip_en_panne_en_maint']=$result6->num_rows();

        echo json_encode($data);
    }

    public function fetch_equip_panneDate()
    {

        $idM=$this->input->post('idDate');

        $this->load->model('Res_model');
        $result1 = $this->Res_model->fetch_equip_panneDate($idM);
        $data['equip_en_panne'] = $result1->num_rows();
        $result2 = $this->Res_model->fetch_equip_panne_nn_maintDate($idM);
        $data['equip_en_panne_nn_maint'] =$result2->num_rows();
        $result3 = $this->Res_model->fetch_equip_panne_nn_repDate($idM);
        $data['equip_en_panne_nn_rep'] =$result3->num_rows();
        $result4 = $this->Res_model->fetch_equip_panne_nn_affecDate($idM);
        $data['equip_en_panne_nn_affec'] =$result4->num_rows();
        /* $result5=$this->Res_model->fetch_equip_panne_ANDate($idM);
         $data['equip_en_panne_AN']=$result5->num_rows();*/
         $result6=$this->Res_model->fetch_equip_panne_en_maintDate($idM);
         $data['equip_en_panne_en_maint']=$result6->num_rows();

        echo json_encode($data);
    }

    public function fetch_equip_panneSF()
    {

        $idM=$this->input->post('id_sf');

        $this->load->model('Res_model');
        $result1 = $this->Res_model->fetch_equip_panneSF($idM);
        $data['equip_en_panne'] = $result1->num_rows();
        $result2 = $this->Res_model->fetch_equip_panne_nn_maintSF($idM);
        $data['equip_en_panne_nn_maint'] =$result2->num_rows();
        $result3 = $this->Res_model->fetch_equip_panne_nn_repSF($idM);
        $data['equip_en_panne_nn_rep'] =$result3->num_rows();
        $result4 = $this->Res_model->fetch_equip_panne_nn_affecSF($idM);
        $data['equip_en_panne_nn_affec'] =$result4->num_rows();
        /*  $result5=$this->Res_model->fetch_equip_panne_ANSF($idM);
            $data['equip_en_panne_AN']=$result5->num_rows();*/
            $result6=$this->Res_model->fetch_equip_panne_en_maintSF($idM);
            $data['equip_en_panne_en_maint']=$result6->num_rows();
        echo json_encode($data);
    }

    /*****************  nbMat E/S ***************************/
    public function nbMatEs()
    {
        $this->load->model('Res_model');
        $q=$this->Res_model->enStock();


        if ($q->num_rows() > 0)

        {
            foreach ($q->result() as $v)
            {
                $nbTotal=$v->nbT;

            }}

        $query=$this->Res_model->mat_Es('1');
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->nb;

            }}

        $a=$s*100/$nbTotal;
        $data['jan']=$a;

        $query2=$this->Res_model->mat_Es('2');
        if ($query2->num_rows() > 0)

        {
            foreach ($query2->result() as $v)
            {
                $s=$v->nb;

            }}

        $b=$s*100/$nbTotal;

        $data['fev']=$b;

        $query3=$this->Res_model->mat_Es('3');
        if ($query3->num_rows() > 0)

        {
            foreach ($query3->result() as $v)
            {
                $s=$v->nb;

            }}

        $c=$s*100/$nbTotal;

        $data['mars']=$c;

        $query4=$this->Res_model->mat_Es('4');
        if ($query4->num_rows() > 0)

        {
            foreach ($query4->result() as $v)
            {
                $s=$v->nb;

            }}

        $d=$s*100/$nbTotal;

        $data['avril']=$d;

        $query5=$this->Res_model->mat_Es('5');
        if ($query5->num_rows() > 0)

        {
            foreach ($query5->result() as $v)
            {
                $s=$v->nb;

            }}

        $e=$s*100/$nbTotal;

        $data['may']=$e;
        $query6=$this->Res_model->mat_Es('6');
        if ($query6->num_rows() > 0)

        {
            foreach ($query6->result() as $v)
            {
                $s=$v->nb;

            }}

        $f=$s*100/$nbTotal;

        $data['juin']=$f;
        $query7=$this->Res_model->mat_Es('7');
        if ($query7->num_rows() > 0)

        {
            foreach ($query7->result() as $v)
            {
                $s=$v->nb;

            }}

        $g=$s*100/$nbTotal;

        $data['jull']=$g;
        $query8=$this->Res_model->mat_Es('8');
        if ($query8->num_rows() > 0)

        {
            foreach ($query8->result() as $v)
            {
                $s=$v->nb;

            }}

        $h=$s*100/$nbTotal;

        $data['aout']=$h;
        $query9=$this->Res_model->mat_Es('9');
        if ($query9->num_rows() > 0)

        {
            foreach ($query9->result() as $v)
            {
                $s=$v->nb;

            }}

        $i=$s*100/$nbTotal;

        $data['sep']=$i;
        $query10=$this->Res_model->mat_Es('10');
        if ($query10->num_rows() > 0)

        {
            foreach ($query10->result() as $v)
            {
                $s=$v->nb;

            }}

        $j=$s*100/$nbTotal;

        $data['oct']=$j;
        $query11=$this->Res_model->mat_Es('11');
        if ($query11->num_rows() > 0)

        {
            foreach ($query11->result() as $v)
            {
                $s=$v->nb;

            }}

        $k=$s*100/$nbTotal;

        $data['nov']=$k;
        $query12=$this->Res_model->mat_Es('12');
        if ($query12->num_rows() > 0)

        {
            foreach ($query12->result() as $v)
            {
                $s=$v->nb;

            }}

        $l=$s*100/$nbTotal;

        $data['dec']=$l;



        echo json_encode($data);
    }

    public function nbMat_ES_Annee()
    {
        $annee=$this->input->post('idDate');
        $this->load->model('Res_model');
        $q=$this->Res_model->enStock_A($annee);


        if ($q->num_rows() > 0)

        {
            foreach ($q->result() as $v)
            {
                $nbTotal=$v->nbT;

            }}

        $query=$this->Res_model->mat_Es_A('1',$annee);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->nb;

            }}

        $a=$s*100/$nbTotal;
        $data['jan']=$a;

        $query2=$this->Res_model->mat_Es_A('2',$annee);
        if ($query2->num_rows() > 0)

        {
            foreach ($query2->result() as $v)
            {
                $s=$v->nb;

            }}

        $b=$s*100/$nbTotal;

        $data['fev']=$b;

        $query3=$this->Res_model->mat_Es_A('3',$annee);
        if ($query3->num_rows() > 0)

        {
            foreach ($query3->result() as $v)
            {
                $s=$v->nb;

            }}

        $c=$s*100/$nbTotal;

        $data['mars']=$c;

        $query4=$this->Res_model->mat_Es_A('4',$annee);
        if ($query4->num_rows() > 0)

        {
            foreach ($query4->result() as $v)
            {
                $s=$v->nb;

            }}

        $d=$s*100/$nbTotal;

        $data['avril']=$d;

        $query5=$this->Res_model->mat_Es_A('5',$annee);
        if ($query5->num_rows() > 0)

        {
            foreach ($query5->result() as $v)
            {
                $s=$v->nb;

            }}

        $e=$s*100/$nbTotal;

        $data['may']=$e;
        $query6=$this->Res_model->mat_Es_A('6',$annee);
        if ($query6->num_rows() > 0)

        {
            foreach ($query6->result() as $v)
            {
                $s=$v->nb;

            }}

        $f=$s*100/$nbTotal;

        $data['juin']=$f;
        $query7=$this->Res_model->mat_Es_A('7',$annee);;
        if ($query7->num_rows() > 0)

        {
            foreach ($query7->result() as $v)
            {
                $s=$v->nb;

            }}

        $g=$s*100/$nbTotal;

        $data['jull']=$g;
        $query8=$this->Res_model->mat_Es_A('8',$annee);
        if ($query8->num_rows() > 0)

        {
            foreach ($query8->result() as $v)
            {
                $s=$v->nb;

            }}

        $h=$s*100/$nbTotal;

        $data['aout']=$h;
        $query9=$this->Res_model->mat_Es_A('9',$annee);
        if ($query9->num_rows() > 0)

        {
            foreach ($query9->result() as $v)
            {
                $s=$v->nb;

            }}

        $i=$s*100/$nbTotal;

        $data['sep']=$i;
        $query10=$this->Res_model->mat_Es_A('10',$annee);
        if ($query10->num_rows() > 0)

        {
            foreach ($query10->result() as $v)
            {
                $s=$v->nb;

            }}

        $j=$s*100/$nbTotal;

        $data['oct']=$j;
        $query11=$this->Res_model->mat_Es_A('11',$annee);
        if ($query11->num_rows() > 0)

        {
            foreach ($query11->result() as $v)
            {
                $s=$v->nb;

            }}

        $k=$s*100/$nbTotal;

        $data['nov']=$k;
        $query12=$this->Res_model->mat_Es_A('12',$annee);
        if ($query12->num_rows() > 0)

        {
            foreach ($query12->result() as $v)
            {
                $s=$v->nb;

            }}

        $l=$s*100/$nbTotal;

        $data['dec']=$l;



        echo json_encode($data);
    }


    public function nbMatSs()
    {
        $this->load->model('Res_model');
        $q=$this->Res_model->enStock();


        if ($q->num_rows() > 0)

        {
            foreach ($q->result() as $v)
            {
                $nbTotal=$v->nbT;

            }}

        $query=$this->Res_model->mat_Ss('1');
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->nb;

            }}

        $a=$s*100/($nbTotal+$s);
        $data['jan']=$a;

        $query2=$this->Res_model->mat_Ss('2');
        if ($query2->num_rows() > 0)

        {
            foreach ($query2->result() as $v)
            {
                $s=$v->nb;

            }}

        $b=$s*100/($nbTotal+$s);

        $data['fev']=$b;

        $query3=$this->Res_model->mat_Ss('3');
        if ($query3->num_rows() > 0)

        {
            foreach ($query3->result() as $v)
            {
                $s=$v->nb;

            }}

        $c=$s*100/($nbTotal+$s);

        $data['mars']=$c;

        $query4=$this->Res_model->mat_Ss('4');
        if ($query4->num_rows() > 0)

        {
            foreach ($query4->result() as $v)
            {
                $s=$v->nb;

            }}

        $d=$s*100/($nbTotal+$s);

        $data['avril']=$d;

        $query5=$this->Res_model->mat_Ss('5');
        if ($query5->num_rows() > 0)

        {
            foreach ($query5->result() as $v)
            {
                $s=$v->nb;

            }}

        $e=$s*100/($nbTotal+$s);

        $data['may']=$e;
        $query6=$this->Res_model->mat_Ss('6');
        if ($query6->num_rows() > 0)

        {
            foreach ($query6->result() as $v)
            {
                $s=$v->nb;

            }}

        $f=$s*100/($nbTotal+$s);

        $data['juin']=$f;
        $query7=$this->Res_model->mat_Ss('7');
        if ($query7->num_rows() > 0)

        {
            foreach ($query7->result() as $v)
            {
                $s=$v->nb;

            }}

        $g=$s*100/($nbTotal+$s);

        $data['jull']=$g;
        $query8=$this->Res_model->mat_Ss('8');
        if ($query8->num_rows() > 0)

        {
            foreach ($query8->result() as $v)
            {
                $s=$v->nb;

            }}

        $h=$s*100/($nbTotal+$s);

        $data['aout']=$h;
        $query9=$this->Res_model->mat_Ss('9');
        if ($query9->num_rows() > 0)

        {
            foreach ($query9->result() as $v)
            {
                $s=$v->nb;

            }}

        $i=$s*100/($nbTotal+$s);

        $data['sep']=$i;
        $query10=$this->Res_model->mat_Ss('10');
        if ($query10->num_rows() > 0)

        {
            foreach ($query10->result() as $v)
            {
                $s=$v->nb;

            }}

        $j=$s*100/($nbTotal+$s);

        $data['oct']=$j;
        $query11=$this->Res_model->mat_Ss('11');
        if ($query11->num_rows() > 0)

        {
            foreach ($query11->result() as $v)
            {
                $s=$v->nb;

            }}

        $k=$s*100/($nbTotal+$s);

        $data['nov']=$k;
        $query12=$this->Res_model->mat_Ss('12');
        if ($query12->num_rows() > 0)

        {
            foreach ($query12->result() as $v)
            {
                $s=$v->nb;

            }}

        $l=$s*100/($nbTotal+$s);

        $data['dec']=$l;



        echo json_encode($data);
    }
    public function nbMat_SS_Annee()
    {
        $annee=$this->input->post('idDate');
        $this->load->model('Res_model');
        $q=$this->Res_model->enStock_A($annee);


        if ($q->num_rows() > 0)

        {
            foreach ($q->result() as $v)
            {
                $nbTotal=$v->nbT;

            }}

        $query=$this->Res_model->mat_Ss_A('1',$annee);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->nb;

            }}

        $a=$s*100/($nbTotal+$s);
        $data['jan']=$a;

        $query2=$this->Res_model->mat_Ss_A('2',$annee);
        if ($query2->num_rows() > 0)

        {
            foreach ($query2->result() as $v)
            {
                $s=$v->nb;

            }}

        $b=$s*100/($nbTotal+$s);

        $data['fev']=$b;

        $query3=$this->Res_model->mat_Ss_A('3',$annee);
        if ($query3->num_rows() > 0)

        {
            foreach ($query3->result() as $v)
            {
                $s=$v->nb;

            }}

        $c=$s*100/($nbTotal+$s);

        $data['mars']=$c;

        $query4=$this->Res_model->mat_Ss_A('4',$annee);
        if ($query4->num_rows() > 0)

        {
            foreach ($query4->result() as $v)
            {
                $s=$v->nb;

            }}

        $d=$s*100/($nbTotal+$s);

        $data['avril']=$d;

        $query5=$this->Res_model->mat_Ss_A('5',$annee);
        if ($query5->num_rows() > 0)

        {
            foreach ($query5->result() as $v)
            {
                $s=$v->nb;

            }}

        $e=$s*100/($nbTotal+$s);

        $data['may']=$e;
        $query6=$this->Res_model->mat_Ss_A('6',$annee);
        if ($query6->num_rows() > 0)

        {
            foreach ($query6->result() as $v)
            {
                $s=$v->nb;

            }}

        $f=$s*100/($nbTotal+$s);

        $data['juin']=$f;
        $query7=$this->Res_model->mat_Ss_A('7',$annee);
        if ($query7->num_rows() > 0)

        {
            foreach ($query7->result() as $v)
            {
                $s=$v->nb;

            }}

        $g=$s*100/($nbTotal+$s);

        $data['jull']=$g;
        $query8=$this->Res_model->mat_Ss_A('8',$annee);
        if ($query8->num_rows() > 0)

        {
            foreach ($query8->result() as $v)
            {
                $s=$v->nb;

            }}

        $h=$s*100/($nbTotal+$s);

        $data['aout']=$h;
        $query9=$this->Res_model->mat_Ss_A('9',$annee);
        if ($query9->num_rows() > 0)

        {
            foreach ($query9->result() as $v)
            {
                $s=$v->nb;

            }}

        $i=$s*100/($nbTotal+$s);

        $data['sep']=$i;
        $query10=$this->Res_model->mat_Ss_A('10',$annee);
        if ($query10->num_rows() > 0)

        {
            foreach ($query10->result() as $v)
            {
                $s=$v->nb;

            }}

        $j=$s*100/($nbTotal+$s);

        $data['oct']=$j;
        $query11=$this->Res_model->mat_Ss_A('11',$annee);
        if ($query11->num_rows() > 0)

        {
            foreach ($query11->result() as $v)
            {
                $s=$v->nb;

            }}

        $k=$s*100/($nbTotal+$s);

        $data['nov']=$k;
        $query12=$this->Res_model->mat_Ss_A('12',$annee);
        if ($query12->num_rows() > 0)

        {
            foreach ($query12->result() as $v)
            {
                $s=$v->nb;

            }}

        $l=$s*100/($nbTotal+$s);

        $data['dec']=$l;



        echo json_encode($data);
    }


    /****  chart 2*****/
    public function fetch_temp()
    {
        $this->load->model('Res_model');
        $query=$this->Res_model->fetch_TA();
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->somme;

            }}
        /***/
        $result2=$this->Res_model->fetch_vie_today();

        if ($result2->num_rows() > 0)

        {
            foreach ($result2->result() as $f)
            {
                $s1=$f->sum;

            }}
        /****/
        $result3=$this->Res_model->fetch_vie_ff();
        if ($result3->num_rows() > 0)

        {
            foreach ($result3->result() as $d)
            {
                $s2=$d->sum1;

            }}

        $tM=$s1+$s2;

        $data['tA']=$s;
        $data['tM']=$tM;
        echo json_encode($data);
    }
    /*************  fetch temp marque ***************/
    public function fetch_tempMarque()
    {
        $id=$idM=$this->input->post('idMarq');
        $this->load->model('Res_model');
        $query=$this->Res_model->fetch_TAMarque($id);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->somme;

            }}
        /***/
        $result2=$this->Res_model->fetch_vie_todayMarque($id);

        if ($result2->num_rows() > 0)

        {
            foreach ($result2->result() as $f)
            {
                $s1=$f->sum;

            }}
        /****/
        $result3=$this->Res_model->fetch_vie_ffMarque($id);
        if ($result3->num_rows() > 0)

        {
            foreach ($result3->result() as $d)
            {
                $s2=$d->sum1;

            }}

        $tM=$s1+$s2;

        $data['tA']=$s;
        $data['tM']=$tM;
        echo json_encode($data);
    }
    /*************  fetch temp modele ***************/
    public function fetch_tempMod()
    {
        $id=$idM=$this->input->post('idMod');
        $this->load->model('Res_model');
        $query=$this->Res_model->fetch_TAMod($id);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->somme;

            }}
        /***/
        $result2=$this->Res_model->fetch_vie_todayMod($id);

        if ($result2->num_rows() > 0)

        {
            foreach ($result2->result() as $f)
            {
                $s1=$f->sum;

            }}
        /****/
        $result3=$this->Res_model->fetch_vie_ffMod($id);
        if ($result3->num_rows() > 0)

        {
            foreach ($result3->result() as $d)
            {
                $s2=$d->sum1;

            }}

        $tM=$s1+$s2;

        $data['tA']=$s;
        $data['tM']=$tM;
        echo json_encode($data);
    }
    /*************  fetch temp famille ***************/
    public function fetch_temp_F()
    {
        $id=$idM=$this->input->post('idf');
        $this->load->model('Res_model');
        $query=$this->Res_model->fetch_TA_F($id);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->somme;

            }}
        /***/
        $result2=$this->Res_model->fetch_vie_today_F($id);

        if ($result2->num_rows() > 0)

        {
            foreach ($result2->result() as $f)
            {
                $s1=$f->sum;

            }}
        /****/
        $result3=$this->Res_model->fetch_vie_ff_F($id);
        if ($result3->num_rows() > 0)

        {
            foreach ($result3->result() as $d)
            {
                $s2=$d->sum1;

            }}

        $tM=$s1+$s2;

        $data['tA']=$s;
        $data['tM']=$tM;
        echo json_encode($data);
    }

    /*************  fetch temp sous famille ***************/
    public function fetch_temp_SF()
    {
        $id=$this->input->post('id_sf');
        $this->load->model('Res_model');
        $query=$this->Res_model->fetch_TA_SF($id);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $v)
            {
                $s=$v->somme;

            }} else{ $s=0;}
        /***/
        $result2=$this->Res_model->fetch_vie_today_SF($id);

        if ($result2->num_rows() > 0)

        {
            foreach ($result2->result() as $f)
            {
                $s1=$f->sum;

            }}else{ $s1=0;}
        /****/
        $result3=$this->Res_model->fetch_vie_ff_SF($id);
        if ($result3->num_rows() > 0)

        {
            foreach ($result3->result() as $d)
            {
                $s2=$d->sum1;

            }}else{ $s2=0;}

        $tM=$s1+$s2;

        $data['tA']=$s;
        $data['tM']=$tM;
        echo json_encode($data);
    }


    /******* nb mat utilise en Maintenance ********/
    public function nbMatRep()
    {
        $this->load->model('Res_model');
        $query=$this->Res_model->nbMatRep(1);
        if ($query->num_rows() > 0)

        {
            foreach ($query->result() as $f)
            {
                $s1=$f->nb;

            }}
        $data['jan']=$s1;
        $query1=$this->Res_model->nbMatRep(2);
        if ($query1->num_rows() > 0)

            foreach ($query1->result() as $f)
            {
                $s2=$f->nb;

            }
        $data['fev']=$s2;
        $query3=$this->Res_model->nbMatRep('3');
        if ($query3->num_rows() > 0)

        {
            foreach ($query3->result() as $v)
            {
                $s=$v->nb;

            }}

        $c=$s;

        $data['mars']=$c;

        $query4=$this->Res_model->nbMatRep('4');
        if ($query4->num_rows() > 0)

        {
            foreach ($query4->result() as $v)
            {
                $s=$v->nb;

            }}

        $d=$s;

        $data['avril']=$d;

        $query5=$this->Res_model->nbMatRep('5');
        if ($query5->num_rows() > 0)

        {
            foreach ($query5->result() as $v)
            {
                $s=$v->nb;

            }}

        $e=$s;

        $data['may']=$e;
        $query6=$this->Res_model->nbMatRep('6');
        if ($query6->num_rows() > 0)

        {
            foreach ($query6->result() as $v)
            {
                $s=$v->nb;

            }}

        $f=$s;

        $data['juin']=$f;
        $query7=$this->Res_model->nbMatRep('7');
        if ($query7->num_rows() > 0)

        {
            foreach ($query7->result() as $v)
            {
                $s=$v->nb;

            }}

        $g=$s;

        $data['jull']=$g;
        $query8=$this->Res_model->nbMatRep('8');
        if ($query8->num_rows() > 0)

        {
            foreach ($query8->result() as $v)
            {
                $s=$v->nb;

            }}

        $h=$s;

        $data['aout']=$h;
        $query9=$this->Res_model->nbMatRep('9');
        if ($query9->num_rows() > 0)

        {
            foreach ($query9->result() as $v)
            {
                $s=$v->nb;

            }}

        $i=$s;

        $data['sep']=$i;
        $query10=$this->Res_model->nbMatRep('10');
        if ($query10->num_rows() > 0)

        {
            foreach ($query10->result() as $v)
            {
                $s=$v->nb;

            }}

        $j=$s;

        $data['oct']=$j;
        $query11=$this->Res_model->nbMatRep('11');
        if ($query11->num_rows() > 0)

        {
            foreach ($query11->result() as $v)
            {
                $s=$v->nb;

            }}

        $k=$s;

        $data['nov']=$k;
        $query12=$this->Res_model->nbMatRep('12');
        if ($query12->num_rows() > 0)

        {
            foreach ($query12->result() as $v)
            {
                $s=$v->nb;

            }}

        $l=$s;

        $data['dec']=$l;



        echo json_encode($data);

    }
    /***********/
    /* public function fetch_sfVide()
     {
         $this->load->model("mater_mod");
         $id=$this->input->post("idF");
         if (isset($id) && !empty($id))
         {
             $query = $this->mater_mod->selectSFVide($id);
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

     }*/
    /************sf****/
    public function supp_SF()
    {
        /*
         $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectFVide();
        $this->load->view('suppF',$data);
        */

        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectF();
        $this->load->view('suppSF',$data);
    }

    public function fetch_sfVide()
    {
        $this->load->model("mater_mod");
        $id = $this->input->post("idF");
        if (isset($id) && !empty($id)) {
            $query = $this->mater_mod->selectSFVide($id);
            if ($query->num_rows() > 0) {
                echo '<option value="">..........</option>';

                foreach ($query->result() as $v) {

                    echo '<option value="' . $v->idSF . '">' . $v->libSF . '</option>';

                }
            } else {
                echo '<option value="NULL">no row selected</option>';
            }
        } else {

        }
    }

    public function changer()
    {
        $idDI = $this->input->post('idDI');
        $this->load->model('Rep_model');
        $res = $this->Rep_model->selectMatdi($idDI);
        if ($res->num_rows() > 0)
        {
            foreach ($res->result() as $v)
            {
                $idModele = $v->idModele;
                $date = $v->date;
                $numSerie = $v->numSerie;
            }
        }
        $this->load->model('Mater_mod');

        $mat = $this->Mater_mod->selectmo_mat($idModele);
        if ($mat->num_rows() > 0)
        {
            foreach ($mat->result() as $ma)
            {
                $infM['dateFF'] = $date;
                $infM['reforme'] = $ma->numSerie;
                $this->Mater_mod->update_data($infM,$numSerie);
            }
        }
        $di['etat'] = 11;
        $this->load->model('Rep_model');
        $this->Rep_model->updateDi($idDI,$di);
        redirect(base_url()."Res/di_nonrep");
    }

    public function upFamille()
    {
        $idF = $_POST['idF'];
        $data['libF'] = $_POST['libF'];
        if ($data['libF'] == '')
        {
            echo "champ vide";
        }
        else
        {
            $this->load->model('Res_model');
            $this->Res_model->updateF($idF,$data);
            echo "Famille updated";
        }

    }
    public function upSF()
    {
        $idSF = $_POST['idSF'];
        $data['libSF'] = $_POST['libSF'];
        if ($data['libSF'] == '')
        {
            echo "champ vide";
        }
        else
        {
            $this->load->model('Res_model');
            $this->Res_model->updateSF($idSF,$data);
            echo "Sous Famille updated";
        }

    }

}
