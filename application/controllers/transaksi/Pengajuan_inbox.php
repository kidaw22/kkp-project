<?php

class Pengajuan_inbox extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->M_login->session_check();
    }

    public function index()
    {
        $data['breadcrumb'] = '<b> Kotak Masuk </b>';
        $data['content'] = 'transaksi/v_pengajuan_inbox';

        $this->template->display('admin/dashboard', $data);
    }

    public function form($prm_id = '')
    {
        $data['breadcrumb'] = '<b> Kotak Masuk </b>';
        $data['content'] = 'transaksi/v_pengajuan_inbox_detail';
        $data['inbox_id'] = $prm_id;

        $this->template->display('admin/dashboard', $data);
    }

    public function getInbox($prm_id = '')
    {
        if ($this->input->is_ajax_request()) {
            $strQuery = "SELECT
                            a.id,
                            a.pengajuan_id,
                            b.warga_id,
                            b.nama_lengkap,
                            b.no_ktp,
                            b.tanggal_lahir,
                            b.jenis_kelamin,
                            b.alamat_ktp,
                            b.alamat_domisili,
                            b.status_tempat_tinggal,
                            b.no_kk,
                            (select Nama_Bantuan from bantuan where id = b.jenis_bantuan) as bantuan,
                            b.jumlah_tanggungan,
                            b.jumlah_kendaraan,
                            status,
                            a.catatan,
                            coalesce((select Nama from warga where id = b.approved_by), '-') as approved_by
                            from pengajuan_inbox a
                            left join pengajuan b
                            on a.pengajuan_id = b.id
                            where a.approver_id = '" . $this->session->userdata('user_id') . "'
                            ";

            if($prm_id !== ''){
                $strQuery .= " AND a.id = $prm_id ";
            }

            $strQuery .= "order by id desc";

            $query = $this->db->query($strQuery);
            $return_value = ($prm_id === "") ? $query->result_array() : $query->row();

            echo json_encode($return_value);
        }
    }

    public function approved(){
        if($this->input->is_ajax_request()){
            $data = [
                'tanggal_Disetujui' => date('Y-m-d'),
                'approved_By' => $this->session->userdata('user_id')
            ];

            $this->db->where(array('id' => $this->input->post('pengajuan_id')));
            $this->db->update('pengajuan', $data);

            $data = [
                'Status' => 'Disetujui',
                'Catatan' => $this->input->post('notes')
            ];

            $this->db->where(array('id' => $this->input->post('id')));
            $this->db->update('pengajuan_inbox', $data);

            $data = [
                'dari_warga_id' => $this->session->userdata('user_id'),
                'untuk_warga_id' => $this->input->post('warga_id'),
                'url' => 'transaksi/pengajuan_inbox/form/'.$this->input->post('id'),
                'pesan' => 'Pengajuan anda sudah disetujui!',
                'tanggal' => date('Y-m-d')
            ];

            $this->db->insert('notifikasi', $data);

            $return_value = array('status' => 'success', 'message' => 'Data berhasil disetujui!');
            echo json_encode($return_value);
        }
    }

    public function reject(){
        if($this->input->is_ajax_request()){
            $data = [
                'tanggal_Disetujui' => date('Y-m-d'),
                'approved_By' => $this->session->userdata('user_id')
            ];

            $this->db->where(array('id' => $this->input->post('pengajuan_id')));
            $this->db->update('pengajuan', $data);

            $data = [
                'Status' => 'Ditolak',
                'Catatan' => $this->input->post('notes')
            ];

            $this->db->where(array('id' => $this->input->post('id')));
            $this->db->update('pengajuan_inbox', $data);

            $data = [
                'dari_warga_id' => $this->session->userdata('user_id'),
                'untuk_warga_id' => $this->input->post('warga_id'),
                'url' => 'transaksi/pengajuan_inbox/form/'.$this->input->post('id'),
                'pesan' => 'Pengajuan anda ditolak!',
                'tanggal' => date('Y-m-d')
            ];

            $this->db->insert('notifikasi', $data);

            $return_value = array('status' => 'success', 'message' => 'Data berhasil ditolak!');

            echo json_encode($return_value);
        }
    }
}
