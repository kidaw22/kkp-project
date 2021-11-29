<?php

class NotFound extends CI_Controller
{
    public function index()
    {
        $this->load->view('errors/404_page');
    }
}
