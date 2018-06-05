<?php

class Mod extends CI_model 
{
    public function can_log($username,$password){
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $this->db->where('actif',1);
        $query= $this->db->get('employe');

        if ($query->num_rows() >0)
        {
            return $query;
        }
        else
        {
            return false;
        }
    }

    public function retRes($mat)
	{
		$this->db->where('mat',$mat);
		$query= $this->db->get('responsable');
		if ($query->num_rows() >0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function retRep($mat)
	{
		$this->db->where('mat',$mat);
		$query= $this->db->get('reparateur');
		if ($query->num_rows() >0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function retGes($mat)
	{
		$this->db->where('mat',$mat);
		$query= $this->db->get('gestionnaireStock');
		if ($query->num_rows() >0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}



?>
