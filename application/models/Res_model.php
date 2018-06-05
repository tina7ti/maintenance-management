<?php
class Res_model extends CI_Model
{
	public function selectall_rep_actif()
	{
		$query = $this->db->query("SELECT r.mat,r.numRep,nom,prenom,fonction,email,tel FROM reparateur r , employe e WHERE r.mat = e.mat AND e.actif = 1 ");
		return $query;
	}
    public function select_repinfo($numRep)
    {
        $query = $this->db->query("SELECT r.mat,r.numRep,e.nom,e.prenom,e.fonction,e.email,e.tel 
FROM reparateur r , employe e 
WHERE r.numRep = $numRep AND r.mat = e.mat");
        return $query;
    }
	public function select_rep($numRep)
	{
		$query = $this->db->query("SELECT COUNT(d.idDI) as nb FROM DI d 
WHERE d.numRep = $numRep AND d.etat = 1 ");
		return $query;
	}
    public function select_main($numRep)
    {
        $query = $this->db->query("SELECT COUNT(d.idDI) as nb FROM DI d 
WHERE d.numRep = $numRep AND d.etat = 3 ");
        return $query;
    }
	public function selectall_rep()
	{
		$query = $this->db->get('reparateur');
		return $query;
	}
	public function select_di()
	{
		$query = $this->db->query("SELECT d.idDI,d.etat,d.numSerie,d.date,d.note,e.nom,e.prenom,s.libS,ma.libMarque,mo.libModele, mo.idModele,m.local,m.numArmoire, sf.libSF, f.libF 
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f , modele mo , marque ma
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND sf.idF = f.idF AND d.etat =0 
  AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque");
		return $query;
	}
	public function select_di_nonrep()
	{
		$query = $this->db->query("SELECT d.idDI,d.etat,m.mat,d.observations,d.numSerie,d.date,d.note,
e.nom,e.prenom,s.libS,ma.libMarque, mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF,e2.nom as repnom,e2.prenom as repprenom
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f,reparateur r,employe e2, marque ma, modele mo
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND sf.idF = f.idF AND (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71)
  AND d.numrep = r.numrep AND e2.mat = r.mat AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque");
		return $query;
	}
	public function select_di_nonrepID($idDI)
	{
		$query = $this->db->query("SELECT d.idDI,d.etat,m.mat,d.observations,d.numSerie,d.date,d.note,
e.nom,e.prenom,s.libS,ma.libMarque, mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF,e2.nom as repnom,e2.prenom as repprenom
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f,reparateur r,employe e2, modele mo, marque ma
  WHERE m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND sf.idF = f.idF AND (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71)
  AND d.numrep = r.numrep AND e2.mat = r.mat AND m.idModele = mo.idModele AND ma.idMarque = mo.idMarque AND d.idDI = $idDI");
		return $query;
	}
	public function select_di_sp($idDI)
	{
		$query = $this->db->query("SELECT d.idDI,d.date,d.note,d.observations,e.nom,e.prenom,s.libS,ma.libMarque, mo.libModele,m.local,m.numArmoire, sf.libSF, f.libF 
 FROM DI d, employe e,service s,materiel m,sousFamille sf,famille f , modele mo, marque ma
  WHERE d.idDI =$idDI AND m.mat = e.mat AND d.numSerie = m.numSerie AND e.idS=s.idS AND mo.idSF=sf.idSF AND 
  m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND sf.idF = f.idF");
		return $query;
	}

	public function select_count()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE etat=0');
		return $query;
	}
	public function select_count2()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE etat=2');
		return $query;
	}
	public function select_count3()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71)');
		return $query;
	}
    public function select_count4()
    {
        $query = $this->db->query('SELECT * FROM DI WHERE etat=4  ');
        return $query;
    }
	public function insertF($data)
	{
		$this->db->insert('famille',$data);
	}
    public function insertSF($data)
    {
        $this->db->insert('sousFamille',$data);
    }

    public function modifF($data)
	{
		$this->db->update($data);
	}

	public function suppf($data)
	{
		$this->db->where('idF',$data);
		$this->db->delete("famille");
	}
    public function suppsf($data)
    {
        $this->db->where('idSF',$data);
        $this->db->delete("sousFamille");
    }
	public function fetch_equip_panne()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE etat = 1 OR etat = 2 OR etat=0 OR etat=3 OR etat=8 OR etat=9 OR etat=6');
		return $query;
	}

	public function fetch_equip_panne_nn_maint()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE etat = 1 OR etat = 3 OR etat=8 OR etat=9');
		return $query;
	}

	public function fetch_equip_panne_nn_affec()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE etat = 0');
		return $query;
	}
	public function fetch_equip_panne_nn_rep()
	{
		$query = $this->db->query('SELECT * FROM DI WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71)');
		return $query;
	}

