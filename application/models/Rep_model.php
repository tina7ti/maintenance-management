<?php
class Rep_model extends CI_Model
{
	public function selectnum_rep($mat)
	{
		$this->db->where('mat',$mat);
		$query = $this->db->get('reparateur');
		return $query;
	}
	public function selectDI_attente($numRep)
	{
		$query = $this->db->query('SELECT d.idDI,d.numSerie,m.mat,d.date,d.note,e.nom,e.prenom,s.libS,ma.libMarque,
 mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF 
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f , marque ma, modele mo
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND
   m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND sf.idF = f.idF AND 
  d.numRep ='.$numRep.' AND d.etat = 1');
		return $query;
	}
	public function select_count2($numRep)
	{
        $query = $this->db->query('SELECT d.idDI FROM DI d
  WHERE d.numRep ='.$numRep.' AND (d.etat = 3 OR d.etat = 6 OR d.etat = 8 OR d.etat = 9)');
        return $query;
	}
    public function select_count3($numRep)
    {
        $query = $this->db->query('SELECT d.idDI FROM DI d
  WHERE d.numRep ='.$numRep.' AND d.etat = 9');
        return $query;
    }

	public function select_all_materiel_stock()
	{

		$query = $this->db->query("SELECT * FROM materiel WHERE dateSS IS NULL ");
		return $query;
	}
	public function inf_tab($idf,$idsf,$idmar,$idmod)
	{
		$query = $this->db->query("SELECT f.idF,f.libF, sf.idSF, sf.libSF, ma.idMarque, ma.libMarque, mo.idModele, mo.libModele FROM 
		famille f,sousFamille sf, modele mo, marque ma  WHERE 
		f.idF= $idf AND sf.idSF = $idsf AND ma.idMarque = $idmar AND mo.idModele = $idmod");
		return $query;
	}
    public function select_marques($idsf)
    {
     $query = $this->db->query("SELECT DISTINCT ma.idMarque, ma.libMarque FROM 
sousFamille sf, modele mo, marque ma WHERE
sf.idSF = $idsf AND sf.idSF = mo.idSF AND mo.idMarque = ma.idMarque ");
     return $query;
	}
    public function fetch_mode_sfMarq($sfid,$marqid)
    {
        $query = $this->db->query("SELECT DISTINCT mo.idModele,mo.libModele FROM modele mo , sousFamille sF 
WHERE mo.idMarque=$marqid AND mo.idSF = $sfid ");
        return $query;
    }

    public function select_di($idDI)
    {
        $this->db->where('idDI',$idDI);
        return $this->db->get('DI');
    }

    public function selectPrix($idModele)
    {
        $query = $this->db->query("SELECT * FROM materiel WHERE idModele = $idModele ");
        return $query;
    }

    public function updateDi($idDI,$data)
    {
        $this->db->where('idDI',$idDI);
        $this->db->update('DI',$data);
    }

    public function updateMaint($idDI,$maint)
    {
        $this->db->where('idDI',$idDI);
        $this->db->update('maintenance',$maint);
    }
    public function selectMesDI_att($numRep)
    {
        $query = $this->db->query('SELECT d.idDI,d.etat,d.numSerie,m.mat,d.date,d.note,e.nom,e.prenom,s.libS,ma.libMarque, mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF 
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f , marque ma, modele mo
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND
   m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND sf.idF = f.idF AND 
  d.numRep ='.$numRep.' AND (d.etat = 3 OR d.etat = 6 OR d.etat = 8 OR d.etat = 9)');
        return $query;
    }
    public function select_di_maint($idDI)
    {
        $query = $this->db->query("SELECT d.idDI,d.etat,m.mat,d.observations,d.numSerie,d.date,d.note,
e.nom,e.prenom,s.libS,ma.libMarque, mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f,reparateur r, modele mo, marque ma
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND sf.idF = f.idF AND (d.etat =3 OR d.etat = 6 OR d.etat = 8 OR d.etat = 9)
  AND d.numrep = r.numrep AND m.idModele = mo.idModele AND ma.idMarque = mo.idMarque AND d.idDI = $idDI");
        return $query;
    }

    public function insertMaint($inf1)
    {
        $this->db->insert("maintenance",$inf1);
    }

    public function selectNmaint($idDI)
    {
        $this->db->where('idDI',$idDI);
        return $this->db->get('maintenance');
    }
    public function selectMatmaint($numMaint)
    {
        $this->db->where('numMaint',$numMaint);
        return $this->db->get('materiel');
    }
    public function selectMatmaint2($idDI)
    {
        $query = $this->db->query("SELECT m.numSerie, m.prixAchat, f.libF, sf.libSF, m.idModele, mo.libModele, ma.libMarque 
FROM materiel m ,DI d ,modele mo, marque ma, famille f , sousFamille sf 
WHERE d.idDI = $idDI AND d.numMaint = m.numMaint AND m.idModele = mo.idModele AND mo.idSF = sf.idSF AND sf.idF = f.idF
AND mo.idMarque = ma.idMarque");
        return $query;
    }
    public function selectMatmaint3($numMaint)
    {
        $query = $this->db->query("SELECT DISTINCT m.numSerie, m.prixAchat, f.libF, sf.libSF, mo.libModele, ma.libMarque 
FROM materiel m ,DI d ,modele mo, marque ma, famille f , sousFamille sf 
WHERE m.numMaint = $numMaint AND m.idModele = mo.idModele AND mo.idSF = sf.idSF AND sf.idF = f.idF
AND mo.idMarque = ma.idMarque");
        return $query;
    }
    public function selectinfdi($idDI)
    {
        $query =$this->db->query("SELECT * FROM DI WHERE idDI = $idDI AND numMaint != NULL ");
        return $query;
    }

    public function insertNMT($nmt)
    {
        $this->db->insert('nmt',$nmt);
    }

    public function selectmatPret1($num_rep)
    {
     $this->db->where('etat',9);
     $this->db->where('numRep',$num_rep);
     return $this->db->get('DI');
    }
    public function selectmatPret2($num_rep)
    {
        $query = $this->db->query("SELECT d.etat,d.idDI, n.idModele, mo.libModele, f.libF,sf.libSF, ma.libMarque, mo.qteS
        FROM nmt n,modele mo, marque ma, famille f, sousFamille sf ,DI d WHERE d.numRep = $num_rep AND d.idDI = n.idDI 
        AND n.idDI = d.idDI AND d.etat = 9 AND n.idModele = mo.idModele AND mo.idMarque = ma.idMarque 
        AND mo.idSF = sf.idSF AND sf.idF = f.idF");
        return $query;
    }
    public function selectmatPret3($num_rep)
    {
        $query = $this->db->query("SELECT d.etat,d.idDI, m1.idModele, mo1.libModele, f1.libF,sf1.libSF, ma1.libMarque,
m1.numSerie, m2.numSerie as num2, m2.idModele as idmod2 , mo2.libModele as libMod2, f2.libF as libF2, sf2.libSF as libsf2, 
ma2.libMarque as libMar2 
        FROM materiel m1, materiel m2,modele mo1, marque ma1, famille f1, sousFamille sf1,modele mo2,
         marque ma2, famille f2, sousFamille sf2 ,DI d 
         WHERE d.numSerie = m1.numSerie AND m1.idModele = mo1.idModele AND mo1.idMarque = ma1.idMarque AND 
         mo1.idSF = sf1.idSF AND sf1.idF = f1.idF AND m1.reforme = m2.numSerie AND d.numRep = $num_rep AND 
         m2.idModele = mo2.idModele AND mo2.idMarque = ma2.idMarque AND mo2.idSF = sf2.idSF AND sf2.idF = f2.idF 
         AND d.etat = 11");
        return $query;
    }
    public function rettarifRep($mat)
    {
        $this->db->where('mat',$mat);
        $query= $this->db->get('reparateur');
        if ($query->num_rows() >0)
        {
            foreach ($query->result() as $v)
            {
                return $v->tarifH;
            }
        }
        else
        {
            return 0;
        }
    }

    public function updateMat($numMaint,$inf)
    {
        $this->db->where('numMaint',$numMaint);
        $this->db->update('materiel',$inf);
    }

    public function deleteMaint($numMaint)
    {
        $this->db->where('numMaint',$numMaint);
        $this->db->delete('maintenance');
    }
    public function selectMatdi($idDI)
    {
        $query = $this->db->query("SELECT m.numSerie,  m.idModele, d.date
FROM materiel m ,DI d 
WHERE d.idDI = $idDI AND d.numSerie = m.numSerie");
        return $query;
    }

    public function matDispo($idModele)
    {
        $query = $this->db->query("SELECT * FROM materiel WHERE idModele = $idModele AND dateSS IS NULL AND 
numSerie NOT IN (SELECT reforme FROM materiel WHERE reforme IS NOT NULL)");
        return $query;
    }

}
