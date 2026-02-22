<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_Klinik_Model extends CI_Model {
    
    protected $table = 'layanan_klinik';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        // Ambil semua data dari tabel
        $query = $this->db->get($this->table);
        $result = $query->result();
        
        // Jika tidak ada data, kembalikan array kosong
        if (empty($result)) {
            return [];
        }
        
        return $result;
    }
    
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id_layanan' => $id])->row();
    }
    
    public function insert($data) {
        // Tambahkan created_at dan updated_at
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        // Update updated_at
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id_layanan', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, ['id_layanan' => $id]);
    }
    
    public function check_nama($nama_layanan) {
        return $this->db->get_where($this->table, ['nama_layanan' => $nama_layanan])->num_rows() > 0;
    }
    
    public function check_nama_except($nama_layanan, $id) {
        $this->db->where('nama_layanan', $nama_layanan);
        $this->db->where('id_layanan !=', $id);
        return $this->db->get($this->table)->num_rows() > 0;
    }
    
    public function get_kategori_options() {
        return [
            'Grooming' => 'Grooming',
            'Penitipan' => 'Penitipan',
            'Vaksinasi' => 'Vaksinasi',
            'Bedah' => 'Bedah',
            'Sterilisasi' => 'Sterilisasi',
            'Perawatan' => 'Perawatan',
            'Diagnostik' => 'Diagnostik',
            'Emergensi' => 'Emergensi',
            'Lainnya' => 'Lainnya'
        ];
    }
}