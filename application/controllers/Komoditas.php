<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Komoditas_model');
        $this->load->library('session');
        $this->load->helper('security');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    } 
    
    public function index() {
        $data['komoditas'] = $this->Komoditas_model->get_all();
        $data['title'] = 'Master Komoditas';
        $this->load->view('admin/komoditas', $data);
    }
    
    public function simpan() { 
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('komoditas');
        }
        
        $nama_komoditas = $this->input->post('nama_komoditas');
        if ($this->Komoditas_model->check_nama($nama_komoditas)) {
            $this->session->set_flashdata('error', 'Nama komoditas sudah terdaftar');
            redirect('komoditas');
        }
        
        $data = array(
            'nama_komoditas' => $nama_komoditas,
            'jenis_hewan' => $this->input->post('jenis'),
            'satuan' => $this->input->post('satuan'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin')
        );
        
        $result = $this->Komoditas_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data komoditas berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data komoditas');
        }
        
        redirect('komoditas');
    }
    
    public function update() {
        $id = $this->input->post('id_komoditas');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('komoditas');
        }
        
        $nama_komoditas = $this->input->post('nama_komoditas');
        $existing = $this->Komoditas_model->check_nama_except($nama_komoditas, $id);
        if ($existing) {
            $this->session->set_flashdata('error', 'Nama komoditas sudah digunakan oleh data lain');
            redirect('komoditas');
        }
        
        $data = array(
            'nama_komoditas' => $nama_komoditas,
            'jenis_hewan' => $this->input->post('jenis'),
            'satuan' => $this->input->post('satuan'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin')
        );
        
        $result = $this->Komoditas_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data komoditas berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data komoditas');
        }
        
        redirect('komoditas');
    }
    
    public function hapus_ajax() {
        $id = $this->input->post('id');
        
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            return;
        }
        
        $result = $this->Komoditas_model->delete($id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data komoditas berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data komoditas']);
        }
    }

    public function export_excel()
    {
        $results = $this->Komoditas_model->get_all();
        
        ob_clean();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan_Komoditas.xls"');
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
        
        echo '<div class="header-title">LAPORAN DATA KOMODITAS</div>';
        echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
        echo '<div class="subtitle">KOTA SURABAYA</div>';
        echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
        echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
        echo '<br>';
        
        echo '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="40">No</th>';
        echo '<th>Nama Komoditas</th>';
        echo '<th>Jenis Hewan</th>';
        echo '<th>Satuan</th>';
        echo '<th>Jenis Kelamin</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        $no = 1;
        $totalData = 0;
        foreach($results as $item) {
            $totalData++;
            $jk_display = $item->jenis_kelamin;
            if ($jk_display == 'P') $jk_display = 'Perempuan';
            elseif ($jk_display == 'L') $jk_display = 'Laki-laki';
            elseif ($jk_display == 'K') $jk_display = 'Keduanya';
            
            echo '<tr>';
            echo '<td align="center">' . $no++ . '</td>';
            echo '<td align="left">' . (!empty($item->nama_komoditas) ? $item->nama_komoditas : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->jenis_hewan) ? $item->jenis_hewan : '-') . '</td>';
            echo '<td align="center">' . (!empty($item->satuan) ? $item->satuan : '-') . '</td>';
            echo '<td align="center">' . $jk_display . '</td>';
            echo '</tr>';
        }
        
        echo '<tr class="total-row">';
        echo '<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
        echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Data Komoditas</strong></td>';
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