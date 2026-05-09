<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_klinik extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Layanan_klinik_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
     
    public function index() {
        $data['layanan_klinik'] = $this->Layanan_klinik_model->get_all();
        $data['title'] = 'Master Layanan Klinik';
        $this->load->view('admin/layanan_klinik', $data);
    }
    
    public function simpan() {
        $this->form_validation->set_rules('nama_layanan', 'Nama Layanan', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors(); 
            $this->session->set_flashdata('error', $errors);
            redirect('layanan_klinik');
        }
        
        $nama_layanan = $this->input->post('nama_layanan');
        if ($this->Layanan_klinik_model->check_nama($nama_layanan)) {
            $this->session->set_flashdata('error', 'Nama layanan sudah terdaftar');
            redirect('layanan_klinik');
        }
        
        $data = array('nama_layanan' => $nama_layanan);
        $result = $this->Layanan_klinik_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data layanan klinik berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data layanan klinik');
        }
        
        redirect('layanan_klinik');
    }
    
    public function update() {
        $id = $this->input->post('id_layanan');
        
        if (!$id) {
            $this->session->set_flashdata('error', 'ID layanan tidak ditemukan');
            redirect('layanan_klinik');
        }
        
        $this->form_validation->set_rules('nama_layanan', 'Nama Layanan', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('layanan_klinik');
        }
        
        $nama_layanan = $this->input->post('nama_layanan');
        $existing = $this->Layanan_klinik_model->check_nama_except($nama_layanan, $id);
        if ($existing) {
            $this->session->set_flashdata('error', 'Nama layanan sudah digunakan oleh data lain');
            redirect('layanan_klinik');
        }
        
        $data = array('nama_layanan' => $nama_layanan);
        $result = $this->Layanan_klinik_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data layanan klinik berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data layanan klinik');
        }
        
        redirect('layanan_klinik');
    }
    
    public function hapus_ajax() {
        $id = $this->input->post('id');
        
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            return;
        }
        
        $result = $this->Layanan_klinik_model->delete($id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data layanan klinik berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data layanan klinik']);
        }
    }

    public function export_excel()
    {
        $results = $this->Layanan_klinik_model->get_all();
        
        ob_clean();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Layanan_Klinik.xls"');
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
        
        echo '<div class="header-title">LAPORAN DATA LAYANAN KLINIK</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>Nama Layanan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalData = 0;
        foreach($results as $item) {
            $totalData++;
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</tr>';
            echo '<td align="left">' . (!empty($item->nama_layanan) ? $item->nama_layanan : '-') . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="1" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Data Layanan</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '<table>';
        
        echo '<div class="footer-note">';
        echo 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
        echo '</div>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>