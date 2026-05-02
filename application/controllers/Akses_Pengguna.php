<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses_pengguna extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Akses_pengguna_model');
        $this->load->library('session');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['akses'] = $this->Akses_pengguna_model->get_all(); 
        $data['title'] = 'Master Akses Pengguna';
        $this->load->view('admin/akses_pengguna', $data);
    }
    
    public function simpan() {
        // Validasi password
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        
        if ($password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Password dan Konfirmasi Password tidak sama');
            redirect('akses_pengguna');
        }
        
        if (strlen($password) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter');
            redirect('akses_pengguna');
        }
        
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $password,
            'level' => $this->input->post('level'),
            'telepon' => $this->input->post('telepon'),
            'kecamatan' => $this->input->post('kecamatan'),
            'status' => $this->input->post('status')
        );
        
        $result = $this->Akses_pengguna_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data pengguna');
        }
        
        redirect('akses_pengguna');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $data = array(
            'username' => $this->input->post('username'),
            'level' => $this->input->post('level'),
            'telepon' => $this->input->post('telepon'),
            'kecamatan' => $this->input->post('kecamatan'),
            'status' => $this->input->post('status')
        );
        
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }
        
        $result = $this->Akses_pengguna_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pengguna');
        }
         
        redirect('akses_pengguna');
    }
    
    public function hapus($id) {
        $result = $this->Akses_pengguna_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pengguna');
        }
        
        redirect('akses_pengguna');
    }

    // ==================== EXPORT EXCEL ====================
    public function export_excel()
    {
        $results = $this->Akses_pengguna_model->get_all();
        
        // Bersihkan output buffer
        ob_clean();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Akses_Pengguna.xls"');
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
        
        echo '<div class="header-title">LAPORAN DATA AKSES PENGGUNA</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        echo '<td>';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>Username</th>';
        echo '<th>Level</th>';
        echo '<th>Telepon</th>';
        echo '<th>Kecamatan</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        foreach($results as $item) {
            $status = ($item->status == 'aktif') ? 'AKTIF' : 'NONAKTIF';
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . (!empty($item->username) ? $item->username : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->level) ? $item->level : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->telepon) ? $item->telepon : '-') . '</td>';
            echo '<td align="left">' . (!empty($item->kecamatan) ? $item->kecamatan : '-') . '</td>';
            echo '<td align="center">' . $status . '</td>';
            echo '</tr>';
        }
        
        // Total row
        $totalData = count($results);
        echo '<tr class="total-row">';
        echo '<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Pengguna</strong></td>';
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