    public function selectDI_att()
    {
        $query = $this->db->query("SELECT d.idDI,d.note,d.observations,d.date,e.nom,e.prenom,e1.nom as empnom,e1.prenom as empprenom ,e.tel,
e.email,m.numSerie,m.idModele,m.local,m.numArmoire,mo.libModele,ma.libMarque,sf.libSF,f.libF,s.libS FROM 
DI d,employe e, employe e1, materiel m, modele mo, reparateur r ,marque ma , sousFamille sf, famille f, service s 
        WHERE d.etat = 2 AND r.numRep = d.numRep AND r.mat = e.mat AND d.numSerie = m.numSerie AND m.mat = e1.mat AND 
        e1.idS = s.idS AND mo.idSF = sf.idSF AND sf.idF = f.idF AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque");
        return $query;
	}

    public function selectNMT($idDI)
    {
        $query = $this->db->query("SELECT d.etat, n.idModele, mo.libModele, f.libF,sf.libSF, ma.libMarque, mo.qteS
        FROM nmt n,modele mo, marque ma, famille f, sousFamille sf ,DI d WHERE d.idDI = n.idDI AND n.idDI = $idDI 
        AND n.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND mo.idSF = sf.idSF AND sf.idF = f.idF");
        return $query;
	}
    public function deletenmt($idDI)
    {
        $this->db->where('idDI',$idDI);
        $this->db->delete('nmt');
    }
    public function selectDI_r()
    {
        $query = $this->db->query("SELECT d.idDI,d.numMaint,d.numSerie,d.etat, f.libF,sf.libSF, ma.libMarque, mo.libModele FROM
        DI d, materiel m, famille f, sousFamille sf, marque ma, modele mo WHERE 
        (d.etat = 4 OR d.etat = 10) AND d.numSerie = m.numSerie AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque AND 
        mo.idSF = sf.idSF AND sf.idF = f.idF ORDER BY d.numMaint DESC ");
        return $query;
    }
    public function selectDIRap($idDI)
    {
        $query = $this->db->query("SELECT d.numMaint,d.numSerie,d.idDI,d.note,d.observations,d.date,e.nom,e.prenom,
e1.nom as empnom,e1.prenom as empprenom ,e.tel,
e.email,m.numSerie,m.idModele,m.local,m.numArmoire,mo.libModele,ma.libMarque,sf.libSF,f.libF,s.libS FROM 
DI d,employe e, employe e1, materiel m, modele mo, reparateur r ,marque ma , sousFamille sf, famille f, service s 
        WHERE d.idDI = $idDI AND r.numRep = d.numRep AND r.mat = e.mat AND d.numSerie = m.numSerie AND m.mat = e1.mat AND 
        e1.idS = s.idS AND mo.idSF = sf.idSF AND sf.idF = f.idF AND m.idModele = mo.idModele AND mo.idMarque = ma.idMarque");
        return $query;
    }
    /*******************TB*************************/

    /********   Temp d'aret    **********/
    public function fetch_TA()
    {
        $query=$this->db->query("SELECT SUM(datediff(dateF,dateD)) as somme FROM `maintenance`") ;
        return $query;
    }

    /****  vie  *****/
    public function fetch_vie_today()
    {
        $query=$this->db->query("select SUM(datediff(CURRENT_DATE,dateSS)) as sum from materiel where dateFF is null");
        return $query;
    }

    public function fetch_vie_ff()
    {
        $query=$this->db->query("select SUM(datediff(dateFF,dateSS)) as sum1 from materiel where dateFF is not null");
        return $query;

    }

    /*****************   tem aret et vie marque *******************/

    public function fetch_TAMarque($idM)
    {
        $query=$this->db->query("SELECT SUM(datediff(dateF,dateD)) as somme FROM maintenance maint , modele mo , marque ma , materiel mat where mat.numMaint is not null and mat.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'") ;
        return $query;
    }
    public function fetch_vie_todayMarque($idM)
    {
        $query=$this->db->query("select SUM(datediff(CURRENT_DATE,dateSS)) as sum from materiel m, modele mo , marque ma where dateFF is null and m.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'");
        return $query;
    }

    public function fetch_vie_ffMarque($idM)
    {
        $query=$this->db->query("select SUM(datediff(dateFF,dateSS)) as sum1 from materiel m , modele mo, marque ma where dateFF is not null and m.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'");
        return $query;

    }
    /*****************   tem aret et vie modele *******************/

    public function fetch_TAMod($idM)
    {
        $query=$this->db->query("SELECT SUM(datediff(dateF,dateD)) as somme FROM maintenance maint , modele mo , materiel mat where mat.numMaint is not null and mat.idModele=mo.idModele and mo.idMarque='$idM'") ;
        return $query;
    }
    public function fetch_vie_todayMod($idM)
    {
        $query=$this->db->query("select SUM(datediff(CURRENT_DATE,dateSS)) as sum from materiel m, modele mo where dateFF is null and m.idModele=mo.idModele and mo.idMarque='$idM'");
        return $query;
    }

    public function fetch_vie_ffMod($idM)
    {
        $query=$this->db->query("select SUM(datediff(dateFF,dateSS)) as sum1 from materiel m , modele mo where dateFF is not null and m.idModele=mo.idModele and mo.idMarque='$idM'");
        return $query;

    }
    /*****************   tem aret et vie famille *******************/

    public function fetch_TA_F($idM)
    {
        $query=$this->db->query("SELECT SUM(datediff(dateF,dateD)) as somme FROM maintenance maint , modele mo , materiel mat , famille f , sousFamille sf where mat.numMaint is not null and mat.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idF= f.idF and f.idF='$idM'") ;
        return $query;
    }
    public function fetch_vie_today_F($idM)
    {
        $query=$this->db->query("select SUM(datediff(CURRENT_DATE,dateSS)) as sum from materiel m, modele mo , famille f , sousFamille sf where dateFF is null and m.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idF= f.idF and f.idF='$idM'");
        return $query;
    }

    public function fetch_vie_ff_F($idM)
    {
        $query=$this->db->query("select SUM(datediff(dateFF,dateSS)) as sum1 from materiel m , modele mo , famille f , sousFamille sf where dateFF is not null and m.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idF= f.idF and f.idF='$idM'");
        return $query;

    }

    /*****************   tem aret et vie sous famille *******************/

    public function fetch_TA_SF($idM)
    {
        $query=$this->db->query("SELECT SUM(datediff(dateF,dateD)) as somme FROM maintenance maint , modele mo , materiel mat , sousFamille sf where mat.numMaint is not null and mat.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idSF='$idM'") ;
        return $query;
    }
    public function fetch_vie_today_SF($idM)
    {
        $query=$this->db->query("select SUM(datediff(CURRENT_DATE,dateSS)) as sum from materiel m, modele mo , sousFamille sf where dateFF is null and m.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idSF='$idM'");
        return $query;
    }

    public function fetch_vie_ff_SF($idM)
    {
        $query=$this->db->query("select SUM(datediff(dateFF,dateSS)) as sum1 from materiel m , modele mo ,  sousFamille sf where dateFF is not null and m.idModele=mo.idModele and mo.idSF=sf.idSF and sf.idSF='$idM'");
        return $query;

    }
    /************************** nb mat utilise en reparation ********************/

    public function nbMatRep ($mois)
    {
        $query=$this->db->query("select count(*) as nb from materiel mat , maintenance m where mat.numMaint is not null and mat.numMaint=m.numMaint and month(m.dateD)='$mois'");
        return $query;
    }


    /****************************    nbMat E/S  ********************************/

    public function enStock()
    {
        $query=$this->db->query("select count(*) as nbT from materiel where dateSS is null");
        return $query;
    }
    public function enStock_A($annee)
    {
        $query=$this->db->query("select count(*) as nbT from materiel where dateSS is null and year(dateES)=year('$annee')");
        return $query;
    }

    public function matEs()
    {
        $lastMonth=$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
        $query=$this->db->query("select count(*) as nb from materiel where '$lastMonth'<=dateES and dateES< CURRENT_DATE and dateSS is null");
        return $query;
    }
    public function mat_Es($mois)
    {

        $data=$this->db->query("select count(*) as nb from materiel where MONTH(dateES)='$mois' and dateSS is null");
        return $data;
    }
    public function mat_Es_A($mois,$annee)
    {

        $data=$this->db->query("select count(*) as nb from materiel where MONTH(dateES)='$mois' and dateSS is null and year(dateES)=year('$annee')");
        return $data;
    }
    public function matSs()
    {
        $lastMonth=$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
        $query=$this->db->query("select * from materiel where '$lastMonth'<=dateSS and dateES< CURRENT_DATE");
        return $query;
    }

    public function mat_Ss($mois)
    {
        $lastMonth=$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
        $query=$this->db->query("select count(*) as nb from materiel where dateSS is not null and Month(dateSS)='$mois'");
        return $query;
    }
    public function mat_Ss_A($mois,$annee)
    {
        $lastMonth=$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
        $query=$this->db->query("select count(*) as nb from materiel where dateSS is not null and Month(dateSS)='$mois' and year(dateSS)=year('$annee')");
        return $query;
    }

    /*****************/



        /******  chart 1  ********/
    public function   fetch_equip_panne_ER()
    {
        $query=$this->db->query('select * from DI where etat = 6');
        return $query;
    }
    public function   fetch_equip_panne_AN()
    {
        $query=$this->db->query('select * from DI where etat = 7');
        return $query;
    }
    public function fetch_equip_panne_en_maint()
    {
        $query=$this->db->query('select * from DI where  etat = 6');
        return $query;
    }

    /*Marque*/
    function fetch_equip_panneM($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat , marque ma , modele mo WHERE (etat = 1 OR etat = 2 OR etat=0 OR etat=3) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_maintM($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat  , modele mo WHERE (etat = 1 OR etat = 3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=$idM");
        return $query;
    }

    public

    function fetch_equip_panne_nn_affecM($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat , marque ma , modele mo WHERE etat = 0 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'");
        return $query;
    }
    public

    function fetch_equip_panne_nn_repM($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat ,modele mo WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=$idM");
        return $query;
    }
    public function   fetch_equip_panne_ANM($idM)
    {
        $query=$this->db->query("select * from DI d , materiel mat , marque ma , modele mo where etat = 7 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=ma.idMarque and ma.idMarque='$idM'");
    }
    public function fetch_equip_panne_en_maintM($idM)
    {
        $query=$this->db->query("select * from DI d , materiel mat ,modele mo where  etat = 6 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idMarque=$idM");
        return $query;
    }

    /*Modle*/
    function fetch_equip_panneMod($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat WHERE (etat = 1 OR etat = 2 OR etat=0 OR etat=3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=$idM");
        return $query;
    }

    public

    function fetch_equip_panne_nn_maintMod($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat ,  modele mo WHERE (etat = 1 OR etat = 3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idModele='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_affecMod($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat ,  modele mo WHERE etat = 0 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idModele='$idM'");
        return $query;
    }
    public

    function fetch_equip_panne_nn_repMod($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat ,  modele mo WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idModele='$idM'");
        return $query;
    }

    public function   fetch_equip_panne_ANMod($idM)
    {
        $query=$this->db->query("select * from DI d , materiel mat ,  modele mo where etat = 70 OR etat = 71 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idModele='$idM'");
    }
    public function fetch_equip_panne_en_maintMod($idM)
    {
        $query=$this->db->query("select * from DI d , materiel mat where  etat = 6 and d.numSerie=mat.numSerie and mat.idModele=$idM");
    return $query;
    }

    /*FAmille*/

    function fetch_equip_panneFamille($idM) {
        $query = $this->db->query("SELECT * FROM DI d ,  modele mo ,materiel mat , famille f , sousFamille sf WHERE (etat = 1 OR etat = 2 OR etat=0 OR etat=3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_maintFamille($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat , modele mo, famille f , sousFamille sf WHERE (etat = 1 OR etat = 3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_affecFamille($idM) {
        $query = $this->db->query("SELECT * FROM DI d , materiel mat , modele mo, famille f , sousFamille sf  WHERE etat = 0 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
        return $query;
    }
    public

    function fetch_equip_panne_nn_repFamille($idM) {
        $query = $this->db->query("SELECT * FROM DI d  , modele mo, materiel mat , famille f , sousFamille sf  WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
        return $query;
    }
    public function   fetch_equip_panne_ANFamille($idM)
    {
        $query=$this->db->query("select * from DI d  , modele mo, materiel mat ,  famille f , sousFamille sf where etat = 7 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
    }
    public function fetch_equip_panne_en_maintFamille($idM)
    {
        $query=$this->db->query("select * from DI d  ,  modele mo, materiel mat ,  famille f , sousFamille sf where  etat = 6 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=sf.idSF and  sf.idF=f.idF and f.idF='$idM'");
         return $query;
    }


    /********   sous famille    ********/

    function fetch_equip_panneSF($idM) {
        $query = $this->db->query("SELECT * FROM DI d  , modele mo, materiel mat WHERE (etat = 1 OR etat = 2 OR etat=0 OR etat=3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
        return $query;

    }

    public

    function fetch_equip_panne_nn_maintSF($idM) {
        $query = $this->db->query("SELECT * FROM DI d ,modele mo , materiel mat WHERE (etat = 1 OR etat = 3 OR etat=8 OR etat=9) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
        return $query;
    }

    public

    function fetch_equip_panne_nn_affecSF($idM) {
        $query = $this->db->query("SELECT * FROM DI d , modele mo, materiel mat WHERE etat = 0 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
        return $query;
    }
    public

    function fetch_equip_panne_nn_repSF($idM) {
        $query = $this->db->query("SELECT * FROM DI d , modele mo, materiel mat WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71) and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
        return $query;
    }

    public function   fetch_equip_panne_ANSF($idM)
    {
        $query=$this->db->query("select * from DI d ,  modele mo, materiel mat where etat = 7 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
    }
    public function fetch_equip_panne_en_maintSF($idM)
    {
        $query=$this->db->query("select * from DI d ,  modele mo, materiel mat where  etat = 6 and d.numSerie=mat.numSerie and mat.idModele=mo.idModele and mo.idSF=$idM");
        return $query;
    }

    /**********   DATE  *********/

    function fetch_equip_panneDate($idM) {
        $query = $this->db->query("SELECT * FROM DI  WHERE (etat = 1 OR etat = 2 OR etat=0 OR etat=3 OR etat=8 OR etat=9) and date='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_maintDate($idM) {
        $query = $this->db->query("SELECT * FROM DI  WHERE (etat = 1 OR etat = 3 OR etat=8 OR etat=9) and date='$idM'");
        return $query;
    }

    public

    function fetch_equip_panne_nn_affecDate($idM) {
        $query = $this->db->query("SELECT * FROM DI   WHERE etat = 0 and date='$idM'");
        return $query;
    }
    public

    function fetch_equip_panne_nn_repDate($idM) {
        $query = $this->db->query("SELECT * FROM DI  WHERE (etat = 50 OR etat = 51 OR etat = 70 OR etat = 71) and date='$idM'");
        return $query;
    }

    public function   fetch_equip_panne_ANDate($idM)
    {
        $query=$this->db->query("select * from DI where etat = 7 and date='$idM'");
    }
    public function fetch_equip_panne_en_maintDate($idM)
    {
        $query=$this->db->query("select * from DI  where  etat = 6 and date='$idM'");
        return $query;
    }

    public function updateF($idF,$data)
    {
        $this->db->where('idF',$idF);
        $this->db->update('famille',$data);
    }

    public function updateSF($idSF,$data)
    {
        $this->db->where('idSF',$idSF);
        $this->db->update('sousFamille',$data);
    }

}
