<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->M_login->session_check();
    }

    public function index()
    {
        $data['breadcrumb'] = 'Dashboard';
        $data['content'] = 'dashboard';

        $query_get_warga = $this->db->query("SELECT id from warga");
        $data['warga_count'] = $query_get_warga->num_rows();

        $prm_start_date = date('Y-m-01');
        $prm_end_date = date('Y-m-t');

        $query_get_kegiatan = $this->db->query("SELECT id
                                                from kegiatan
                                                where date_format(Tanggal_Mulai, '%Y-%m-%d') between '$prm_start_date' and '$prm_end_date'");
        $data['kegiatan_count'] = $query_get_kegiatan->num_rows();

        $query_get_pengajuan = $this->db->query("select id
                                                    from pengajuan_inbox
                                                    where status = 'Baru' and approver_id = '".$this->session->userdata('user_id')."'");
        $data['pengajuan_count'] = $query_get_pengajuan->num_rows();

        $this->template->display('dashboard', $data);
    }

    public function getNotifikasi(){
        if($this->input->is_ajax_request()){
            $user_id = $this->session->userdata('user_id');
            $strQuery = "SELECT
                            id,
                            pesan,
                            url,
                            coalesce(tanggal, '') as tanggal
                            from notifikasi
                            where untuk_warga_id = $user_id
                            and status = 'new'
                            order by id desc";
            
            $query = $this->db->query($strQuery);
            $return_value = $query->result_array();

            echo json_encode($return_value);
        }
    }
}
