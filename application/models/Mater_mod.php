<?php
class Mater_mod extends CI_Model
{
	public function selectF()
	{
		$query = $this->db->get('famille');
		return $query;
	}

	public function selectMarque()
	{
		$query = $this->db->get('marque');
		return $query;
	}
	public function selectModele_id($idMarque)
	{
		$this->db->where('idMarque',$idMarque);
		$query = $this->db->get('modele');
		return $query;
	}
	public function selectSF($idF)
	{
		$this->db->where("idF",$idF);
		$query = $this->db->get('sousFamille');
		return $query;
	}
	public function selectmater_en_stock($idSF,$idmod)
	{
		$query = $this->db->query("SELECT * FROM materiel m , sousFamille sf, modele mo ,marque ma WHERE 
sf.idSF = $idSF AND mo.idSF = $idSF AND mo.idModele = $idmod AND m.idModele = $idmod AND ma.idMarque = mo.idMarque AND m.dateSS IS NULL AND 
m.numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL) ");
		return $query;
	}
	public function selectmat($numSerie)
	{
		$this->db->where("numSerie",$numSerie);
		$query = $this->db->get('materiel');
		return $query;
	}
	public function selectC()
	{
		$query = $this->db->get('classe');
		return $query;
	}
	public function selectFourn()
	{
		$query = $this->db->get('fournisseur');
		return $query;
	}
	public function selectSF_id($idSF)
	{
		$this->db->where("idSF",$idSF);
		$query = $this->db->get('sousFamille');
		return $query;
	}
	public function selectF_id($idF)
	{
		$this->db->where("idF",$idF);
		$query = $this->db->get('famille');
		return $query;
	}
	public function selectFourn_id($idFourn)
	{
		$this->db->where("idFourn",$idFourn);
		$query = $this->db->get('fournisseur');
		return $query;
	}
	public function insert_data($data)
	{
		$this->db->insert("materiel",$data);
	}
	/*
	public function fetch_data()
    {
        //$query = $this->db->get("users");
        //select * from users
        //$query = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        $this->db->select("*");
        $this->db->from("users");
        $query = $this->db->get();
        return $query;
    }

    public function fetch_single_data($id){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$id);
        $query = $this->db->get();
        return $query;
    }*/
    public function update_data($data,$numSerie){
        $this->db->where("numSerie",$numSerie);
        $this->db->update("materiel",$data);
    }
	public function delete_data($numSerie)
	{
		$this->db->where("numSerie",$numSerie);
		$this->db->delete("materiel");
	}
    public function selectLibMarq_modele($idMarque, $table,$id)
    {
        $this->db->where($id,$idMarque);
        return $this->db->get($table);
    }

