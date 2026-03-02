<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Rpu_Model extends CI_Model {
    
    protected $table = 'input_rpu';
    protected $table_komoditas = 'input_rpu_komoditas';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Save RPU data
     */
    public function save_rpu($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Save komoditas data
     */
    public function save_komoditas($data) {
        return $this->db->insert_batch($this->table_komoditas, $data);
    }
    
    /**
     * Get RPU by ID with komoditas
     */
    public function get_rpu_by_id($id) {
        $this->db->select('r.*');
        $this->db->from($this->table . ' r');
        $this->db->where('r.id', $id);
        $rpu = $this->db->get()->row();
        
        if ($rpu) {
            // Get komoditas
            $this->db->select('*');
            $this->db->from($this->table_komoditas);
            $this->db->where('input_rpu_id', $id);
            $rpu->komoditas = $this->db->get()->result();
        }
        
        return $rpu;
    }
    
    /**
     * Get RPU by kecamatan (untuk petugas)
     */
    public function get_rpu_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $this->db->select('r.*, GROUP_CONCAT(CONCAT(k.komoditas, ":", k.jumlah_ekor, " ekor") SEPARATOR " | ") as komoditas_list');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all RPU (untuk admin)
     */
    public function get_all_rpu() {
        $this->db->select('r.*, GROUP_CONCAT(CONCAT(k.komoditas, ":", k.jumlah_ekor, " ekor") SEPARATOR " | ") as komoditas_list');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get by periode (tanggal range)
     */
    public function get_by_periode($start_date, $end_date, $kecamatan) {
        $this->db->select('r.*, GROUP_CONCAT(CONCAT(k.komoditas, ":", k.jumlah_ekor, " ekor") SEPARATOR " | ") as komoditas_list');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id', 'left');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->where('r.tanggal_rpu >=', $start_date);
        $this->db->where('r.tanggal_rpu <=', $end_date);
        $this->db->group_by('r.id');
        $this->db->order_by('r.tanggal_rpu', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Count all RPU data by kecamatan
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }

    /**
     * Sum total ekor by kecamatan
     */
    public function sum_total_ekor($kecamatan) {
        $this->db->select('SUM(k.jumlah_ekor) as total');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id');
        $this->db->where('r.kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (int)$result->total : 0;
    }
    
    /**
     * Sum total berat by kecamatan
     */
    public function sum_total_berat($kecamatan) {
        $this->db->select('SUM(k.berat_kg) as total');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id');
        $this->db->where('r.kecamatan', $kecamatan);
        $result = $this->db->get()->row();
        return $result->total ? (float)$result->total : 0;
    }
    
    /**
     * Get distinct komoditas by kecamatan
     */
    public function get_distinct_komoditas($kecamatan) {
        $this->db->distinct();
        $this->db->select('k.komoditas');
        $this->db->from($this->table_komoditas . ' k');
        $this->db->join($this->table . ' r', 'r.id = k.input_rpu_id');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->where('k.komoditas IS NOT NULL');
        $this->db->where('k.komoditas !=', '');
        $this->db->order_by('k.komoditas', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct pejagal by kecamatan
     */
    public function get_distinct_pejagal($kecamatan) {
        $this->db->distinct();
        $this->db->select('pejagal');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('pejagal IS NOT NULL');
        $this->db->where('pejagal !=', '');
        $this->db->order_by('pejagal', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Cek apakah NIK sudah pernah digunakan
     */
    public function cek_nik_exists($nik, $kecamatan) {
        if (empty($nik)) return 0;
        
        $this->db->from($this->table);
        $this->db->where('nik_pj', $nik);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun, $kecamatan) {
        $this->db->select("MONTH(r.tanggal_rpu) as bulan, COUNT(DISTINCT r.id) as total_kegiatan, SUM(k.jumlah_ekor) as total_ekor, SUM(k.berat_kg) as total_berat");
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id');
        $this->db->where("YEAR(r.tanggal_rpu)", $tahun);
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->group_by("MONTH(r.tanggal_rpu)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per kelurahan
     */
    public function get_statistik_per_kelurahan($kecamatan) {
        $this->db->select('r.kelurahan, COUNT(DISTINCT r.id) as total_kegiatan, SUM(k.jumlah_ekor) as total_ekor, SUM(k.berat_kg) as total_berat');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->group_by('r.kelurahan');
        $this->db->order_by('total_kegiatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get statistik per pejagal
     */
    public function get_statistik_per_pejagal($kecamatan) {
        $this->db->select('r.pejagal, COUNT(DISTINCT r.id) as total_kegiatan, SUM(k.jumlah_ekor) as total_ekor, SUM(k.berat_kg) as total_berat');
        $this->db->from($this->table . ' r');
        $this->db->join($this->table_komoditas . ' k', 'r.id = k.input_rpu_id');
        $this->db->where('r.kecamatan', $kecamatan);
        $this->db->group_by('r.pejagal');
        $this->db->order_by('total_kegiatan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>