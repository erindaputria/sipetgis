<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpu extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Rpu_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['rpu'] = $this->Rpu_model->get_all();
        $data['title'] = 'Master Data RPU';
        $this->load->view('admin/rpu', $data);
    }
    
    public function simpan() {
        $pejagal = $this->input->post('pejagal');
        
        if (empty($pejagal)) {
            $this->session->set_flashdata('error', 'Nama RPU tidak boleh kosong');
            redirect('rpu');
        }
        
        $existing = $this->Rpu_model->check_pejagal($pejagal);
        if ($existing) {
            $this->session->set_flashdata('error', 'Nama RPU sudah terdaftar');
            redirect('rpu');
        }
        
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        
        $data = array(
            'pejagal' => $pejagal,
            'latitude' => (!empty($latitude) && $latitude != '') ? $latitude : null,
            'longitude' => (!empty($longitude) && $longitude != '') ? $longitude : null
        );
        
        $result = $this->Rpu_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data RPU');
        }
        
        redirect('rpu');
    }
    
    public function update() {
        $pejagal_lama = $this->input->post('pejagal_lama');
        $pejagal_baru = $this->input->post('pejagal');
        
        if (empty($pejagal_baru)) {
            $this->session->set_flashdata('error', 'Nama RPU tidak boleh kosong');
            redirect('rpu');
        }
        
        if ($pejagal_lama != $pejagal_baru) {
            $existing = $this->Rpu_model->check_pejagal($pejagal_baru);
            if ($existing) {
                $this->session->set_flashdata('error', 'Nama RPU sudah terdaftar');
                redirect('rpu');
            }
        }
        
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        
        $data = array(
            'pejagal' => $pejagal_baru,
            'latitude' => (!empty($latitude) && $latitude != '') ? $latitude : null,
            'longitude' => (!empty($longitude) && $longitude != '') ? $longitude : null
        );
        
        $result = $this->Rpu_model->update($pejagal_lama, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data RPU berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data RPU');
        }
         
        redirect('rpu');
    }
    
    public function hapus_ajax() {
        $pejagal = $this->input->post('pejagal');
        
        if (!$pejagal) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            return;
        }
        
        $result = $this->Rpu_model->delete($pejagal);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data RPU berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data RPU']);
        }
    }

    public function export_excel() {
        $results = $this->Rpu_model->get_all();
        
        ob_clean();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_RPU.xls"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        echo '<html><head><meta charset="UTF-8"><style>';
        echo 'body { margin: 20px; font-family: Arial, sans-serif; }';
        echo '.header-title { font-size: 18pt; font-weight: bold; color: #000000; text-align: center; margin-bottom: 5px; }';
        echo '.subtitle { font-size: 12pt; color: #000000; text-align: center; margin-bottom: 3px; }';
        echo 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
        echo 'th, td { border: 1px solid #000000; padding: 8px; }';
        echo 'th { background-color: #832706; color: #000000; text-align: center; font-weight: bold; }';
        echo 'td { color: #000000; }';
        echo '.total-row { background-color: #e8f5e9; font-weight: bold; }';
        echo '.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }';
        echo '</style></head><body>';
        
        echo '<div class="header-title">LAPORAN DATA RPU</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div><br>';
        
        echo '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
        echo '<thead><tr>';
        echo '<th width="40">No</th>';
        echo '<th>Nama RPU</th>';
        echo '<th>Latitude</th>';
        echo '<th>Longitude</th>';
        echo '</tr></thead><tbody>';
        
        $no = 1;
        $totalData = 0;
        foreach($results as $item) {
            $totalData++;
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . (!empty($item->pejagal) ? $item->pejagal : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->latitude) ? $item->latitude : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->longitude) ? $item->longitude : '-') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Data RPU</strong></td>';
        echo '</tr>';
        
        echo '</tbody></table>';
        echo '<div class="footer-note">SIPETGIS - Sistem Informasi Peternakan Kota Surabaya</div>';
        echo '</body></html>';
        
        exit;
    }

    public function get_all_data()
{
    $data = $this->Rpu_model->get_all();
    echo json_encode($data);
}
}
?> 