<?php

class Pengumuman extends CI_Controller{
    public function __construct(){
        parent::__construct();

        $this->M_login->session_check();
    }

    public function index(){
        $data['breadcrumb'] = '<b> Pengumuman </b>';
        $data['content'] = 'transaksi/v_pengumuman';

        $this->template->display('partials/base_view', $data);
    }
}
