<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_login($username, $password) {
        // Query untuk mengecek username dan password
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('level', 'admin'); // Hanya untuk level admin
        $query = $this->db->get('akses_pengguna');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('akses_pengguna');
        return $query->row();
    }
} 
?>