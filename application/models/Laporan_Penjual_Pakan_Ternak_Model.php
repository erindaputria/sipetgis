<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_pakan_ternak_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kecamatan()
    {
        // Get distinct kecamatan from penjual table
        $this->db->distinct();
        $this->db->select('kecamatan');
        $this->db->from('penjual');
        $this->db->order_by('kecamatan', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        // If no data, return default list
        if(empty($result)) {
            $kecamatan_list = [
                'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
                'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
                'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
                'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
                'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
                'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
            ];
            
            $result = [];
            foreach($kecamatan_list as $kec) {
                $result[] = (object)['kecamatan' => $kec];
            }
        }
        
        return $result;
    }

    public function get_tahun()
    {
        // Get distinct years from created_at
        $this->db->distinct();
        $this->db->select('YEAR(created_at) as tahun');
        $this->db->from('penjual');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        // If no data, return default years
        if(empty($result)) {
            $currentYear = date('Y');
            $result = [];
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_penjual_pakan($tahun, $kecamatan_filter = null)
    {
        $this->db->select('
            id_penjual,
            nama_toko,
            nama_pemilik,
            nik,
            nama_petugas,
            tanggal_input,
            keterangan,
            nib,
            alamat,
            kecamatan,
            kelurahan,
            rt,
            rw,
            latitude,
            longitude,
            telp,
            dagangan,
            kategori_obat,
            jenis_obat,
            foto_toko,
            surat_ijin,
            obat_hewan,
            created_at
        ');
        $this->db->from('penjual');
        
        // Filter by year
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        // Filter by kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_total_penjual_pakan($tahun, $kecamatan_filter)
    {
        $this->db->from('penjual');
        
        // Filter by year
        if($tahun && $tahun != '') {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        // Filter by kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $total_usaha = $this->db->count_all_results();
        
        return (object)[
            'total_usaha' => $total_usaha
        ];
    }
}