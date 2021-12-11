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
        $this->template->display('dashboard', $data);
    }

    public function getNotifikasi(){
        if($this->input->is_ajax_request()){
            $user_id = $this->session->userdata('user_id');
            $strQuery = "SELECT
                            id,
                            pesan,
                            url
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
