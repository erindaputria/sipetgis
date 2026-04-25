<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_pelaku_usaha_model extends CI_Model {
    
    protected $table = 'pelaku_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_pelaku_usaha($data) {
        // RAW QUERY - paling aman
        $sql = "INSERT INTO pelaku_usaha 
                (nama, nik, telepon, alamat, nama_petugas, tanggal_input, kecamatan, kelurahan, latitude, longitude, foto) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $values = array(
            $data['nama'],
            $data['nik'],
            isset($data['telepon']) ? $data['telepon'] : null,
            $data['alamat'],
            $data['nama_petugas'],
            isset($data['tanggal_input']) ? $data['tanggal_input'] : date('Y-m-d'),
            $data['kecamatan'],
            $data['kelurahan'],
            $data['latitude'],
            $data['longitude'],
            isset($data['foto']) ? $data['foto'] : null
        );
        
        $result = $this->db->query($sql, $values);
        
        if (!$result) {
            $error = $this->db->error();
            log_message('error', 'Insert failed: ' . print_r($error, true));
            return false;
        }
        
        return true;
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