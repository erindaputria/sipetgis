<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha_Model extends CI_Model {
    
    protected $table = 'pelaku_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_pelaku_usaha($data) {
        // Debug: Log before insert
        log_message('debug', 'Attempting to insert data: ' . print_r($data, true));
        
        // Only save fields that exist in your table
        $allowed_fields = array('nama', 'nik', 'telepon', 'alamat', 'nama_petugas', 'tanggal_input', 'kecamatan', 'kelurahan', 'latitude', 'longitude', 'foto');
        $filtered_data = array();
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $filtered_data[$field] = $data[$field];
            }
        }
        
        // Insert data
        $result = $this->db->insert($this->table, $filtered_data);
        
        if (!$result) {
            log_message('error', 'Insert failed. Last query: ' . $this->db->last_query());
            log_message('error', 'DB Error: ' . print_r($this->db->error(), true));
        } else {
            log_message('debug', 'Insert successful. Insert ID: ' . $this->db->insert_id());
        }
        
        return $result;
    }
    
    public function get_pelaku_usaha_by_kecamatan($kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table); 
        $this->db->where('kecamatan', $kecamatan);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_all_pelaku_usaha($kecamatan = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_by_periode($tahun, $kecamatan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kecamatan', $kecamatan);
        $this->db->where("YEAR(created_at)", $tahun);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function count_all($kecamatan = null) {
        $this->db->from($this->table);
        if ($kecamatan) {
            $this->db->where('kecamatan', $kecamatan);
        }
        return $this->db->count_all_results();
    }
    
    public function check_nik($nik) {
        $this->db->where('nik', $nik);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
}
?>