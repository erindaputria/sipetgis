<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaku_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Pelaku_usaha_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('security');
         
        // Cek login (sesuaikan dengan sistem autentikasi Anda)
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
     
    public function index() {
        $data['pelaku_usaha'] = $this->Pelaku_usaha_model->get_all();
        $data['title'] = 'Master Data Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha', $data);
    }
    
    public function simpan() {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada atau belum
        $nik = $this->input->post('nik');
        if ($this->Pelaku_usaha_model->check_nik($nik)) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama', TRUE),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kecamatan' => $this->input->post('kecamatan', TRUE),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function update() {
        // Validasi input
        $this->form_validation->set_rules('id', 'ID', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('telepon', 'Telepon', 'min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('pelaku_usaha');
        }
        
        $id = $this->input->post('id');
        $nik = $this->input->post('nik');
        
        // Cek apakah data dengan ID tersebut ada
        $existing_data = $this->Pelaku_usaha_model->get_by_id($id);
        if (!$existing_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        // Cek NIK sudah ada untuk pengguna lain (kecuali data sendiri)
        $check_nik = $this->Pelaku_usaha_model->check_nik_except($nik, $id);
        if ($check_nik) {
            $this->session->set_flashdata('error', 'NIK sudah digunakan oleh pelaku usaha lain');
            redirect('pelaku_usaha');
        }
        
        $data = array(
            'nama' => $this->input->post('nama', TRUE),
            'nik' => $nik,
            'telepon' => $this->input->post('telepon', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kecamatan' => $this->input->post('kecamatan', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->Pelaku_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function hapus($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('pelaku_usaha');
        }
        
        // Cek apakah data dengan ID tersebut ada
        $existing_data = $this->Pelaku_usaha_model->get_by_id($id);
        if (!$existing_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        $result = $this->Pelaku_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelaku usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pelaku usaha');
        }
        
        redirect('pelaku_usaha');
    }
    
    public function detail($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('pelaku_usaha');
        }
        
        $data['pelaku'] = $this->Pelaku_usaha_model->get_by_id($id);
         
        if (!$data['pelaku']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('pelaku_usaha');
        }
        
        $data['title'] = 'Detail Pelaku Usaha';
        $data['active_menu'] = 'pelaku_usaha';
        
        $this->load->view('admin/pelaku_usaha_detail', $data);
    }

    // ==================== EXPORT EXCEL (TANPA LIBRARY) ====================
    public function export_excel()
    {
        $results = $this->Pelaku_usaha_model->get_all();
        
        // Header untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Pelaku_Usaha.xls"');
        header('Cache-Control: max-age=0');
        
        // Mulai output HTML sebagai Excel
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
        
        // Header Laporan
        echo '<div class="header-title">LAPORAN DATA PELAKU USAHA</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        // Tabel Data
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>NIK</th>';
        echo '<th>Nama Pelaku Usaha</th>';
        echo '<th>Telepon</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Alamat</th>';
        echo '<th>Tanggal Terdaftar</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($results as $item) {
            $tanggal_daftar = '-';
            if(isset($item->created_at) && $item->created_at && $item->created_at != '0000-00-00') {
                $tanggal_daftar = date('d/m/Y', strtotime($item->created_at));
            }
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="center">' . (!empty($item->nik) ? $item->nik : '-') . '</td>';
            echo '<td align="left">' . (!empty($item->nama) ? $item->nama : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->telepon) ? $item->telepon : '-') . '</td>';
            echo '<td align="left">' . (!empty($item->kecamatan) ? $item->kecamatan : '-') . '</td>';
            echo '<td align="left">' . (!empty($item->alamat) ? $item->alamat : '-') . '</td>';
            echo '<td align="center">' . $tanggal_daftar . '</td>';
            echo '</tr>';
        }
        
        // Total row
        $totalData = count($results);
        echo '<tr class="total-row">';
        echo '<td colspan="6" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Pelaku Usaha</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>';
        
        // Footer Note
        echo '<div class="footer-note">';
        echo 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
        echo '</div>';
        
        echo '</body>';
        echo '</html>';
        
        exit;
    }
}
?>