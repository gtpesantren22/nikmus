<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('PengajuanModel', 'model');
        $this->load->model('Auth_model');

        $user = $this->Auth_model->current_user();
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        } elseif ($user->level != 'account' && $user->level != 'humas') {
            echo "
            <script>
            alert('Maaf. Data tidak dapat megakses halaman ini');
            window.location = '" . base_url('welcome') . "';
            </script>
            ";
        }
    }

    public function index()
    {
        $data['judul'] = 'history';
        $data['data'] = $this->model->data()->result();
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('head', $data);
        $this->load->view('history', $data);
        $this->load->view('foot');
    }

    public function detail($kode)
    {
        $data['judul'] = 'history';
        $data['user'] = $this->Auth_model->current_user();
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['data2'] = $this->model->getBy('history', 'kode_pengajuan', $kode)->result();
        $data['spj'] = $this->model->getBy('spj', 'kode_pengajuan', $kode)->row();

        $this->load->view('head', $data);
        $this->load->view('history_detail', $data);
        $this->load->view('foot');
    }
}