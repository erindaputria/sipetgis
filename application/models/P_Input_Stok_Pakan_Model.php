<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_stok_pakan_model extends CI_Model {
    
    protected $table = 'input_stok_pakan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save single stok pakan record
     */
    public function save_stok_pakan($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get stok pakan by kecamatan (untuk petugas)
     */
    public function get_stok_pakan_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('input_stok_pakan.*, input_demplot.nama_demplot, input_demplot.kelurahan');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = input_stok_pakan.id_demplot', 'left');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->order_by('input_stok_pakan.tanggal', 'DESC');
        $this->db->order_by('input_stok_pakan.created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all stok pakan (untuk admin)
     */
    public function get_all_stok_pakan() {
        $this->db->select('input_stok_pakan.*, input_demplot.nama_demplot, input_demplot.kelurahan, input_demplot.kecamatan');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = input_stok_pakan.id_demplot', 'left');
        $this->db->order_by('input_stok_pakan.tanggal', 'DESC');
        $this->db->order_by('input_stok_pakan.created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get stok pakan by ID
     */
    public function get_stok_pakan_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_stok', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    /**
     * Get by periode (tahun)
     */
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('input_stok_pakan.*, input_demplot.nama_demplot, input_demplot.kelurahan');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = input_stok_pakan.id_demplot', 'left');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->where("YEAR(input_stok_pakan.tanggal)", $tahun);
        $this->db->order_by('input_stok_pakan.tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete stok pakan
     */
    public function delete_stok_pakan($id) {
        $this->db->where('id_stok', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Count all stok pakan data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = ' . $this->table . '.id_demplot');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }

    /**
     * Get total stok masuk by periode
     */
    public function total_stok_masuk($tahun, $kecamatan) {
        $this->db->select('SUM(stok_masuk) as total');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = ' . $this->table . '.id_demplot');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal)", $tahun);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }

    /**
     * Get total stok keluar by periode
     */
    public function total_stok_keluar($tahun, $kecamatan) {
        $this->db->select('SUM(stok_keluar) as total');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = ' . $this->table . '.id_demplot');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal)", $tahun);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get distinct jenis pakan by kecamatan
     */
    public function get_distinct_jenis_pakan($kecamatan) {
        $this->db->distinct();
        $this->db->select('jenis_pakan');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = ' . $this->table . '.id_demplot');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->where('jenis_pakan IS NOT NULL');
        $this->db->where('jenis_pakan !=', '');
        $this->db->order_by('jenis_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct merk pakan by kecamatan
     */
    public function get_distinct_merk_pakan($kecamatan) {
        $this->db->distinct();
        $this->db->select('merk_pakan');
        $this->db->from($this->table);
        $this->db->join('input_demplot', 'input_demplot.id_demplot = ' . $this->table . '.id_demplot');
        $this->db->where('input_demplot.kecamatan', $kecamatan);
        $this->db->where('merk_pakan IS NOT NULL');
        $this->db->where('merk_pakan !=', '');
        $this->db->order_by('merk_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}