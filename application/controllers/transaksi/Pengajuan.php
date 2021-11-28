<?php
class Pengajuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_pengajuan');

        $this->M_login->session_check();
    }

    public function index()
    {
        $data['breadcrumb'] = 'Form Pengajuan Bantuan';
        $data['content'] = 'transaksi/v_pengajuan';
        $this->template->display('dashboard', $data);
    }

    public function getPengajuan()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->M_pengajuan->get_pengajuan();

            echo json_encode($data);
        }
    }

    public function savePengajuan()
    {
        if ($this->input->is_ajax_request()) {
            $data = [
                'jenis_bantuan' => $this->input->post('jenis_bantuan'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'no_ktp' => $this->input->post('no_ktp'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat_ktp' => $this->input->post('alamat_ktp'),
                'alamat_domisili' => $this->input->post('alamat_domisili'),
                'status_tempat_tinggal' => $this->input->post('status_tempat_tinggal'),
                'no_kk' => $this->input->post('no_kk'),
                'jumlah_tanggungan' => $this->input->post('jumlah_tanggungan'),
                'jumlah_kendaraan' => $this->input->post('jumlah_kendaraan'),
                'warga_id' => $this->input->post('warga_id'),
                'tanggal_dibuat' => date('Y-m-d'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $this->db->insert('pengajuan', $data);
            $header['ID'] = $this->db->insert_id();

            $get_admin = $this->db->query("SELECT id from warga where usertype = 1");

            foreach ($get_admin->result() as $row) {
                $inbox[] = [
                    'Pengajuan_Id' => $header['ID'],
                    'Approver_Id' => $row->id
                ];
            }

            $this->db->insert_batch('pengajuan_inbox', $inbox);

            $return_value = array('status' => 'success', 'message' => "Pengajuan Anda Akan Di Proses!");

            echo json_encode($return_value);
        }
    }

    public function getPengajuanDetail($prm_id = '')
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->M_pengajuan->get_pengajuan_detail($prm_id);

            echo json_encode($data);
        }
    }

    public function deletePengajuan($prm_id = '')
    {
        if ($this->input->is_ajax_request()) {
            $this->db->delete('kegiatan_peserta', array('Kegiatan_id' => $prm_id));

            $this->db->delete('kegiatan', array('id' => $prm_id));

            $return_value = array('status' => 'success', 'message' => 'Sukses menghapus data!');

            echo json_encode($return_value);
        }
    }

    public function getCombo()
    {
        if ($this->input->is_ajax_request()) {
            switch ($this->input->post('type')) {
                case 'bantuan':
                    $strQuery = "SELECT id as combo_key,
                                        Nama_Bantuan as combo_name
                                        from bantuan";
                    break;
            }

            $query = $this->db->query($strQuery);
            $return_value = $query->result_array();

            echo json_encode($return_value);
        }
    }

    public function getWarga($prm_nik = ''){
        if($this->input->is_ajax_request()){
            $strQuery = "SELECT id,
                                Nama,
                                jenis_kelamin,
                                tanggal_lahir,
                                alamat_KTP,
                                No_KK
                                from warga
                                where NIK = $prm_nik";

            $query = $this->db->query($strQuery);
            $return_value = $query->row();

            echo json_encode($return_value);
        }
    }
}
