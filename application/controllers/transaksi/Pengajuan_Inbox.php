<?php

class Pengajuan_inbox extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->M_login->session_check();
    }

    public function index()
    {
        $data['breadcrumb'] = '<b> Kotak Masuk </b>';
        $data['content'] = 'transaksi/v_kegiatan_inbox';

        $this->template->display('admin/dashboard', $data);
    }

    public function form($prm_id = '')
    {
    }

    public function getInbox()
    {
        if ($this->input->is_ajax_request()) {
            $strQuery = "SELECT
                            a.id,
                            b.nama_lengkap,
                            b.no_ktp,
                            (select Nama_Bantuan from bantuan where id = b.jenis_bantuan) as bantuan,
                            b.jumlah_tanggungan,
                            b.jumlah_kendaraan,
                            status
                            from pengajuan_inbox a
                            left join pengajuan b
                            on a.pengajuan_id = b.id
                            where a.approver_id = '" . $this->session->userdata('user_id') . "'
                            order by id desc
                            ";

            $query = $this->db->query($strQuery);

            echo json_encode($query->result_array());
        }
    }
}
