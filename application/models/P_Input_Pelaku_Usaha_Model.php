<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Ambil semua data pelaku usaha
    public function get_all_pelaku_usaha() {
        $this->db->select('*');
        $this->db->from('input_pelaku_usaha'); // Sesuaikan dengan nama tabel di database
        $this->db->order_by('tanggal_input', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Ambil data untuk tabel (halaman utama)
    public function get_pelaku_usaha_for_table() {
        $this->db->select('nama_peternak, komoditas_ternak, jumlah_tambah, jumlah_kurang, tanggal_input');
        $this->db->from('input_pelaku_usaha'); // Sesuaikan dengan nama tabel di database
        $this->db->order_by('tanggal_input', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Simpan data pelaku usaha baru
    public function save_pelaku_usaha($data) {
        return $this->db->insert('input_pelaku_usaha', $data); // Sesuaikan dengan nama tabel di database
    }
    
    // Cek apakah tabel ada
    public function check_table_exists() {
        return $this->db->table_exists('input_pelaku_usaha');
    }
}