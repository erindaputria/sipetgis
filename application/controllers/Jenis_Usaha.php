<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Jenis_usaha_model');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->helper('url');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['jenis_usaha'] = $this->Jenis_usaha_model->get_all();
        $data['title'] = 'Master Jenis Usaha';
        $this->load->view('admin/jenis_usaha', $data);
    }
     
    public function simpan() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', strip_tags($errors));
            redirect('jenis_usaha');
        }
        
        $jenis_usaha = trim($this->input->post('jenis_usaha'));
        
        if ($this->Jenis_usaha_model->check_exists($jenis_usaha)) {
            $this->session->set_flashdata('error', 'Jenis Usaha "' . $jenis_usaha . '" sudah ada!');
            redirect('jenis_usaha');
        }
        
        $data = array(
            'jenis_usaha' => $jenis_usaha
        );
        
        $result = $this->Jenis_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', strip_tags($errors));
            redirect('jenis_usaha');
        }
        
        $jenis_usaha = trim($this->input->post('jenis_usaha'));
        
        if ($this->Jenis_usaha_model->check_exists($jenis_usaha, $id)) {
            $this->session->set_flashdata('error', 'Jenis Usaha "' . $jenis_usaha . '" sudah ada!');
            redirect('jenis_usaha');
        }
        
        $data = array(
            'jenis_usaha' => $jenis_usaha
        );
        
        $result = $this->Jenis_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function hapus($id = null) {
        if ($id === null) {
            $id = $this->uri->segment(3);
        }
        
        if ($id === null) {
            $id = $this->input->get('id');
        }
        
        if ($id === null || $id === '') {
            $this->session->set_flashdata('error', 'ID tidak ditemukan! Silakan coba lagi.');
            redirect('jenis_usaha');
        }
        
        $data = $this->Jenis_usaha_model->get_by_id($id);
        if (!$data) {
            $this->session->set_flashdata('error', 'Data jenis usaha dengan ID ' . $id . ' tidak ditemukan!');
            redirect('jenis_usaha');
        }
        
        $result = $this->Jenis_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data jenis usaha "' . $data->jenis_usaha . '" berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data jenis usaha');
        }
        
        redirect('jenis_usaha');
    }
    
    public function get_csrf() {
        $this->output->set_content_type('application/json');
        echo json_encode([
            'csrf_token' => $this->security->get_csrf_hash()
        ]);
    }

    // ==================== EXPORT EXCEL ====================
    public function export_excel()
    {
        $results = $this->Jenis_usaha_model->get_all();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Jenis_Usaha.xls"');
        header('Cache-Control: max-age=0');
        
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
        
        echo '<div class="header-title">LAPORAN DATA JENIS USAHA</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>Jenis Usaha</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($results as $item) {
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . (!empty($item->jenis_usaha) ? $item->jenis_usaha : '-') . '</td>';
            echo '</tr>';
        }
        
        $totalData = count($results);
        echo '<tr class="total-row">';
        echo '<td colspan="1" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Jenis Usaha</strong></td>';
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