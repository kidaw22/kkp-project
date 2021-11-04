<?php

class M_warga extends CI_Model{
    public function get_warga(){
        $strQuery = "SELECT id,
                        NIK as nik,
                        Nama as name
                        from warga";

        $query = $this->db->query($strQuery);
        $result = $query->result_array();

        return $result;
    }
}

?>