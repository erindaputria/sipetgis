<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_pakan_ternak extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_penjual_pakan_ternak_model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }

    public function index()
    { 
        $data['title'] = 'Laporan Penjual Pakan Ternak';
        $data['kecamatan'] = $this->Laporan_penjual_pakan_ternak_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_penjual_pakan_ternak_model->get_tahun();
        
        $this->load->view('laporan/laporan_penjual_pakan_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_penjual_pakan_ternak_model->get_data_penjual_pakan($tahun, $kecamatan);
        $total = $this->Laporan_penjual_pakan_ternak_model->get_total_penjual_pakan($tahun, $kecamatan);
        
        // Ambil data rekap per kecamatan
        $rekap_kecamatan = $this->Laporan_penjual_pakan_ternak_model->get_rekap_per_kecamatan($tahun, $kecamatan);
        $total_rekap = $this->Laporan_penjual_pakan_ternak_model->get_total_rekap($tahun, $kecamatan);
        
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
        $data = $this->Laporan_penjual_pakan_ternak_model->get_all_data_penjual_pakan();
        $total = $this->Laporan_penjual_pakan_ternak_model->get_total_penjual_pakan('', 'semua');
        
        // Ambil semua rekap per kecamatan (tanpa filter)
        $rekap_kecamatan = $this->Laporan_penjual_pakan_ternak_model->get_all_rekap_per_kecamatan();
        $total_rekap = $this->Laporan_penjual_pakan_ternak_model->get_all_total_rekap();
        
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
        $data['kecamatan'] = urldecode($kecamatan);
        $data['tahun'] = $this->input->get('tahun');
        
        $data['details'] = $this->Laporan_penjual_pakan_ternak_model->get_detail_by_kecamatan(
            $data['kecamatan'], 
            $data['tahun']
        );
        
        $this->load->view('laporan/detail_penjual_pakan_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        
        // Jika tahun kosong atau 'all', ambil semua data
        if(empty($tahun) || $tahun == 'all') {
            $results = $this->Laporan_penjual_pakan_ternak_model->get_all_data_penjual_pakan();
            $rekap_kecamatan = $this->Laporan_penjual_pakan_ternak_model->get_all_rekap_per_kecamatan();
            $total_rekap = $this->Laporan_penjual_pakan_ternak_model->get_all_total_rekap();
            $periodeText = 'SEMUA_DATA';
        } else {
            $results = $this->Laporan_penjual_pakan_ternak_model->get_data_penjual_pakan($tahun, $kecamatan);
            $rekap_kecamatan = $this->Laporan_penjual_pakan_ternak_model->get_rekap_per_kecamatan($tahun, $kecamatan);
            $total_rekap = $this->Laporan_penjual_pakan_ternak_model->get_total_rekap($tahun, $kecamatan);
            $periodeText = 'TAHUN_' . $tahun;
        }
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Penjual_Pakan_Ternak_' . $periodeText . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        // ==================== SHEET 1: DETAIL PENJUAL PAKAN ====================
        echo '<h2 align="center">DATA PENJUAL PAKAN TERNAK</h2>';
        echo '<h3 align="center">Kota Surabaya - ' . $kecamatanText . '</h3>';
        echo '<h4 align="center">Periode: ' . str_replace('_', ' ', $periodeText) . '</h4>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Toko/Perusahaan</th>';
        echo '<th>NIB/SIUP</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Nama Pemilik</th>';
        echo '<th>No WA</th>';
        echo '<th>Obat Hewan</th>';
        echo '<th>Surat Ijin</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($results as $item) {
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->nama_toko ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nib ?? '-') . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nama_pemilik ?? '-') . '</td>';
            echo '<td align="left">' . ($item->telp ?? '-') . '</td>';
            echo '<td align="center">' . (($item->obat_hewan ?? 'N') == 'Y' ? 'Ya' : 'Tidak') . '</td>';
            echo '<td align="center">' . (($item->surat_ijin ?? 'N') == 'Y' ? 'Ya' : 'Tidak') . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        
        echo '<br><br>';
        
        // ==================== SHEET 2: REKAP PER KECAMATAN ====================
        echo '<h3 align="center">REKAP PENJUAL PAKAN PER KECAMATAN</h3>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="50%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Jumlah Usaha</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalUsaha = 0;
        foreach($rekap_kecamatan as $item) {
            $jumlah = (int)($item->jumlah_usaha ?? 0);
            $totalUsaha += $jumlah;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><strong>TOTAL</strong></table>';
        echo '<td align="right"><strong>' . number_format($totalUsaha, 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>