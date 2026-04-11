<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Demplot_Model extends CI_Model {
    
    protected $table = 'input_demplot';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all Demplot data
     */
    public function get_all_demplot() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id_demplot', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get Demplot by ID
     */
    public function get_demplot_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_demplot', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * Get Demplot by kecamatan
     */
    public function get_by_kecamatan($kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('id_demplot', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get Demplot by jenis hewan
     */
    public function get_by_jenis_hewan($jenis_hewan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('jenis_hewan', $jenis_hewan);
        $this->db->order_by('id_demplot', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get Demplot by luas range
     */
    public function get_by_luas_range($min_luas, $max_luas) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($min_luas !== null) {
            $this->db->where('luas_m2 >=', $min_luas);
        }
        if ($max_luas !== null) {
            $this->db->where('luas_m2 <=', $max_luas);
        }
        $this->db->order_by('id_demplot', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all Demplot data
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    /**
     * Sum total hewan
     */
    public function sum_total_hewan() {
        $this->db->select('COALESCE(SUM(jumlah_hewan), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total luas
     */
    public function sum_total_luas() {
        $this->db->select('COALESCE(SUM(luas_m2), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (float)$result->total : 0;
    }
    
    /**
     * Count distinct jenis hewan
     */
    public function count_distinct_jenis_hewan() {
        $this->db->distinct();
        $this->db->select('jenis_hewan');
        $this->db->from($this->table);
        $this->db->where('jenis_hewan IS NOT NULL');
        $this->db->where('jenis_hewan !=', '');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * Get distinct kecamatan
     */
    public function get_distinct_kecamatan() {
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from($this->table);
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct kelurahan
     */
    public function get_distinct_kelurahan() {
        $this->db->distinct();
        $this->db->select('kelurahan');
        $this->db->from($this->table);
        $this->db->where('kelurahan IS NOT NULL');
        $this->db->where('kelurahan !=', '');
        $this->db->order_by('kelurahan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct jenis hewan
     */
    public function get_distinct_jenis_hewan() {
        $this->db->distinct();
        $this->db->select('jenis_hewan');
        $this->db->from($this->table);
        $this->db->where('jenis_hewan IS NOT NULL');
        $this->db->where('jenis_hewan !=', '');
        $this->db->order_by('jenis_hewan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete Demplot
     */
    public function delete_demplot($id) {
        $this->db->where('id_demplot', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get statistik per kecamatan
     */
    public function get_statistik_per_kecamatan() {
        $this->db->select('kecamatan, 
            COUNT(*) as total_demplot, 
            COALESCE(SUM(jumlah_hewan), 0) as total_hewan, 
            COALESCE(SUM(luas_m2), 0) as total_luas');
        $this->db->from($this->table);
        $this->db->group_by('kecamatan');
        $this->db->order_by('total_demplot', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per jenis hewan
     */
    public function get_statistik_per_jenis_hewan() {
        $this->db->select('jenis_hewan, 
            COUNT(*) as total_demplot, 
            COALESCE(SUM(jumlah_hewan), 0) as total_hewan, 
            COALESCE(SUM(luas_m2), 0) as total_luas');
        $this->db->from($this->table);
        $this->db->where('jenis_hewan IS NOT NULL');
        $this->db->where('jenis_hewan !=', '');
        $this->db->group_by('jenis_hewan');
        $this->db->order_by('total_hewan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>