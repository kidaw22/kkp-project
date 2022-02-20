<?php

class Laporan_bantuan extends CI_Controller{
    public function __construct(){
        parent::__construct();

        $this->load->model('laporan/M_laporan_bantuan');
    }

    public function index(){
        $data['breadcrumb'] = 'Laporan Bantuan';
        $data['content'] = 'laporan/v_laporan_bantuan';
        $this->template->display('dashboard', $data);
    }

    public function getData(){
        if($this->input->is_ajax_request()){
            $category = $this->input->post('category');
            $period_start = $this->input->post('period_start');
            $period_end =  $this->input->post('period_end');

            $data = $this->M_laporan_bantuan->get_data($category, $period_start, $period_end);

            echo json_encode($data);
        }
    }
}

?>