<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_data_tpu_rpu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_data_tpu_rpu_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = 'Laporan Data TPU/RPU';
        $data['kecamatan'] = $this->Laporan_data_tpu_rpu_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_data_tpu_rpu_model->get_tahun();
        
        $this->load->view('laporan/laporan_data_tpu_rpu', $data);
    }

    public function get_all_data()
    {
        $data = $this->Laporan_data_tpu_rpu_model->get_all_data_tpu_rpu();
        
        // Ambil rekap per kecamatan untuk SEMUA DATA
        $rekap_kecamatan = $this->Laporan_data_tpu_rpu_model->get_all_rekap_tpu();
        $total_rekap = $this->Laporan_data_tpu_rpu_model->get_all_total_rekap_tpu();
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'rekap_kecamatan' => $rekap_kecamatan,
            'total_rekap' => $total_rekap
        ];
        
        echo json_encode($response);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        if(empty($tahun)) {
            $tahun = null;
        }
        
        if(empty($kecamatan) || $kecamatan == 'semua') {
            $kecamatan = null;
        }
        
        $data = $this->Laporan_data_tpu_rpu_model->get_data_tpu_rpu($tahun, $kecamatan);
        
        // Ambil rekap per kecamatan sesuai filter
        $rekap_kecamatan = $this->Laporan_data_tpu_rpu_model->get_rekap_tpu_per_kecamatan($tahun, $kecamatan);
        $total_rekap = $this->Laporan_data_tpu_rpu_model->get_total_rekap_tpu($tahun, $kecamatan);
        
        $response = [
            'status' => 'success',
            'data' => $data,
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
        $data['results'] = $this->Laporan_data_tpu_rpu_model->get_data_tpu_rpu($tahun, $kecamatan);
        
        $this->load->view('laporan/detail_tpu_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        // Jika tahun kosong atau 'all', ambil semua data
        if(empty($tahun) || $tahun == 'all') {
            $results = $this->Laporan_data_tpu_rpu_model->get_all_data_tpu_rpu();
            $rekap_kecamatan = $this->Laporan_data_tpu_rpu_model->get_all_rekap_tpu();
            $periodText = 'SEMUA DATA';
        } else {
            $results = $this->Laporan_data_tpu_rpu_model->get_data_tpu_rpu($tahun, $kecamatan);
            $rekap_kecamatan = $this->Laporan_data_tpu_rpu_model->get_rekap_tpu_per_kecamatan($tahun, $kecamatan);
            $periodText = 'TAHUN ' . $tahun;
        }
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_TPU_RPU_' . str_replace(' ', '_', $periodText) . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.badge-izin { background-color: #e8f5e9; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        // ==================== SHEET 1: DETAIL TPU/RPU ====================
        echo '<h2 align="center">DATA TEMPAT PEMOTONGAN UNGGAS</h2>';
        echo '<h3 align="center">Kota Surabaya - ' . $kecamatanText . '</h3>';
        echo '<h4 align="center">Periode: ' . $periodText . '</h4>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama TPU/RPU</th>';
        echo '<th>Perizinan</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Penanggung Jawab</th>';
        echo '<th>No Telepon</th>';
        echo '<th>Ayam (Ekor)</th>';
        echo '<th>Itik (Ekor)</th>';
        echo '<th>Lainnya (Ekor)</th>';
        echo '<th>Tersedia Juleha</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalAyam = 0;
        $totalItik = 0;
        $totalLainnya = 0;
        
        foreach($results as $item) {
            $ayam = (int)($item->jumlah_pemotongan->ayam ?? 0);
            $itik = (int)($item->jumlah_pemotongan->itik ?? 0);
            $lainnya = (int)($item->jumlah_pemotongan->lainnya ?? 0);
            
            $totalAyam += $ayam;
            $totalItik += $itik;
            $totalLainnya += $lainnya;
            
            $izinHtml = '<span style="background-color:#e8f5e9; padding:2px 8px;">' . ($item->perizinan ?? '-') . '</span>';
            $julehaHtml = ($item->tersedia_juleha ?? 'Tidak') == 'Ya' 
                ? '<span style="background-color:#e8f5e9; padding:2px 8px;">Ya</span>' 
                : '<span style="background-color:#ffebee; padding:2px 8px;">Tidak</span>';
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->nama_tpu ?? '-') . '</td>';
            echo '<td align="center">' . $izinHtml . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->pj ?? '-') . '</td>';
            echo '<td align="left">' . ($item->no_telp ?? '-') . '</td>';
            echo '<td align="right">' . number_format($ayam, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format($itik, 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format($lainnya, 0, ',', '.') . '</td>';
            echo '<td align="center">' . $julehaHtml . '</td>';
            echo '</tr>';
        }
        
        // Total row
        echo '<tr class="total-row">';
        echo '<td colspan="8" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalAyam, 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalItik, 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalLainnya, 0, ',', '.') . '</strong></td>';
        echo '<td align="center"><strong>' . number_format(count($results), 0, ',', '.') . ' TPU/RPU</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '<br><br>';
        
        // ==================== SHEET 2: REKAP PER KECAMATAN ====================
        echo '<h3 align="center">REKAP TPU/RPU PER KECAMATAN</h3>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="50%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Jumlah TPU/RPU</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalTpu = 0;
        foreach($rekap_kecamatan as $item) {
            $jumlah = (int)($item->jumlah_tpu ?? 0);
            $totalTpu += $jumlah;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalTpu, 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>