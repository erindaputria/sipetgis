<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_pemotongan_unggas_model extends CI_Model {
    
    protected $table = 'input_pemotongan_unggas';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save single pemotongan record
     */
    public function save_pemotongan($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /** 
     * Get all pemotongan with JOIN to get RPU name
     */ 
    public function get_all_pemotongan() {
        $this->db->select('input_pemotongan_unggas.*, rpu.pejagal as nama_rpu');
        $this->db->from($this->table);
        $this->db->join('rpu', 'rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get pemotongan by ID
     */
    public function get_pemotongan_by_id($id) {
        $this->db->select('input_pemotongan_unggas.*, rpu.pejagal as nama_rpu');
        $this->db->from($this->table);
        $this->db->join('rpu', 'rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->where('id_pemotongan', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    /**
     * Get by periode (tahun)
     */
    public function get_by_periode($tahun) {
        $this->db->select('input_pemotongan_unggas.*, rpu.pejagal as nama_rpu');
        $this->db->from($this->table);
        $this->db->join('rpu', 'rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->where("YEAR(tanggal)", $tahun);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get by RPU ID
     */
    public function get_by_rpu($id_rpu) {
        $this->db->select('input_pemotongan_unggas.*, rpu.pejagal as nama_rpu');
        $this->db->from($this->table);
        $this->db->join('rpu', 'rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->where('id_rpu', $id_rpu);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get by daerah asal
     */
    public function get_by_daerah_asal($daerah_asal) {
        $this->db->select('input_pemotongan_unggas.*, rpu.pejagal as nama_rpu');
        $this->db->from($this->table);
        $this->db->join('rpu', 'rpu.id = input_pemotongan_unggas.id_rpu', 'left');
        $this->db->where('daerah_asal', $daerah_asal);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete pemotongan
     */
    public function delete_pemotongan($id) {
        $this->db->where('id_pemotongan', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count all pemotongan data
     */
    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Sum total ayam
     */
    public function sum_ayam() {
        $this->db->select('SUM(ayam) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total itik
     */
    public function sum_itik() {
        $this->db->select('SUM(itik) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total dst
     */
    public function sum_dst() {
        $this->db->select('SUM(dst) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total semua unggas
     */
    public function sum_total_unggas() {
        $this->db->select('SUM(ayam + itik + dst) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get distinct daerah asal
     */
    public function get_distinct_daerah_asal() {
        $this->db->distinct();
        $this->db->select('daerah_asal');
        $this->db->from($this->table);
        $this->db->where('daerah_asal IS NOT NULL');
        $this->db->where('daerah_asal !=', '');
        $this->db->order_by('daerah_asal', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all RPU/pejagal from rpu table
     */
    public function get_all_rpu() {
        if (!$this->db->table_exists('rpu')) {
            return array();
        }
        
        $this->db->select('*');
        $this->db->from('rpu');
        $this->db->order_by('pejagal', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}