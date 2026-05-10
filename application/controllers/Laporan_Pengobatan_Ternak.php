<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pengobatan_ternak extends CI_Controller {

    public function __construct()
    { 
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('Laporan_pengobatan_ternak_model');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
 
    public function index()
    {
        $data['title'] = 'Laporan Pengobatan Ternak';
        $data['kecamatan'] = $this->Laporan_pengobatan_ternak_model->get_kecamatan();
        $data['tahun'] = $this->Laporan_pengobatan_ternak_model->get_tahun();
        
        $this->load->view('laporan/laporan_pengobatan_ternak', $data);
    }

    public function get_data()
    {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        $jenis_hewan = $this->input->post('jenis_hewan');
        
        $data = $this->Laporan_pengobatan_ternak_model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
        $rekap_jenis = $this->Laporan_pengobatan_ternak_model->get_rekap_per_jenis_hewan($tahun, $kecamatan);
        $rekap_kecamatan = $this->Laporan_pengobatan_ternak_model->get_rekap_per_kecamatan($tahun, $jenis_hewan);
        
        // Ambil data rekap breakdown
        $rekap_breakdown = $this->Laporan_pengobatan_ternak_model->get_rekap_breakdown($tahun, $kecamatan, $jenis_hewan);
        $total_breakdown = $this->Laporan_pengobatan_ternak_model->get_total_breakdown($tahun, $kecamatan, $jenis_hewan);
        
        $response = [
            'data' => $data,
            'rekap_jenis' => $rekap_jenis,
            'rekap_kecamatan' => $rekap_kecamatan,
            'rekap_breakdown' => $rekap_breakdown,
            'total_breakdown' => $total_breakdown
        ];
        
        echo json_encode($response);
    }
    
    public function get_all_data()
    {
        $data = $this->Laporan_pengobatan_ternak_model->get_all_pengobatan();
        $rekap_jenis = $this->Laporan_pengobatan_ternak_model->get_all_rekap_per_jenis_hewan();
        $rekap_kecamatan = $this->Laporan_pengobatan_ternak_model->get_all_rekap_per_kecamatan();
        
        // Ambil rekap breakdown untuk SEMUA DATA (tahun null = ambil semua)
        $rekap_breakdown = $this->Laporan_pengobatan_ternak_model->get_rekap_breakdown(null, null, null);
        $total_breakdown = $this->Laporan_pengobatan_ternak_model->get_total_breakdown(null, null, null);
        
        $response = [
            'data' => $data,
            'rekap_jenis' => $rekap_jenis,
            'rekap_kecamatan' => $rekap_kecamatan,
            'rekap_breakdown' => $rekap_breakdown,
            'total_breakdown' => $total_breakdown
        ];
        
        echo json_encode($response);
    }
    
    public function detail_kecamatan($kecamatan, $jenis_hewan = null)
    {
        $data['kecamatan'] = urldecode($kecamatan);
        $data['jenis_hewan'] = $jenis_hewan;
        $data['tahun'] = $this->input->get('tahun');
        
        $data['details'] = $this->Laporan_pengobatan_ternak_model->get_detail_pengobatan(
            $data['kecamatan'], 
            $data['jenis_hewan'], 
            $data['tahun']
        );
        
        $this->load->view('laporan/detail_pengobatan_kecamatan', $data);
    }
    
    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $tahun = $this->input->get('tahun');
        $kecamatan = $this->input->get('kecamatan');
        $jenis_hewan = $this->input->get('jenis_hewan');
        
        if(empty($tahun) || $tahun == 'all') {
            // Ambil semua data
            $results = $this->Laporan_pengobatan_ternak_model->get_all_pengobatan();
            $rekapBreakdown = $this->Laporan_pengobatan_ternak_model->get_rekap_breakdown(null, null, null);
            $totalBreakdown = $this->Laporan_pengobatan_ternak_model->get_total_breakdown(null, null, null);
            
            // Hitung total jumlah dari results
            $totalJumlah = 0;
            foreach($results as $item) {
                $totalJumlah += (int)$item->jumlah;
            }
            
            $periodeText = 'SEMUA DATA';
        } else {
            // Ambil data sesuai filter
            $results = $this->Laporan_pengobatan_ternak_model->get_data_pengobatan($tahun, $kecamatan, $jenis_hewan);
            $rekapBreakdown = $this->Laporan_pengobatan_ternak_model->get_rekap_breakdown($tahun, $kecamatan, $jenis_hewan);
            $totalBreakdown = $this->Laporan_pengobatan_ternak_model->get_total_breakdown($tahun, $kecamatan, $jenis_hewan);
            
            // Hitung total jumlah dari results
            $totalJumlah = 0;
            foreach($results as $item) {
                $totalJumlah += (int)$item->jumlah;
            }
            
            $periodeText = 'TAHUN ' . $tahun;
        }
        
        $kecamatanText = ($kecamatan && $kecamatan != 'semua') ? 'Kecamatan ' . $kecamatan : 'Seluruh Kecamatan';
        $jenisText = ($jenis_hewan && $jenis_hewan != 'semua') ? ' - Jenis Hewan: ' . $jenis_hewan : '';
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Pengobatan_Ternak_' . str_replace(' ', '_', $periodeText) . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'td, th { border: 1px solid #000; padding: 6px; }';
        echo 'th { background-color: #f2f2f2; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.subtitle { background-color: #d9ead3; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        // ==================== SHEET 1: DETAIL PENGOBATAN ====================
        echo '<h2 align="center">REKAP DATA PENGOBATAN TERNAK</h2>';
        echo '<h3 align="center">Kota Surabaya - ' . $kecamatanText . $jenisText . '</h3>';
        echo '<h4 align="center">Periode: ' . $periodeText . '</h4>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
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
        echo '<th>Gejala Klinis</th>';
        echo '<th>Jenis Pengobatan</th>';
        echo '<th>Jumlah</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($results as $item) {
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="center">' . ($item->tanggal_pengobatan ? date('d/m/Y', strtotime($item->tanggal_pengobatan)) : '-') . '</td>';
            echo '<td align="left">' . ($item->nama_petugas ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nama_peternak ?? '-') . '</td>';
            echo '<td align="left">' . ($item->nik ?? '-') . '</td>';
            echo '<td align="left">' . ($item->alamat ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->kelurahan ?? '-') . '</td>';
            echo '<td align="left">' . ($item->komoditas_ternak ?? '-') . '</td>';
            echo '<td align="left">' . ($item->gejala_klinis ?? '-') . '</td>';
            echo '<td align="left">' . ($item->jenis_pengobatan ?? '-') . '</td>';
            echo '<td align="right">' . number_format((int)$item->jumlah, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="11" align="right"><strong>TOTAL JUMLAH TERNAK</strong></td>';
        echo '<td align="right"><strong>' . number_format($totalJumlah, 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '<br><br>';
        
        // ==================== SHEET 2: REKAP PER KECAMATAN ====================
        echo '<h3 align="center">REKAP PENGOBATAN PER KECAMATAN</h3>';
        
        echo '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Sapi Potong</th>';
        echo '<th>Sapi Perah</th>';
        echo '<th>Kambing</th>';
        echo '<th>Domba</th>';
        echo '<th>Ayam</th>';
        echo '<th>Itik</th>';
        echo '<th>Kelinci</th>';
        echo '<th>Kucing</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($rekapBreakdown as $item) {
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . ($item->kecamatan ?? '-') . '</td>';
            echo '<td align="right">' . number_format((int)($item->sapi_potong ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->sapi_perah ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->kambing ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->domba ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->ayam ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->itik ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->kelinci ?? 0), 0, ',', '.') . '</td>';
            echo '<td align="right">' . number_format((int)($item->kucing ?? 0), 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><strong>TOTAL</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->sapi_potong ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->sapi_perah ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->kambing ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->domba ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->ayam ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->itik ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->kelinci ?? 0), 0, ',', '.') . '</strong></td>';
        echo '<td align="right"><strong>' . number_format((int)($totalBreakdown->kucing ?? 0), 0, ',', '.') . '</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>