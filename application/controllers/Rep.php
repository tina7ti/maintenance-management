<?php
class Rep extends CI_Controller
{
	public function index()
	{
		$this->load->view('header');
        $this->test();
		$data['fonction'] = $this->get_menu();
		$data['title'] = "Réparateur";
		$this->load->view('accueil', $data);
	}
	public function get_menu()
	{
		return array(
			'&nbsp;Les demandes d\'intervention' => array('<i class="fas fa-clipboard-list fa-3x"></i>', 'Rep/di_affec','rep1'),
			'&nbsp;Mes Maintenances' => array('<i class="fas fa-wrench fa-3x"></i>', 'Rep/all_maint','rep2'),
			'<span style="font-size: 0.9em;">Matériaux nécessaire au réparations prêt</span>' => array('<i class="fas fa-desktop fa-3x"></i><i class="fas fa-check fa-2x" style="color: rgb(129,180,108); margin-left: -9%; margin-top: -1%"></i>', 'Rep/affNEC','rep3'),
            'Editer Demande d\'intervention' => array('<i class="fas fa-plus fa-3x"></i>', 'Rep/edit_di')
		);
	}
    public function test()
    {
        $this->load->model('mod');
        if (! $this->mod->retRep($this->session->userdata('mat'))) {
            redirect(base_url().'Login/pdPriv');
        }
    }
	public function base()
	{
		$this->load->view('header');
		$data['fonc'] = array(
			"DIs" => array('rep1','Rep/di_affec'),
			"Mes Maintenances" => array('rep2','Rep/all_maint'),
			"Matériaux nécessaire au réparations prêt" => array('rep3','Rep/affNEC'),
            "Editer Demande d'intervention" => 'Rep/edit_di',
		);
		$data['title'] = "Réparateur";
		$this->load->view('menu', $data);
	}
	public function di_affec()
	{
		$this->base();
		$this->load->model('Rep_model');
		$qr = $this->Rep_model->selectnum_rep($this->session->userdata('mat'));
		if ($qr->num_rows() >0)
		{
			foreach ($qr->result() as $v)
			{
				$num_rep = $v->numRep;
			}
		}
		$data['di_attente'] = $this->Rep_model->selectDI_attente($num_rep);
		$this->load->view('all_rep',$data);
	}
	public function repat_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("observations" , "Observations" ,'required');

