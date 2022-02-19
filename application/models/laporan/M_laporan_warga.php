<?php

class M_laporan_warga extends CI_Model{
    public function get_warga($start = '', $end = ''){
        $strQuery = "SELECT
                        NIK,
                        Nama,
                        Alamat_KTP,
                        No_Telp,
                        Jenis_Kelamin,
                        Jenis_Pekerjaan,
                        Tanggal_Lahir,
                        Alamat_Domisili,
                        No_KK,
                        case when usertype = 1 then 'Admin' else 'User' end as usertype,
                        Jumlah_Tanggungan,
                        DATE_FORMAT(tanggal_dibuat, '%Y-%m-%d') as tanggal_dibuat
                        from warga
                        where tanggal_dibuat >= '$start' and tanggal_dibuat <= '$end'
                        ";
        
        $query = $this->db->query($strQuery);

        return $query->result_array();
    }
}

?>