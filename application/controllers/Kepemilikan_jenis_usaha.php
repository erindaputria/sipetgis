<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepemilikan_jenis_usaha extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Kepemilikan_jenis_usaha_model');
        $this->load->model('Pelaku_usaha_model');
        $this->load->library('session');
        $this->load->helper('security');
    }
    
    public function index() {
        $data['kepemilikan_jenis_usaha'] = $this->Kepemilikan_jenis_usaha_model->get_all_combined();
        $data['pelaku_usaha'] = $this->Pelaku_usaha_model->get_all();
        $this->load->view('admin/kepemilikan_jenis_usaha', $data);
    } 
    
    public function search_pelaku_usaha() {
        // Handle CSRF for AJAX
        if ($this->input->get('csrf_test_name')) {
            $this->security->csrf_verify();
        }
         
        $search = $this->input->get('q');
        
        if (empty($search) || strlen($search) < 2) {
            echo json_encode(['results' => []]);
            return;
        }
        
        $this->db->select('nik, nama');
        $this->db->from('pelaku_usaha');
        $this->db->group_start();
        $this->db->like('nama', $search);
        $this->db->or_like('nik', $search);
        $this->db->group_end();
        $this->db->limit(20);
        $query = $this->db->get();
        $result = $query->result();
        
        $data = [];
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->nik,
                'text' => $row->nama . ' - ' . $row->nik,
                'nik' => $row->nik,
                'nama' => $row->nama
            ];
        }
        
        echo json_encode(['results' => $data]);
    }
    
    public function get_csrf() {
        $this->output->set_content_type('application/json');
        echo json_encode([
            'csrf_token' => $this->security->get_csrf_hash()
        ]);
    }
    
    public function simpan() { 
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[15]|max_length[20]');
        $this->form_validation->set_rules('nama_peternak', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('kepemilikan_jenis_usaha');
        }
        
        if ($this->Kepemilikan_jenis_usaha_model->check_exists_by_nik($this->input->post('nik'))) {
            $this->session->set_flashdata('error', 'Data dengan NIK ini sudah memiliki kepemilikan usaha!');
            redirect('kepemilikan_jenis_usaha');
        }
        
        $data = array(
            'nik' => $this->input->post('nik'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'gis_lat' => $this->input->post('gis_lat'),
            'gis_long' => $this->input->post('gis_long')
        );
        
        $result = $this->Kepemilikan_jenis_usaha_model->insert($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    }
    
    public function update() {
        $id = $this->input->post('id');
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[15]|max_length[20]');
        $this->form_validation->set_rules('nama_peternak', 'Nama Pelaku Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            redirect('kepemilikan_jenis_usaha');
        }
        
        $data = array(
            'nik' => $this->input->post('nik'),
            'nama_peternak' => $this->input->post('nama_peternak'),
            'jenis_usaha' => $this->input->post('jenis_usaha'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'gis_lat' => $this->input->post('gis_lat'),
            'gis_long' => $this->input->post('gis_long')
        );
        
        $result = $this->Kepemilikan_jenis_usaha_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    } 
    
    public function hapus($id) {
        $result = $this->Kepemilikan_jenis_usaha_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data kepemilikan jenis usaha berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kepemilikan jenis usaha');
        }
        
        redirect('kepemilikan_jenis_usaha');
    }

    // ==================== EXPORT EXCEL ====================
public function export_excel()
{
    $results = $this->Kepemilikan_jenis_usaha_model->get_all_combined();
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_Kepemilikan_Jenis_Usaha.xls"');
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
    
    echo '<div class="header-title">LAPORAN DATA KEPEMILIKAN JENIS USAHA</div>';
    echo '<div class="subtitle">DINAS KETAHANAN PANGAN DAN PERTANIAN</div>';
    echo '<div class="subtitle">KOTA SURABAYA</div>';
    echo '<hr style="border: 1px solid #000; margin: 10px 0;">';
    echo '<div class="subtitle" style="font-size: 10pt;">Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>';
    echo '<br>';
    
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th width="40">No</th>';
    echo '<th>NIK</th>';
    echo '<th>Nama Pelaku Usaha</th>';
    echo '<th>Jenis Usaha</th>';
    echo '<th>Jumlah</th>';
    echo '<th>Kecamatan</th>';
    echo '<th>Alamat</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    $totalJumlah = 0;
    foreach($results as $item) {
        $jumlah = (int)($item->jumlah ?? 0);
        $totalJumlah += $jumlah;
        
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '<td align="center">' . (!empty($item->nik) ? $item->nik : '-') . '</td>';
        echo '<td align="left">' . (!empty($item->nama_peternak) ? $item->nama_peternak : '-') . '</td>';
        echo '<td align="left">' . (!empty($item->jenis_usaha) ? $item->jenis_usaha : '-') . '</td>';
        echo '<td align="center">' . number_format($jumlah, 0, ',', '.') . '</td>';
        echo '<td align="left">' . (!empty($item->kecamatan) ? $item->kecamatan : '-') . '</td>';
        echo '<td align="left">' . (!empty($item->alamat) ? $item->alamat : '-') . '</td>';
        echo '</tr>';
    }
    
    // Total row
    $totalData = count($results);
    echo '<tr class="total-row">';
    echo '<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>';
    echo '<td align="center"><strong>' . number_format($totalJumlah, 0, ',', '.') . '</strong></td>';
    echo '<td colspan="2" align="center"><strong>' . number_format($totalData, 0, ',', '.') . ' Data</strong></td>';
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