<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_Input_Rpu extends CI_Controller {

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
        
        $this->load->model('P_Input_Rpu_Model');
    }

    public function index() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data['rpu_data'] = $this->P_Input_Rpu_Model->get_rpu_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        $data['pejagal_list'] = $this->P_Input_Rpu_Model->get_distinct_pejagal($user_kecamatan);
        
        $this->load->view('petugas/p_input_rpu', $data);
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
        // Set validation rules
        $this->form_validation->set_rules('tanggal_rpu', 'Tanggal RPU', 'required');
        $this->form_validation->set_rules('pejagal', 'Nama RPU/Pejagal', 'required|trim');
        $this->form_validation->set_rules('nama_pj', 'Nama Penanggung Jawab', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');

        // Validasi array data (multiple komoditas)
        $komoditas = $this->input->post('komoditas');
        $jumlah_ekor = $this->input->post('jumlah_ekor');
        $berat_kg = $this->input->post('berat_kg');
        $asal_unggas = $this->input->post('asal_unggas');

        if (empty($komoditas) || !is_array($komoditas)) {
            $response = array(
                'status' => 'error',
                'message' => 'Data komoditas harus diisi minimal 1'
            );
            echo json_encode($response);
            return;
        }

        foreach ($komoditas as $index => $k) {
            if (empty($k)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Komoditas baris ke-' . ($index + 1) . ' harus diisi'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($jumlah_ekor[$index]) || $jumlah_ekor[$index] < 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jumlah ekor baris ke-' . ($index + 1) . ' harus diisi (minimal 1)'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($berat_kg[$index]) || $berat_kg[$index] <= 0) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Berat (kg) baris ke-' . ($index + 1) . ' harus diisi (minimal 0.1)'
                );
                echo json_encode($response);
                return;
            }
            
            if (empty($asal_unggas[$index])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Asal unggas baris ke-' . ($index + 1) . ' harus dipilih'
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

        // Upload foto
        $uploaded_file = null;
        $upload_path = './uploads/rpu/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] != 4) {
            
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
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

        // Data RPU
        $data_rpu = array(
            'tanggal_rpu' => $this->input->post('tanggal_rpu'),
            'pejagal' => $this->input->post('pejagal'),
            'lokasi' => $this->input->post('lokasi'),
            'kecamatan' => $this->session->userdata('kecamatan'),
            'kelurahan' => $this->input->post('kelurahan'),
            'rt' => $this->input->post('rt'),
            'rw' => $this->input->post('rw'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'nama_pj' => $this->input->post('nama_pj'),
            'nik_pj' => $this->input->post('nik_pj'),
            'telp_pj' => $this->input->post('telp_pj'),
            'nama_petugas' => $this->input->post('nama_petugas'),
            'foto_kegiatan' => $uploaded_file,
            'keterangan' => $this->input->post('keterangan')
        );
        
        // Simpan data RPU
        $rpu_id = $this->P_Input_Rpu_Model->save_rpu($data_rpu);
        
        if ($rpu_id) {
            // Data komoditas
            $data_komoditas = array();
            foreach ($komoditas as $index => $k) {
                $data_komoditas[] = array(
                    'input_rpu_id' => $rpu_id,
                    'komoditas' => $k,
                    'jumlah_ekor' => $jumlah_ekor[$index],
                    'berat_kg' => $berat_kg[$index],
                    'asal_unggas' => $asal_unggas[$index],
                    'keterangan_komoditas' => isset($keterangan_komoditas[$index]) ? $keterangan_komoditas[$index] : null
                );
            }
            
            // Simpan komoditas
            $save_komoditas = $this->P_Input_Rpu_Model->save_komoditas($data_komoditas);
            
            if ($save_komoditas) {
                $foto_msg = $uploaded_file ? ' dan 1 foto' : ' (tanpa foto)';
                $response = array(
                    'status' => 'success',
                    'message' => count($komoditas) . ' data komoditas berhasil disimpan' . $foto_msg
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data komoditas'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal menyimpan data RPU. Silakan cek kembali data Anda.'
            );
        }

        echo json_encode($response);
    }

    public function get_all_data() {
        $user_kecamatan = $this->session->userdata('kecamatan');
        $data = $this->P_Input_Rpu_Model->get_rpu_by_kecamatan($user_kecamatan);
        echo json_encode($data);
    }

    public function get_by_periode() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (!$start_date) {
            $start_date = date('Y-m-01');
        }
        
        if (!$end_date) {
            $end_date = date('Y-m-t');
        }
        
        $data = $this->P_Input_Rpu_Model->get_by_periode($start_date, $end_date, $kecamatan);
        
        if (!empty($data)) {
            $response = array(
                'status' => 'success',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 'empty',
                'data' => [],
                'message' => 'Tidak ada data untuk periode ' . date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date)) . ' di kecamatan ' . $kecamatan
            );
        }
        
        echo json_encode($response);
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
    
    /**
     * Cek apakah NIK sudah pernah digunakan
     */
    public function cek_nik() {
        $nik = $this->input->post('nik');
        $kecamatan = $this->session->userdata('kecamatan');
        
        if (empty($nik)) {
            echo json_encode(['status' => 'empty']);
            return;
        }
        
        $cek = $this->P_Input_Rpu_Model->cek_nik_exists($nik, $kecamatan);
        
        if ($cek) {
            echo json_encode([
                'status' => 'exists',
                'message' => 'NIK ini sudah pernah digunakan sebanyak ' . $cek . ' kali di kecamatan ini'
            ]);
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
    
    /**
     * Get detail RPU by ID
     */
    public function get_detail($id) {
        $data = $this->P_Input_Rpu_Model->get_rpu_by_id($id);
        
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
}
?>