<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_data_vaksinasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->model('Laporan_history_data_vaksinasi_model');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        } 
    }

    public function index()
    {
        $data['title'] = 'Laporan History Data Vaksinasi';
        $data['kecamatan'] = $this->Laporan_history_data_vaksinasi_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_history_data_vaksinasi_model->get_tahun();
        $data['jenis_vaksin'] = $this->Laporan_history_data_vaksinasi_model->get_jenis_vaksin();
        
        $this->load->view('laporan/laporan_history_data_vaksinasi', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_vaksin = $this->input->post('jenis_vaksin');
        $jenis_hewan = $this->input->post('jenis_hewan');
        
        $data = $this->Laporan_history_data_vaksinasi_model->get_history_data($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_total_dosis($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'total_dosis' => $total_dosis,
            'jenis_vaksin' => $jenis_vaksin,
            'tahun' => $tahun,
            'count' => count($data)
        ];
        
        echo json_encode($response);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_vaksin = $this->input->get('jenis_vaksin');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        // Jika tahun kosong, gunakan tahun default
        if(empty($tahun)) {
            $tahun = date('Y');
        }
        
        // Ambil data
        $results = $this->Laporan_history_data_vaksinasi_model->get_history_data($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_total_dosis($tahun, $kecamatan, $jenis_vaksin, $jenis_hewan);
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisHewanText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        $jenisVaksinText = ($jenis_vaksin && $jenis_vaksin != 'semua') ? $jenis_vaksin : 'Semua Jenis Vaksin';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_History_Vaksinasi_' . str_replace(' ', '_', $jenisVaksinText) . '_' . $tahun . '.xls"');
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
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        
        // Judul Laporan
        echo '<td>';
        echo '<td colspan="10" align="center"><b>REKAP DATA VAKSIN ' . $jenisVaksinText . ' TAHUN ' . $tahun . '</b></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="10" align="center">Kota Surabaya - ' . $kecamatanText . $jenisHewanText . '</td>';
        echo '</tr>';
        echo '<tr><td colspan="10">&nbsp;</td></tr>';
        
        // Header Tabel
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Nama Petugas</th>';
        echo '<th>Nama Peternak</th>';
        echo '<th>NIK</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Jenis Hewan</th>';
        echo '<th>Dosis (Jumlah)</th>';
        echo '</tr>';
        
        // Data
        $no = 1;
        $total = 0;
        foreach($results as $item) {
            $jumlah = (int)($item->jumlah ?? 0);
            $total += $jumlah;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="center">' . ($item->tanggal ?? '-') . '</td>';
            echo '<td align="left">' . ($item->petugas ?? '-') . '</td>';
            echo '<td align="left">' . ($item->peternak ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nik ?? '-') . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->jenis_hewan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        // Total
        echo '<tr class="total-row">';
        echo '<td colspan="9" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="right"><strong>' . number_format($total, 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
        exit;
    }

    public function get_all_data()
{
    $data = $this->Laporan_history_data_vaksinasi_model->get_all_history_data();
    $total_dosis = $this->Laporan_history_data_vaksinasi_model->get_all_total_dosis();
    
    $response = [
        'status' => 'success',
        'data' => $data,
        'total_dosis' => $total_dosis,
        'count' => count($data)
    ];
    
    echo json_encode($response);
}
}
?>