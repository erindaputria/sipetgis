<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_kepemilikan_ternak_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Daftar 31 kecamatan urutan tetap
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
        $result = [];
        foreach($this->kecamatan_order as $kec) {
            $result[] = (object)['kecamatan' => $kec];
        }
        return $result; 
    }

    public function get_tahun()
    {
        $sql = "SELECT DISTINCT YEAR(tanggal_input) as tahun FROM input_jenis_usaha WHERE tanggal_input IS NOT NULL ORDER BY tahun DESC";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) {
            return $query->result();
        }
        
        $currentYear = date('Y');
        $result = [];
        for($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $result[] = (object)['tahun' => $i];
        }
        return $result;
    }

    // Data Peternak (COUNT DISTINCT NIK)
    public function get_data_peternak($tahun, $bulan = null, $kecamatan_filter = null)
    {
        $sql = "SELECT 
                    kecamatan,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Potong' THEN nik END) as sapi_potong,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Perah' THEN nik END) as sapi_perah,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kambing' THEN nik END) as kambing,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Domba' THEN nik END) as domba,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN nik END) as ayam,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Itik' THEN nik END) as itik,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Angsa' THEN nik END) as angsa,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kalkun' THEN nik END) as kalkun,
                    COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Burung' THEN nik END) as burung
                FROM input_jenis_usaha
                WHERE 1=1";
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_input) = " . $this->db->escape($tahun);
        }
        
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(tanggal_input) = " . $this->db->escape($bulan);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND UPPER(kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $sql .= " GROUP BY kecamatan ORDER BY kecamatan ASC";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        // Map data
        $dataMap = [];
        foreach($results as $item) {
            $kec = ucwords(strtolower($item->kecamatan));
            $dataMap[$kec] = $item;
        }
        
        // Tentukan kecamatan yang ditampilkan
        $kecamatanList = [];
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $kecamatanList = [ucwords(strtolower($kecamatan_filter))];
        } else {
            $kecamatanList = $this->kecamatan_order;
        }
        
        // Build hasil dengan nilai default 0
        $final_results = [];
        foreach($kecamatanList as $kec) {
            if(isset($dataMap[$kec])) {
                $final_results[] = $dataMap[$kec];
            } else {
                $final_results[] = (object)[
                    'kecamatan' => $kec,
                    'sapi_potong' => 0, 'sapi_perah' => 0, 'kambing' => 0,
                    'domba' => 0, 'ayam' => 0, 'itik' => 0, 'angsa' => 0,
                    'kalkun' => 0, 'burung' => 0
                ];
            }
        }
        
        return $final_results;
    }

    // Data Populasi (SUM jumlah)
    public function get_data_populasi($tahun, $bulan = null, $kecamatan_filter = null)
    {
        $sql = "SELECT 
                    kecamatan,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Potong' THEN jumlah ELSE 0 END), 0) as sapi_potong,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Perah' THEN jumlah ELSE 0 END), 0) as sapi_perah,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kambing' THEN jumlah ELSE 0 END), 0) as kambing,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Domba' THEN jumlah ELSE 0 END), 0) as domba,
                    COALESCE(SUM(CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN jumlah ELSE 0 END), 0) as ayam,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Itik' THEN jumlah ELSE 0 END), 0) as itik,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Angsa' THEN jumlah ELSE 0 END), 0) as angsa,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kalkun' THEN jumlah ELSE 0 END), 0) as kalkun,
                    COALESCE(SUM(CASE WHEN komoditas_ternak = 'Burung' THEN jumlah ELSE 0 END), 0) as burung
                FROM input_jenis_usaha
                WHERE 1=1";
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_input) = " . $this->db->escape($tahun);
        }
        
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(tanggal_input) = " . $this->db->escape($bulan);
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND UPPER(kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $sql .= " GROUP BY kecamatan ORDER BY kecamatan ASC";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        // Map data
        $dataMap = [];
        foreach($results as $item) {
            $kec = ucwords(strtolower($item->kecamatan));
            $dataMap[$kec] = $item;
        }
        
        // Tentukan kecamatan yang ditampilkan
        $kecamatanList = [];
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $kecamatanList = [ucwords(strtolower($kecamatan_filter))];
        } else {
            $kecamatanList = $this->kecamatan_order;
        }
        
        // Build hasil dengan nilai default 0
        $final_results = [];
        foreach($kecamatanList as $kec) {
            if(isset($dataMap[$kec])) {
                $final_results[] = $dataMap[$kec];
            } else {
                $final_results[] = (object)[
                    'kecamatan' => $kec,
                    'sapi_potong' => 0, 'sapi_perah' => 0, 'kambing' => 0,
                    'domba' => 0, 'ayam' => 0, 'itik' => 0, 'angsa' => 0,
                    'kalkun' => 0, 'burung' => 0
                ];
            }
        }
        
        return $final_results;
    }

    // Total keseluruhan
    public function get_total_data($tahun, $bulan = null, $kecamatan_filter, $jenis_data)
    {
        if($jenis_data == 'peternak') {
            $sql = "SELECT 
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Potong' THEN nik END), 0) as sapi_potong,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Perah' THEN nik END), 0) as sapi_perah,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kambing' THEN nik END), 0) as kambing,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Domba' THEN nik END), 0) as domba,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN nik END), 0) as ayam,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Itik' THEN nik END), 0) as itik,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Angsa' THEN nik END), 0) as angsa,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kalkun' THEN nik END), 0) as kalkun,
                        COALESCE(COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Burung' THEN nik END), 0) as burung
                    FROM input_jenis_usaha
                    WHERE 1=1";
        } else {
            $sql = "SELECT 
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Potong' THEN jumlah ELSE 0 END), 0) as sapi_potong,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Sapi Perah' THEN jumlah ELSE 0 END), 0) as sapi_perah,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kambing' THEN jumlah ELSE 0 END), 0) as kambing,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Domba' THEN jumlah ELSE 0 END), 0) as domba,
                        COALESCE(SUM(CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN jumlah ELSE 0 END), 0) as ayam,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Itik' THEN jumlah ELSE 0 END), 0) as itik,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Angsa' THEN jumlah ELSE 0 END), 0) as angsa,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Kalkun' THEN jumlah ELSE 0 END), 0) as kalkun,
                        COALESCE(SUM(CASE WHEN komoditas_ternak = 'Burung' THEN jumlah ELSE 0 END), 0) as burung
                    FROM input_jenis_usaha
                    WHERE 1=1";
        }
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_input) = " . $this->db->escape($tahun);
        }
        if($bulan && $bulan != '') {
            $sql .= " AND MONTH(tanggal_input) = " . $this->db->escape($bulan);
        }
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND UPPER(kecamatan) = " . $this->db->escape(strtoupper($kecamatan_filter));
        }
        
        $query = $this->db->query($sql);
        $result = $query->row();
        
        if($result) {
            return $result;
        }
        
        return (object)[
            'sapi_potong' => 0, 'sapi_perah' => 0, 'kambing' => 0,
            'domba' => 0, 'ayam' => 0, 'itik' => 0, 'angsa' => 0,
            'kalkun' => 0, 'burung' => 0
        ];
    }
}
?>