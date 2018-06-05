<?php
class RecupMail extends CI_Model
{
	public function retrive($un)
    {
     $query=$this->db->query('SELECT email FROM employe WHERE username ="'.$un.'"' );
     return $query;
	}
	public function updateMP($data,$username)
	{
		$this->db->where('username',$username);
		$this->db->update('employe',$data);
	}
}
?>
