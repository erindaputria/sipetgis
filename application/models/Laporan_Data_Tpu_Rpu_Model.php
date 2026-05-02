<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_tpu_rpu_model extends CI_Model {

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
        $sql = "SELECT DISTINCT kecamatan FROM input_rpu WHERE kecamatan IS NOT NULL AND kecamatan != '' ORDER BY kecamatan ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        if(empty($result)) {
            foreach($this->kecamatan_order as $kec) {
                $result[] = (object)['kecamatan' => $kec];
            }
        }
        
        return $result;
    } 

    public function get_tahun()
    {
        $sql = "SELECT DISTINCT YEAR(tanggal_rpu) as tahun FROM input_rpu WHERE tanggal_rpu IS NOT NULL ORDER BY tahun DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_tpu_rpu($tahun = null, $kecamatan_filter = null)
    {
        $sql = "SELECT 
                    r.*,
                    GROUP_CONCAT(
                        CONCAT(k.komoditas, ':', k.jumlah_ekor, ':', k.berat_kg, ':', k.asal_unggas)
                        SEPARATOR '|'
                    ) as komoditas_detail,
                    COALESCE(SUM(k.jumlah_ekor), 0) as total_ekor,
                    COALESCE(SUM(k.berat_kg), 0) as total_berat
                FROM input_rpu r
                LEFT JOIN input_rpu_komoditas k ON r.id = k.input_rpu_id
                WHERE 1=1";
        
        $params = [];
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(r.tanggal_rpu) = ?";
            $params[] = $tahun;
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND r.kecamatan = ?";
            $params[] = $kecamatan_filter;
        }
        
        $sql .= " GROUP BY r.id
                  ORDER BY r.tanggal_rpu DESC, r.id DESC";
        
        $query = $this->db->query($sql, $params);
        $results = $query->result();
        
        $data = [];
        foreach($results as $row) {
            $total_ayam = 0;
            $total_itik = 0;
            $total_lainnya = 0;
            $asal_unggas_list = [];
            
            if(!empty($row->komoditas_detail)) {
                $komoditas_items = explode('|', $row->komoditas_detail);
                foreach($komoditas_items as $item) {
                    $parts = explode(':', $item);
                    if(count($parts) == 4) {
                        $komoditas = $parts[0];
                        $jumlah = intval($parts[1]);
                        $asal = $parts[3];
                        
                        $asal_unggas_list[] = $asal;
                        
                        if(strpos($komoditas, 'Ayam') !== false || strpos($komoditas, 'Broiler') !== false || strpos($komoditas, 'Kampung') !== false || strpos($komoditas, 'Layer') !== false) {
                            $total_ayam += $jumlah;
                        } elseif(strpos($komoditas, 'Itik') !== false) {
                            $total_itik += $jumlah;
                        } else {
                            $total_lainnya += $jumlah;
                        }
                    }
                }
            }
            
            if(empty($komoditas_items) && $row->total_ekor > 0) {
                $total_ayam = intval($row->total_ekor);
            }
            
            $asal_unggas_unique = array_unique($asal_unggas_list);
            $daerah_asal = !empty($asal_unggas_unique) ? implode(', ', $asal_unggas_unique) : '-';
            
            $data[] = (object)[
                'id' => $row->id,
                'nama_tpu' => $row->pejagal ?: '-',
                'perizinan' => $row->perizinan ?: '-',
                'alamat' => $row->lokasi ?: '-',
                'kecamatan' => $row->kecamatan ?: '-',
                'kelurahan' => $row->kelurahan ?: '-',
                'pj' => $row->nama_pj ?: '-',
                'no_telp' => $row->telp_pj ?: '-',
                'jumlah_pemotongan' => (object)[
                    'ayam' => $total_ayam,
                    'itik' => $total_itik,
                    'lainnya' => $total_lainnya
                ],
                'daerah_asal' => $daerah_asal,
                'tersedia_juleha' => ($row->tersedia_juleha == 'Y' || $row->tersedia_juleha == 'Ya') ? 'Ya' : 'Tidak',
                'tanggal_rpu' => $row->tanggal_rpu,
                'nama_petugas' => $row->nama_petugas,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude
            ];
        }
        
        return $data;
    }
    
    public function get_total_tpu_rpu($tahun = null, $kecamatan_filter = null)
    {
        $data = $this->get_data_tpu_rpu($tahun, $kecamatan_filter);
        
        $total_tpu = count($data);
        $total_ayam = 0;
        $total_itik = 0;
        $total_lainnya = 0;
        
        foreach($data as $row) { 
            $total_ayam += $row->jumlah_pemotongan->ayam;
            $total_itik += $row->jumlah_pemotongan->itik;
            $total_lainnya += $row->jumlah_pemotongan->lainnya;
        }
        
        return (object)[
            'total_tpu' => $total_tpu,
            'total_ayam' => $total_ayam,
            'total_itik' => $total_itik,
            'total_lainnya' => $total_lainnya
        ];
    }

    // ========== METHOD REKAP PER KECAMATAN (0-0-0) ==========

    /**
     * Get rekap jumlah TPU/RPU per kecamatan
     */
    public function get_rekap_tpu_per_kecamatan($tahun = null, $kecamatan_filter = null)
    {
        $sql = "SELECT kecamatan, COUNT(*) as jumlah_tpu, COALESCE(SUM(
            (SELECT COALESCE(SUM(jumlah_ekor), 0) FROM input_rpu_komoditas WHERE input_rpu_id = input_rpu.id)
        ), 0) as total_pemotongan
        FROM input_rpu
        WHERE 1=1";
        
        $params = [];
        
        if($tahun && $tahun != '') {
            $sql .= " AND YEAR(tanggal_rpu) = ?";
            $params[] = $tahun;
        }
        
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND kecamatan = ?";
            $params[] = $kecamatan_filter;
        }
        
        $sql .= " GROUP BY kecamatan";
        
        $query = $this->db->query($sql, $params);
        $results = $query->result();
        
        // Map data ke array
        $dataMap = [];
        foreach($results as $row) {
            $kec = ucwords(strtolower($row->kecamatan));
            $dataMap[$kec] = (object)[
                'jumlah_tpu' => (int)$row->jumlah_tpu,
                'total_pemotongan' => (int)$row->total_pemotongan
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
                'jumlah_tpu' => isset($dataMap[$kec]) ? $dataMap[$kec]->jumlah_tpu : 0,
                'total_pemotongan' => isset($dataMap[$kec]) ? $dataMap[$kec]->total_pemotongan : 0
            ];
            $result[] = $row;
        }
        
        return $result;
    }

    /**
     * Get total rekap per kecamatan
     */
    public function get_total_rekap_tpu($tahun = null, $kecamatan_filter = null)
    {
        $data = $this->get_rekap_tpu_per_kecamatan($tahun, $kecamatan_filter);
        
        $total = (object)[
            'jumlah_tpu' => 0,
            'total_pemotongan' => 0
        ];
        
        foreach($data as $row) {
            $total->jumlah_tpu += $row->jumlah_tpu;
            $total->total_pemotongan += $row->total_pemotongan;
        }
        
        return $total;
    }

    /**
     * Get all data tanpa filter tahun (untuk load awal)
     */
    public function get_all_data_tpu_rpu()
    {
        return $this->get_data_tpu_rpu(null, null);
    }

    /**
     * Get all rekap per kecamatan (tanpa filter tahun)
     */
    public function get_all_rekap_tpu()
    {
        return $this->get_rekap_tpu_per_kecamatan(null, null);
    }

    /**
     * Get all total rekap (tanpa filter tahun)
     */
    public function get_all_total_rekap_tpu()
    {
        return $this->get_total_rekap_tpu(null, null);
    }
}
?>