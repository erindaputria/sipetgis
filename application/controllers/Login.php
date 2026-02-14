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
        $this->load->view('login');
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
            $this->session->set_userdata('username', $username);
            $this->session->set_userdata('role', 'Admin Bidang');
            $this->session->set_userdata('kecamatan', 'Surabaya');
            redirect('dashboard');
        }
        // Cek login untuk kepala dinas
        elseif($username == 'kepala' && $password == 'password') {
            $this->session->set_userdata('username', $username);
            $this->session->set_userdata('role', 'Kepala Dinas');
            $this->session->set_userdata('kecamatan', 'Surabaya');
            redirect('k_dashboard_kepala');
        }
        // Cek login untuk petugas kecamatan
        else {
            // Loop untuk cek apakah username cocok dengan pola petugas_kecamatan
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
                // Ubah format nama kecamatan untuk tampilan (capitalize)
                $kecamatan_display = ucwords(str_replace('_', ' ', $kecamatan_login));
                
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('role', 'Petugas Kecamatan');
                $this->session->set_userdata('kecamatan', $kecamatan_display);
                $this->session->set_userdata('kecamatan_code', $kecamatan_login);
                redirect('p_dashboard_petugas');
            }
            else {
                // Kalau salah, kembali ke login
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
?>