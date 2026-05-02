<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta_sebaran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Peta_sebaran_model');
    }

    public function index()
    {
        $data['title'] = 'Peta Sebaran - SIPETGIS';
        $this->load->view('admin/peta_sebaran', $data);
    }

    // ============================================
    // API PENGOBATAN
    // ============================================
    
    public function get_data_pengobatan()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');
        
        $data = $this->Peta_sebaran_model->get_filtered_pengobatan($kecamatan, $tgl_mulai, $tgl_selesai);
        
        $defaultKoordinat = [
            'Asemrowo' => ['lat' => -7.2050, 'lng' => 112.7079],
            'Benowo' => ['lat' => -7.2296, 'lng' => 112.6523],
            'Jambangan' => ['lat' => -7.3249, 'lng' => 112.7135],
            'Bulak' => ['lat' => -7.2299, 'lng' => 112.7871],
            'Dukuh Pakis' => ['lat' => -7.2759, 'lng' => 112.6907],
            'Kenjeran' => ['lat' => -7.2478, 'lng' => 112.7799],
            'Pakal' => ['lat' => -7.2876, 'lng' => 112.6298],
            'Sukolilo' => ['lat' => -7.2875, 'lng' => 112.7772],
            'Wiyung' => ['lat' => -7.3202, 'lng' => 112.6983],
            'Karang Pilang' => ['lat' => -7.3193, 'lng' => 112.6768],
            'Lakarsantri' => ['lat' => -7.2914, 'lng' => 112.6495],
            'Tandes' => ['lat' => -7.2591, 'lng' => 112.6728],
            'Gubeng' => ['lat' => -7.2841, 'lng' => 112.7536],
            'Sawahan' => ['lat' => -7.2771, 'lng' => 112.7291]
        ];
        
        $formatted_data = [];
        foreach ($data as $item) {
            $kecamatan = trim($item['kecamatan'] ?? '');
            $lat = -7.2575; $lng = 112.7521;
            
            if (!empty($kecamatan) && isset($defaultKoordinat[$kecamatan])) {
                $lat = $defaultKoordinat[$kecamatan]['lat'];
                $lng = $defaultKoordinat[$kecamatan]['lng'];
            } elseif (!empty($kecamatan) && isset($defaultKoordinat[ucfirst(strtolower($kecamatan))])) {
                $key = ucfirst(strtolower($kecamatan));
                $lat = $defaultKoordinat[$key]['lat'];
                $lng = $defaultKoordinat[$key]['lng'];
            }
            
            $formatted_data[] = [
                'id' => $item['id'],
                'nama_peternak' => $item['nama_peternak'] ?? 'Tidak diketahui',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'nik' => $item['nik'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'rt' => $item['rt'] ?? '-',
                'rw' => $item['rw'] ?? '-',
                'tanggal_pengobatan' => $item['tanggal_pengobatan'] ?? '0000-00-00',
                'diagnosa' => $item['gejala_klinis'] ?? '-',
                'komoditas_ternak' => $item['komoditas_ternak'] ?? '-',
                'jenis_pengobatan' => $item['jenis_pengobatan'] ?? '-',
                'jumlah' => intval($item['jumlah']) ?: 0,
                'telp' => $item['telp'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-',
                'bantuan_prov' => $item['bantuan_prov'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API VAKSINASI
    // ============================================
    
    public function get_data_vaksinasi()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');
        
        $data = $this->Peta_sebaran_model->get_filtered_vaksinasi($kecamatan, $tgl_mulai, $tgl_selesai);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id_vaksinasi'],
                'nama_peternak' => $item['nama_peternak'] ?? 'Tidak diketahui',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'nik' => $item['nik'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'rt' => $item['rt'] ?? '-',
                'rw' => $item['rw'] ?? '-',
                'tanggal_vaksinasi' => $item['tanggal_vaksinasi'] ?? '0000-00-00',
                'jenis_vaksinasi' => $item['jenis_vaksinasi'] ?? '-',
                'komoditas_ternak' => $item['komoditas_ternak'] ?? '-',
                'dosis' => $item['dosis'] ?? '-',
                'jumlah' => intval($item['jumlah']) ?: 0,
                'telp' => $item['telp'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-',
                'bantuan_prov' => $item['bantuan_prov'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API PELAKU USAHA
    // ============================================
    
    public function get_data_pelaku_usaha()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        
        $data = $this->Peta_sebaran_model->get_filtered_pelaku_usaha($kecamatan);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id'],
                'nama_pelaku' => $item['nama'] ?? 'Tidak diketahui',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'nik' => $item['nik'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => ucfirst(strtolower($item['kecamatan'] ?? 'Tidak diketahui')),
                'kelurahan' => $item['kelurahan'] ?? '-',
                'telepon' => $item['telepon'] ?? '-',
                'tanggal_input' => $item['tanggal_input'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API PENJUAL PAKAN
    // ============================================
    
    public function get_data_penjual_pakan()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        
        $data = $this->Peta_sebaran_model->get_filtered_penjual_pakan($kecamatan);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id_penjual'],
                'nama_toko' => $item['nama_toko'] ?? 'Tidak diketahui',
                'nama_pemilik' => $item['nama_pemilik'] ?? '-',
                'nik' => $item['nik'] ?? '-',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'telp' => $item['telp'] ?? '-',
                'nib' => $item['nib'] ?? '-',
                'surat_ijin' => $item['surat_ijin'] ?? '-',
                'tanggal_input' => $item['tanggal_input'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API PENJUAL OBAT
    // ============================================
    
    public function get_data_penjual_obat()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        
        $data = $this->Peta_sebaran_model->get_filtered_penjual_obat($kecamatan);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id_penjual'],
                'nama_toko' => $item['nama_toko'] ?? 'Tidak diketahui',
                'nama_pemilik' => $item['nama_pemilik'] ?? '-',
                'nik' => $item['nik'] ?? '-',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'telp' => $item['telp'] ?? '-',
                'kategori_obat' => $item['kategori_obat'] ?? '-',
                'jenis_obat' => $item['jenis_obat'] ?? '-',
                'nib' => $item['nib'] ?? '-',
                'surat_ijin' => $item['surat_ijin'] ?? '-',
                'obat_hewan' => $item['obat_hewan'] ?? '-',
                'tanggal_input' => $item['tanggal_input'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API KLINIK HEWAN
    // ============================================
    
    public function get_data_klinik_hewan()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        
        $data = $this->Peta_sebaran_model->get_filtered_klinik_hewan($kecamatan);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id'],
                'nama_klinik' => $item['nama_klinik'] ?? 'Tidak diketahui',
                'nama_pemilik' => $item['nama_pemilik'] ?? '-',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'telp' => $item['telp'] ?? '-',
                'jumlah_dokter' => intval($item['jumlah_dokter']) ?: 0,
                'jenis_layanan' => $item['jenis_layanan'] ?? '-',
                'surat_ijin' => $item['surat_ijin'] ?? '-',
                'created_at' => $item['created_at'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API RPU
    // ============================================
    
    public function get_data_rpu()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');
        
        $data = $this->Peta_sebaran_model->get_filtered_rpu($kecamatan, $tgl_mulai, $tgl_selesai);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id'],
                'nama_rpu' => $item['nama_rpu'] ?? 'Tidak diketahui',
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'latitude' => $lat,
                'longitude' => $lng,
                'tanggal_rpu' => $item['tanggal_rpu'] ?? '0000-00-00',
                'nama_pj' => $item['nama_pj'] ?? '-',
                'telp_pj' => $item['telp_pj'] ?? '-',
                'tersedia_juleha' => $item['tersedia_juleha'] ?? '-',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API PEMOTONGAN UNGGAS
    // ============================================
    
    public function get_data_pemotongan_unggas()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');
        
        $data = $this->Peta_sebaran_model->get_filtered_pemotongan_unggas($kecamatan, $tgl_mulai, $tgl_selesai);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude'] ?? 0) ?: -7.2575;
            $lng = floatval($item['longitude'] ?? 0) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id_pemotongan'],
                'tanggal' => $item['tanggal'] ?? '0000-00-00',
                'ayam' => intval($item['ayam']) ?: 0,
                'itik' => intval($item['itik']) ?: 0,
                'dst' => intval($item['dst']) ?: 0,
                'daerah_asal' => $item['daerah_asal'] ?? '-',
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-',
                'nama_kecamatan' => $item['kecamatan_rpu'] ?? 'Tidak diketahui',
                'nama_rpu' => $item['nama_rpu'] ?? '-',
                'latitude' => $lat,
                'longitude' => $lng
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API DEMPLOT
    // ============================================
    
    public function get_data_demplot()
    {
        header('Content-Type: application/json');
        $kecamatan = $this->input->get('kecamatan') ? json_decode($this->input->get('kecamatan')) : [];
        
        $data = $this->Peta_sebaran_model->get_filtered_demplot($kecamatan);
        
        $formatted_data = [];
        foreach ($data as $item) {
            $lat = floatval($item['latitude']) ?: -7.2575;
            $lng = floatval($item['longitude']) ?: 112.7521;
            
            $formatted_data[] = [
                'id' => $item['id_demplot'],
                'nama_demplot' => $item['nama_demplot'] ?? 'Tidak diketahui',
                'alamat' => $item['alamat'] ?? 'Alamat tidak tersedia',
                'nama_kecamatan' => $item['kecamatan'] ?? 'Tidak diketahui',
                'kelurahan' => $item['kelurahan'] ?? '-',
                'luas_m2' => intval($item['luas_m2']) ?: 0,
                'jenis_hewan' => $item['jenis_hewan'] ?? '-',
                'jumlah_hewan' => intval($item['jumlah_hewan']) ?: 0,
                'stok_pakan' => $item['stok_pakan'] ?? '-',
                'latitude' => $lat,
                'longitude' => $lng,
                'nama_petugas' => $item['nama_petugas'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-',
                'created_at' => $item['created_at'] ?? '-'
            ];
        }
        echo json_encode($formatted_data);
    }

    // ============================================
    // API KECAMATAN
    // ============================================
    
    public function get_all_kecamatan()
    {
        header('Content-Type: application/json');
        echo json_encode($this->Peta_sebaran_model->get_all_kecamatan());
    }
}
?>