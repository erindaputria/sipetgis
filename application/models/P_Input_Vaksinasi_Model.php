<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Vaksinasi_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Ambil semua data vaksinasi
    public function get_all_vaksinasi() {
        $this->db->select('*');
        $this->db->from('input_vaksinasi');
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Ambil data untuk tabel (halaman utama)
    public function get_vaksinasi_for_table() {
        $this->db->select('nama_peternak, komoditas_ternak, jenis_vaksinasi, jumlah, tanggal_vaksinasi');
        $this->db->from('input_vaksinasi');
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Simpan data vaksinasi baru
    public function save_vaksinasi($data) {
        return $this->db->insert('input_vaksinasi', $data);
    }
}
?>