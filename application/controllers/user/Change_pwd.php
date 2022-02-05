<?php

class Change_pwd extends CI_Controller{
    public function __construct(){
        parent::__construct();

        $this->load->model('user/M_change_pwd');
    }

    public function index(){
        $data['breadcrumb'] = 'Ubah Kata Sandi';
        $data['content'] = 'user/v_change_pwd';
        $this->template->display('dashboard', $data);
    }

    public function savePassword(){
        if($this->input->is_ajax_request()){
            $user_id = $this->session->userdata('user_id');

            $check_old_password = $this->db->query("SELECT password from Warga where id = '$user_id'")->row('password');

            if($check_old_password === md5($this->input->post('old_password'))){
                $data = [
                    'password' => md5($this->input->post('new_password'))
                ];
    
                $where = [
                    'id' => $this->session->userdata('user_id')
                ];

                $this->db->where($where);
                $this->db->update('Warga', $data);

                if($this->db->affected_rows() > 0){
                    $return_value = [
                        'status' => 'success',
                        'message' => 'Ubah kata sandi sukses!'
                    ];
                }
            }else{
                $return_value = [
                    'status' => 'error',
                    'message' => 'Kata sandi lama salah!'
                ];
            }

            echo json_encode($return_value);
        }
    }
}

?>