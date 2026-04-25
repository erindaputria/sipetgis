<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_demplot_model extends CI_Model {
    
    protected $table = 'input_demplot';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save single demplot record
     */
    public function save_demplot($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get demplot by kecamatan (untuk petugas)
     */
    public function get_demplot_by_kecamatan($kecamatan) {
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
     * Get all demplot (untuk admin)
     */
    public function get_all_demplot() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get demplot by ID
     */
    public function get_demplot_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_demplot', $id);
        $query = $this->db->get();
        
        return $query->row_array();
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
     * Delete demplot
     */
    public function delete_demplot($id) {
        $this->db->where('id_demplot', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count all demplot data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }

    /**
     * Sum total luas lahan by kecamatan
     */
    public function sum_luas($kecamatan) {
        $this->db->select('SUM(luas_m2) as total');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (float)$result->total : 0;
    }
    
    /**
     * Sum total jumlah hewan by kecamatan
     */
    public function sum_jumlah_hewan($kecamatan) {
        $this->db->select('SUM(jumlah_hewan) as total');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get distinct jenis hewan by kecamatan
     */
    public function get_distinct_jenis_hewan($kecamatan) {
        $this->db->distinct();
        $this->db->select('jenis_hewan');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('jenis_hewan IS NOT NULL');
        $this->db->where('jenis_hewan !=', '');
        $this->db->order_by('jenis_hewan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}