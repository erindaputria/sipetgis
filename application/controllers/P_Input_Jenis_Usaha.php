<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Jenis_Usaha extends CI_Controller {

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
        
        $this->load->model('P_Input_Jenis_Usaha_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['jenis_usaha_data'] = $this->P_Input_Jenis_Usaha_Model->get_jenis_usaha_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_jenis_usaha', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'Asemrowo' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
            'Benowo' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            // ... (lanjutkan dengan semua kecamatan)
        );
    }

    public function save() {
        // Set response header
        header('Content-Type: application/json');
        
        // Set validation rules
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        // Validasi array data (multiple komoditas ternak)
        $komoditas_ternak = $this->input->post('jenis_usaha'); // Input name tetap jenis_usaha untuk kompatibilitas form
        $jumlah = $this->input->post('jumlah');

        if (empty($komoditas_ternak) || !is_array($komoditas_ternak)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data komoditas ternak harus diisi minimal 1'
            ));
            return;
        }

        foreach ($komoditas_ternak as $index => $j) {
            if (empty($j)) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Komoditas ternak baris ke-' . ($index + 1) . ' harus diisi'
                ));
                return;
            }
            
            if (!isset($jumlah[$index]) || $jumlah[$index] === '') {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jumlah baris ke-' . ($index + 1) . ' harus diisi'
                ));
                return;
            }
            
            if ($jumlah[$index] < 0) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jumlah tidak boleh negatif'
                ));
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'message' => validation_errors()
            ));
            return;
        }

        // Upload foto
        $uploaded_files = array();
        $upload_path = './uploads/jenis_usaha/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_usaha']) && $_FILES['foto_usaha']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_usaha')) {
                $upload_data = $this->upload->data();
                $uploaded_files[] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Gagal upload foto: ' . strip_tags($error)
                ));
                return;
            }
        }

        // Simpan setiap baris data - Gunakan komoditas_ternak bukan jenis_usaha
        $success_count = 0;
        $kecamatan_user = $this->session->userdata('kecamatan');
        
        foreach ($komoditas_ternak as $index => $j) {
            $keterangan_val = $this->input->post('keterangan');
            $rt_val = $this->input->post('rt');
            $rw_val = $this->input->post('rw');
            
            // Data sesuai dengan struktur tabel yang ada
            $data = array(
                'nama_petugas' => $this->input->post('nama_petugas'),
                'nama_peternak' => $this->input->post('nama_pemilik'),
                'tanggal_input' => $this->input->post('tanggal_input'),
                'keterangan' => (!empty($keterangan_val)) ? $keterangan_val : NULL,
                'kecamatan' => $kecamatan_user,
                'kelurahan' => $this->input->post('kelurahan'),
                'rt' => (!empty($rt_val)) ? $rt_val : NULL,
                'rw' => (!empty($rw_val)) ? $rw_val : NULL,
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'foto_usaha' => !empty($uploaded_files) ? $uploaded_files[0] : NULL,
                'komoditas_ternak' => $j, // Gunakan komoditas_ternak, bukan jenis_usaha
                'jumlah' => $jumlah[$index]
            );
            
            if ($this->P_Input_Jenis_Usaha_Model->save_jenis_usaha($data)) {
                $success_count++;
            }
        }

        if ($success_count > 0) {
            $foto_msg = !empty($uploaded_files) ? ' dan 1 foto' : ' (tanpa foto)';
            echo json_encode(array(
                'status' => 'success',
                'message' => $success_count . ' data berhasil disimpan' . $foto_msg
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data'
            ));
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Jenis_Usaha_Model->get_jenis_usaha_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_Input_Jenis_Usaha_Model->get_by_periode($tahun, $kecamatan);
        
        if (!empty($data)) {
            echo json_encode(array(
                'status' => 'success',
                'data' => $data
            ));
        } else {
            echo json_encode(array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk tahun ' . $tahun . ' di kecamatan ' . $kecamatan
            ));
        }
    }

    public function get_kelurahan_by_kecamatan() {
        $kecamatan = $this->input->post('kecamatan');
        $kel_list = $this->get_all_kelurahan();
        
        if (isset($kel_list[$kecamatan])) {
            echo json_encode($kel_list[$kecamatan]);
        } else {
            echo json_encode([]);
        }
    }
}