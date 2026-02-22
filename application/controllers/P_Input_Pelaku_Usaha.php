<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Pelaku_Usaha extends CI_Controller {

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
        
        $this->load->model('P_Input_Pelaku_Usaha_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['pelaku_usaha_data'] = $this->P_Input_Pelaku_Usaha_Model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        
        $this->load->view('petugas/p_input_pelaku_usaha', $data);
    }
    
    private function get_all_kelurahan() {
        return array(
            'Asemrowo' => array('Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'),
            'Benowo' => array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'),
            'Bubutan' => array('Alun-alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'),
            'Bulak' => array('Bulak', 'Kedung Cowek', 'Kenjeran', 'Sukolilo Baru'),
            'Dukuh Pakis' => array('Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'),
            'Gayungan' => array('Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'),
            'Genteng' => array('Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'),
            'Gubeng' => array('Airlangga', 'Baratajaya', 'Gubeng', 'Kertajaya', 'Mojo'),
            'Gunung Anyar' => array('Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'),
            'Jambangan' => array('Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'),
            'Karang Pilang' => array('Karang Pilang', 'Kebraon', 'Kedurus', 'Waru Gunung'),
            'Kenjeran' => array('Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding', 'Sidotopo Wetan'),
            'Krembangan' => array('Dupak', 'Kemayoran', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat'),
            'Lakarsantri' => array('Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'),
            'Mulyorejo' => array('Dukuh Sutorejo', 'Kalijudan', 'Kaliawan', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'),
            'Pabean Cantian' => array('Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'),
            'Pakal' => array('Babat Jerawat', 'Pakal', 'Sumber Rejo'),
            'Rungkut' => array('Kali Rungkut', 'Kedung Baruk', 'Medokan Ayu', 'Penjaringan Sari', 'Rungkut Kidul', 'Wonorejo'),
            'Sambikerep' => array('Bringin', 'Lontar', 'Madya', 'Sambikerep'),
            'Sawahan' => array('Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'),
            'Semampir' => array('Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'),
            'Simokerto' => array('Kapasan', 'Simokerto', 'Simolawang', 'Tambak Rejo'),
            'Sukolilo' => array('Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Medokan Semampir', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'),
            'Sukomanunggal' => array('Putat Gede', 'Simomulyo', 'Simomulyo Baru', 'Sukomanunggal', 'Tanjungsari'),
            'Tambaksari' => array('Gading', 'Kapas Madya', 'Pacar Kembang', 'Pacar Keling', 'Ploso', 'Rangkah', 'Tambaksari'),
            'Tandes' => array('Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'),
            'Tegalsari' => array('Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'),
            'Tenggilis Mejoyo' => array('Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'),
            'Wiyung' => array('Babat Jerawat', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'),
            'Wonocolo' => array('Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'),
            'Wonokromo' => array('Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo')
        );
    }

    public function save() {
        // Set response header
        header('Content-Type: application/json');
        
        // Set validation rules
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('tanggal_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        // Validasi array data (multiple komoditas)
        $komoditas = $this->input->post('komoditas_ternak');
        $jumlah_tambah = $this->input->post('jumlah_tambah');
        $jumlah_kurang = $this->input->post('jumlah_kurang');

        if (empty($komoditas) || !is_array($komoditas)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Data komoditas harus diisi minimal 1'
            ));
            return;
        }

        foreach ($komoditas as $index => $k) {
            if (empty($k)) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Komoditas ternak baris ke-' . ($index + 1) . ' harus diisi'
                ));
                return;
            }
            
            if (!isset($jumlah_tambah[$index]) || $jumlah_tambah[$index] === '') {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jumlah tambah baris ke-' . ($index + 1) . ' harus diisi'
                ));
                return;
            }
            
            if (!isset($jumlah_kurang[$index]) || $jumlah_kurang[$index] === '') {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Jumlah kurang baris ke-' . ($index + 1) . ' harus diisi'
                ));
                return;
            }
            
            if ($jumlah_tambah[$index] < 0 || $jumlah_kurang[$index] < 0) {
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
        $upload_path = './uploads/pelaku_usaha/';
        
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

        // Simpan setiap baris komoditas
        $success_count = 0;
        $kecamatan_user = $this->session->userdata('kecamatan');
        
        foreach ($komoditas as $index => $k) {
            $nik_val = $this->input->post('nik');
            $telp_val = $this->input->post('telp');
            $keterangan_val = $this->input->post('keterangan');
            $rt_val = $this->input->post('rt');
            $rw_val = $this->input->post('rw');
            
            $data = array(
                'nama_petugas' => $this->input->post('nama_petugas'),
                'nama_peternak' => $this->input->post('nama_peternak'),
                'nik' => (!empty($nik_val)) ? $nik_val : NULL,
                'tanggal_input' => $this->input->post('tanggal_input'),
                'keterangan' => (!empty($keterangan_val)) ? $keterangan_val : NULL,
                'kecamatan' => $kecamatan_user,
                'kelurahan' => $this->input->post('kelurahan'),
                'rt' => (!empty($rt_val)) ? $rt_val : NULL,
                'rw' => (!empty($rw_val)) ? $rw_val : NULL,
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'telp' => (!empty($telp_val)) ? $telp_val : NULL,
                'foto_usaha' => !empty($uploaded_files) ? $uploaded_files[0] : NULL,
                'komoditas_ternak' => $k,
                'jumlah_tambah' => $jumlah_tambah[$index],
                'jumlah_kurang' => $jumlah_kurang[$index]
            );
            
            if ($this->P_Input_Pelaku_Usaha_Model->save_pelaku_usaha($data)) {
                $success_count++;
            }
        }

        if ($success_count > 0) {
            $foto_msg = !empty($uploaded_files) ? ' dan 1 foto' : ' (tanpa foto)';
            echo json_encode(array(
                'status' => 'success',
                'message' => $success_count . ' data pelaku usaha berhasil disimpan' . $foto_msg
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data pelaku usaha'
            ));
        }
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Pelaku_Usaha_Model->get_pelaku_usaha_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $data = $this->P_Input_Pelaku_Usaha_Model->get_by_periode($tahun, $kecamatan);
        
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
    
    public function cek_nik() {
        $nik = $this->input->post('nik');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (empty($nik)) {
            echo json_encode(['status' => 'empty']);
            return;
        }
        
        $cek = $this->P_Input_Pelaku_Usaha_Model->cek_nik_exists($nik, $kecamatan);
        
        if ($cek) {
            echo json_encode([
                'status' => 'exists',
                'message' => 'NIK ini sudah pernah digunakan sebanyak ' . $cek . ' kali di kecamatan ini'
            ]);
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
}