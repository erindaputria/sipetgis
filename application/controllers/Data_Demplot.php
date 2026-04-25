<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_demplot extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_demplot_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek session login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['demplot_data'] = $this->Data_demplot_model->get_all_demplot();
        $data['kecamatan_list'] = $this->Data_demplot_model->get_distinct_kecamatan();
        $data['kelurahan_list'] = $this->Data_demplot_model->get_distinct_kelurahan();
        $data['jenis_hewan_list'] = $this->Data_demplot_model->get_distinct_jenis_hewan();
        
        $this->load->view('admin/data/data_demplot', $data);
    }

    // Fungsi untuk mendapatkan data JSON (untuk AJAX)
    public function get_data()
    {
        $data = $this->Data_demplot_model->get_all_demplot();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan detail Demplot by ID
    public function detail($id)
    {
        $data = $this->Data_demplot_model->get_demplot_by_id($id);
        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    // Fungsi untuk filter berdasarkan kecamatan
    public function filter_by_kecamatan()
    {
        $kecamatan = $this->input->post('kecamatan');
        
        if ($kecamatan && $kecamatan != 'all') {
            $data = $this->Data_demplot_model->get_by_kecamatan($kecamatan);
        } else {
            $data = $this->Data_demplot_model->get_all_demplot();
        }
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk filter berdasarkan jenis hewan
    public function filter_by_jenis_hewan()
    {
        $jenis_hewan = $this->input->post('jenis_hewan');
        
        if ($jenis_hewan && $jenis_hewan != 'all') {
            $data = $this->Data_demplot_model->get_by_jenis_hewan($jenis_hewan);
        } else {
            $data = $this->Data_demplot_model->get_all_demplot();
        }
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk filter berdasarkan luas
    public function filter_by_luas()
    {
        $min_luas = $this->input->post('min_luas');
        $max_luas = $this->input->post('max_luas');
        
        if (($min_luas && $min_luas != '') || ($max_luas && $max_luas != '')) {
            $data = $this->Data_demplot_model->get_by_luas_range($min_luas, $max_luas);
        } else {
            $data = $this->Data_demplot_model->get_all_demplot();
        }
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Fungsi untuk menghapus data
    public function hapus($id)
    {
        // Cek apakah data ada
        $demplot = $this->Data_demplot_model->get_demplot_by_id($id);
        
        if ($demplot) {
            // Hapus file foto jika ada
            if (!empty($demplot->foto_demplot) && file_exists('./uploads/demplot/' . $demplot->foto_demplot)) {
                unlink('./uploads/demplot/' . $demplot->foto_demplot);
            }
            
            $result = $this->Data_demplot_model->delete_demplot($id);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Data demplot berhasil dihapus');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data demplot');
            }
        } else {
            $this->session->set_flashdata('error', 'Data demplot tidak ditemukan');
        }
        
        redirect('data_demplot');
    }

    // Fungsi untuk mendapatkan statistik
    public function get_statistik()
    {
        $statistik = [
            'total_demplot' => $this->Data_demplot_model->count_all(),
            'total_hewan' => $this->Data_demplot_model->sum_total_hewan(),
            'total_luas' => $this->Data_demplot_model->sum_total_luas(),
            'total_jenis_hewan' => $this->Data_demplot_model->count_distinct_jenis_hewan()
        ];
        
        echo json_encode($statistik);
    }

    // Fungsi untuk mendapatkan statistik per kecamatan
    public function get_statistik_per_kecamatan()
    {
        $data = $this->Data_demplot_model->get_statistik_per_kecamatan();
        echo json_encode($data);
    }

    // Fungsi untuk mendapatkan statistik per jenis hewan
    public function get_statistik_per_jenis_hewan()
    {
        $data = $this->Data_demplot_model->get_statistik_per_jenis_hewan();
        echo json_encode($data);
    }

    // Fungsi untuk export data ke CSV
    public function export_csv()
    {
        $data = $this->Data_demplot_model->get_all_demplot();
        
        // Set header untuk download file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data_demplot_' . date('Y-m-d') . '.csv');
        
        // Buat output stream
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, array('ID', 'Nama Demplot', 'Alamat', 'Kecamatan', 'Kelurahan', 'Luas (m²)', 'Jenis Hewan', 'Jumlah Hewan', 'Stok Pakan', 'Latitude', 'Longitude', 'Nama Petugas', 'Keterangan', 'Tanggal Input'));
        
        // Data CSV
        foreach ($data as $row) {
            fputcsv($output, array(
                $row['id_demplot'],
                $row['nama_demplot'],
                $row['alamat'],
                $row['kecamatan'],
                $row['kelurahan'],
                $row['luas_m2'],
                $row['jenis_hewan'],
                $row['jumlah_hewan'],
                $row['stok_pakan'],
                $row['latitude'],
                $row['longitude'],
                $row['nama_petugas'],
                $row['keterangan'],
                $row['created_at']
            ));
        }
        
        fclose($output);
    }

    // Fungsi untuk export data ke PDF (sederhana)
    public function export_pdf()
    {
        $this->load->library('pdf');
        
        $data['demplot_data'] = $this->Data_demplot_model->get_all_demplot();
        
        $html = $this->load->view('admin/export/demplot_pdf', $data, true);
        
        $this->pdf->createPDF($html, 'data_demplot_' . date('Y-m-d'), false);
    }
}
?>