<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_kepemilikan_ternak_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

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
        // Gabungkan tahun dari kedua tabel
        $sql = "SELECT DISTINCT tahun FROM (
                    SELECT YEAR(tanggal_input) as tahun FROM input_jenis_usaha WHERE tanggal_input IS NOT NULL
                    UNION
                    SELECT YEAR(tanggal_input) as tahun FROM jenis_usaha WHERE tanggal_input IS NOT NULL
                ) AS tahun_data ORDER BY tahun DESC";
        
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

    public function get_data_peternak($tahun, $bulan = null, $kecamatan_filter = null)
    {
        // Query gabungan dari input_jenis_usaha dan jenis_usaha
        $sql = "SELECT kecamatan, 
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Potong' THEN nik END) as sapi_potong,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Perah' THEN nik END) as sapi_perah,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kambing' THEN nik END) as kambing,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Domba' THEN nik END) as domba,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN nik END) as ayam,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Itik' THEN nik END) as itik,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Angsa' THEN nik END) as angsa,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kalkun' THEN nik END) as kalkun,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Burung' THEN nik END) as burung
                FROM (
                    -- Data dari input_jenis_usaha
                    SELECT kecamatan, komoditas_ternak, nik, tanggal_input
                    FROM input_jenis_usaha
                    WHERE 1=1
                    
                    UNION ALL
                    
                    -- Data dari jenis_usaha (konversi jenis_usaha ke komoditas_ternak)
                    SELECT 
                        UPPER(kecamatan) as kecamatan,
                        CASE 
                            WHEN jenis_usaha LIKE '%Sapi Potong%' OR jenis_usaha LIKE '%Sapi%' THEN 'Sapi Potong'
                            WHEN jenis_usaha LIKE '%Sapi Perah%' THEN 'Sapi Perah'
                            WHEN jenis_usaha LIKE '%Kambing%' THEN 'Kambing'
                            WHEN jenis_usaha LIKE '%Domba%' THEN 'Domba'
                            WHEN jenis_usaha LIKE '%Ayam%' THEN 'Ayam'
                            WHEN jenis_usaha LIKE '%Itik%' THEN 'Itik'
                            WHEN jenis_usaha LIKE '%Angsa%' THEN 'Angsa'
                            WHEN jenis_usaha LIKE '%Kalkun%' THEN 'Kalkun'
                            WHEN jenis_usaha LIKE '%Burung%' THEN 'Burung'
                            ELSE 'Lainnya'
                        END as komoditas_ternak,
                        nik,
                        tanggal_input
                    FROM jenis_usaha
                    WHERE 1=1
                ) AS semua_data
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
        
        $sql .= " GROUP BY kecamatan";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        // Normalisasi nama kecamatan (upper case ke title case)
        foreach($results as $item) {
            $item->kecamatan = ucwords(strtolower($item->kecamatan));
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $filter_normalized = ucwords(strtolower($kecamatan_filter));
            foreach($results as $item) {
                if($item->kecamatan == $filter_normalized) {
                    return [$item];
                }
            }
            return [(object)[
                'kecamatan' => $filter_normalized,
                'sapi_potong' => 0, 'sapi_perah' => 0, 'kambing' => 0,
                'domba' => 0, 'ayam' => 0, 'itik' => 0, 'angsa' => 0,
                'kalkun' => 0, 'burung' => 0
            ]];
        }
        
        $final_results = [];
        foreach($this->kecamatan_order as $kec) {
            $found = false;
            foreach($results as $item) {
                if($item->kecamatan == $kec) {
                    $final_results[] = $item;
                    $found = true;
                    break;
                }
            }
            if(!$found) {
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

    public function get_data_populasi($tahun, $bulan = null, $kecamatan_filter = null)
    {
        // Query gabungan untuk populasi (SUM jumlah)
        $sql = "SELECT kecamatan, 
                   SUM(CASE WHEN komoditas_ternak = 'Sapi Potong' THEN jumlah ELSE 0 END) as sapi_potong,
                   SUM(CASE WHEN komoditas_ternak = 'Sapi Perah' THEN jumlah ELSE 0 END) as sapi_perah,
                   SUM(CASE WHEN komoditas_ternak = 'Kambing' THEN jumlah ELSE 0 END) as kambing,
                   SUM(CASE WHEN komoditas_ternak = 'Domba' THEN jumlah ELSE 0 END) as domba,
                   SUM(CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN jumlah ELSE 0 END) as ayam,
                   SUM(CASE WHEN komoditas_ternak = 'Itik' THEN jumlah ELSE 0 END) as itik,
                   SUM(CASE WHEN komoditas_ternak = 'Angsa' THEN jumlah ELSE 0 END) as angsa,
                   SUM(CASE WHEN komoditas_ternak = 'Kalkun' THEN jumlah ELSE 0 END) as kalkun,
                   SUM(CASE WHEN komoditas_ternak = 'Burung' THEN jumlah ELSE 0 END) as burung
                FROM (
                    -- Data dari input_jenis_usaha
                    SELECT kecamatan, komoditas_ternak, jumlah, tanggal_input
                    FROM input_jenis_usaha
                    WHERE 1=1
                    
                    UNION ALL
                    
                    -- Data dari jenis_usaha
                    SELECT 
                        UPPER(kecamatan) as kecamatan,
                        CASE 
                            WHEN jenis_usaha LIKE '%Sapi Potong%' OR jenis_usaha LIKE '%Sapi%' THEN 'Sapi Potong'
                            WHEN jenis_usaha LIKE '%Sapi Perah%' THEN 'Sapi Perah'
                            WHEN jenis_usaha LIKE '%Kambing%' THEN 'Kambing'
                            WHEN jenis_usaha LIKE '%Domba%' THEN 'Domba'
                            WHEN jenis_usaha LIKE '%Ayam%' THEN 'Ayam'
                            WHEN jenis_usaha LIKE '%Itik%' THEN 'Itik'
                            WHEN jenis_usaha LIKE '%Angsa%' THEN 'Angsa'
                            WHEN jenis_usaha LIKE '%Kalkun%' THEN 'Kalkun'
                            WHEN jenis_usaha LIKE '%Burung%' THEN 'Burung'
                            ELSE 'Lainnya'
                        END as komoditas_ternak,
                        jumlah,
                        tanggal_input
                    FROM jenis_usaha
                    WHERE 1=1
                ) AS semua_data
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
        
        $sql .= " GROUP BY kecamatan";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        
        foreach($results as $item) {
            $item->kecamatan = ucwords(strtolower($item->kecamatan));
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $filter_normalized = ucwords(strtolower($kecamatan_filter));
            foreach($results as $item) {
                if($item->kecamatan == $filter_normalized) {
                    return [$item];
                }
            }
            return [(object)[
                'kecamatan' => $filter_normalized,
                'sapi_potong' => 0, 'sapi_perah' => 0, 'kambing' => 0,
                'domba' => 0, 'ayam' => 0, 'itik' => 0, 'angsa' => 0,
                'kalkun' => 0, 'burung' => 0
            ]];
        }
        
        $final_results = [];
        foreach($this->kecamatan_order as $kec) {
            $found = false;
            foreach($results as $item) {
                if($item->kecamatan == $kec) {
                    $final_results[] = $item;
                    $found = true;
                    break;
                }
            }
            if(!$found) {
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

    public function get_total_data($tahun, $bulan = null, $kecamatan_filter, $jenis_data)
    {
        if($jenis_data == 'peternak') {
            $sql = "SELECT 
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Potong' THEN nik END) as sapi_potong,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Sapi Perah' THEN nik END) as sapi_perah,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kambing' THEN nik END) as kambing,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Domba' THEN nik END) as domba,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN nik END) as ayam,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Itik' THEN nik END) as itik,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Angsa' THEN nik END) as angsa,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Kalkun' THEN nik END) as kalkun,
                   COUNT(DISTINCT CASE WHEN komoditas_ternak = 'Burung' THEN nik END) as burung
                FROM (
                    SELECT nik, komoditas_ternak, kecamatan, tanggal_input FROM input_jenis_usaha
                    UNION ALL
                    SELECT nik, 
                        CASE 
                            WHEN jenis_usaha LIKE '%Sapi Potong%' OR jenis_usaha LIKE '%Sapi%' THEN 'Sapi Potong'
                            WHEN jenis_usaha LIKE '%Sapi Perah%' THEN 'Sapi Perah'
                            WHEN jenis_usaha LIKE '%Kambing%' THEN 'Kambing'
                            WHEN jenis_usaha LIKE '%Domba%' THEN 'Domba'
                            WHEN jenis_usaha LIKE '%Ayam%' THEN 'Ayam'
                            WHEN jenis_usaha LIKE '%Itik%' THEN 'Itik'
                            WHEN jenis_usaha LIKE '%Angsa%' THEN 'Angsa'
                            WHEN jenis_usaha LIKE '%Kalkun%' THEN 'Kalkun'
                            WHEN jenis_usaha LIKE '%Burung%' THEN 'Burung'
                            ELSE 'Lainnya'
                        END as komoditas_ternak,
                        kecamatan,
                        tanggal_input
                    FROM jenis_usaha
                ) AS semua_data
                WHERE 1=1";
        } else {
            $sql = "SELECT 
                   SUM(CASE WHEN komoditas_ternak = 'Sapi Potong' THEN jumlah ELSE 0 END) as sapi_potong,
                   SUM(CASE WHEN komoditas_ternak = 'Sapi Perah' THEN jumlah ELSE 0 END) as sapi_perah,
                   SUM(CASE WHEN komoditas_ternak = 'Kambing' THEN jumlah ELSE 0 END) as kambing,
                   SUM(CASE WHEN komoditas_ternak = 'Domba' THEN jumlah ELSE 0 END) as domba,
                   SUM(CASE WHEN komoditas_ternak IN ('Ayam Buras', 'Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Ayam') THEN jumlah ELSE 0 END) as ayam,
                   SUM(CASE WHEN komoditas_ternak = 'Itik' THEN jumlah ELSE 0 END) as itik,
                   SUM(CASE WHEN komoditas_ternak = 'Angsa' THEN jumlah ELSE 0 END) as angsa,
                   SUM(CASE WHEN komoditas_ternak = 'Kalkun' THEN jumlah ELSE 0 END) as kalkun,
                   SUM(CASE WHEN komoditas_ternak = 'Burung' THEN jumlah ELSE 0 END) as burung
                FROM (
                    SELECT komoditas_ternak, jumlah, kecamatan, tanggal_input FROM input_jenis_usaha
                    UNION ALL
                    SELECT 
                        CASE 
                            WHEN jenis_usaha LIKE '%Sapi Potong%' OR jenis_usaha LIKE '%Sapi%' THEN 'Sapi Potong'
                            WHEN jenis_usaha LIKE '%Sapi Perah%' THEN 'Sapi Perah'
                            WHEN jenis_usaha LIKE '%Kambing%' THEN 'Kambing'
                            WHEN jenis_usaha LIKE '%Domba%' THEN 'Domba'
                            WHEN jenis_usaha LIKE '%Ayam%' THEN 'Ayam'
                            WHEN jenis_usaha LIKE '%Itik%' THEN 'Itik'
                            WHEN jenis_usaha LIKE '%Angsa%' THEN 'Angsa'
                            WHEN jenis_usaha LIKE '%Kalkun%' THEN 'Kalkun'
                            WHEN jenis_usaha LIKE '%Burung%' THEN 'Burung'
                            ELSE 'Lainnya'
                        END as komoditas_ternak,
                        jumlah,
                        kecamatan,
                        tanggal_input
                    FROM jenis_usaha
                ) AS semua_data
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