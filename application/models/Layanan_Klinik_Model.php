<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_klinik_model extends CI_Model {
    
    protected $table = 'layanan_klinik';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->order_by('id_layanan', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id_layanan' => $id])->row();
    }
    
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
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
}
?>