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
        // Kolom yang ada di tabel input_rpu - menggunakan 'lokasi'
        $allowed_fields = array(
            'tanggal_rpu', 'pejagal', 'perizinan', 'tersedia_juleha', 
            'lokasi', 'kecamatan', 'kelurahan', 'rt', 'rw', 
            'latitude', 'longitude', 'nama_pj', 'nik_pj', 
            'telp_pj', 'nama_petugas', 'foto_kegiatan', 'keterangan'
        );
        
        $filtered_data = array();
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $filtered_data[$field] = $data[$field];
            }
        }
        
        $this->db->insert($this->table, $filtered_data);
        return $this->db->insert_id();
    }
    
    /**
     * Save komoditas data
     */
    public function save_komoditas($data) { 
        if (empty($data)) {
            return false;
        }
        return $this->db->insert_batch($this->table_komoditas, $data);
    }
    
    /**
     * Get RPU by kecamatan
     */
    public function get_rpu_by_kecamatan($kecamatan) {
        if (empty($kecamatan)) {
            return array();
        }
        
        $sql = "SELECT r.*, 
                GROUP_CONCAT(
                    DISTINCT k.komoditas
                    ORDER BY k.id
                    SEPARATOR '|'
                ) as komoditas_list,
                COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor,
                COALESCE(SUM(k.berat_kg), 0) as total_berat
                FROM " . $this->table . " r
                LEFT JOIN " . $this->table_komoditas . " k ON r.id = k.input_rpu_id
                WHERE r.kecamatan = ?
                GROUP BY r.id
                ORDER BY r.tanggal_rpu DESC, r.id DESC";
        
        $query = $this->db->query($sql, array($kecamatan));
        $result = $query->result_array();
        
        // Parse komoditas untuk ditampilkan sebagai badge
        foreach ($result as &$row) {
            $row['komoditas_badges'] = array();
            if (!empty($row['komoditas_list'])) {
                $row['komoditas_badges'] = explode('|', $row['komoditas_list']);
                // Filter empty values
                $row['komoditas_badges'] = array_filter($row['komoditas_badges']);
            }
        }
        
        return $result;
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
     * Get distinct komoditas by kecamatan
     */
    public function get_distinct_komoditas($kecamatan) {
        $sql = "SELECT DISTINCT k.komoditas 
                FROM " . $this->table_komoditas . " k
                JOIN " . $this->table . " r ON r.id = k.input_rpu_id
                WHERE r.kecamatan = ? AND k.komoditas IS NOT NULL AND k.komoditas != ''
                ORDER BY k.komoditas ASC";
        $query = $this->db->query($sql, array($kecamatan));
        return $query->result_array();
    }
    
    /**
     * Count all RPU data
     */
    public function count_all($kecamatan) {
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
    
    /**
     * Sum total ekor
     */
    public function sum_total_ekor($kecamatan) {
        $sql = "SELECT COALESCE(SUM(k.jumlah_ekor), 0) as total 
                FROM " . $this->table . " r
                LEFT JOIN " . $this->table_komoditas . " k ON r.id = k.input_rpu_id
                WHERE r.kecamatan = ?";
        $query = $this->db->query($sql, array($kecamatan));
        $result = $query->row();
        return (int)$result->total;
    }
    
    /**
     * Sum total berat
     */
    public function sum_total_berat($kecamatan) {
        $sql = "SELECT COALESCE(SUM(k.berat_kg), 0) as total 
                FROM " . $this->table . " r
                LEFT JOIN " . $this->table_komoditas . " k ON r.id = k.input_rpu_id
                WHERE r.kecamatan = ?";
        $query = $this->db->query($sql, array($kecamatan));
        $result = $query->row();
        return (float)$result->total;
    }
    
    /**
     * Cek NIK exists
     */
    public function cek_nik_exists($nik, $kecamatan) { 
        if (empty($nik)) return 0;
        $this->db->from($this->table);
        $this->db->where('nik_pj', $nik);
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->count_all_results();
    }
}
?>