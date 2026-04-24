<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Jenis_Usaha_Model extends CI_Model {
    
    protected $table = 'input_jenis_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_jenis_usaha($data) {
        // Field yang diperbolehkan
        $allowed_fields = array(
            'nama_petugas', 
            'nama_peternak', 
            'nik', 
            'telepon', 
            'tanggal_input', 
            'keterangan', 
            'kecamatan', 
            'kelurahan', 
            'rt', 
            'rw', 
            'alamat',
            'latitude', 
            'longitude', 
            'foto_usaha', 
            'jenis_usaha', 
            'komoditas_ternak', 
            'jumlah',
            'jenis_kelamin'
        );
        
        $filtered_data = array();
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $filtered_data[$field] = $data[$field];
            }
        }
        
        // PASTIKAN JUMLAH ADALAH INTEGER
        if (isset($filtered_data['jumlah'])) {
            $filtered_data['jumlah'] = (int)$filtered_data['jumlah'];
        }
        
        return $this->db->insert($this->table, $filtered_data);
    }
    
    public function get_jenis_usaha_by_kecamatan($kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan); 
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_all_jenis_usaha($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(tanggal_input)", $tahun);
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function count_all($kecamatan = null) {
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results();
    }
    
    public function count_unique_pemilik($kecamatan = null) {
        $this->db->select('COUNT(DISTINCT nama_peternak) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total'] ?? 0;
    }
    
    public function sum_jumlah($kecamatan = null) {
        $this->db->select('SUM(jumlah) as total');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return (int)($result['total'] ?? 0);
    }
    
    public function get_total_ternak_saat_ini($kecamatan = null) {
        return $this->sum_jumlah($kecamatan);
    }
    
    public function get_statistik_jenis_usaha($kecamatan = null) {
        $this->db->select('jenis_usaha, SUM(jumlah) as total_jumlah');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('jenis_usaha');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_komoditas($kecamatan = null) {
        $this->db->select('komoditas_ternak, SUM(jumlah) as total_jumlah');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_statistik_per_kelurahan($kecamatan = null) {
        $this->db->select('kelurahan, COUNT(*) as total_usaha, SUM(jumlah) as total_jumlah');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->group_by('kelurahan');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_distinct_jenis_usaha($kecamatan) {
        $this->db->distinct();
        $this->db->select('jenis_usaha');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('jenis_usaha IS NOT NULL');
        $this->db->where('jenis_usaha !=', '');
        $this->db->order_by('jenis_usaha', 'ASC');
        return $this->db->get()->result_array();
    }
    
    public function get_distinct_komoditas($kecamatan) { 
        $this->db->distinct();
        $this->db->select('komoditas_ternak');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where('komoditas_ternak IS NOT NULL');
        $this->db->where('komoditas_ternak !=', '');
        $this->db->order_by('komoditas_ternak', 'ASC');
        return $this->db->get()->result_array();
    }
     
    public function check_table_exists() {
        return $this->db->table_exists($this->table);
    }
}
?>