<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengajuan extends CI_Model
{
    private $_table = "pengajuan";

    public $id;
    public $jenis_bantuan;
    public $nama_lengkap;
    public $no_ktp;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat_ktp;
    public $alamat_domisili;
    public $status_tempat_tinggal;
    public $no_kk;
    public $jumlah_tanggungan;
    public $jumlah_kendaraan;

    public function rules()
    {
        return [
            ['field' => 'jenis_bantuan',
            'label' => 'Jenis Bantuan',
            'rules' => 'required'],

            ['field' => 'nama_lengkap',
            'label' => 'Nama Lengkap',
            'rules' => 'required'],
            
            ['field' => 'no_ktp',
            'label' => 'Nomor KTP',
            'rules' => 'numeric'],

            ['field' => 'tanggal_lahir',
            'label' => 'Tanggal Lahir',
            'rules' => 'date'],

            ['field' => 'jenis_kelamin',
            'label' => 'Jenis Kelamin',
            'rules' => 'required'],

            ['field' => 'alamat_ktp',
            'label' => 'Alamat KTP',
            'rules' => 'required'],

            ['field' => 'alamat_domisili',
            'label' => 'Alamat Domisili',
            'rules' => 'required'],

            ['field' => 'status_tempat_tinggal',
            'label' => 'Status Tempat Tinggal',
            'rules' => 'required'],

            ['field' => 'no_kk',
            'label' => 'Nomor KK',
            'rules' => 'numeric'],

            ['field' => 'jumlah_tanggungan',
            'label' => 'Jumlah Tanggungan',
            'rules' => 'numeric'],

            ['field' => 'jumlah_kendaraan',
            'label' => 'Jumlah Kendaraan',
            'rules' => 'numeric'],
        ];
    }

    public function getPengajuan()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function savePengajuan()
    {
        $post = $this->input->post();
        $this->product_id = uniqid();
        $this->name = $post["name"];
        $this->price = $post["price"];
        $this->description = $post["description"];
        return $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->product_id = $post["id"];
        $this->name = $post["name"];
        $this->price = $post["price"];
        $this->description = $post["description"];
        return $this->db->update($this->_table, $this, array('product_id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("product_id" => $id));
    }
}