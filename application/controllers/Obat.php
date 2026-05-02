<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Obat_model');
        $this->load->library('session');
        
        // Cek login
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['obat'] = $this->Obat_model->get_all();
        $data['title'] = 'Master Obat';
        $this->load->view('admin/obat', $data);
    }
    
    public function simpan() {
        $data = array( 
            'obat' => $this->input->post('obat'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'dosis' => $this->input->post('dosis')
        );
        
        $result = $this->Obat_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data obat');
        }
        
        redirect('obat');
    }
    
    public function update() {
        $id = $this->input->post('id_obat');
        
        $data = array(
            'obat' => $this->input->post('obat'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'dosis' => $this->input->post('dosis')
        );
        
        $result = $this->Obat_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data obat');
        }
        
        redirect('obat');
    }
    
    public function hapus($id) {
        $result = $this->Obat_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data obat berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data obat');
        }
        
        redirect('obat');
    }

    // ==================== EXPORT EXCEL ====================
public function export_excel()
{
    // Nonaktifkan CSRF check untuk method ini
    if (isset($this->security)) {
        $this->security->csrf_verify = false;
    }
    
    $results = $this->Obat_model->get_all();
    
    // Bersihkan output buffer
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_Obat_Hewan.xls"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');
    header('Expires: 0');
    
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
    
    echo '<div class="header-title">LAPORAN DATA OBAT HEWAN</div>';
    echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
    echo '<div class="subtitle">KOTA SURABAYA</div>';
    echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
    echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
    echo '<br>';
    
    echo '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th width="40">No</th>';
    echo '<th>Nama Obat</th>';
    echo '<th>Jenis Pengobatan</th>';
    echo '<th>Dosis</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    $totalData = 0;
    foreach($results as $item) {
        $totalData++;
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '<td align="left">' . (!empty($item->obat) ? htmlspecialchars($item->obat) : '-') . '</td>';
        echo '<td align="left">' . (!empty($item->jenis_pengobatan) ? htmlspecialchars($item->jenis_pengobatan) : '-') . '</td>';
        echo '<td align="left">' . (!empty($item->dosis) ? htmlspecialchars($item->dosis) : '-') . '</td>';
        echo '</tr>';
    }
    
    // Total row
    echo '<tr class="total-row">';
    echo '<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
    echo '<td align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Data Obat</strong></td>';
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