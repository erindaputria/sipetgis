<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pengobatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // LOAD SEMUA LIBRARY YANG DIPERLUKAN
        $this->load->model('P_Input_Pengobatan_Model');
        $this->load->library('upload');
        $this->load->library('form_validation'); // <-- INI YANG MISSING!
        $this->load->helper(array('form', 'url', 'file'));
    }

    public function index() {
        $data['pengobatan_data'] = $this->P_Input_Pengobatan_Model->get_pengobatan_for_table();
        $this->load->view('p_input_pengobatan', $data);
    }

    public function save() {
        // Set validation rules
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required');
        $this->form_validation->set_rules('komoditas_ternak', 'Komoditas Ternak', 'required');
        $this->form_validation->set_rules('jenis_pengobatan', 'Jenis Pengobatan', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('tanggal_pengobatan', 'Tanggal Pengobatan', 'required');
        $this->form_validation->set_rules('bantuan_prov', 'Bantuan Provinsi', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Handle file upload
        $foto_name = '';
        if (!empty($_FILES['foto_pengobatan']['name'])) {
            $config['upload_path'] = './uploads/pengobatan/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('foto_pengobatan')) {
                $upload_data = $this->upload->data();
                $foto_name = $upload_data['file_name'];
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

        $data = array(
            'nama_petugas' => $this->input->post('nama_petugas') ?? 'Petugas Lapangan',
            'nama_peternak' => $this->input->post('nama_peternak'),
            'nik' => $this->input->post('nik') ?? '',
            'komoditas_ternak' => $this->input->post('komoditas_ternak'),
            'jenis_pengobatan' => $this->input->post('jenis_pengobatan'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal_pengobatan' => $this->input->post('tanggal_pengobatan'),
            'keterangan' => $this->input->post('keterangan') ?? '',
            'bantuan_prov' => $this->input->post('bantuan_prov'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt') ?? '',
            'rw' => $this->input->post('rw') ?? '',
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'telp' => $this->input->post('telp') ?? '',
            'foto_pengobatan' => $foto_name
        );

        $insert_id = $this->P_Input_Pengobatan_Model->save_pengobatan($data);

        if ($insert_id) {
            $response = array(
                'status' => 'success',
                'message' => 'Data pengobatan berhasil disimpan',
                'id' => $insert_id
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pengobatan'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $data = $this->P_Input_Pengobatan_Model->get_all_for_datatable();
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
        $komoditas = $this->input->post('komoditas');
        $kelurahan = $this->input->post('kelurahan');
        $periode = $this->input->post('periode');
        
        if ($komoditas != 'all' && $komoditas != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_komoditas($komoditas);
        } elseif ($kelurahan != 'all' && $kelurahan != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_kelurahan($kelurahan);
        } elseif ($periode != 'all' && $periode != '') {
            $data = $this->P_Input_Pengobatan_Model->get_by_periode($periode);
        } else {
            $data = $this->P_Input_Pengobatan_Model->get_all_for_datatable();
        }
        
        echo json_encode($data);
    }
    
    public function get_statistik() {
        $statistik = array(
            'total' => $this->P_Input_Pengobatan_Model->count_all(),
            'total_ternak' => $this->P_Input_Pengobatan_Model->sum_jumlah(),
            'total_peternak' => $this->P_Input_Pengobatan_Model->count_unique_peternak(),
            'total_kelurahan' => $this->P_Input_Pengobatan_Model->count_unique_kelurahan(),
            'per_bulan' => $this->P_Input_Pengobatan_Model->get_statistik_per_bulan(),
            'per_komoditas' => $this->P_Input_Pengobatan_Model->get_statistik_per_komoditas()
        );
        
        echo json_encode($statistik);
    }
}