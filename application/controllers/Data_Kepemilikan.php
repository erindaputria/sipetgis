<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepemilikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Data_kepemilikan_model');
        $this->load->helper('url');
        $this->load->library('session');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
  
    public function index()
    {
        $data['jenis_usaha_list'] = $this->Data_kepemilikan_model->get_all_jenis_usaha();
        $data['data_ternak'] = $this->Data_kepemilikan_model->get_data_ternak();
        $data['summary_kecamatan'] = $this->Data_kepemilikan_model->get_summary_by_kecamatan();
        $data['title'] = 'Data Kepemilikan Ternak';
        
        $this->load->view('admin/data/data_kepemilikan', $data);
    }

    public function get_detail_pelaku_usaha() {
        $jenis_usaha = $this->input->post('jenis_usaha');
        
        if (!$jenis_usaha) {
            echo json_encode(['error' => 'Jenis usaha tidak ditemukan']);
            return;
        }
        
        $jenis_usaha = urldecode($jenis_usaha);
        $detail = $this->Data_kepemilikan_model->get_detail_by_jenis_usaha($jenis_usaha);
        
        $html = '';
        $no = 1;
        foreach ($detail as $d) {
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td align="left">' . htmlspecialchars($d->nama_peternak ?? '-') . '</td>';
            $html .= '<td align="center">' . htmlspecialchars($d->nik ?? '-') . '</td>';
            $html .= '<td align="left">' . htmlspecialchars($d->kecamatan ?? '-') . '</td>';
            $alamat = $d->alamat ? $d->alamat : ($d->kelurahan ?? '-');
            if ($d->rt && $d->rw) {
                $alamat .= ' RT ' . $d->rt . '/RW ' . $d->rw;
            }
            $html .= '<td align="left">' . htmlspecialchars($alamat) . '</td>';
            $html .= '<td align="center">' . number_format($d->jumlah ?? 0, 0, ',', '.') . ' Ekor<br><small class="text-muted">' . htmlspecialchars($d->komoditas_ternak ?? '-') . '</small></td>';
            $html .= '<td align="center">' . htmlspecialchars($d->telepon ?? '-') . '</td>';
            $html .= '</tr>';
        }
        
        echo json_encode([
            'html' => $html,
            'jenis_usaha' => $jenis_usaha,
            'total_data' => count($detail)
        ]);
    }

    public function filter_data() {
        $jenis_usaha = $this->input->post('jenis_usaha');
        $data = $this->Data_kepemilikan_model->get_filtered_data($jenis_usaha);
        
        $html = '';
        $no = 1;
        foreach ($data as $d) {
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td align="left">' . htmlspecialchars($d->jenis_usaha) . '</td>';
            $html .= '<td align="center">' . $d->total_peternak . ' Peternak</td>';
            $html .= '<td align="center">' . number_format($d->total_ternak, 0, ',', '.') . ' Ekor</td>';
            $html .= '<td align="center">';
            $html .= '<button class="btn btn-detail btn-sm" onclick="showDetail(\'' . urlencode($d->jenis_usaha) . '\')">';
            $html .= '<i class="fas fa-eye me-1"></i>Detail';
            $html .= '</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        if (empty($data)) {
            $html .= '<tr><td colspan="5" class="text-center">Tidak ada data ditemukan</td></tr>';
        }
        
        echo json_encode(['html' => $html]);
    }

    // ==================== EXPORT EXCEL ====================
    public function export_excel()
    {
        $data_ternak = $this->Data_kepemilikan_model->get_data_ternak();
        
        // Bersihkan output buffer
        ob_clean();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Data_Kepemilikan_Ternak.xls"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<style>';
        echo 'body { margin: 20px; font-family: Arial, sans-serif; }';
        echo '.header-title { font-size: 18pt; font-weight: bold; color: #000000; text-align: center; margin-bottom: 5px; }';
        echo '.subtitle { font-size: 12pt; color: #000000; text-align: center; margin-bottom: 3px; }';
        echo 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
        echo 'th, td { border: 1px solid #000000; padding: 8px; }';
        echo 'th { background-color: #832706; color: #000000; text-align: center; font-weight: bold; }';
        echo 'td { color: #000000; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        echo '<div class="header-title">LAPORAN DATA KEPEMILIKAN TERNAK</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>Jenis Usaha</th>';
        echo '<th>Jumlah Peternak</th>';
        echo '<th>Total Ternak (Ekor)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalPeternak = 0;
        $totalTernak = 0;
        foreach($data_ternak as $item) {
            $peternak = (int)($item->total_peternak ?? 0);
            $ternak = (int)($item->total_ternak ?? 0);
            $totalPeternak += $peternak;
            $totalTernak += $ternak;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . (!empty($item->jenis_usaha) ? $item->jenis_usaha : '-') . '</td>';
            echo '<td align="center">' . number_format($peternak, 0, ',', '.') . ' Peternak</td>';
            echo '<td align="center">' . number_format($ternak, 0, ',', '.') . ' Ekor</td>';
            echo '</tr>';
        }
        
        // Total row
        echo '<tr class="total-row">';
        echo '<td colspan="2" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalPeternak, 0, ',', '.') . ' Peternak</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalTernak, 0, ',', '.') . ' Ekor</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        echo '<div class="footer-note">';
        echo 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
        echo '</div>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>