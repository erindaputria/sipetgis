<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Vaksinasi_Model extends CI_Model {
    
    protected $table = 'input_vaksinasi';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save single vaksinasi record
     */
    public function save_vaksinasi($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get vaksinasi by kecamatan (untuk petugas)
     */
    public function get_vaksinasi_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all vaksinasi (untuk admin)
     */
    public function get_all_vaksinasi() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get by periode (tahun)
     */
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        $this->db->order_by('tanggal_vaksinasi', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all vaksinasi data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }

    /**
     * Sum total jumlah ternak yang divaksinasi by kecamatan 
     */
    public function sum_jumlah($kecamatan) {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get distinct komoditas by kecamatan
     */
    public function get_distinct_komoditas($kecamatan) {
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Cek apakah NIK sudah pernah digunakan
     */
    public function cek_nik_exists($nik, $kecamatan) {
        if (empty($nik)) return 0;
        
        $this->db->from($this->table);
        $this->db->where('nik', $nik);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun, $kecamatan) {
        $this->db->select("MONTH(tanggal_vaksinasi) as bulan, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak");
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal_vaksinasi)", $tahun);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->group_by("MONTH(tanggal_vaksinasi)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per kelurahan
     */
    public function get_statistik_per_kelurahan($kecamatan) {
        $this->db->select('kelurahan, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->group_by('kelurahan');
        $this->db->order_by('total_kasus', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}