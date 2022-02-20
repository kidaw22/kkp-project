<?php

class Laporan_warga extends CI_Controller{
    public function __construct(){
        parent::__construct();

        $this->load->model('laporan/M_laporan_warga');
    }

    public function index(){
        $data['breadcrumb'] = 'Laporan Warga';
        $data['content'] = 'laporan/v_laporan_warga';
        $this->template->display('dashboard', $data);
    }

    public function getWarga(){
        if($this->input->is_ajax_request()){
            $period_start = $this->input->post('period_start');
            $period_end =  $this->input->post('period_end');

            $warga = $this->M_laporan_warga->get_warga($period_start, $period_end);

            echo json_encode($warga);
        }
    }
}

?>