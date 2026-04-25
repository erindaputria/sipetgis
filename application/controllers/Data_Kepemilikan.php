<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepemilikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Data_kepemilikan_model');
        $this->load->helper('url');
    }
 
    public function index()
    {
        $data['jenis_usaha_list'] = $this->Data_kepemilikan_model->get_all_jenis_usaha();
        $data['data_ternak'] = $this->Data_kepemilikan_model->get_data_ternak();
        $data['summary_kecamatan'] = $this->Data_kepemilikan_model->get_summary_by_kecamatan();
        
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
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . htmlspecialchars($d->nama_peternak ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($d->nik ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($d->kecamatan ?? '-') . '</td>';
            $alamat = $d->alamat ? $d->alamat : ($d->kelurahan ?? '-');
            if ($d->rt && $d->rw) {
                $alamat .= ' RT ' . $d->rt . '/RW ' . $d->rw;
            }
            $html .= '<td>' . htmlspecialchars($alamat) . '</td>';
            $html .= '<td>' . number_format($d->jumlah ?? 0, 0, ',', '.') . ' Ekor<br><small class="text-muted">' . htmlspecialchars($d->komoditas_ternak ?? '-') . '</small></td>';
            $html .= '<td>' . htmlspecialchars($d->telepon ?? '-') . '</td>';
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
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . htmlspecialchars($d->jenis_usaha) . '</td>';
            $html .= '<td>' . $d->total_peternak . ' <span class="text-muted">Peternak</span></td>';
            $html .= '<td>' . number_format($d->total_ternak, 0, ',', '.') . ' <span class="badge-ternak">Ekor</span></td>';
            $html .= '<td>';
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
}
?>