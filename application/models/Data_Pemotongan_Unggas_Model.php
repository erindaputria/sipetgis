<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pemotongan_unggas_model extends CI_Model {
    
    protected $table = 'input_pemotongan_unggas';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all pemotongan unggas data
     */
    public function get_all_pemotongan() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        // Calculate totals for each row
        foreach ($results as &$row) {
            $row['total_ekor'] = $this->calculate_total_ekor($row);
            $row['total_berat'] = $this->calculate_total_berat($row);
            $row['komoditas_list'] = $this->generate_komoditas_list($row);
        }
        
        return $results;
    }
    
    /**
     * Get pemotongan by ID
     */
    public function get_pemotongan_by_id($id) {
        $this->db->from($this->table);
        $this->db->where('id_pemotongan', $id);
        $query = $this->db->get();
        
        $result = $query->row();
        
        if ($result) {
            $result->total_ekor = $this->calculate_total_ekor((array)$result);
            $result->total_berat = $this->calculate_total_berat((array)$result);
            $result->komoditas_list = $this->generate_komoditas_list((array)$result);
        }
        
        return $result;
    }
    
    /**
     * Calculate total ekor from all columns
     */
    private function calculate_total_ekor($data) {
        $total = 0;
        $columns = ['ayam', 'itik', 'dst']; // Add other columns as needed
        
        foreach ($columns as $col) {
            if (isset($data[$col]) && is_numeric($data[$col])) {
                $total += (int)$data[$col];
            }
        }
        
        return $total;
    }
    
    /**
     * Calculate total berat (assuming average weight per type)
     * Modify this based on your actual weight calculation logic
     */
    private function calculate_total_berat($data) {
        // This is a placeholder - adjust based on your actual weight calculation
        // You might need to join with a table that has weight per type
        $total = 0;
        $columns = ['ayam', 'itik', 'dst']; // Add other columns as needed
        
        foreach ($columns as $col) {
            if (isset($data[$col]) && is_numeric($data[$col])) {
                // Assuming average weight of 1.5 kg per bird - adjust as needed
                $total += (int)$data[$col] * 1.5;
            }
        }
        
        return $total;
    }
    
    /**
     * Generate komoditas list string for display
     */
    private function generate_komoditas_list($data) {
        $list = [];
        $columns = [
            'ayam' => 'Ayam',
            'itik' => 'Itik',
            'dst' => 'DST' // Add more as needed
        ];
        
        foreach ($columns as $col => $label) {
            if (isset($data[$col]) && $data[$col] > 0) {
                $list[] = $label . ': ' . $data[$col] . ' ekor';
            }
        }
        
        return implode(' | ', $list);
    }
    
    /**
     * Get pemotongan by periode (range tanggal)
     */
    public function get_by_periode($start_date, $end_date) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        foreach ($results as &$row) {
            $row['total_ekor'] = $this->calculate_total_ekor($row);
            $row['total_berat'] = $this->calculate_total_berat($row);
            $row['komoditas_list'] = $this->generate_komoditas_list($row);
        }
        
        return $results;
    }
    
    /**
     * Count all pemotongan data
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    /**
     * Sum total ekor
     */
    public function sum_total_ekor() {
        $this->db->select('COALESCE(SUM(ayam), 0) as total_ayam, 
                          COALESCE(SUM(itik), 0) as total_itik,
                          COALESCE(SUM(dst), 0) as total_dst');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        
        return ($result->total_ayam + $result->total_itik + $result->total_dst);
    }
    
    /**
     * Sum total berat (estimated)
     */
    public function sum_total_berat() {
        $this->db->select('COALESCE(SUM(ayam), 0) as total_ayam, 
                          COALESCE(SUM(itik), 0) as total_itik,
                          COALESCE(SUM(dst), 0) as total_dst');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        
        // Assuming average weights: ayam=1.5kg, itik=1.2kg, dst=1.0kg
        $total = ($result->total_ayam * 1.5) + 
                 ($result->total_itik * 1.2) + 
                 ($result->total_dst * 1.0);
        
        return $total;
    }
    
    /**
     * Get distinct petugas
     */
    public function get_distinct_petugas() {
        $this->db->distinct();
        $this->db->select('nama_petugas');
        $this->db->from($this->table);
        $this->db->where('nama_petugas IS NOT NULL');
        $this->db->where('nama_petugas !=', '');
        $this->db->order_by('nama_petugas', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get distinct RPU
     */
    public function get_distinct_rpu() {
        $this->db->distinct();
        $this->db->select('id_rpu');
        $this->db->from($this->table);
        $this->db->where('id_rpu IS NOT NULL');
        $this->db->order_by('id_rpu', 'ASC');
        $query = $this->db->get();
        
        // Get RPU names from another table if needed
        $results = $query->result_array();
        
        // You might want to join with RPU table to get names
        // This is a placeholder
        foreach ($results as &$row) {
            $row['nama_rpu'] = 'RPU ' . $row['id_rpu']; // Replace with actual name lookup
        }
        
        return $results;
    }
    
    /**
     * Delete pemotongan
     */
    public function delete_pemotongan($id) {
        $this->db->where('id_pemotongan', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get statistik per bulan
     */
    public function get_statistik_per_bulan($tahun) {
        $this->db->select("MONTH(tanggal) as bulan, 
            COUNT(*) as total_kegiatan, 
            COALESCE(SUM(ayam), 0) as total_ayam, 
            COALESCE(SUM(itik), 0) as total_itik,
            COALESCE(SUM(dst), 0) as total_dst");
        $this->db->from($this->table);
        $this->db->where("YEAR(tanggal)", $tahun);
        $this->db->group_by("MONTH(tanggal)");
        $this->db->order_by("bulan", "ASC");
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        // Calculate totals for each row
        foreach ($results as &$row) {
            $row['total_ekor'] = $row['total_ayam'] + $row['total_itik'] + $row['total_dst'];
            $row['total_berat'] = ($row['total_ayam'] * 1.5) + 
                                  ($row['total_itik'] * 1.2) + 
                                  ($row['total_dst'] * 1.0);
        }
        
        return $results;
    }
    
    /**
     * Get statistik per RPU
     */
    public function get_statistik_per_rpu() {
        $this->db->select('id_rpu, 
            COUNT(*) as total_kegiatan, 
            COALESCE(SUM(ayam), 0) as total_ayam, 
            COALESCE(SUM(itik), 0) as total_itik,
            COALESCE(SUM(dst), 0) as total_dst');
        $this->db->from($this->table);
        $this->db->group_by('id_rpu');
        $this->db->order_by('total_kegiatan', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        foreach ($results as &$row) {
            $row['total_ekor'] = $row['total_ayam'] + $row['total_itik'] + $row['total_dst'];
            $row['total_berat'] = ($row['total_ayam'] * 1.5) + 
                                  ($row['total_itik'] * 1.2) + 
                                  ($row['total_dst'] * 1.0);
            // You might want to add RPU name here
            $row['nama_rpu'] = 'RPU ' . $row['id_rpu']; // Replace with actual name
        }
        
        return $results;
    }
}
?>