<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_klinik_hewan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // 31 Kecamatan di Surabaya
    public function get_all_kecamatan()
    {
        return [
            'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
            'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
            'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
            'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
            'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
            'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
        ];
    }

    public function get_kecamatan()
    {
        $kecamatan_list = $this->get_all_kecamatan();
        $result = [];
        foreach($kecamatan_list as $kec) {
            $result[] = (object)['kecamatan' => $kec];
        }
        return $result;
    }

    public function get_tahun()
    {
        // Ambil tahun unik dari created_at
        $this->db->distinct();
        $this->db->select("YEAR(created_at) as tahun");
        $this->db->from('input_klinik_hewan');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
        // Jika tidak ada data, gunakan tahun default
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_klinik($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('
            nama_klinik,
            nama_pemilik,
            alamat,
            kecamatan,
            kelurahan,
            jumlah_dokter,
            telp as no_wa,
            nib,
            sertifikat_standar,
            created_at
        ');
        $this->db->from('input_klinik_hewan');
        
        // Filter tahun (jika ada)
        if($tahun && $tahun != '') {
            $this->db->where("YEAR(created_at)", $tahun);
        }
        
        // Filter kecamatan (jika tidak 'semua')
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != '') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result();
        
        // Format data
        foreach($results as $item) {
            // Format sertifikat
            if($item->sertifikat_standar == 'Y') {
                $item->sertifikat_standar = 'Ada';
            } elseif($item->sertifikat_standar == 'N') {
                $item->sertifikat_standar = 'Tidak Ada';
            } else {
                $item->sertifikat_standar = $item->sertifikat_standar ?: 'Tidak Ada';
            }
            
            // Format NIB
            if(empty($item->nib)) {
                $item->nib = '-';
            }
            
            // Format no WA
            if(empty($item->no_wa)) {
                $item->no_wa = '-';
            }
            
            // Format nama pemilik
            if(empty($item->nama_pemilik)) {
                $item->nama_pemilik = '-';
            }
            
            // Format alamat
            if(empty($item->alamat)) {
                $item->alamat = '-';
            }
        }
        
        return $results;
    }
    
    public function get_total_klinik($tahun = null, $kecamatan_filter = null)
    { 
        $data = $this->get_data_klinik($tahun, $kecamatan_filter);
        
        $total_klinik = count($data);
        $total_dokter = 0;
        
        foreach($data as $row) {
            $total_dokter += (int)$row->jumlah_dokter;
        }
        
        return (object)[
            'total_klinik' => $total_klinik,
            'total_dokter' => $total_dokter
        ];
    }
}
?>