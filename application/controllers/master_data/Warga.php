<?php
class Warga extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('master_data/M_warga');
    }

    public function index()
	{
        $data['breadcrumb'] = 'Warga';
        $data['content'] = 'master_data/v_warga';
		$this->template->display('dashboard', $data);
	}

    public function getWarga(){
        if($this->input->is_ajax_request()){
            $data = $this->M_warga->get_warga();

            echo json_encode($data);
        }
    }

    public function saveWarga(){
        if($this->input->is_ajax_request()){
            $data = [
                'NIK' => $this->input->post('nik'),
                'Nama' => $this->input->post('nama'),
                'Alamat_KTP' => $this->input->post('Alamat_KTP'),
                'No_Telp' => $this->input->post('No_Telp'),
                'No_BPJS' => $this->input->post('No_BPJS'),
                'No_NPWP' => $this->input->post('No_NPWP'),
                'Tanggal_Lahir' => $this->input->post('Tanggal_Lahir'),
                'Alamat_Domisili' => $this->input->post('Alamat_Domisili'),
                'No_KK' => $this->input->post('No_KK')
            ];

            if(trim($this->input->post('id')) === ""){
                $this->db->insert('warga', $data);
                $message = "Sukses menambahkan data!";
            }else{
                $this->db->where(array('id' => $this->input->post('id')));
                $this->db->update('warga', $data);

                $message = "Sukses memperbarui data!";
            }
            $return_value = array('status' => 'success', 'message' => $message);

            echo json_encode($return_value);
        }
    }

    public function getWargaDetail($prm_id = ''){
        if($this->input->is_ajax_request()){
            $data = $this->M_warga->get_warga_detail($prm_id);

            echo json_encode($data);
        }
    }

    public function deleteWarga($prm_id = ''){
        if($this->input->is_ajax_request()){
            $this->db->delete('warga', array('id' => $prm_id));

            $return_value = array('status' => 'success', 'message' => 'Sukses menghapus data!');

            echo json_encode($return_value);
        }
    }
}
?>
