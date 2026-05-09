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

    /**
     * Mengambil detail peternak berdasarkan jenis usaha (PERSIS, bukan LIKE)
     * Setiap NIK hanya muncul sekali dengan menjumlahkan total ternaknya
     */
    public function get_detail_by_jenis_usaha($jenis_usaha) {
        $this->db->select('
            nik,
            MAX(nama_peternak) as nama_peternak,
            MAX(telepon) as telepon,
            MAX(komoditas_ternak) as komoditas_ternak,
            MAX(jenis_usaha) as jenis_usaha,
            SUM(CAST(jumlah AS UNSIGNED)) as jumlah,
            MAX(kecamatan) as kecamatan,
            MAX(kelurahan) as kelurahan,
            MAX(alamat) as alamat,
            MAX(rt) as rt,
            MAX(rw) as rw
        ');
        $this->db->from('input_jenis_usaha');
        // Pencarian PERSIS (bukan LIKE) - ini kunci utama perbaikan
        $this->db->where("LOWER(TRIM(jenis_usaha)) =", strtolower(trim($jenis_usaha)));
        $this->db->group_by('nik');
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
            // Filter juga menggunakan pencarian persis untuk konsistensi
            $this->db->where("LOWER(TRIM(jenis_usaha)) =", strtolower(trim($jenis_usaha)));
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

    /**
     * Menghitung jumlah peternak UNIK untuk suatu jenis usaha (pencarian PERSIS)
     */
    public function get_count_peternak_by_jenis($jenis_usaha) {
        $this->db->select('COUNT(DISTINCT nik) as total_peternak');
        $this->db->from('input_jenis_usaha');
        $this->db->where("LOWER(TRIM(jenis_usaha)) =", strtolower(trim($jenis_usaha)));
        $query = $this->db->get();
        return $query->row()->total_peternak ?? 0;
    }
}