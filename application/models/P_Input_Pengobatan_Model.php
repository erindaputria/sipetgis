<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pengobatan_Model extends CI_Model {
    
    protected $table = 'input_pengobatan';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_pengobatan() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengobatan', 'DESC'); 
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_pengobatan_for_table() {
        $this->db->select('id_obat, nama_peternak, komoditas_ternak, jenis_pengobatan, jumlah, tanggal_pengobatan, kelurahan, rt, rw, latitude, longitude, foto_pengobatan');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_all_for_datatable() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_pengobatan_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_obat', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function save_pengobatan($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update_pengobatan($id, $data) {
        $this->db->where('id_obat', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete_pengobatan($id) {
        $this->db->where('id_obat', $id);
        return $this->db->delete($this->table);
    }
    
    public function get_by_komoditas($komoditas) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('komoditas_ternak', $komoditas);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_by_kelurahan($kelurahan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kelurahan', $kelurahan);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_by_periode($tahun) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal_pengobatan)", $tahun);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_by_date_range($start_date, $end_date) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('tanggal_pengobatan >=', $start_date);
        $this->db->where('tanggal_pengobatan <=', $end_date);
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_with_coordinates() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('latitude IS NOT NULL');
        $this->db->where('latitude !=', '');
        $this->db->where('longitude IS NOT NULL');
        $this->db->where('longitude !=', '');
        $this->db->order_by('tanggal_pengobatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    public function sum_jumlah() {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function count_unique_peternak() {
        $this->db->select('COUNT(DISTINCT nama_peternak) as total');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function count_unique_kelurahan() {
        $this->db->select('COUNT(DISTINCT kelurahan) as total');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function get_kelurahan_list() {
        $this->db->select('DISTINCT kelurahan');
        $this->db->from($this->table);
        $this->db->where('kelurahan IS NOT NULL');
        $this->db->where('kelurahan !=', '');
        $this->db->order_by('kelurahan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_per_bulan($tahun = null) {
        $tahun = $tahun ?: date('Y');
        
        $this->db->select("MONTH(tanggal_pengobatan) as bulan, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak");
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal_pengobatan)", $tahun);
        $this->db->group_by("MONTH(tanggal_pengobatan)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_per_komoditas() {
        $this->db->select("komoditas_ternak, COUNT(*) as total_kasus, SUM(jumlah) as total_ternak");
        $this->db->from($this->table);
        $this->db->group_by("komoditas_ternak");
        $this->db->order_by("total_kasus", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
}