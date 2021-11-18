<?php
class Bantuan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('master_data/M_bantuan');

        $this->M_login->session_check();
    }

    public function index()
	{
        $data['breadcrumb'] = 'Bantuan';
        $data['content'] = 'master_data/v_bantuan';
		$this->template->display('dashboard', $data);
	}

    public function getBantuan(){
        if($this->input->is_ajax_request()){
            $data = $this->M_bantuan->get_bantuan();

            echo json_encode($data);
        }
    }

    public function saveBantuan(){
        if($this->input->is_ajax_request()){
            $data = [
                'Nama_Bantuan' => $this->input->post('Nama_Bantuan'),
                'Periode_Dari' => $this->input->post('Periode_Dari'),
                'Periode_Sampai' => $this->input->post('Periode_Sampai')
            ];

            if(trim($this->input->post('id')) === ""){
                $this->db->insert('bantuan', $data);
                $message = "Sukses menambahkan data!";
            }else{
                $this->db->where(array('id' => $this->input->post('id')));
                $this->db->update('bantuan', $data);

                $message = "Sukses memperbarui data!";
            }
            $return_value = array('status' => 'success', 'message' => $message);

            echo json_encode($return_value);
        }
    }

    public function getBantuanDetail($prm_id = ''){
        if($this->input->is_ajax_request()){
            $data = $this->M_bantuan->get_bantuan_detail($prm_id);

            echo json_encode($data);
        }
    }

    public function deleteBantuan($prm_id = ''){
        if($this->input->is_ajax_request()){
            $this->db->delete('bantuan', array('id' => $prm_id));

            $return_value = array('status' => 'success', 'message' => 'Sukses menghapus data!');

            echo json_encode($return_value);
        }
    }
}
