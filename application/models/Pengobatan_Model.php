<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengobatan_Model extends CI_Model {
    
    private $table = 'pengobatan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        // Pastikan mengambil semua kolom termasuk jenis_obat dan tahun
        $this->db->select('id_obat, nama_pengobatan, jenis_obat, tahun, bantuan_prov, keterangan');
        $this->db->order_by('id_obat', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id_obat', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id_obat', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id_obat', $id);
        return $this->db->delete($this->table);
    }
}