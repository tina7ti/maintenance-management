<?php
class Adm_model extends CI_Model
{
    public function selectS()
    {
        return $this->db->get('service');
    }
    public function selectfon()
    {
        return $this->db->query("SELECT DISTINCT fonction FROM employe");
    }
    public function selectF()
    {
        return $this->db->get('famille');
    }
    public function ajEmp($data)
    {
        $this->db->insert("employe",$data);
    }

    public function insertS($data)
    {
        $this->db->insert('service',$data);
    }

    public function selectEmp()
    {
        $this->db->where('actif',1);
        return $this->db->get('employe');
    }
    public function selectEmp_s($idS)
    {
        $this->db->where('idS',$idS);
        $this->db->where('actif',1);
        return $this->db->get('employe');
    }
    public function returnEmp($mat)
    {
       $query = $this->db->query("SELECT * FROM employe e, service s WHERE e.mat = $mat AND e.idS =s.idS");
        return $query;
    }

    public function updateE($mat,$data)
    {
        $this->db->where('mat',$mat);
        $this->db->update('employe',$data);
    }

    public function recupS($idS)
    {
        $this->db->where('idS',$idS);
        return $this->db->get('service');
    }

    public function selectsf($idF)
    {
        $this->db->where('idF',$idF);
        return $this->db->get('sousFamille');
    }

    public function updateS($idS,$data)
    {
        $this->db->where('idS',$idS);
        return $this->db->update('service',$data);
    }

    public function selectMarq($idSF)
    {
        $query = $this->db->query("SELECT DISTINCT ma.idMarque, ma.libMarque FROM marque ma, modele mo
WHERE mo.idMarque = ma.idMarque AND mo.idSF = $idSF");
        return $query;
    }

    public function selectModele($idSF,$idMarque)
    {
        $query = $this->db->query("SELECT * FROM modele WHERE idMarque = $idMarque AND idSF = $idSF");
        return $query;
    }

    public function selectEquip($idModele)
    {
        $query = $this->db->query("SELECT m.numSerie,f.libF,sf.libSF, mo.libModele, ma.libMarque 
FROM materiel m, marque ma, modele mo, famille f, sousFamille sf
WHERE m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF AND sf.idF = f.idF AND 
m.idModele = $idModele AND m.dateSS IS NULL AND m.numSerie NOT IN 
(SELECT reforme FROM materiel WHERE reforme IS NOT NULL )");
        return $query;
    }

    public function remptab($numSerie)
    {
        $query = $this->db->query("SELECT m.numSerie,f.libF,sf.libSF, mo.libModele, ma.libMarque 
FROM materiel m, marque ma, modele mo, famille f, sousFamille sf
WHERE m.numSerie= '$numSerie' AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF
 AND sf.idF = f.idF");
        return $query;
    }

    public function selectE($mat)
    {
        $this->db->where('mat',$mat);
        return $this->db->get('employe');
    }

    public function updateMat($num,$data)
    {
        $this->db->where('numSerie',$num);
        $this->db->update('materiel',$data);
    }
    /**************/
    public function SelectMat_e($mat)
    {
        $query = $this->db->query("SELECT m.numSerie, f.libF, sf.libSF, mo.libModele, ma.libMarque
        FROM materiel m, famille f, sousFamille sf, modele mo, marque ma WHERE 
        m.mat= $mat AND m.idModele=mo.idModele AND mo.idSF=sf.idSF AND mo.idMarque= ma.idMarque AND sf.idF=f.idF");
        return $query;
    }
}
?>