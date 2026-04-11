<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Stok_Pakan_Model extends CI_Model {
    
    protected $table = 'input_stok_pakan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all stok pakan data
     */
    public function get_all_stok() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get stok pakan by ID
     */
    public function get_stok_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('id_stok', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * Get stok pakan by periode (range tanggal)
     */
    public function get_by_periode($start_date, $end_date) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get stok pakan by jenis pakan
     */
    public function get_by_jenis_pakan($jenis_pakan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('jenis_pakan', $jenis_pakan);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get stok pakan by merk pakan
     */
    public function get_by_merk_pakan($merk_pakan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('merk_pakan', $merk_pakan);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get stok pakan by id_demplot
     */
    public function get_by_demplot($id_demplot) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_demplot', $id_demplot);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all stok pakan data
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    /**
     * Sum total stok awal
     */
    public function sum_stok_awal() {
        $this->db->select('COALESCE(SUM(stok_awal), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total stok masuk
     */
    public function sum_stok_masuk() {
        $this->db->select('COALESCE(SUM(stok_masuk), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total stok keluar
     */
    public function sum_stok_keluar() {
        $this->db->select('COALESCE(SUM(stok_keluar), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total stok akhir
     */
    public function sum_stok_akhir() {
        $this->db->select('COALESCE(SUM(stok_akhir), 0) as total');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Get current stok by jenis pakan (latest record per jenis)
     */
    public function get_current_stok_per_jenis() {
        $this->db->select('jenis_pakan, merk_pakan, id_demplot, stok_akhir, tanggal');
        $this->db->from($this->table);
        $this->db->where_in('id_stok', 'SELECT MAX(id_stok) FROM ' . $this->table . ' GROUP BY jenis_pakan, merk_pakan, id_demplot', FALSE);
        $this->db->order_by('jenis_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct jenis pakan
     */
    public function get_distinct_jenis_pakan() {
        $this->db->distinct();
        $this->db->select('jenis_pakan');
        $this->db->from($this->table);
        $this->db->where('jenis_pakan IS NOT NULL');
        $this->db->where('jenis_pakan !=', '');
        $this->db->order_by('jenis_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct merk pakan
     */
    public function get_distinct_merk_pakan() {
        $this->db->distinct();
        $this->db->select('merk_pakan');
        $this->db->from($this->table);
        $this->db->where('merk_pakan IS NOT NULL');
        $this->db->where('merk_pakan !=', '');
        $this->db->order_by('merk_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct id_demplot
     */
    public function get_distinct_demplot() {
        $this->db->distinct();
        $this->db->select('id_demplot');
        $this->db->from($this->table);
        $this->db->where('id_demplot IS NOT NULL');
        $this->db->order_by('id_demplot', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Delete stok pakan
     */
    public function delete_stok($id) {
        $this->db->where('id_stok', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun) {
        $this->db->select("MONTH(tanggal) as bulan, 
            COUNT(*) as total_transaksi, 
            COALESCE(SUM(stok_masuk), 0) as total_masuk, 
            COALESCE(SUM(stok_keluar), 0) as total_keluar,
            COALESCE(SUM(stok_akhir), 0) as total_akhir");
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal)", $tahun);
        $this->db->group_by("MONTH(tanggal)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get statistik per jenis pakan
     */
    public function get_statistik_per_jenis() {
        $this->db->select('jenis_pakan, 
            COUNT(*) as total_transaksi, 
            COALESCE(SUM(stok_masuk), 0) as total_masuk, 
            COALESCE(SUM(stok_keluar), 0) as total_keluar,
            COALESCE(SUM(stok_akhir), 0) as total_akhir');
        $this->db->from($this->table);
        $this->db->group_by('jenis_pakan');
        $this->db->order_by('total_transaksi', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get statistik per merk pakan
     */
    public function get_statistik_per_merk() {
        $this->db->select('merk_pakan, 
            COUNT(*) as total_transaksi, 
            COALESCE(SUM(stok_masuk), 0) as total_masuk, 
            COALESCE(SUM(stok_keluar), 0) as total_keluar,
            COALESCE(SUM(stok_akhir), 0) as total_akhir');
        $this->db->from($this->table);
        $this->db->group_by('merk_pakan');
        $this->db->order_by('total_transaksi', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get statistik per demplot
     */
    public function get_statistik_per_demplot() {
        $this->db->select('id_demplot, 
            COUNT(*) as total_transaksi, 
            COALESCE(SUM(stok_masuk), 0) as total_masuk, 
            COALESCE(SUM(stok_keluar), 0) as total_keluar,
            COALESCE(SUM(stok_akhir), 0) as total_akhir');
        $this->db->from($this->table);
        $this->db->group_by('id_demplot');
        $this->db->order_by('total_transaksi', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        // Add demplot name if needed (join with demplot table)
        foreach ($results as &$row) {
            $row['nama_demplot'] = 'Demplot ' . $row['id_demplot']; // Replace with actual name lookup
        }
        
        return $results;
    }
    
    /**
     * Get stok opname summary (per jenis/merk)
     */
    public function get_stok_opname_summary() {
        $this->db->select('jenis_pakan, merk_pakan, id_demplot, 
            SUM(stok_masuk) as total_masuk,
            SUM(stok_keluar) as total_keluar,
            (SELECT stok_akhir FROM ' . $this->table . ' t2 
             WHERE t2.jenis_pakan = t1.jenis_pakan 
             AND t2.merk_pakan = t1.merk_pakan 
             AND t2.id_demplot = t1.id_demplot 
             ORDER BY t2.tanggal DESC, t2.id_stok DESC LIMIT 1) as stok_akhir_terkini');
        $this->db->from($this->table . ' t1');
        $this->db->group_by('jenis_pakan, merk_pakan, id_demplot');
        $this->db->order_by('jenis_pakan', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}
?>