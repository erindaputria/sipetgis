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
        if (empty($user_kecamatan)) {
            $user_kecamatan = 'Benowo';
        }
        
        $data['rpu_data'] = $this->P_Input_Rpu_Model->get_rpu_by_kecamatan($user_kecamatan);
        $data['kel_list'] = $this->get_all_kelurahan();
        $data['user_kecamatan'] = $user_kecamatan;
        $data['pejagal_list'] = $this->P_Input_Rpu_Model->get_distinct_pejagal($user_kecamatan);
        $data['komoditas_list'] = $this->P_Input_Rpu_Model->get_distinct_komoditas($user_kecamatan);
        $data['total_ekor'] = $this->P_Input_Rpu_Model->sum_total_ekor($user_kecamatan);
        $data['total_berat'] = $this->P_Input_Rpu_Model->sum_total_berat($user_kecamatan);
        $data['total_kegiatan'] = $this->P_Input_Rpu_Model->count_all($user_kecamatan);
        
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
        $this->output->set_content_type('application/json');
        
        // Validation rules
        $this->form_validation->set_rules('tanggal_rpu', 'Tanggal RPU', 'required');
        $this->form_validation->set_rules('pejagal', 'Nama RPU/Pejagal', 'required|trim');
        $this->form_validation->set_rules('nama_pj', 'Nama Penanggung Jawab', 'required|trim');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required|trim');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors('<div>', '</div>')]);
            return;
        }

        // Ambil data komoditas
        $komoditas = $this->input->post('komoditas');
        $jumlah_ekor = $this->input->post('jumlah_ekor');
        $berat_kg = $this->input->post('berat_kg');
        $asal_unggas = $this->input->post('asal_unggas');

        if (empty($komoditas) || !is_array($komoditas)) {
            echo json_encode(['status' => 'error', 'message' => 'Data komoditas harus diisi minimal 1']);
            return;
        }

        // Validasi dan filter komoditas
        $valid_komoditas = array();
        foreach ($komoditas as $index => $k) {
            if (empty($k)) continue;
            
            if (empty($jumlah_ekor[$index]) || $jumlah_ekor[$index] < 1) {
                echo json_encode(['status' => 'error', 'message' => 'Jumlah ekor baris ke-' . ($index + 1) . ' harus diisi (minimal 1)']);
                return;
            }
            
            if (empty($berat_kg[$index]) || $berat_kg[$index] <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Berat (kg) baris ke-' . ($index + 1) . ' harus diisi (minimal 0.1)']);
                return;
            }
            
            $valid_komoditas[] = array(
                'komoditas' => $k,
                'jumlah_ekor' => $jumlah_ekor[$index],
                'berat_kg' => $berat_kg[$index],
                'asal_unggas' => isset($asal_unggas[$index]) ? $asal_unggas[$index] : 'Surabaya'
            );
        }

        if (empty($valid_komoditas)) {
            echo json_encode(['status' => 'error', 'message' => 'Minimal satu data komoditas harus diisi lengkap']);
            return;
        }

        // Upload foto
        $uploaded_file = null;
        $upload_path = FCPATH . 'uploads/rpu/';
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
                $uploaded_file = $this->upload->data('file_name');
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal upload foto: ' . strip_tags($this->upload->display_errors())]);
                return;
            }
        }

        // Data RPU - gunakan 'lokasi' sesuai dengan kolom di tabel
        $data_rpu = array(
            'tanggal_rpu' => $this->input->post('tanggal_rpu'),
            'pejagal' => $this->input->post('pejagal'),
            'perizinan' => $this->input->post('perizinan'),
            'tersedia_juleha' => $this->input->post('tersedia_juleha'),
            'lokasi' => $this->input->post('lokasi'),
            'kecamatan' => $this->session->userdata('kecamatan') ?: 'Benowo',
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
        
        $rpu_id = $this->P_Input_Rpu_Model->save_rpu($data_rpu);
        
        if ($rpu_id && $rpu_id > 0) {
            $data_komoditas = array();
            foreach ($valid_komoditas as $kom) {
                $data_komoditas[] = array(
                    'input_rpu_id' => $rpu_id,
                    'komoditas' => $kom['komoditas'],
                    'jumlah_ekor' => $kom['jumlah_ekor'],
                    'berat_kg' => $kom['berat_kg'],
                    'asal_unggas' => $kom['asal_unggas']
                );
            }
            
            if ($this->P_Input_Rpu_Model->save_komoditas($data_komoditas)) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan dengan ' . count($data_komoditas) . ' komoditas']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data RPU tersimpan tapi gagal menyimpan komoditas']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data RPU']);
        }
    }

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
                'message' => 'NIK ini sudah pernah digunakan sebanyak ' . $cek . ' kali'
            ]); 
        } else {
            echo json_encode(['status' => 'new']);
        }
    }
}
?>