<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Penjual_Model extends CI_Model {
    
    protected $table = 'penjual';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save penjual record
     */
    public function save_penjual($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /** 
     * Get penjual by kecamatan
     */
    public function get_penjual_by_kecamatan($kecamatan) {
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
     * Get all penjual (untuk admin)
     */
    public function get_all_penjual() {
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
     * Count all penjual data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Count by surat ijin status
     */
    public function count_surat_ijin($kecamatan, $status = 'Y') {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('surat_ijin', $status);
        return $this->db->count_all_results();
    }
    
    /**
     * Count by dagangan type
     */
    public function count_by_dagangan($kecamatan, $dagangan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('dagangan', $dagangan);
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
     * Get distinct dagangan by kecamatan
     */
    public function get_distinct_dagangan($kecamatan) {
        $this->db->distinct();
        $this->db->select('dagangan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('dagangan IS NOT NULL');
        $this->db->where('dagangan !=', '');
        $this->db->order_by('dagangan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get statistik per kelurahan
     */
    public function get_statistik_per_kelurahan($kecamatan) {
        $this->db->select('kelurahan, 
                          COUNT(*) as total_toko,
                          SUM(CASE WHEN surat_ijin = "Y" THEN 1 ELSE 0 END) as berijin,
                          SUM(CASE WHEN dagangan = "Obat" THEN 1 ELSE 0 END) as penjual_obat,
                          SUM(CASE WHEN dagangan = "Pakan" THEN 1 ELSE 0 END) as penjual_pakan,
                          SUM(CASE WHEN dagangan = "Peralatan" THEN 1 ELSE 0 END) as penjual_peralatan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->group_by('kelurahan');
        $this->db->order_by('total_toko', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}