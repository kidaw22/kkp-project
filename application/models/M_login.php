<?php

class M_login extends CI_Model
{
    public function _logout()
    {
        $this->session->sess_destroy();
    }

    public function check_account($prm_nik = '', $prm_password = '')
    {

        $checkAccount = $this->db->select('id, Nama, usertype')
            ->from('warga')
            ->where(array('NIK' => $prm_nik, 'password' => md5($prm_password)))
            ->get();

        $return_value = [];

        if ($checkAccount->num_rows() > 0) {
            $session_data = [
                'user_id' => $checkAccount->row()->id,
                'user_name' => $checkAccount->row()->Nama,
                'usertype' => $checkAccount->row()->usertype,
                'login_stat' => true
            ];

            $this->session->set_userdata($session_data);

            $return_value = [
                'status' => 'success',
                'message' => 'Anda berhasil login!'
            ];
        } else {
            $return_value = [
                'status' => 'error',
                'message' => 'NIK atau kata sandi salah!'
            ];
        }

        return $return_value;
    }

    public function session_check()
    {
        @session_start();

        if (!$this->session->userdata('login_stat')) {
            $this->_logout();

            die('<span style="font: 9pt Sans, Verdana; font-weight: bold;">Logging Out...</span><script>location.replace("' . site_url('/login') . '");</script>');
        }
    }
}
