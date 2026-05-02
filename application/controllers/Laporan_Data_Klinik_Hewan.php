<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_klinik_hewan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_data_klinik_hewan_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }

    public function index()
    {
        $data['title'] = 'Laporan Data Klinik Hewan';
        $data['kecamatan'] = $this->Laporan_data_klinik_hewan_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_data_klinik_hewan_model->get_tahun();
        
        $this->load->view('laporan/laporan_data_klinik_hewan', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_data_klinik_hewan_model->get_data_klinik($tahun, $kecamatan);
        $total = $this->Laporan_data_klinik_hewan_model->get_total_klinik($tahun, $kecamatan);
        
        // Ambil rekap per kecamatan
        $rekap_kecamatan = $this->Laporan_data_klinik_hewan_model->get_rekap_klinik_per_kecamatan($tahun, $kecamatan);
        $total_rekap = $this->Laporan_data_klinik_hewan_model->get_total_rekap_klinik($tahun, $kecamatan);
        
        $response = [
            'data' => $data,
            'total' => $total,
            'rekap_kecamatan' => $rekap_kecamatan,
            'total_rekap' => $total_rekap
        ];
        
        echo json_encode($response);
    }
    
    public function get_all_data()
    {
        $data = $this->Laporan_data_klinik_hewan_model->get_all_data_klinik();
        $total = $this->Laporan_data_klinik_hewan_model->get_total_klinik(null, null);
        
        // Ambil rekap per kecamatan untuk SEMUA DATA
        $rekap_kecamatan = $this->Laporan_data_klinik_hewan_model->get_all_rekap_klinik();
        $total_rekap = $this->Laporan_data_klinik_hewan_model->get_all_total_rekap_klinik();
        
        $response = [
            'data' => $data,
            'total' => $total,
            'rekap_kecamatan' => $rekap_kecamatan,
            'total_rekap' => $total_rekap
        ];
        
        echo json_encode($response);
    }
    
    public function detail_kecamatan($kecamatan)
    {
        $kecamatan = urldecode($kecamatan);
        $tahun = $this->input->get('tahun');
        
        $data['kecamatan'] = $kecamatan;
        $data['tahun'] = $tahun;
        $data['results'] = $this->Laporan_data_klinik_hewan_model->get_data_klinik($tahun, $kecamatan);
        $data['total'] = $this->Laporan_data_klinik_hewan_model->get_total_klinik($tahun, $kecamatan);
        
        $this->load->view('laporan/detail_klinik_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        // Jika tahun kosong atau 'all', ambil semua data
        if(empty($tahun) || $tahun == 'all') {
            $results = $this->Laporan_data_klinik_hewan_model->get_all_data_klinik();
            $rekap_kecamatan = $this->Laporan_data_klinik_hewan_model->get_all_rekap_klinik();
            $total_rekap = $this->Laporan_data_klinik_hewan_model->get_all_total_rekap_klinik();
            $periodeText = 'SEMUA_DATA';
        } else {
            $results = $this->Laporan_data_klinik_hewan_model->get_data_klinik($tahun, $kecamatan);
            $rekap_kecamatan = $this->Laporan_data_klinik_hewan_model->get_rekap_klinik_per_kecamatan($tahun, $kecamatan);
            $total_rekap = $this->Laporan_data_klinik_hewan_model->get_total_rekap_klinik($tahun, $kecamatan);
            $periodeText = 'TAHUN_' . $tahun;
        }
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Klinik_Hewan_' . $periodeText . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.badge-ada { background-color: #e8f5e9; }';
        echo '.badge-tidak { background-color: #ffebee; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        // ==================== SHEET 1: DETAIL KLINIK ====================
        echo '<h2 align="center">DATA KLINIK HEWAN KOTA SURABAYA</h2>';
        echo '<h3 align="center">' . $kecamatanText . '</h3>';
        echo '<h4 align="center">Periode: ' . str_replace('_', ' ', $periodeText) . '</h4>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Klinik Hewan</th>';
        echo '<th>NIB</th>';
        echo '<th>Sertifikat Standar</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Jumlah Dokter</th>';
        echo '<th>Nama Pemilik</th>';
        echo '<th>No WA</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalKlinik = 0;
        $totalDokter = 0;
        
        foreach($results as $item) {
            $totalKlinik++;
            $dokter = (int)($item->jumlah_dokter ?? 0);
            $totalDokter += $dokter;
            
            $sertifikatHtml = ($item->sertifikat_standar ?? 'Tidak Ada') == 'Ada' 
                ? '<span style="background-color:#e8f5e9; padding:2px 8px;">Ada</span>' 
                : '<span style="background-color:#ffebee; padding:2px 8px;">Tidak Ada</span>';
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->nama_klinik ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nib ?? '-') . '</td>';
            echo '<td align="center">' . $sertifikatHtml . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="center">' . number_format($dokter, 0, ',', '.') . '</td>';
            echo '<td align="left">' . ($item->nama_pemilik ?? '-') . '</td>';
            echo '<td align="left">' . ($item->no_wa ?? '-') . '</td>';
            echo '</tr>';
        }
        
        // Total row
        echo '<tr class="total-row">';
        echo '<td colspan="7" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalDokter, 0, ',', '.') . ' Dokter</strong></td>';
        echo '<td colspan="2" align="center"><strong>' . number_format($totalKlinik, 0, ',', '.') . ' Klinik</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '<br><br>';
        
        // ==================== SHEET 2: REKAP PER KECAMATAN ====================
        echo '<h3 align="center">REKAP KLINIK HEWAN PER KECAMATAN</h3>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="50%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Jumlah Klinik</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $total = 0;
        foreach($rekap_kecamatan as $item) {
            $jumlah = (int)($item->jumlah_klinik ?? 0);
            $total += $jumlah;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="right"><strong>' . number_format($total, 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>