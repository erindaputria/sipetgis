<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_stok_pakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_stok_pakan_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login'); 
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Stok Pakan';
        $data['demplot'] = $this->Laporan_stok_pakan_model->get_demplot();
        $data['tahun'] = $this->Laporan_stok_pakan_model->get_tahun();
        
        $this->load->view('laporan/laporan_stok_pakan', $data);
    }

    public function get_all_data()
    {
        $data = $this->Laporan_stok_pakan_model->get_all_data_stok_pakan();
        $total = $this->Laporan_stok_pakan_model->get_all_total_stok_pakan();
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $demplot = $this->input->post('demplot');
        
        $data = $this->Laporan_stok_pakan_model->get_data_stok_pakan($tahun, $demplot);
        $total = $this->Laporan_stok_pakan_model->get_total_stok_pakan($tahun, $demplot);
        
        $response = [
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
public function export_excel()
{
    $tahun = $this->input->get('tahun');
    $demplot = $this->input->get('demplot');
    
    // Jika tahun kosong atau 'all', ambil semua data
    if(empty($tahun) || $tahun == 'all') {
        $results = $this->Laporan_stok_pakan_model->get_all_data_stok_pakan();
        $total = $this->Laporan_stok_pakan_model->get_all_total_stok_pakan();
        $periodText = 'SEMUA DATA';
    } else {
        $results = $this->Laporan_stok_pakan_model->get_data_stok_pakan($tahun, $demplot);
        $total = $this->Laporan_stok_pakan_model->get_total_stok_pakan($tahun, $demplot);
        $periodText = 'TAHUN ' . $tahun;
    }
    
    $demplotText = ($demplot && $demplot != 'semua') ? $demplot : 'Seluruh Demplot';
    
    // Header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_Stok_Pakan_' . str_replace(' ', '_', $periodText) . '.xls"');
    header('Cache-Control: max-age=0');
    
    // Mulai output HTML sebagai Excel
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<style>';
    echo 'td, th { border: 1px solid #000; padding: 6px; }';
    echo 'th { background-color: #f2f2f2; }';
    echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
    echo '.stok-masuk { color: #2e7d32; }';
    echo '.stok-keluar { color: #c62828; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    
    // ==================== DETAIL STOK PAKAN ====================
    echo '<h2 align="center">DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN</h2>';
    echo '<h3 align="center">' . $demplotText . '</h3>';
    echo '<h4 align="center">Periode: ' . $periodText . '</h4>';
    echo '<br>';
    
    echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No</th>';
    echo '<th>Tanggal</th>';
    echo '<th>Nama Demplot</th>';
    echo '<th>Jenis Pakan</th>';
    echo '<th>Merk Pakan</th>';
    echo '<th>Stok Awal (kg)</th>';
    echo '<th>Stok Masuk (kg)</th>';
    echo '<th>Stok Keluar (kg)</th>';
    echo '<th>Stok Akhir (kg)</th>';
    echo '<th>Keterangan</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    $totalStokAwal = 0;
    $totalStokMasuk = 0;
    $totalStokKeluar = 0;
    $totalStokAkhir = 0;
    
    foreach($results as $item) {
        $stokAwal = (int)($item->stok_awal ?? 0);
        $stokMasuk = (int)($item->stok_masuk ?? 0);
        $stokKeluar = (int)($item->stok_keluar ?? 0);
        $stokAkhir = (int)($item->stok_akhir ?? 0);
        
        $totalStokAwal += $stokAwal;
        $totalStokMasuk += $stokMasuk;
        $totalStokKeluar += $stokKeluar;
        $totalStokAkhir += $stokAkhir;
        
        $tanggal = '-';
        if($item->tanggal && $item->tanggal != '0000-00-00') {
            $tanggal = date('d/m/Y', strtotime($item->tanggal));
        }
        
        $stokMasukDisplay = $stokMasuk > 0 ? '+' . number_format($stokMasuk, 0, ',', '.') : number_format($stokMasuk, 0, ',', '.');
        $stokKeluarDisplay = $stokKeluar > 0 ? '-' . number_format($stokKeluar, 0, ',', '.') : number_format($stokKeluar, 0, ',', '.');
        
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '<td align="center">' . $tanggal . '</td>';
        echo '<td align="left">' . ($item->nama_demplot ?? '-') . '</td>';
        echo '<td align="left">' . ($item->jenis_pakan ?? '-') . '</td>';
        echo '<td align="left">' . ($item->merk_pakan ?? '-') . '</td>';
        echo '<td align="right">' . number_format($stokAwal, 0, ',', '.') . ' kg</td>';
        echo '<td align="right" class="stok-masuk">' . $stokMasukDisplay . ' kg</td>';
        echo '<td align="right" class="stok-keluar">' . $stokKeluarDisplay . ' kg</td>';
        echo '<td align="right">' . number_format($stokAkhir, 0, ',', '.') . ' kg</td>';
        echo '<td align="left">' . ($item->keterangan ?? '-') . '</td>';
        echo '</tr>';
    }
    
    // Total row
    $transaksiCount = count($results);
    echo '<tr class="total-row">';
    echo '<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
    echo '<td align="right"><strong>' . number_format($totalStokAwal, 0, ',', '.') . ' kg</strong></td>';
    echo '<td align="right"><strong>' . number_format($totalStokMasuk, 0, ',', '.') . ' kg</strong></td>';
    echo '<td align="right"><strong>' . number_format($totalStokKeluar, 0, ',', '.') . ' kg</strong></td>';
    echo '<td align="right"><strong>' . number_format($totalStokAkhir, 0, ',', '.') . ' kg</strong></td>';
    echo '<td align="center"><strong>' . number_format($transaksiCount, 0, ',', '.') . ' Transaksi</strong></td>';
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    
    echo '</body>';
    echo '</html>';
    
    exit;
}
}
?>