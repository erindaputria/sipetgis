<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
    private $table_input_jenis_usaha = 'input_jenis_usaha';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Count total pelaku usaha (unique berdasarkan NIK)
     */
    public function count_pelaku_usaha() {
        $this->db->select('COUNT(DISTINCT nik) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Count total jenis ternak/komoditas (unique)
     */
    public function count_jenis_usaha() {
        $this->db->select('COUNT(DISTINCT komoditas_ternak) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->row();
        return (int)($result->total ?? 0);
    }
    
    /**
     * Get statistik per kecamatan dengan detail komoditas
     */
    public function get_statistik_per_kecamatan() {
        // Daftar semua kecamatan di Surabaya
        $kecamatan_list = $this->get_all_kecamatan();
        
        $result = [];
        $no = 1;
        
        foreach ($kecamatan_list as $kecamatan) {
            // Get data per kecamatan
            $row = $this->get_kecamatan_statistik($kecamatan);
            if ($row) {
                $row->no = $no++;
                $result[] = $row;
            }
        }
        
        return $result;
    }
    
    /**
     * Get statistik untuk satu kecamatan
     */
    public function get_kecamatan_statistik($kecamatan) {
        // Get all komoditas data for this kecamatan
        $this->db->select('komoditas_ternak, SUM(jumlah) as total_jumlah');
        $this->db->where('kecamatan', $kecamatan);
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $komoditas_data = $query->result();
        
        // If no data, skip this kecamatan (or return with zeros)
        if (empty($komoditas_data) && !$this->has_any_data($kecamatan)) {
            return null;
        }
        
        // Count unique peternak in this kecamatan
        $this->db->select('COUNT(DISTINCT nik) as jumlah_peternak');
        $this->db->where('kecamatan', $kecamatan);
        $peternak_query = $this->db->get($this->table_input_jenis_usaha);
        $jumlah_peternak = (int)($peternak_query->row()->jumlah_peternak ?? 0);
        
        // Initialize all komoditas with 0
        $komoditas = [
            'Sapi Potong' => 0,
            'Sapi Perah' => 0,
            'Kambing' => 0,
            'Domba' => 0,
            'Ayam Buras' => 0,
            'Ayam Broiler' => 0,
            'Ayam Layer' => 0,
            'Itik' => 0,
            'Angsa' => 0,
            'Kalkun' => 0,
            'Burung' => 0,
            'Kerbau' => 0,
            'Kuda' => 0
        ];
        
        // Fill with actual data
        foreach ($komoditas_data as $kd) {
            $komoditas_name = trim($kd->komoditas_ternak);
            if (isset($komoditas[$komoditas_name])) {
                $komoditas[$komoditas_name] = (int)$kd->total_jumlah;
            }
        }
        
        return (object)array_merge(
            ['kecamatan' => $kecamatan, 'jumlah_peternak' => $jumlah_peternak],
            $komoditas
        );
    }
    
    /**
     * Check if kecamatan has any data
     */
    private function has_any_data($kecamatan) {
        $this->db->where('kecamatan', $kecamatan);
        return $this->db->get($this->table_input_jenis_usaha)->num_rows() > 0;
    }
    
    /**
     * Get all kecamatan list
     */
    public function get_all_kecamatan() {
        return [
            'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
            'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
            'Karang Pilang', 'Kenjeran', 'Krembangan', 'Lakarsantri',
            'Mulyorejo', 'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep',
            'Sawahan', 'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal',
            'Tambaksari', 'Tandes', 'Tegalsari', 'Tenggilis Mejoyo',
            'Wiyung', 'Wonocolo', 'Wonokromo'
        ];
    }
    
    /**
     * Get total per komoditas (untuk footer/total keseluruhan)
     */
    public function get_total_per_komoditas() {
        $this->db->select('komoditas_ternak, SUM(jumlah) as total');
        $this->db->group_by('komoditas_ternak');
        $query = $this->db->get($this->table_input_jenis_usaha);
        $result = $query->result();
        
        $totals = [
            'Sapi Potong' => 0,
            'Sapi Perah' => 0,
            'Kambing' => 0,
            'Domba' => 0,
            'Ayam Buras' => 0,
            'Ayam Broiler' => 0,
            'Ayam Layer' => 0,
            'Itik' => 0,
            'Angsa' => 0,
            'Kalkun' => 0,
            'Burung' => 0,
            'Kerbau' => 0,
            'Kuda' => 0
        ];
        
        foreach ($result as $row) {
            $komoditas_name = trim($row->komoditas_ternak);
            if (isset($totals[$komoditas_name])) {
                $totals[$komoditas_name] = (int)$row->total;
            }
        }
        
        return $totals;
    }
    
    /**
     * Get total peternak keseluruhan
     */
    public function get_total_peternak() {
        $this->db->select('COUNT(DISTINCT nik) as total');
        $query = $this->db->get($this->table_input_jenis_usaha);
        return (int)($query->row()->total ?? 0);
    }
}
?>