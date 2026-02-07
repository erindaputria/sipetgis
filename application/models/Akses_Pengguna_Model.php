<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses_Pengguna_Model extends CI_Model {
    
    private $table = 'akses_pengguna';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        // Ubah 'id' menjadi 'id_user' sesuai dengan struktur tabel
        $this->db->select('id_user as id, username, password, level, telepon, kecamatan, status');
        $this->db->order_by('id_user', 'ASC'); // Order by id_user
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id_user', $id);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id_user', $id);
        return $this->db->delete($this->table);
    }
    
    public function check_username($username) {
        $this->db->where('username', $username);
        return $this->db->get($this->table)->row();
    }
}