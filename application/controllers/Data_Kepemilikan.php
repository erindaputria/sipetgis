<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepemilikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Data_kepemilikan_model');
        $this->load->helper('url');
        $this->load->library('session');
        
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
        $jenis_usaha = trim(strtolower(urldecode($this->input->post('jenis_usaha') ?? '')));
        
        if (!$jenis_usaha) {
            echo json_encode(['error' => 'Jenis usaha tidak ditemukan']);
            return;
        }
        
        $detail = $this->Data_kepemilikan_model->get_detail_by_jenis_usaha($jenis_usaha);
        
        $html = '';
        $no = 1;
        
        // Array untuk memastikan NIK unik (mencegah duplikasi peternak)
        $unique_nik = [];
        
        foreach ($detail as $d) {
            // Jika NIK sudah pernah ditampilkan, skip
            if (in_array($d->nik, $unique_nik)) {
                continue;
            }
            $unique_nik[] = $d->nik;
            
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
            $html .= '<td align="center">' . number_format($d->jumlah ?? 0, 0, ',', '.') . ' Ekor<br><small>' . htmlspecialchars($d->komoditas_ternak ?? '-') . '</small></td>';
            $html .= '<td align="center">' . htmlspecialchars($d->telepon ?? '-') . '</td>';
            $html .= '</tr>';
        }
        
        $total_peternak = $this->Data_kepemilikan_model->get_count_peternak_by_jenis($jenis_usaha);
        
        echo json_encode([
            'html' => $html,
            'jenis_usaha' => $jenis_usaha,
            'total_data' => count($unique_nik),
            'total_peternak' => $total_peternak
        ]);
    }

    public function filter_data()
    {
        $jenis_usaha = trim(strtolower(urldecode($this->input->post('jenis_usaha') ?? '')));
        
        if ($jenis_usaha && $jenis_usaha != 'all') {
            $data_ternak = $this->Data_kepemilikan_model->get_filtered_data($jenis_usaha);
        } else {
            $data_ternak = $this->Data_kepemilikan_model->get_data_ternak();
        }
        
        $html = '';
        if (!empty($data_ternak)) {
            $no = 1;
            foreach ($data_ternak as $dt) {
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . htmlspecialchars($dt->jenis_usaha) . '</td>';
                $html .= '<td>' . number_format($dt->total_peternak, 0, ',', '.') . ' <span class="badge bg-secondary">Peternak</span></td>';
                $html .= '<td>' . number_format($dt->total_ternak, 0, ',', '.') . ' <span class="badge bg-success">Ekor</span></td>';
                $html .= '<td>';
                $html .= '<button class="btn btn-sm btn-info" onclick="showDetail(\'' . urlencode($dt->jenis_usaha) . '\')">';
                $html .= '<i class="fas fa-eye me-1"></i>Detail';
                $html .= '</button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="5" class="text-center">Tidak ada数据</td></tr>';
        }
        
        echo json_encode(['html' => $html]);
    }
    
    public function export_excel()
    {
        $data_ternak = $this->Data_kepemilikan_model->get_data_ternak();
        
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
        echo '.header-title { font-size: 18pt; font-weight: bold; text-align: center; margin-bottom: 5px; }';
        echo '.subtitle { font-size: 12pt; text-align: center; margin-bottom: 3px; }';
        echo 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
        echo 'th, td { border: 1px solid #000000; padding: 8px; }';
        echo 'th { background-color: #832706; color: white; text-align: center; font-weight: bold; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.footer-note { margin-top: 30px; font-size: 10px; text-align: center; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        echo '<div class="header-title">LAPORAN DATA KEPEMILIKAN TERNAK</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr>';
        echo '<div class="subtitle">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No</th>';
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
            $ternak = (int)($item->total_ekor ?? 0);
            $totalPeternak += $peternak;
            $totalTernak += $ternak;
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td>' . (!empty($item->jenis_ternak) ? $item->jenis_ternak : '-') . '</td>';
            echo '<td align="center">' . number_format($peternak, 0, ',', '.') . ' Peternak</td>';
            echo '<td align="center">' . number_format($ternak, 0, ',', '.') . ' Ekor</td>';
            echo '</tr>';
        }
        
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