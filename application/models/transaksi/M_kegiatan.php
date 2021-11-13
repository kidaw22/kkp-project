<?php

class M_kegiatan extends CI_Model{
    public function get_kegiatan(){
        $strQuery = "SELECT id,
                        NIK as nik,
                        Nama as name
                        from warga";

        $query = $this->db->query($strQuery);
        $result = $query->result_array();

        return $result;
    }

    public function get_kegiatan_detail($prm_id = ''){
        $strQuery = "SELECT *
                        from warga
                        where id = $prm_id";

        $query = $this->db->query($strQuery);
        $result = $query->row();

        return $result;
    }
}

?>