<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_history_ternak_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('input_jenis_usaha');
        $this->db->order_by('tanggal_input', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_detail_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('input_jenis_usaha')->row();
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