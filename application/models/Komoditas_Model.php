<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas_Model extends CI_Model {
    
    private $table = 'komoditas';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->order_by('nama_komoditas', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id_komoditas', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id_komoditas', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id_komoditas', $id);
        return $this->db->delete($this->table);
    }
    
    public function check_nama($nama_komoditas) {
        $this->db->where('nama_komoditas', $nama_komoditas);
        return $this->db->get($this->table)->row();
    }
    
    public function check_nama_except($nama_komoditas, $id) {
        $this->db->where('nama_komoditas', $nama_komoditas);
        $this->db->where('id_komoditas !=', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function get_by_jenis($jenis) {
        $this->db->where('jenis_hewan', $jenis);
        $this->db->order_by('nama_komoditas', 'ASC');
        return $this->db->get($this->table)->result();
    }
}