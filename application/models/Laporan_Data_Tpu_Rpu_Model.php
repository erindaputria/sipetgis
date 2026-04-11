<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Data_Tpu_Rpu_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kecamatan()
    {
        // Cara 1: Gunakan query manual (RECOMMENDED)
        $sql = "SELECT DISTINCT kecamatan FROM input_rpu WHERE kecamatan IS NOT NULL AND kecamatan != '' ORDER BY kecamatan ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        // Jika tidak ada data, gunakan data default
        if(empty($result)) {
            $kecamatan_list = [
                'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
                'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
                'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
                'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
                'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
                'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
            ];
            
            foreach($kecamatan_list as $kec) {
                $result[] = (object)['kecamatan' => $kec];
            }
        }
        
        return $result;
    }

    public function get_tahun()
    {
        // Cara 1: Gunakan query manual (RECOMMENDED)
        $sql = "SELECT DISTINCT YEAR(tanggal_rpu) as tahun FROM input_rpu WHERE tanggal_rpu IS NOT NULL ORDER BY tahun DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        // Jika tidak ada data, gunakan data default
        if(empty($result)) {
            $currentYear = date('Y');
            for($i = $currentYear; $i >= $currentYear - 5; $i--) {
                $result[] = (object)['tahun' => $i];
            }
        }
        
        return $result;
    }

    public function get_data_tpu_rpu($tahun, $kecamatan_filter = null)
    {
        // Query untuk mengambil data RPU dengan komoditas
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
                WHERE YEAR(r.tanggal_rpu) = ?";
        
        $params = [$tahun];
        
        // Tambah filter kecamatan
        if($kecamatan_filter && $kecamatan_filter != 'semua') {
            $sql .= " AND r.kecamatan = ?";
            $params[] = $kecamatan_filter;
        }
        
        $sql .= " GROUP BY r.id
                  ORDER BY r.tanggal_rpu DESC, r.id DESC";
        
        $query = $this->db->query($sql, $params);
        $results = $query->result();
        
        // Format data untuk ditampilkan
        $data = [];
        foreach($results as $row) {
            // Parse komoditas detail
            $komoditas_list = [];
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
                        
                        $komoditas_list[] = $komoditas;
                        $asal_unggas_list[] = $asal;
                        
                        // Kategorikan jenis komoditas
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
            
            // Jika tidak ada komoditas detail, gunakan total_ekor
            if(empty($komoditas_list) && $row->total_ekor > 0) {
                $total_ayam = intval($row->total_ekor);
            }
            
            // Gabungkan daerah asal unggas
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
                'tersedia_juleha' => $row->tersedia_juleha ?: 'Tidak',
                'tanggal_rpu' => $row->tanggal_rpu,
                'nama_petugas' => $row->nama_petugas,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'foto_kegiatan' => $row->foto_kegiatan,
                'komoditas_list' => $komoditas_list
            ];
        }
        
        return $data;
    }
    
    public function get_total_tpu_rpu($tahun, $kecamatan_filter)
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
    
    public function get_all_data_for_export($tahun, $kecamatan_filter = null)
    {
        return $this->get_data_tpu_rpu($tahun, $kecamatan_filter);
    }
}
?>