<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepemilikan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jenis_usaha() {
        $this->db->distinct();
        $this->db->select('jenis_usaha');
        $this->db->from('input_jenis_usaha');
        $this->db->order_by('jenis_usaha', 'asc');
        return $this->db->get()->result();
    }

    public function get_data_ternak() {
        $this->db->select('
            jenis_usaha,
            COUNT(DISTINCT nik) as total_peternak,
            SUM(CAST(jumlah AS UNSIGNED)) as total_ternak
        ');
        $this->db->from('input_jenis_usaha');
        $this->db->group_by('jenis_usaha');
        $this->db->order_by('jenis_usaha', 'asc');
        
        $result = $this->db->get()->result();
        
        $data = [];
        $no = 1;
        foreach ($result as $row) {
            $data[] = (object)[
                'no' => $no++,
                'jenis_ternak' => $row->jenis_usaha,
                'total_peternak' => $row->total_peternak,
                'total_ekor' => $row->total_ternak
            ];
        }
        
        return $data;
    }

    public function get_detail_by_jenis_usaha($jenis_usaha) {
        $this->db->select('
            nik,
            nama_peternak,
            telepon,
            komoditas_ternak,
            jenis_usaha,
            jumlah,
            kecamatan,
            kelurahan,
            alamat,
            rt,
            rw
        ');
        $this->db->from('input_jenis_usaha');
        $this->db->where('jenis_usaha', $jenis_usaha);
        $this->db->order_by('nama_peternak', 'asc');
        
        return $this->db->get()->result();
    }

    public function get_filtered_data($jenis_usaha = null) {
        $this->db->select('
            jenis_usaha,
            COUNT(DISTINCT nik) as total_peternak,
            SUM(CAST(jumlah AS UNSIGNED)) as total_ternak
        ');
        $this->db->from('input_jenis_usaha');
        
        if ($jenis_usaha && $jenis_usaha != 'all') {
            $this->db->where('jenis_usaha', $jenis_usaha);
        }
        
        $this->db->group_by('jenis_usaha');
        $this->db->order_by('jenis_usaha', 'asc');
        
        return $this->db->get()->result();
    }

    public function get_summary_by_kecamatan() {
        $this->db->select('
            kecamatan,
            COUNT(DISTINCT nik) as jumlah_peternak,
            SUM(CAST(jumlah AS UNSIGNED)) as total_ternak
        ');
        $this->db->from('input_jenis_usaha');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->group_by('kecamatan');
        $this->db->order_by('kecamatan', 'asc');
        
        return $this->db->get()->result();
    }
}
?>