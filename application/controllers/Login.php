<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_login');
	}

	public function index()
	{
		$data['breadcrumb'] = 'Dashboard';
		$data['content'] = 'v_login';
		$this->load->view('v_login', $data);
	}

	public function check()
	{
		if ($this->input->is_ajax_request()) {
			$nik = $this->input->post('nik');
			$password = $this->input->post('password');

			$valid = $this->M_login->check_account($nik, $password);

			echo json_encode($valid);
		}
	}

	public function logout()
	{
		$session_ci = array('login_stat' => FALSE);
		$this->session->set_userdata($session_ci);
		$this->M_login->session_check();
	}
}
