<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Klinik_Hewan_Model extends CI_Model {
    
    protected $table = 'input_klinik_hewan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save klinik hewan record
     */
    public function save_klinik($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get klinik by kecamatan (untuk petugas)
     */
    public function get_klinik_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all klinik (untuk admin)
     */
    public function get_all_klinik() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'DESC');
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
        $this->db->where("YEAR(created_at)", $tahun);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all klinik data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Get distinct kelurahan by kecamatan
     */
    public function get_distinct_kelurahan($kecamatan) {
        $this->db->distinct();
        $this->db->select('kelurahan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('kelurahan IS NOT NULL');
        $this->db->where('kelurahan !=', '');
        $this->db->order_by('kelurahan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct jenis layanan by kecamatan
     */
    public function get_distinct_jenis_layanan($kecamatan) {
        $this->db->distinct();
        $this->db->select('jenis_layanan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('jenis_layanan IS NOT NULL');
        $this->db->where('jenis_layanan !=', '');
        $this->db->order_by('jenis_layanan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get total jumlah dokter by kecamatan
     */
    public function sum_jumlah_dokter($kecamatan) {
        $this->db->select('SUM(jumlah_dokter) as total');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
}