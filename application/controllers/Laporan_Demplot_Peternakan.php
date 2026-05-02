<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_demplot_peternakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_demplot_peternakan_model');
        
        if(!$this->session->userdata('logged_in')) { 
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Demplot Peternakan';
        $data['demplot'] = $this->Laporan_demplot_peternakan_model->get_demplot();
        $data['tahun'] = $this->Laporan_demplot_peternakan_model->get_tahun();
        $data['kecamatan'] = $this->Laporan_demplot_peternakan_model->get_kecamatan();
        
        $this->load->view('laporan/laporan_demplot_peternakan', $data);
    }

    public function get_all_data()
    {
        $data = $this->Laporan_demplot_peternakan_model->get_all_data_demplot();
        
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        
        echo json_encode($response);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $demplot = $this->input->post('demplot');
        $kecamatan = $this->input->post('kecamatan');
        
        $data = $this->Laporan_demplot_peternakan_model->get_data_demplot($tahun, $demplot, $kecamatan);
        $total = $this->Laporan_demplot_peternakan_model->get_total_demplot($tahun, $demplot, $kecamatan);
        
        $response = [
            'status' => 'success',
            'data' => $data,
            'total' => $total
        ];
        
        echo json_encode($response);
    }
    
    public function detail_demplot($nama_demplot)
    {
        $tahun = $this->input->get('tahun');
        $data['nama_demplot'] = urldecode($nama_demplot);
        $data['tahun'] = $tahun;
        $data['details'] = $this->Laporan_demplot_peternakan_model->get_detail_demplot($nama_demplot, $tahun);
        
        $this->load->view('laporan/laporan_demplot_detail', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $demplot = $this->input->get('demplot');
        $kecamatan = $this->input->get('kecamatan');
        
        // Jika tahun kosong atau 'semua', ambil semua data
        if(empty($tahun) || $tahun == 'semua' || $tahun == 'all') {
            $results = $this->Laporan_demplot_peternakan_model->get_all_data_demplot();
            $periodText = 'SEMUA DATA';
        } else {
            $results = $this->Laporan_demplot_peternakan_model->get_data_demplot($tahun, $demplot, $kecamatan);
            $periodText = 'TAHUN ' . $tahun;
        }
        
        $demplotText = ($demplot && $demplot != 'semua') ? $demplot : 'Seluruh Demplot';
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Demplot_Peternakan_' . str_replace(' ', '_', $periodText) . '.xls"');
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
        
        // ==================== DETAIL DEMPLOT ====================
        echo '<h2 align="center">DATA DEMPLOT PETERNAKAN</h2>';
        echo '<h3 align="center">Kota Surabaya - ' . $demplotText . ' - ' . $kecamatanText . '</h3>';
        echo '<h4 align="center">Periode: ' . $periodText . '</h4>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Demplot</th>';
        echo '<th>Alamat</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Kelurahan</th>';
        echo '<th>Luas (m²)</th>';
        echo '<th>Jenis Hewan</th>';
        echo '<th>Jumlah (ekor)</th>';
        echo '<th>Stok Pakan</th>';
        echo '<th>Keterangan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalLuas = 0;
        $totalJumlah = 0;
        
        foreach($results as $item) {
            $luas = (float)($item->luas_m2 ?? 0);
            $jumlah = (int)($item->jumlah_hewan ?? 0);
            
            $totalLuas += $luas;
            $totalJumlah += $jumlah;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->nama_demplot ?? '-') . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($luas, 0, ',', '.') . ' m²</td>';
            echo '<td align="left">' . ($item->jenis_hewan ?? '-') . '</td>';
            echo '<td align="right">' . number_format($jumlah, 0, ',', '.') . ' ekor</td>';
            echo '<td align="left">' . ($item->stok_pakan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->keterangan ?? '-') . '</td>';
            echo '</tr>';
        }
        
        // Total row
        echo '<tr class="total-row">';
        echo '<td colspan="5" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalLuas, 0, ',', '.') . ' m²</strong></td>';
        echo '<td align="center"><strong>-</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalJumlah, 0, ',', '.') . ' ekor</strong></td>';
        echo '<td colspan="2" align="center"><strong>' . number_format(count($results), 0, ',', '.') . ' Demplot</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>