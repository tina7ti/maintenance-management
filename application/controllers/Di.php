<?php
class Di extends CI_Controller
{
	public function index()
	{
		$this->load->view('header');
		$this->load->model('Di_model');
        $query = $this->Di_model->matsf($this->session->userdata('mat'));
        $data['matsf'] = $query;
		$this->load->view('ajDI' , $data);

	}

    public function fetch_mar()
    {
		$idSF = $_POST['sfid'];
        $this->load->model('Di_model');
        $query = $this->Di_model->matmar($idSF, $this->session->userdata('mat'));
        if ($query->num_rows() > 0)
		{
			$o = "<option value=''>Select Marque</option>";
            foreach ($query->result() as $v) {
				$o .= "<option value='$v->idMarque'>$v->libMarque</option>";
			}
		}
		else $o = "<option value=''>Aucune marque sélectionnée</option>";
        echo $o;
	}
    public function fetch_mod()
    {
        $idMarque = $_POST['idmar'];
        $idSF = $_POST['sfid'];
        $this->load->model('Di_model');
        $query = $this->Di_model->matmod($idSF,$idMarque, $this->session->userdata('mat'));
        if ($query->num_rows() > 0)
        {
            $o = "<option value=''>Select Modele</option>";
            foreach ($query->result() as $v) {
                $o .= "<option value='$v->idModele'>$v->libModele</option>";
            }
        }
        else $o = "<option value=''>Aucun modele sélectionné</option>";
        echo $o;
    }
    public function fetch_equip()
    {
        $idmod = $_POST['idmod'];
        $this->load->model('Di_model');
        $query = $this->Di_model->matequip($idmod, $this->session->userdata('mat'));
        if ($query->num_rows() > 0)
        {
            $o = "<option value=''>Select Numéro</option>";
            foreach ($query->result() as $v) {
                $o .= "<option value='$v->numSerie'>N ° : $v->numSerie</option>";
            }
        }
        else $o = "<option value=''>Aucun num sélectionné</option>";
        echo $o;
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
                redirect(base_url()."Di/ajoutee");
			}

		}
		else
		{
			$this->index();
		}

	}
	public function ajoutee()
	{
		$this->index();
	}


}






?>
