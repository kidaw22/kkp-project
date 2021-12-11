<?php
class Kegiatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_kegiatan');

        $this->M_login->session_check();
    }

    public function index()
    {
        $data['breadcrumb'] = 'Jadwal';
        $data['content'] = 'transaksi/v_kegiatan';
        $this->template->display('dashboard', $data);
    }

    public function preview($prm_event_id = '', $prm_user_id = ''){
        $data['breadcrumb'] = 'Preview';
        $data['content'] = 'transaksi/v_kegiatan_preview';
        $data['event_id'] = $prm_event_id;
        $this->template->display('dashboard', $data);
    }

    public function getPreviewData($prm_event = ''){
        if($this->input->is_ajax_request()){
            $strQuery = "SELECT
                            (select Nama_Bantuan from bantuan where id = Judul_Kegiatan) as jenis_bantuan,
                            Deskripsi_Kegiatan,
                            date_format(Tanggal_Mulai, '%Y-%m-%d') as tanggal_pengambilan,
                            concat(date_format(Tanggal_Mulai, '%H:%i'), ' - ', date_format(Tanggal_Akhir, '%H:%i')) as jam_pengambilan,
                            Lokasi,
                            Deskripsi_Lokasi
                            from kegiatan
                            where id = $prm_event";

            $query = $this->db->query($strQuery);
            $return_value = $query->row();

            echo json_encode($return_value);
        }
    }

    public function getKegiatan()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->M_kegiatan->get_kegiatan();

            echo json_encode($data);
        }
    }

    public function saveKegiatan()
    {
        if ($this->input->is_ajax_request()) {
            $data = [
                'Judul_Kegiatan' => $this->input->post('Judul_Kegiatan'),
                'Deskripsi_Kegiatan' => $this->input->post('Deskripsi_Kegiatan'),
                'Tanggal_Mulai' => $this->input->post('Tanggal_Mulai'). ' ' .$this->input->post('time_start'),
                'Tanggal_Akhir' => $this->input->post('Tanggal_Akhir'). ' ' .$this->input->post('time_end'),
                'Lokasi' => $this->input->post('Lokasi'),
                'Deskripsi_Lokasi' => $this->input->post('Deskripsi_Lokasi'),
            ];

            if (trim($this->input->post('id')) === "") {
                $this->db->insert('kegiatan', $data);
                $header['ID'] = $this->db->insert_id();

                $message = "Sukses menambahkan data!";
            } else {
                $this->db->where(array('id' => $this->input->post('id')));
                $this->db->update('kegiatan', $data);
                $header['ID'] = $this->input->post('id');

                $message = "Sukses memperbarui data!";
            }

            $this->db->delete('kegiatan_peserta', array('Kegiatan_id' => $header['ID']));

            if (count($this->input->post('Peserta')) > 0) {
                for ($i = 0; $i < count($this->input->post('Peserta')); $i++) {
                    $detail[] = [
                        'Kegiatan_id' => $header['ID'],
                        'Warga_id' => $this->input->post('Peserta')[$i]
                    ];

                    if (trim($this->input->post('id')) === "") {
                        $notifikasi = [
                            'dari_warga_id' => $this->session->userdata('user_id'),
                            'untuk_warga_id' => $this->input->post('Peserta')[$i],
                            'pesan' => 'Selamat, anda terpilih mendapatkan bantuan!',
                            'url' => 'transaksi/kegiatan/preview/'.$header['ID'].'/'.$this->session->userdata('user_id'),
                            'tanggal' => date('Y-m-d')
                        ];
                        $this->db->insert('notifikasi', $notifikasi);
                    }
                }
                
                $this->db->insert_batch('kegiatan_peserta', $detail);
            }

            $return_value = array('status' => 'success', 'message' => $message);

            echo json_encode($return_value);
        }
    }

    public function getKegiatanDetail($prm_id = '')
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->M_kegiatan->get_kegiatan_detail($prm_id);

            echo json_encode($data);
        }
    }

    public function deleteKegiatan($prm_id = '')
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
            $type = $this->input->post('type');

            switch ($type) {
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