		if($this->form_validation->run())
		{
			$idDI = $this->uri->segment(3);
			if($this->input->post('nonreparable'))
			{
				$this->base();
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
                    $etat = 51;
                }else $etat = 50;

				$data = array(
					'observations' => $this->input->post('observations'),
					'etat' => $etat
				);
                $this->Rep_model->updateDi($idDI,$data);
				redirect(base_url().'Rep/di_affec/nonrep');
			}
			if($this->input->post('reparable'))
			{
				$this->base();
				$this->load->model('Rep_model');
				$data = array(
					'observations' => $this->input->post('observations')
				);
				$this->Rep_model->updateDi($idDI,$data);
				redirect(base_url().'Rep/di_repa/'.$idDI);
			}

		}else
		{
			$this->index();
		}


	}
	public function fetch_notif()
	{
		$this->load->model('Rep_model');
		$qr = $this->Rep_model->selectnum_rep($this->session->userdata('mat'));
		if ($qr->num_rows() >0)
		{
			foreach ($qr->result() as $v)
			{
				$num_rep = $v->numRep;
			}

            $result1 = $this->Rep_model->selectDI_attente($num_rep);
            $data['unseen_notificationrep1'] = $result1->num_rows();
            $result2 = $this->Rep_model->select_count2($num_rep);
            $data['unseen_notificationrep2'] = $result2->num_rows();
            $result3 = $this->Rep_model->select_count3($num_rep);
            $result4 = $this->Rep_model->selectmatPret3($num_rep);
            $data['unseen_notificationrep3'] = $result3->num_rows() + $result4->num_rows();
            echo json_encode($data);
		}
        /*$data['notification'] ='';
    if ($result->num_rows() >0)
    {
        foreach ($result->result() as $v)
        {
            $data['notification'] .= '
                <li>
                <a href="#">
                <strong>'.$v->mat.'</strong><br/>
                <small><em>'.$v->numSerie.'</em></small>
</a>
</li>
                ';
        }
    }
    else
    {
        $data['notification'] .= '<li><a href="#" class="text-bold text-italic">No notification found</a></li>';
    }*/
	}
	public function etab_di()
	{
		/*$this->base();
		$this->load->model('Di_model');
		$query = $this->Di_model->matEmp($this->session->userdata('mat'));
		$data['matEmp'] = $query;
		$this->load->view('ajDI' , $data);*/
		redirect(base_url().'Di/index/reparateur');
	}
	public function up()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("observations" , "Observations" ,'required');

		if($this->form_validation->run())
		{
				$idDI = $this->uri->segment(3);
				$this->load->model('Res_model');
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
            if ($res->num_rows() > 0)
            {
                $etat = 51;
            }else $etat = 50;

            $data = array(
					'observations' => $this->input->post('observations'),
					'etat' => $etat
				);
				$this->Res_model->update_data($data,$idDI);


		}else
		{
			$this->index();
		}


	}
	public function di_repa()
	{
		$this->base();
		$data['idDI'] = $this->uri->segment(3);
		$this->load->model('Res_model');
		$this->load->model('Rep_model');
        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectF();
        $data['marq'] = $this->mater_mod->selectMarque();
		$data['di_sp'] = $this->Res_model->select_di_sp($data['idDI']);
		$this->load->model('mater_mod');
		$data['fam'] = $this->mater_mod->selectF();
		$this->load->view('di_repa',$data);
	}

	public function tab_return()
	{
		$this->load->model("Rep_model");
		$id=$this->input->post("idModele");
		if (isset($id) && !empty($id))
		{
			echo '
			<tr>
			<td>$this->input->post("idF")</td>
			<td>$this->input->post("idSF")</td>
			<td>$this->input->post("idMarque")</td>
			<td>$id</td>
			<td>Delete</td>
</tr>
			';
		}else
		{

		}

	}
	public function aj_tab()
	{
		$this->load->model('Rep_model');
		$idf = $_POST['idF'];
        $idsf = $_POST['idSF'];
        $idmar = $_POST['idMarque'];
        $idmod = $_POST['idModele'];
        $data['erreur'] = '';
        if (!isset($_POST['modeid'])) {
            $query = $this->Rep_model->inf_tab($idf,$idsf,$idmar,$idmod);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $v) {
                    $data['inf_tab'] = "<tr>
						<td><input type='text' value='$v->libF' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='fa[]' value=\"$v->libF\"></td>
						<td><input type='text' value='$v->libSF' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='sf[]' value=\"$v->libSF\"></td>
						<td><input type='text' value='$v->libMarque' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='marq[]' value=\"$v->libMarque\"></td>
						<td><input type='text' value='$v->libModele' disabled class=\"form-control\" style='border: none;'>
						<!--<input type='hidden' name='mode[]' value=\"$v->libModele\">-->
						<input type='hidden' name='modeid[]' value=\"$v->idModele\"></td>
						<td><a href='#'>Delete</a></td>
						</tr>";
                }
            }
        }
        else
        {
            $modeid = $_POST['modeid'];
            if (in_array($idmod, $modeid)) {
                $data['erreur'] = "Ce Matériel est séléctionné déjà ";
            }
            else{
                $query = $this->Rep_model->inf_tab($idf,$idsf,$idmar,$idmod);
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $v) {
                        $data['inf_tab'] = "<tr>
						<td><input type='text' value='$v->libF' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='fa[]' value=\"$v->libF\"></td>
						<td><input type='text' value='$v->libSF' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='sf[]' value=\"$v->libSF\"></td>
						<td><input type='text' value='$v->libMarque' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='marq[]' value=\"$v->libMarque\"></td>
						<td><input type='text' value='$v->libModele' disabled class=\"form-control\" style='border: none;'>
						<!--<input type='hidden' name='mode[]' value=\"$v->libModele\">-->
						<input type='hidden' name='modeid[]' value=\"$v->idModele\"></td>
						<td><a href='#'>Delete</a></td>
						</tr>";
                    }
                }
            }
        }
		echo json_encode($data);
	}

    public function bilanPre_validation()
    {
        $resultat['er'] ='';
        $this->load->model('Rep_model');
        $idpost = $_POST['idDI'];
        $result = $this->Rep_model->select_di($_POST['idDI']);
        if ($result->num_rows() > 0)
        {
            foreach ($result->result() as $v)
            {
                $di = $v;
            }
        }
        if (isset($_POST['modeid']))
        {
            $modeid = $_POST['modeid'];
            $cout = 0;
            $i=0;
            foreach ($modeid as $v)
            {
                $nmt['idDI'] = $di->idDI;
                $nmt['idModele'] = $v;
                $this->Rep_model->insertNMT($nmt);
               $res = $this->Rep_model->selectPrix($v);
                if ($res->num_rows() >0 )
                {
                    foreach ($res->result() as $f)
                    {
                        $cout = $cout + $f->prixAchat;
                    }
                }
                $i++;
            }
            $di->observations .= ' \n coût des matériaux séléctionnés est environ : '.$cout;
            $resultat['er'] = 'OK';
        }
        else
        {
            $di->observations .= ' \n coût des matériaux séléctionnés : 0 \n';
            $resultat['er'] = 'OK';
        }
        $data['observations'] = $di->observations;
        $data['etat'] = 2 ;
        $this->Rep_model->updateDi($idpost,$data);
        echo json_encode($resultat);

	}

    public function fetch_marqsf()
    {
        $idsf = $_POST['idsf'];
        $this->load->model('Rep_model');
        $result = $this->Rep_model->select_marques($idsf);
        $output = '';
        if ($result->num_rows() > 0)
        {
            $output .= '<option value="">Select Marque</option>';
            foreach ($result->result() as $v)
            {
                $output .= '<option value="'.$v->idMarque.'">'.$v->libMarque.'</option>';
            }
        }else
        {
            $output .= '<option value="">no row selected</option>';
        }
        echo $output;
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
    public function all_maint()
    {
        $this->base();
        $this->load->model('Rep_model');
        $qr = $this->Rep_model->selectnum_rep($this->session->userdata('mat'));
        if ($qr->num_rows() >0)
        {
            foreach ($qr->result() as $v)
            {
                $num_rep = $v->numRep;
            }
        }
        $data['di'] = $this->Rep_model->selectMesDI_att($num_rep);
        $this->load->view('di_recu',$data);
    }

    public function suite_di2()
    {
        $this->base();
        $idDI = $this->uri->segment(3);
        $this->load->model('Rep_model');
        $data['di_sp'] = $this->Rep_model->select_di_maint($idDI);
        $this->load->model('Res_model');
        $data['matNec'] = $this->Res_model->selectNMT($idDI);
        $data['matuti'] = $this->Rep_model->selectMatmaint2($idDI);
        $this->load->view('aff_di',$data);
    }

    public function edit_di()
    {
        $this->base();
        $this->load->model('Di_model');
        $query = $this->Di_model->matsf($this->session->userdata('mat'));
        $data['matsf'] = $query;
        $data['title'] = 'Réparateur';
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

                redirect(base_url()."Rep/Diajoutee");
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
    public function check_date2($dat)
    {
        $datec = new DateTime(date('y-m-d H:i'));
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
    public function commencer()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dateD','Date du début','required|callback_check_date2');
        $idDI = $this->input->post('idDI');
        $etat = $this->input->post('etat');
        if ($this->form_validation->run())
        {
            $data['etat'] = 6;
            $date = $this->input->post('dateD');
            $maint['dateD'] = $date;
            $this->load->model('Rep_model');
            $this->Rep_model->updateMaint($idDI,$maint);
            $this->Rep_model->updateDI($idDI,$data);
            redirect(base_url().'Rep/suite_di2/'.$idDI.'/6');
        }
        else
        {
            redirect(base_url().'Rep/suite_di2/'.$idDI.'/'.$etat.'/err');
        }
    }

    public function finMaint()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dateF','Date du fin','required|callback_check_date2');
        $idDI = $this->input->post('idDI');
        $etat = $this->input->post('etat');
        $this->load->model('Rep_model');
        if ($this->form_validation->run())
        {
            // calcule durée + calcule cout
            $dateF = $this->input->post('dateF');
            $duree = 0;
            $cout = 0;
            $m = $this->Rep_model->selectNmaint($idDI);
            if ($m->num_rows() > 0)
            {
                foreach ($m->result() as $v)
                {
                    $mat = $this->Rep_model->selectMatmaint($v->numMaint);
                    if ($mat->num_rows() > 0)
                    {
                        foreach ($mat->result() as $t)
                        {
                            $cout += $t->prixAchat;
                        }
                        $this->load->model('Res_model');
                        $this->Res_model->deletenmt($idDI);
                    }
                    $duree = date_diff($dateF,$v->dateD);
                }
                $tarif = $this->Rep_model->rettarifRep($this->session->userdata('mat'));
                $cout += $tarif * $duree;
                $data['cout'] = $cout;
                $data['dateF'] = $dateF;
                $this->Rep_model->updateMaint($idDI,$data);
                $di['etat'] = 4;
                $this->Rep_model->updateDi($idDI,$di);
            }
            redirect(base_url()."Rep/all_maint");
        }
        else
        {
            redirect(base_url().'Rep/suite_di2/'.$idDI.'/'.$etat.'/err');
        }
    }
    public function continuer()
    {
        $data['idDI'] = $this->uri->segment(3);
        $this->load->model('mater_mod');
        $data['fam'] = $this->mater_mod->selectF();
        $data['etat'] = $this->uri->segment(4);
        $this->load->view('di_repa',$data);
    }

    public function enrMatUti()
    {
        
    }

    public function affNEC()
    {
        $this->base();
        $this->load->model('Rep_model');
        $qr = $this->Rep_model->selectnum_rep($this->session->userdata('mat'));
        if ($qr->num_rows() >0) {
            foreach ($qr->result() as $v) {
                $num_rep = $v->numRep;
            }
        }
        $data['res1'] = $this->Rep_model->selectmatPret1($num_rep);
        $data['res2'] = $this->Rep_model->selectmatPret2($num_rep);
        $data['res3'] = $this->Rep_model-> selectmatPret3($num_rep);
        $this->load->view('notifGes',$data);
    }

    public function annulMaint()
    {
        $idDI = $this->input->post('idDI');
        $etat = $this->input->post('etat');
        $this->load->model('Rep_model');
        $m = $this->Rep_model->selectNmaint($idDI);
        if ($m->num_rows() > 0) {
            foreach ($m->result() as $v)
            {
                $numMaint = $v->numMaint;
            }
        }
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
        $data['numMaint'] = null;
        $this->Rep_model->updateDi($idDI,$data);
        $inf = array(
            "numMaint" => null,
            "local" => null,
            "dateSS" => null,
            "numArmoire" => null,
            "mat" => null
        );
        $this->Rep_model->updateMat($numMaint,$inf);
        $this->Rep_model->deleteMaint($numMaint);
        redirect(base_url()."Rep/all_maint");
    }
}
