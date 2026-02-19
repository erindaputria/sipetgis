<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pengobatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        
        // CEK SESSION LOGIN
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        
        $this->load->model('P_Input_Pengobatan_Model');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'file'));
    }

    public function index() {
        $kecamatan = $this->session->userdata('kecamatan');
        $data['pengobatan_data'] = $this->P_Input_Pengobatan_Model->get_pengobatan_by_kecamatan($kecamatan);
        $this->load->view('p_input_pengobatan', $data);
    }

    public function save() {
        // Set validation rules with unique checks
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|is_unique[input_pengobatan.nik]', 
            array('is_unique' => 'NIK %s sudah terdaftar. Mohon gunakan NIK yang berbeda.')
        );
        $this->form_validation->set_rules('telp', 'No. Telepon', 'required|is_unique[input_pengobatan.telp]',
            array('is_unique' => 'No. Telepon %s sudah terdaftar. Mohon gunakan nomor yang berbeda.')
        );
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');
        $this->form_validation->set_rules('tanggal_pengobatan', 'Tanggal Pengobatan', 'required');
        $this->form_validation->set_rules('bantuan_prov', 'Bantuan Provinsi', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');

        // Get komoditas arrays from POST
        $komoditas = $this->input->post('komoditas_ternak');
        $jenis = $this->input->post('jenis_pengobatan');
        $jumlah = $this->input->post('jumlah');

        // Validate komoditas arrays
        if (empty($komoditas) || !is_array($komoditas)) {
            $response = array(
                'status' => 'error',
                'message' => 'Data komoditas harus diisi minimal 1'
            );
            echo json_encode($response);
            return;
        }

        // Validate each komoditas row
        foreach ($komoditas as $index => $k) {
            if (empty($k)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Komoditas ternak baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
            if (empty($jenis[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jenis pengobatan baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
            if (empty($jumlah[$index]) || $jumlah[$index] < 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jumlah baris ke-' . ($index + 1) . ' harus diisi (minimal 1)'
                );
                echo json_encode($response);
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Handle multiple file uploads
        $uploaded_files = array();
        $upload_path = './uploads/pengobatan/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (!empty($_FILES['foto_pengobatan']['name'][0])) {
            $files = $_FILES['foto_pengobatan'];
            $file_count = count($files['name']);
            
            for ($i = 0; $i < $file_count; $i++) {
                $_FILES['file_' . $i] = array(
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                );
                
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('file_' . $i)) {
                    $upload_data = $this->upload->data();
                    $uploaded_files[] = $upload_data['file_name'];
                } else {
                    $error = $this->upload->display_errors();
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal upload foto ' . ($i + 1) . ': ' . strip_tags($error)
                    );
                    echo json_encode($response);
                    return;
                }
            }
        }

        // Ambil kecamatan dari session
        $kecamatan = $this->session->userdata('kecamatan');
        $nama_petugas = $this->input->post('nama_petugas');

        // Data master
        $master_data = array(
            'nama_petugas' => $nama_petugas,
            'nama_peternak' => $this->input->post('nama_peternak'),
            'nik' => $this->input->post('nik'),
            'tanggal_pengobatan' => $this->input->post('tanggal_pengobatan'),
            'keterangan' => $this->input->post('keterangan') ?? '',
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'kecamatan' => $kecamatan,
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt') ?? '',
            'rw' => $this->input->post('rw') ?? '',
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => $this->input->post('telp'),
            'foto_pengobatan' => implode(',', $uploaded_files) // Simpan multiple foto dipisah koma
        );

        // Data detail (multiple komoditas)
        $detail_data = array();
        foreach ($komoditas as $index => $k) {
            $detail_data[] = array(
                'komoditas_ternak' => $k,
                'jenis_pengobatan' => $jenis[$index],
                'jumlah' => $jumlah[$index]
            );
        }

        // Simpan ke database melalui model
        $insert_id = $this->P_Input_Pengobatan_Model->save_pengobatan_with_details($master_data, $detail_data);

        if ($insert_id) {
            $response = array(
                'status' => 'success',
                'message' => 'Data pengobatan berhasil disimpan dengan ' . count($detail_data) . ' komoditas dan ' . count($uploaded_files) . ' foto'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pengobatan. Silakan coba lagi.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Pengobatan_Model->get_all_for_datatable($kecamatan);
        echo json_encode($data);
    }

    public function get_detail($id) {
        $data = $this->P_Input_Pengobatan_Model->get_pengobatan_by_id($id);
        echo json_encode($data);
    }

    public function delete($id) {
        $result = $this->P_Input_Pengobatan_Model->delete_pengobatan($id);
        
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
    
    public function filter_data() {
        $kecamatan = $this->session->userdata('kecamatan');
        $komoditas = $this->input->post('komoditas');
        $kelurahan = $this->input->post('kelurahan');
        $periode = $this->input->post('periode');
        
        if ($komoditas != 'all' && $komoditas != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_komoditas($komoditas, $kecamatan);
        } elseif ($kelurahan != 'all' && $kelurahan != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_kelurahan($kelurahan, $kecamatan);
        } elseif ($periode != 'all' && $periode != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_periode($periode, $kecamatan);
        } else {
            $data = $this->P_Input_Pengobatan_Model->get_all_for_datatable($kecamatan);
        }
        
        echo json_encode($data);
    }
    
    public function get_statistik() {
        $kecamatan = $this->session->userdata('kecamatan');
        $statistik = array(
            'total' => $this->P_Input_Pengobatan_Model->count_all($kecamatan),
            'total_ternak' => $this->P_Input_Pengobatan_Model->sum_jumlah($kecamatan),
            'total_peternak' => $this->P_Input_Pengobatan_Model->count_unique_peternak($kecamatan),
            'total_kelurahan' => $this->P_Input_Pengobatan_Model->count_unique_kelurahan($kecamatan),
            'per_bulan' => $this->P_Input_Pengobatan_Model->get_statistik_per_bulan(null, $kecamatan),
            'per_komoditas' => $this->P_Input_Pengobatan_Model->get_statistik_per_komoditas($kecamatan)
        );
        
        echo json_encode($statistik);
    }
}