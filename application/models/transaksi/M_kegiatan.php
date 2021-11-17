<?php

class M_kegiatan extends CI_Model{
    public function get_kegiatan(){
        $strQuery = "SELECT id,
                        (select Nama_Bantuan from bantuan where Judul_Kegiatan = id) as title,
                        date_format(Tanggal_Mulai, '%Y-%m-%d') as start,
                        date_format(Tanggal_Akhir, '%Y-%m-%d') as end
                        from kegiatan";

        $query = $this->db->query($strQuery);
        $result = $query->result_array();

        return $result;
    }

    public function get_kegiatan_detail($prm_id = ''){
        $strQuery = "SELECT id,
                            Judul_Kegiatan,
                            Deskripsi_Kegiatan,
                            Lokasi,
                            Deskripsi_Lokasi,
                            date_format(Tanggal_Mulai, '%Y-%m-%d') as Tanggal_Mulai,
                            date_format(Tanggal_Akhir, '%Y-%m-%d') as Tanggal_Akhir
                            from kegiatan
                            where id = $prm_id";

        $query = $this->db->query($strQuery);
        $result = $query->row();

        $strQuery2 = "SELECT
                        Warga_id
                        from kegiatan_peserta
                        where Kegiatan_id = $prm_id";

        $query = $this->db->query($strQuery2);
        $detail = $query->result_array();

        $result->detail = $detail;

        return $result;
    }
}

?>