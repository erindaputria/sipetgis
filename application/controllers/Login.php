<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard masing-masing
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            if ($role == 'Admin Bidang') {
                redirect('dashboard');
            } elseif ($role == 'Kepala Dinas') {
                redirect('k_dashboard_kepala');
            } elseif ($role == 'Petugas Kecamatan') {
                redirect('p_dashboard_petugas');
            }
        }
        
        $this->load->view('auth/login');
    }

    public function cek_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Daftar kecamatan di Surabaya
        $kecamatan_surabaya = [
            'asemrowo', 'benowo', 'bubutan', 'bulak', 'dukuhpakis',
            'gayungan', 'genteng', 'gubeng', 'gununganyar', 'jambangan',
            'karangpilang', 'kenjeran', 'krembangan', 'lakarsantri', 'mulyorejo',
            'pabeancantian', 'pakal', 'rungkut', 'sambikerep', 'sawahan',
            'semampir', 'simokerto', 'sukolilo', 'sukomanunggal', 'tambaksari',
            'tandes', 'tegalsari', 'tenggilis', 'wiyung', 'wonocolo', 'wonokromo'
        ];

        // Cek login untuk admin
        if($username == 'admin' && $password == 'password') {
            $session_data = array(
                'username' => $username,
                'role' => 'Admin Bidang',
                'kecamatan' => 'Surabaya',
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        }
        // Cek login untuk kepala dinas
        elseif($username == 'kepala' && $password == 'password') {
            $session_data = array(
                'username' => $username,
                'role' => 'Kepala Dinas',
                'kecamatan' => 'Surabaya',
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('k_dashboard_kepala');
        }
        // Cek login untuk petugas kecamatan
        else {
            $login_success = false;
            $kecamatan_login = '';
            
            foreach($kecamatan_surabaya as $kec) {
                if($username == 'petugas_' . $kec && $password == 'password') {
                    $login_success = true;
                    $kecamatan_login = $kec;
                    break;
                }
            }
            
            if($login_success) {
                // Ubah format nama kecamatan untuk tampilan
                $kecamatan_display = ucwords(str_replace('_', ' ', $kecamatan_login));
                
                // Perbaiki penamaan khusus
                $kecamatan_display = str_replace(
                    ['Dukuhpakis', 'Gununganyar', 'Karangpilang', 'Pabeancantian', 'Tenggilis'],
                    ['Dukuh Pakis', 'Gunung Anyar', 'Karang Pilang', 'Pabean Cantian', 'Tenggilis Mejoyo'],
                    $kecamatan_display
                );
                
                $session_data = array(
                    'username' => $username,
                    'role' => 'Petugas Kecamatan',
                    'kecamatan' => $kecamatan_display,
                    'kecamatan_code' => $kecamatan_login,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);
                redirect('p_dashboard_petugas');
            }
            else {
                // Kalau salah, kembali ke login dengan pesan error
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}