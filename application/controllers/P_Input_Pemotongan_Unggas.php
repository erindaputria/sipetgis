<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_input_pemotongan_unggas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'file'));
        
        // CEK SESSION LOGIN
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('P_input_pemotongan_unggas_model');
    }
 
    public function index() {
        $data['pemotongan_data'] = $this->P_input_pemotongan_unggas_model->get_all_pemotongan();
        $data['user_kecamatan'] = $this->session->userdata('kecamatan') ?: 'Benowo';
        
        // Hitung total untuk summary cards
        $data['total_ayam'] = $this->P_input_pemotongan_unggas_model->sum_ayam();
        $data['total_itik'] = $this->P_input_pemotongan_unggas_model->sum_itik();
        $data['total_dst'] = $this->P_input_pemotongan_unggas_model->sum_dst();
        $data['total_unggas'] = $this->P_input_pemotongan_unggas_model->sum_total_unggas();
        
        // Get distinct daerah asal untuk filter
        $data['daerah_asal_list'] = $this->P_input_pemotongan_unggas_model->get_distinct_daerah_asal();
        
        // Get all RPU/pejagal from rpu table
        $data['rpu_list'] = $this->P_input_pemotongan_unggas_model->get_all_rpu();
        
        $this->load->view('petugas/p_input_pemotongan_unggas', $data);
    }

    public function save() {
        // Set validation rules
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('daerah_asal', 'Daerah Asal', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Validasi minimal satu jenis unggas diisi
        $ayam = $this->input->post('ayam') ?: 0;
        $itik = $this->input->post('itik') ?: 0;
        $dst = $this->input->post('dst') ?: 0;
        
        if ($ayam <= 0 && $itik <= 0 && $dst <= 0) {
            $response = array(
                'status' => 'error',
                'message' => 'Minimal satu jenis unggas harus diisi dengan jumlah > 0'
            );
            echo json_encode($response);
            return;
        }

        // Upload foto
        $uploaded_file = null;
        $upload_path = './uploads/pemotongan_unggas/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_kegiatan')) {
                $upload_data = $this->upload->data();
                $uploaded_file = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal upload foto: ' . strip_tags($error)
                );
                echo json_encode($response);
                return;
            }
        }

        // Siapkan data
        $data = array(
            'id_rpu' => $this->input->post('id_rpu') ?: null,
            'tanggal' => $this->input->post('tanggal'),
            'ayam' => $ayam,
            'itik' => $itik,
            'dst' => $dst,
            'daerah_asal' => $this->input->post('daerah_asal'),
            'nama_petugas' => $this->input->post('nama_petugas'),
            'foto_kegiatan' => $uploaded_file,
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s')
        );

        // Simpan data
        $result = $this->P_input_pemotongan_unggas_model->save_pemotongan($data);

        if ($result) {
            $foto_msg = $uploaded_file ? ' dan 1 foto' : ' (tanpa foto)';
            $total_unggas = $ayam + $itik + $dst;
            $response = array(
                'status' => 'success',
                'message' => 'Data pemotongan unggas berhasil disimpan' . $foto_msg . ' (Total: ' . $total_unggas . ' ekor)'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pemotongan unggas. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $data = $this->P_input_pemotongan_unggas_model->get_all_pemotongan();
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_input_pemotongan_unggas_model->get_by_periode($tahun);
        
        if (!empty($data)) {
            $response = array(
                'status' => 'success',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk tahun ' . $tahun
            );
        }
        
        echo json_encode($response);
    }

    public function delete($id) {
        $result = $this->P_input_pemotongan_unggas_model->delete_pemotongan($id);
        
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menghapus data'
            );
        }
        
        echo json_encode($response);
    }
    
    /**
     * Get summary data
     */ 
    public function get_summary() {
        $summary = array(
            'total_ayam' => $this->P_input_pemotongan_unggas_model->sum_ayam(),
            'total_itik' => $this->P_input_pemotongan_unggas_model->sum_itik(),
            'total_dst' => $this->P_input_pemotongan_unggas_model->sum_dst(),
            'total_unggas' => $this->P_input_pemotongan_unggas_model->sum_total_unggas(),
            'total_record' => $this->P_input_pemotongan_unggas_model->count_all()
        );
        
        echo json_encode($summary);
    }
}