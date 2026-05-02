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

    // MULTIPLE FILE UPLOAD - MANUAL METHOD
    $uploaded_files = array();
    $upload_path = FCPATH . 'uploads/pemotongan_unggas/';
    
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, TRUE);
    }
    
    if (isset($_FILES['foto_kegiatan']) && !empty($_FILES['foto_kegiatan']['name'][0])) {
        $files = $_FILES['foto_kegiatan'];
        $file_count = count($files['name']);
        $file_count = min($file_count, 5);
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($files['error'][$i] == 0) {
                $file_name = $files['name'][$i];
                $file_tmp = $files['tmp_name'][$i];
                $file_size = $files['size'][$i];
                $file_type = $files['type'][$i];
                
                $allowed_types = array('image/jpeg', 'image/jpg', 'image/png');
                if (!in_array($file_type, $allowed_types)) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'File ' . $file_name . ' harus format JPG atau PNG'
                    );
                    echo json_encode($response);
                    return;
                }
                
                if ($file_size > 5 * 1024 * 1024) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'File ' . $file_name . ' melebihi 5MB'
                    );
                    echo json_encode($response);
                    return;
                }
                
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_name = time() . '_' . uniqid() . '.' . $ext;
                $destination = $upload_path . $new_name;
                
                if (move_uploaded_file($file_tmp, $destination)) {
                    $uploaded_files[] = $new_name;
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal upload file: ' . $file_name
                    );
                    echo json_encode($response);
                    return;
                }
            }
        }
    }
    
    $foto_string = !empty($uploaded_files) ? implode(',', $uploaded_files) : null;

    // Siapkan data
    $data = array(
        'id_rpu' => $this->input->post('id_rpu') ?: null,
        'tanggal' => $this->input->post('tanggal'),
        'ayam' => $ayam,
        'itik' => $itik,
        'dst' => $dst,
        'daerah_asal' => $this->input->post('daerah_asal'),
        'nama_petugas' => $this->input->post('nama_petugas'),
        'foto_kegiatan' => $foto_string,
        'keterangan' => $this->input->post('keterangan'),
        'created_at' => date('Y-m-d H:i:s')
    );

    // Simpan data
    $result = $this->P_input_pemotongan_unggas_model->save_pemotongan($data);

    if ($result) {
        $foto_msg = !empty($uploaded_files) ? count($uploaded_files) . ' foto berhasil diupload' : 'tanpa foto';
        $total_unggas = $ayam + $itik + $dst;
        $response = array(
            'status' => 'success',
            'message' => 'Data pemotongan unggas berhasil disimpan dengan ' . $foto_msg . ' (Total: ' . $total_unggas . ' ekor)'
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