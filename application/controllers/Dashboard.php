<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['breadcrumb'] = 'Dashboard';
        $data['content'] = 'dashboard';
        $this->template->display('dashboard', $data);
    }
}
