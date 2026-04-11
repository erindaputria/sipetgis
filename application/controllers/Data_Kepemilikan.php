<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Kepemilikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Data_Kepemilikan_Model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['komoditas'] = $this->Data_Kepemilikan_Model->get_komoditas();
        $data['data_ternak'] = $this->Data_Kepemilikan_Model->get_data_ternak();
        $data['summary_kecamatan'] = $this->Data_Kepemilikan_Model->get_summary_by_kecamatan();
        $data['summary_jenis_usaha'] = $this->Data_Kepemilikan_Model->get_summary_by_jenis_usaha();
        
        $this->load->view('admin/data/data_kepemilikan', $data);
    }

    public function get_detail_pelaku_usaha() {
        $jenis_usaha = $this->input->post('jenis_usaha');
        
        $detail = $this->Data_Kepemilikan_Model->get_detail_by_jenis_usaha($jenis_usaha);
        
        $html = '';
        $no = 1;
        foreach ($detail as $d) {
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . htmlspecialchars($d->nama_peternak ?? '-') . '<br>';
            $html .= '<small class="text-muted">NIK: ' . htmlspecialchars($d->nik ?? '-') . '</small></td>';
            $html .= '<td>' . htmlspecialchars($d->kecamatan ?? '-') . '<br>';
            $html .= '<small>' . htmlspecialchars($d->kelurahan ?? '-') . ' RT/RW: ' . htmlspecialchars(($d->rt ?? '-') . '/' . ($d->rw ?? '-')) . '</small></td>';
            $html .= '<td>' . htmlspecialchars($d->jenis_usaha ?? '-') . '</td>';
            $html .= '<td>' . number_format($d->jumlah ?? 0, 0, ',', '.') . ' Ekor</td>';
            $html .= '<td>-</td>'; // Kolom foto
            $html .= '</tr>';
        }
        
        echo json_encode([
            'html' => $html,
            'jenis_usaha' => $jenis_usaha,
            'total_data' => count($detail)
        ]);
    }

    public function get_all_data() {
        $data = $this->Data_Kepemilikan_Model->get_data_ternak();
        
        $html = '';
        foreach ($data as $d) {
            $html .= '<tr>';
            $html .= '<td>' . $d->no . '</td>';
            $html .= '<td>' . htmlspecialchars($d->jenis_ternak) . '</td>';
            $html .= '<td>' . htmlspecialchars($d->nama_komoditas) . '</td>';
            $html .= '<td>' . number_format($d->jumlah, 0, ',', '.') . ' <span class="badge-ternak">' . $d->satuan . '</span></td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-detail btn-sm" onclick="showDetail(\'' . urlencode($d->jenis_ternak) . '\', \'' . htmlspecialchars($d->jenis_ternak, ENT_QUOTES) . '\')">';
            $html .= '<i class="fas fa-eye me-1"></i>Detail Peternak</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        echo json_encode(['html' => $html]);
    }
}