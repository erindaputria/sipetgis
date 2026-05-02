<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjual_obat_hewan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_penjual_obat_hewan_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    } 
 
    public function index()
    {
        $data['title'] = 'Laporan Penjual Obat Hewan';
        $data['kecamatan'] = $this->Laporan_penjual_obat_hewan_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_penjual_obat_hewan_model->get_tahun();
        
        $this->load->view('laporan/laporan_penjual_obat_hewan', $data);
    }

    public function get_all_data()
    {
        $data = $this->Laporan_penjual_obat_hewan_model->get_all_data_penjual_obat();
        
        // Ambil rekap per kecamatan untuk SEMUA DATA
        $rekap_kecamatan = $this->Laporan_penjual_obat_hewan_model->get_all_rekap_per_kecamatan();
        $total_rekap = $this->Laporan_penjual_obat_hewan_model->get_all_total_rekap();
        
        $response = [
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
        
        $data = $this->Laporan_penjual_obat_hewan_model->get_data_penjual_obat($tahun, $kecamatan);
        
        // Ambil rekap per kecamatan sesuai filter
        $rekap_kecamatan = $this->Laporan_penjual_obat_hewan_model->get_rekap_per_kecamatan($tahun, $kecamatan);
        $total_rekap = $this->Laporan_penjual_obat_hewan_model->get_total_rekap($tahun, $kecamatan);
        
        $response = [
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
        $data['results'] = $this->Laporan_penjual_obat_hewan_model->get_data_penjual_obat($tahun, $kecamatan);
        $data['total'] = $this->Laporan_penjual_obat_hewan_model->get_total_penjual_obat($tahun, $kecamatan);
        
        $this->load->view('laporan/detail_penjual_obat_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
public function export_excel()
{
    $tahun = $this->input->get('tahun');
    $kecamatan = $this->input->get('kecamatan');
    
    // Jika tahun kosong atau 'all', ambil semua data
    if(empty($tahun) || $tahun == 'all') {
        $results = $this->Laporan_penjual_obat_hewan_model->get_all_data_penjual_obat();
        $rekap_kecamatan = $this->Laporan_penjual_obat_hewan_model->get_all_rekap_per_kecamatan();
        $periodeText = 'SEMUA DATA';
    } else {
        $results = $this->Laporan_penjual_obat_hewan_model->get_data_penjual_obat($tahun, $kecamatan);
        $rekap_kecamatan = $this->Laporan_penjual_obat_hewan_model->get_rekap_per_kecamatan($tahun, $kecamatan);
        $periodeText = 'TAHUN ' . $tahun;
    }
    
    $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
    
    // Header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_Penjual_Obat_Hewan_' . str_replace(' ', '_', $periodeText) . '.xls"');
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
    
    // ==================== SHEET 1: DETAIL PENJUAL OBAT ====================
    echo '<h2 align="center">DATA PENJUAL OBAT HEWAN</h2>';
    echo '<h3 align="center">Kota Surabaya - ' . $kecamatanText . '</h3>';
    echo '<h4 align="center">Periode: ' . $periodeText . '</h4>';
    echo '<br>';
    
    echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No</th>';
    echo '<th>Nama Toko</th>';
    echo '<th>Nama Pemilik</th>';
    echo '<th>NIB</th>';
    echo '<th>Alamat</th>';
    echo '<th>Kecamatan</th>';
    echo '<th>Kelurahan</th>';
    echo '<th>Dagangan</th>';
    echo '<th>No Telepon</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    foreach($results as $item) {
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '<td align="left">' . ($item->nama_toko ?? '-') . '</td>';
        echo '<td align="left">' . ($item->nama_pemilik ?? '-') . '</td>';
        echo '<td align="left">' . ($item->nib ?? '-') . '</td>';
        echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
        echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
        echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
        echo '<td align="left">' . ($item->dagangan ?? '-') . '</td>';
        echo '<td align="left">' . ($item->telp ?? '-') . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    
    echo '<br><br>';
    
    // ==================== SHEET 2: REKAP PER KECAMATAN ====================
    echo '<h3 align="center">REKAP PENJUAL OBAT PER KECAMATAN</h3>';
    
    echo '<table border="1" cellpadding="5" cellspacing="0" width="50%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No</th>';
    echo '<th>Kecamatan</th>';
    echo '<th>Jumlah Toko</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    $totalToko = 0;
    foreach($rekap_kecamatan as $item) {
        $jumlah = (int)($item->jumlah_toko ?? 0);
        $totalToko += $jumlah;
        
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
        echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . '</td>';
        echo '</tr>';
    }
    
    echo '<tr class="total-row">';
    echo '<td colspan="2" align="center"><strong>TOTAL</strong></td>';
    echo '<td align="right"><strong>' . number_format($totalToko, 0, ',', '.') . '</strong></td>';
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    
    echo '</body>';
    echo '</html>';
    
    exit;
}
}
?>