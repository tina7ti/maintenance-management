<?php

    class DemA extends CI_Model
{
		public function select_tt_SF()
		{
			$query = $this->db->get('sousFamille');
			return $query;
		}
		public function selectnum_ges($mat)
		{
			$this->db->where('mat',$mat);
			$query = $this->db->get('gestionnaireStock');
			return $query;
		}
        public function insertDa ($data1)
        {
            $this->db->insert("DA",$data1);
        }
		public function selectnum_da()
		{
			$query = $this->db->query('SELECT numDA FROM DA WHERE numDA = (SELECT MAX(numDA) FROM DA)');
			return $query;
		}
    
    public function insertqteDa($data2)
    {
		$this->db->insert("qteDA",$data2);
        /*$numda=$this->db->query("select numDa from DA where dateDA=".date(y-m-d));
        foreach($data['idSF'] as $opt)
        {
        $this->db->insert("qteDA",$numda,$opt,$data['qte']);
    }*/
    }

        public function sel_lib_marq($marq)
        {
            $this->db->where('idMarque',$marq);
            $query = $this->db->get('marque');
            return $query;
    }

        public function sel_lib_mod($model)
        {
            $this->db->where('idModele',$model);
            $query = $this->db->get('modele');
            return $query;
    }
}
    
?>
