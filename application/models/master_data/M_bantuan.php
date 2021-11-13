<?php

class M_bantuan extends CI_Model{
    public function get_bantuan(){
        $strQuery = "SELECT id,
                        Nama_Bantuan as Nama_Bantuan,
                        Periode_Dari as Periode_Dari,
                        Periode_Sampai as Periode_Sampai
                        from bantuan";

        $query = $this->db->query($strQuery);
        $result = $query->result_array();

        return $result;
    }

    public function get_bantuan_detail($prm_id = ''){
        $strQuery = "SELECT *
                        from bantuan
                        where id = $prm_id";

        $query = $this->db->query($strQuery);
        $result = $query->row();

        return $result;
    }
}

?>