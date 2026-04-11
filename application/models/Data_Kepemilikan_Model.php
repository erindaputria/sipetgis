<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Kepemilikan_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mendapatkan semua data komoditas
    public function get_komoditas() {
        return $this->db->get('komoditas')->result();
    }

    // Mendapatkan data kepemilikan ternak - TANPA filter komoditas karena tidak ada relasi
    public function get_all() {
        // Ambil semua data dari jenis_usaha
        $jenis_usaha = $this->db->get('jenis_usaha')->result();
        
        // Kelompokkan berdasarkan jenis usaha (karena tidak ada komoditas)
        $result = [];
        foreach ($jenis_usaha as $ju) {
            $key = $ju->jenis_usaha; // Group by jenis usaha
            
            if (!isset($result[$key])) {
                $result[$key] = (object)[
                    'id' => count($result) + 1,
                    'jenis_ternak' => $ju->jenis_usaha,
                    'nama_komoditas' => '-', // Tidak ada data komoditas
                    'satuan' => 'Ekor',
                    'total_peternak' => 0,
                    'total_ekor' => 0
                ];
            }
            
            $result[$key]->total_peternak++;
            $result[$key]->total_ekor += intval($ju->jumlah);
        }
        
        return array_values($result);
    }

    // Filter berdasarkan ID (karena tidak ada komoditas, kita filter berdasarkan ID jenis_usaha)
    public function get_by_id($id) {
        return $this->db->get_where('jenis_usaha', ['id' => $id])->result();
    }

    // Mendapatkan detail pelaku usaha dengan data lengkap
    public function get_detail_pelaku_usaha() {
        $this->db->select('
            ju.*,
            pu.nama as nama_lengkap,
            pu.nik,
            pu.telepon,
            pu.kecamatan as kecamatan_pu,
            pu.kelurahan as kelurahan_pu,
            pu.alamat as alamat_pu
        ');
        $this->db->from('jenis_usaha ju');
        $this->db->join('pelaku_usaha pu', 'ju.nik = pu.nik', 'left');
        $this->db->order_by('ju.nama_peternak', 'asc');
        
        return $this->db->get()->result();
    }

    // Summary per kecamatan dari pelaku_usaha
    public function get_summary_by_kecamatan() {
        $this->db->select('
            kecamatan,
            COUNT(*) as jumlah_peternak
        ');
        $this->db->from('pelaku_usaha');
        $this->db->where('kecamatan IS NOT NULL');
        $this->db->where('kecamatan !=', '');
        $this->db->group_by('kecamatan');
        $this->db->order_by('kecamatan', 'asc');
        
        return $this->db->get()->result();
    }

    // Summary berdasarkan jenis usaha
    public function get_summary_by_jenis_usaha() {
        $this->db->select('
            jenis_usaha,
            COUNT(*) as jumlah_peternak,
            SUM(CAST(jumlah AS UNSIGNED)) as total_ternak
        ');
        $this->db->from('jenis_usaha');
        $this->db->group_by('jenis_usaha');
        $this->db->order_by('jenis_usaha', 'asc');
        
        return $this->db->get()->result();
    }

    // Mendapatkan data untuk ditampilkan di tabel utama
    public function get_data_ternak() {
        $summary = $this->get_summary_by_jenis_usaha();
        
        $result = [];
        $no = 1;
        foreach ($summary as $s) {
            $result[] = (object)[
                'no' => $no++,
                'jenis_ternak' => $s->jenis_usaha,
                'nama_komoditas' => $s->jenis_usaha, // Gunakan jenis_usaha sebagai nama komoditas
                'jumlah' => $s->total_ternak,
                'satuan' => 'Ekor',
                'total_peternak' => $s->jumlah_peternak
            ];
        }
        
        return $result;
    }

    // Mendapatkan detail berdasarkan jenis usaha
    public function get_detail_by_jenis_usaha($jenis_usaha) {
        $this->db->select('
            ju.*,
            pu.nama as nama_lengkap,
            pu.nik,
            pu.telepon,
            pu.kecamatan as kecamatan_pu
        ');
        $this->db->from('jenis_usaha ju');
        $this->db->join('pelaku_usaha pu', 'ju.nik = pu.nik', 'left');
        $this->db->where('ju.jenis_usaha', urldecode($jenis_usaha));
        $this->db->order_by('ju.nama_peternak', 'asc');
        
        return $this->db->get()->result();
    }
}