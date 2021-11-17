<?php
class Kegiatan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_kegiatan');
    }

    public function index()
	{
        $data['breadcrumb'] = 'Kegiatan';
        $data['content'] = 'transaksi/v_kegiatan';
		$this->template->display('dashboard', $data);
	}

    public function getKegiatan(){
        if($this->input->is_ajax_request()){
            $data = $this->M_kegiatan->get_kegiatan();

            echo json_encode($data);
        }
    }

    public function saveKegiatan(){
        if($this->input->is_ajax_request()){
            $data = [
                'Judul_Kegiatan' => $this->input->post('Judul_Kegiatan'),
                'Deskripsi_Kegiatan' => $this->input->post('Deskripsi_Kegiatan'),
                'Tanggal_Mulai' => $this->input->post('Tanggal_Mulai'),
                'Tanggal_Akhir' => $this->input->post('Tanggal_Akhir'),
                'Lokasi' => $this->input->post('Lokasi'),
                'Deskripsi_Lokasi' => $this->input->post('Deskripsi_Lokasi'),
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

    public function getKegiatanDetail($prm_id = ''){
        if($this->input->is_ajax_request()){
            $data = $this->M_kegiatan->get_kegiatan_detail($prm_id);

            echo json_encode($data);
        }
    }

    public function deleteKegiatan($prm_id = ''){
        if($this->input->is_ajax_request()){
            $this->db->delete('warga', array('id' => $prm_id));

            $return_value = array('status' => 'success', 'message' => 'Sukses menghapus data!');

            echo json_encode($return_value);
        }
    }

    public function getCombo(){
        if($this->input->is_ajax_request()){
            $type = $this->input->post('type');

            switch($type){
                case 'warga':
                    $strQuery = "select
                                    id as combo_key,
                                    Nama as combo_name
                                    from warga";
                break;

                case 'bantuan':
                    $strQuery = "select
                                    id as combo_key,
                                    Nama_Bantuan as combo_name
                                    from bantuan";
                    break;
            }

            $query = $this->db->query($strQuery);
            $return_value = $query->result_array();

            echo json_encode($return_value);
        }
    }
}
