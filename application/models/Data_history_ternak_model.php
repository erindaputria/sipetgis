<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_history_ternak_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_data()
    {
        // Pastikan mengambil id sebagai primary key
        $this->db->select('*');
        $this->db->from('input_jenis_usaha');
        $this->db->order_by('tanggal_input', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        // Debug: cek apakah id ada
        if (!empty($result)) {
            log_message('debug', 'First row ID: ' . ($result[0]->id ?? 'TIDAK ADA'));
        }
        
        return $result;
    }
    
    public function get_detail_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('input_jenis_usaha');
        return $query->row();
    }
    
    public function update_data($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('input_jenis_usaha', $data);
    }
    
    public function delete_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('input_jenis_usaha');
    }
}
?>