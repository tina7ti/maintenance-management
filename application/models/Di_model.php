<?php
class Di_model extends CI_Model
{
	public function matEmp($mat)
	{
	$query = $this->db->query("SELECT numSerie,libSF, mo.libModele, ma.libMarque FROM materiel m, sousFamille s, modele mo, marque ma 
WHERE m.mat =".$mat." AND s.idSF = mo.idSF AND m.idModele = mo.idModele AND ma.idMarque = mo.idMarque AND dateFF IS NULL ");
	return $query;
	}
    public function matsf($mat)
    {
        $query = $this->db->query("SELECT DISTINCT s.idSF, libSF FROM materiel m, sousFamille s, modele mo
WHERE m.mat =".$mat." AND s.idSF = mo.idSF AND m.idModele = mo.idModele AND dateFF IS NULL ");
        return $query;
    }
    public function matmar($idSF,$mat)
    {
        $query = $this->db->query("SELECT DISTINCT ma.idMarque, ma.libMarque FROM materiel m,modele mo, marque ma 
WHERE m.mat =".$mat." AND mo.idSF = $idSF AND m.idModele = mo.idModele AND ma.idMarque = mo.idMarque AND dateFF IS NULL ");
        return $query;
    }
    public function matmod($idSF,$mar,$mat)
    {
        $query = $this->db->query("SELECT DISTINCT mo.idModele, mo.libModele FROM materiel m,modele mo 
WHERE m.mat =".$mat." AND mo.idSF = $idSF AND m.idModele = mo.idModele AND mo.idMarque = $mar AND dateFF IS NULL ");
        return $query;
    }
    public function matequip($mod,$mat)
    {
        $query = $this->db->query("SELECT numSerie FROM materiel 
WHERE mat =".$mat." AND idModele =$mod AND dateFF IS NULL ");
        return $query;
    }
	public function insert_data($data)
	{
		$this->db->insert("DI",$data);
	}
}
