<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Dashboard_Petugas_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Fungsi untuk mendapatkan ringkasan data
    public function get_ringkasan_data($kecamatan) {
        $result = array();
        
        // Total pengobatan
        $this->db->where('kecamatan', $kecamatan);
        $result['total_pengobatan'] = $this->db->count_all_results('input_pengobatan');
        
        // Total vaksinasi
        $this->db->where('kecamatan', $kecamatan);
        $result['total_vaksinasi'] = $this->db->count_all_results('input_vaksinasi');
        
        // Total pelaku usaha
        $this->db->where('kecamatan', $kecamatan);
        $result['total_pelaku_usaha'] = $this->db->count_all_results('input_pelaku_usaha');
        
        // Total ternak diobati
        $this->db->select('SUM(jumlah) as total');
        $this->db->where('kecamatan', $kecamatan);
        $query = $this->db->get('input_pengobatan');
        $result['total_ternak_diobati'] = $query->row()->total ?? 0;
        
        // Total ternak divaksin
        $this->db->select('SUM(jumlah) as total');
        $this->db->where('kecamatan', $kecamatan);
        $query = $this->db->get('input_vaksinasi');
        $result['total_ternak_divaksin'] = $query->row()->total ?? 0;
        
        return $result;
    }
}