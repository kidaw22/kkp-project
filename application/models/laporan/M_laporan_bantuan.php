<?php

class M_laporan_bantuan extends CI_Model{
    public function get_data($category, $start, $end){
        switch($category){
            case 'pengajuan':
                $strQuery = "SELECT
                                nama_lengkap as nama,
                                no_ktp as nik,
                                no_kk as kk,
                                (select Nama_Bantuan from bantuan where id = jenis_bantuan) as bantuan,
                                b.Status as status,
                                coalesce(tanggal_Disetujui, '') as date
                                from pengajuan a
                                inner join pengajuan_inbox b
                                on a.id = b.Pengajuan_Id
                                where tanggal_dibuat between '$start' and '$end'
                                and status != 'Baru'";
            break;

            case 'terpilih':
                $strQuery = "SELECT
                                c.Nama as nama,
                                c.NIK as nik,
                                c.No_KK as kk,
                                (select Nama_Bantuan from bantuan where id = Judul_Kegiatan) as bantuan,
                                'Terpilih' as status,
                                DATE_FORMAT(Tanggal_Mulai, '%Y-%m-%d') as date
                                from kegiatan a
                                inner join kegiatan_peserta b
                                on a.id = b.Kegiatan_id
                                inner join warga c
                                on c.id = b.Warga_id
                                where DATE_FORMAT(Tanggal_Mulai, '%Y-%M-%D') between '$start' and '$end'";
            break;
        }

        $query = $this->db->query($strQuery);

        return $query->result_array();
    }
}

?>