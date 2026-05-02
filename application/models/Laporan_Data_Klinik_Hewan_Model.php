<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_klinik_hewan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Daftar kecamatan urutan tetap (31 kecamatan)
    private $kecamatan_order = [
        'Asemrowo', 'Krembangan', 'Pabean Cantian', 'Semampir', 'Bulak',
        'Kenjeran', 'Simokerto', 'Tambaksari', 'Mulyorejo', 'Sukolilo',
        'Gubeng', 'Rungkut', 'Gunung Anyar', 'Tenggilis Mejoyo', 'Wonocolo',
        'Benowo', 'Pakal', 'Sambikerep', 'Tandes', 'Sukomanunggal',
        'Lakarsantri', 'Wiyung', 'Sawahan', 'Dukuh Pakis', 'Karangpilang',
        'Gayungan', 'Jambangan', 'Wonokromo', 'Tegalsari', 'Genteng', 'Bubutan'
    ];

    public function get_kecamatan()
    {
        $kecamatan_list = $this->get_all_kecamatan();
        $result = [];
        foreach($kecamatan_list as $kec) {
            $result[] = (object)['kecamatan' => $kec];
        }
        return $result;
    }

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

    public function get_tahun()
    {
        $this->db->distinct();
        $this->db->select("YEAR(created_at) as tahun");
        $this->db->from('input_klinik_hewan');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('tahun', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();
        
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
        
        if($tahun && $tahun != '') {
            $this->db->where("YEAR(created_at)", $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua' && $kecamatan_filter != '') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        
        $results = $query->result();
        
        foreach($results as $item) {
            if($item->sertifikat_standar == 'Y') {
                $item->sertifikat_standar = 'Ada';
            } elseif($item->sertifikat_standar == 'N') {
                $item->sertifikat_standar = 'Tidak Ada';
            } else {
                $item->sertifikat_standar = $item->sertifikat_standar ?: 'Tidak Ada';
            }
            
            $item->nib = empty($item->nib) ? '-' : $item->nib;
            $item->no_wa = empty($item->no_wa) ? '-' : $item->no_wa;
            $item->nama_pemilik = empty($item->nama_pemilik) ? '-' : $item->nama_pemilik;
            $item->alamat = empty($item->alamat) ? '-' : $item->alamat;
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

    // ========== METHOD REKAP PER KECAMATAN (0-0-0) ==========

    /**
     * Get rekap jumlah klinik per kecamatan
     */
    public function get_rekap_klinik_per_kecamatan($tahun = null, $kecamatan_filter = null)
    {
        $this->db->select('kecamatan, COUNT(*) as jumlah_klinik, COALESCE(SUM(jumlah_dokter), 0) as total_dokter');
        $this->db->from('input_klinik_hewan');
        
        if($tahun) {
            $this->db->where('YEAR(created_at)', $tahun);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $this->db->where('kecamatan', $kecamatan_filter);
        }
        
        $this->db->group_by('kecamatan');
        $query = $this->db->get();
        $results = $query->result();
        
        // Map data ke array
        $dataMap = [];
        foreach($results as $row) {
            $kec = ucwords(strtolower($row->kecamatan));
            $dataMap[$kec] = (object)[
                'jumlah_klinik' => (int)$row->jumlah_klinik,
                'total_dokter' => (int)$row->total_dokter
            ];
        }
        
        // Tentukan kecamatan yang ditampilkan
        $kecamatanList = [];
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $kecamatanList = [ucwords(strtolower($kecamatan_filter))];
        } else {
            $kecamatanList = $this->kecamatan_order;
        }
        
        // Build hasil
        $result = [];
        foreach($kecamatanList as $kec) {
            $row = (object)[
                'kecamatan' => $kec,
                'jumlah_klinik' => isset($dataMap[$kec]) ? $dataMap[$kec]->jumlah_klinik : 0,
                'total_dokter' => isset($dataMap[$kec]) ? $dataMap[$kec]->total_dokter : 0
            ];
            $result[] = $row;
        }
        
        return $result;
    }

    /**
     * Get total rekap per kecamatan
     */
    public function get_total_rekap_klinik($tahun = null, $kecamatan_filter = null)
    {
        $data = $this->get_rekap_klinik_per_kecamatan($tahun, $kecamatan_filter);
        
        $total = (object)[
            'jumlah_klinik' => 0,
            'total_dokter' => 0
        ];
        
        foreach($data as $row) {
            $total->jumlah_klinik += $row->jumlah_klinik;
            $total->total_dokter += $row->total_dokter;
        }
        
        return $total;
    }

    /**
     * Get all data tanpa filter tahun (untuk load awal)
     */
    public function get_all_data_klinik()
    {
        return $this->get_data_klinik(null, null);
    }

    /**
     * Get all rekap per kecamatan (tanpa filter tahun)
     */
    public function get_all_rekap_klinik()
    {
        return $this->get_rekap_klinik_per_kecamatan(null, null);
    }

    /**
     * Get all total rekap (tanpa filter tahun)
     */
    public function get_all_total_rekap_klinik()
    {
        return $this->get_total_rekap_klinik(null, null);
    }

    
}
?>