	public function selectLib($id)
	{
		$query = $this->db->query('SELECT mo.idModele, ma.idMarque, mo.libModele, ma.libMarque
		FROM marque ma, modele mo WHERE mo.idMarque= ma.idMarque AND mo.idModele ='.$id);
		return $query;
	}
	public function fetch_marq_sf($idSF)
	{
		$query = $this->db->query('SELECT ma.idMarque, ma.libMarque
		FROM marque ma, modele mo
		WHERE mo.idSF = '.$idSF.' AND mo.idMarque = ma.idMarque');
		return $query;
	}

    public function fetch_mode_sfMarq($sfid,$marqid)
    {
        $query = $this->db->query("SELECT DISTINCT mo.idModele,mo.libModele FROM modele mo , sousFamille sF 
WHERE mo.idMarque=$marqid AND mo.idSF = $sfid");
        return $query;
	}
    public function selectFVide()
    {

        $query = $this->db->query('select * from famille where idF not in (select idF from sousFamille) or idF not in(select idF from sousFamille where idSF in (select idSF from materiel ))');
        return $query;
    }
   /* public function selectSFVide()
    {
        $query = $this->db->query('select * from sousFamille where idSF not in (select idSF from materiel )');
        return $query;
    }*/
    public function getSeuil($idC)
    {
        $this->db->where('idC',$idC);
        $query = $this->db->get('classe');
        return $query;
    }
    public function modC($data,$idc)
    {
        $this->db->where('idC',$idc);
        $this->db->update('classe',$data);
    }
    public function selectStock()
    {
        $query = $this->db->query("SELECT DISTINCT idModele, qteS, seuil FROM modele mo,classe c WHERE 
c.idC=mo.idC AND mo.qteS <= c.seuil");
        return $query;
    }
    public function ajoutMarque($data)
    {
        $this->db->insert("marque",$data);
    }

    public function ajoutModele($data)
    {
        $this->db->insert("modele",$data);
    }
    public function selectDem()
    {
        $query = $this->db->query("SELECT DISTINCT idDI FROM nmt");
        return $query;
    }
    public function selectcountDem()
    {
        $query = $this->db->query("SELECT DISTINCT d.idDI FROM DI d WHERE (d.etat = 8 OR d.etat = 9 OR d.etat = 50 OR d.etat= 70 OR d.etat =11)");
        return $query;
    }
    public function selectDemMat()
    {
        $query = $this->db->query("SELECT DISTINCT r.numRep,e.nom, e.prenom, COUNT(d.idDI) as nb
        FROM DI d , employe e, reparateur r
        WHERE (d.etat = 8 OR d.etat = 9 OR d.etat = 50 OR d.etat= 70 OR d.etat =11) AND d.numRep = r.numRep AND e.mat = r.mat
        GROUP BY r.numRep");
        return $query;
    }
    public function selectDemMat3($numRep)
    {
        $query = $this->db->query("SELECT d.idDI, r.numRep,e.nom, e.prenom
        FROM DI d , employe e, reparateur r
        WHERE (d.etat = 8 OR d.etat = 9 OR d.etat = 50 OR d.etat= 70 OR d.etat =11) AND d.numRep = r.numRep
         AND d.numRep = $numRep AND e.mat = r.mat");
        return $query;
    }

    public function selectNMTqte($idDI)
    {
        $query = $this->db->query("SELECT n.idModele, mo.libModele,f.idF, f.libF,sf.idSF, sf.libSF,ma.idMarque, ma.libMarque, mo.qteS
        FROM nmt n,modele mo, marque ma, famille f, sousFamille sf WHERE n.idDI = $idDI 
        AND n.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF AND sf.idF = f.idF AND mo.qteS = 0");
        return $query;
    }

    public function selectDI_mat($idDI)
    {
        $query = $this->db->query("SELECT * FROM DI d, materiel m WHERE d.numSerie = m.numSerie AND d.idDI = $idDI");
        return $query;
    }

    public function updateMat($numSerie,$mj)
    {
        $this->db->where("numSerie",$numSerie);
        $this->db->update("materiel",$mj);
    }
    public function selectmo_mat($idModele)
    {
        $query = $this->db->query("SELECT * FROM materiel WHERE dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL)
 AND idModele = $idModele AND (dateES = 
(SELECT MIN(dateES) FROM materiel WHERE idModele = $idModele AND dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL) ) OR (dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL)) )");
        return $query;
    }
    public function selectmo_mat1($idModele)
    {
        $query = $this->db->query("SELECT * FROM materiel WHERE dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL)
 AND idModele = $idModele AND (dateES = 
(SELECT MIN(dateES) FROM materiel WHERE idModele = $idModele AND dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL) ) OR (dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL)) ) LIMIT 1 ");
        return $query;
    }
    public function matstock()
    {
        $query = $this->db->query("SELECT mo.idModele, mo.libModele, mo.qteS, ma.idMarque, ma.libMarque, f.libF,sf.libSF, c.idC, c.seuil
        FROM modele mo, marque ma, famille f , sousFamille sf, classe c
        WHERE mo.idSF = sf.idSF AND mo.idMarque = ma.idMarque AND sf.idF = f.idF AND mo.idC = c.idC 
        AND ( mo.qteS = 0 OR mo.qteS <= c.seuil )");
        return $query;
    }

    public function selectmAcheter($idmod)
    {
        $query = $this->db->query("SELECT mo.idModele, mo.libModele, ma.idMarque, ma.libMarque
         FROM modele mo, marque ma WHERE mo.idModele = $idmod AND mo.idMarque = ma.idMarque");
        return $query;
    }
    public function selectnonDispo($idDI)
    {
        $query = $this->db->query("SELECT d.etat, m.idModele, mo.libModele, f.libF,sf.libSF, ma.libMarque, mo.qteS
        FROM materiel m,modele mo, marque ma, famille f, sousFamille sf ,DI d WHERE d.numSerie = m.numSerie AND d.idDI = $idDI 
        AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF AND sf.idF = f.idF");
        return $query;
    }
    public function selectnondis_aacheter($idDI)
    {
        $query = $this->db->query("SELECT m.idModele, mo.libModele,f.idF, f.libF,sf.idSF, sf.libSF,ma.idMarque, ma.libMarque, mo.qteS
        FROM materiel m, DI d,modele mo, marque ma, famille f, sousFamille sf WHERE d.idDI = $idDI AND d.numSerie = m.numSerie
        AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF AND sf.idF = f.idF AND mo.qteS = 0");
        return $query;
    }
    public function selectSFVide($idF)
    {
        $query = $this->db->query("select * from sousFamille where idF='$idF' and idSF not in (select idSF from modele ) and idSF not in (select idSF from modele where idModele not in (select idModele from materiel))");
        return $query;
    }

    public function selectmatPret3($idDI)
    {
        $query = $this->db->query("SELECT d.etat,d.idDI, m1.idModele, mo1.libModele, f1.libF,sf1.libSF, ma1.libMarque,
m1.numSerie, m2.numSerie as num2, m2.idModele as idmod2 , mo2.libModele as libMod2, f2.libF as libF2, sf2.libSF as libsf2, 
ma2.libMarque as libMar2 , m1.mat, m1.local, m1.numArmoire
        FROM materiel m1, materiel m2,modele mo1, marque ma1, famille f1, sousFamille sf1,modele mo2,
         marque ma2, famille f2, sousFamille sf2 ,DI d 
         WHERE d.numSerie = m1.numSerie AND m1.idModele = mo1.idModele AND mo1.idMarque = ma1.idMarque AND 
         mo1.idSF = sf1.idSF AND sf1.idF = f1.idF AND m1.reforme = m2.numSerie AND d.idDI = $idDI AND 
         m2.idModele = mo2.idModele AND mo2.idMarque = ma2.idMarque AND mo2.idSF = sf2.idSF AND sf2.idF = f2.idF");
        return $query;
    }

    public function selectLastMar()
    {
        $qr =$this->db->query("SELECT idMarque FROM marque WHERE 
idMarque = (SELECT MAX(idMarque) FROM marque)");
        return $qr;
    }

}
