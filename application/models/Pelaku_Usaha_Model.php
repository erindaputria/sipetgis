<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaku_Usaha_Model extends CI_Model {
    
    private $table = 'pelaku_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    public function check_nik($nik) {
        $this->db->where('nik', $nik);
        return $this->db->get($this->table)->row();
    }
    
    public function check_nik_except($nik, $id) {
        $this->db->where('nik', $nik);
        $this->db->where('id !=', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function get_by_kecamatan($kecamatan) {
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('nama_peternak', 'ASC');
        return $this->db->get($this->table)->result();
    }
}