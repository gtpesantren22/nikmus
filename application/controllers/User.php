<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'model');
        $this->load->model('Auth_model');

        $user = $this->Auth_model->current_user();
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        } elseif ($user->level != 'account') {
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
        $data['judul'] = 'user';
        $data['data'] = $this->model->data()->result();
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('head', $data);
        $this->load->view('user', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data = [
            'id_user' => $this->uuid->v4(),
            'nama' => $this->input->post('nama', true),
            'username' => $this->input->post('username', true),
            'level' => $this->input->post('level', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_BCRYPT),
            'aktif' => $this->input->post('aktif', true),
        ];

        $this->model->simpan('user', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Ditambahkan');
            redirect('user');
        } else {
            $this->session->set_flashdata('error', 'Tambah Data Gagal');
            redirect('user');
        }
    }

    public function edit()
    {
        $where = $this->input->post('kode_kriteria', true);
        $data = [
            'nama' => $this->input->post('nama', true),
            'nominal' => rmRp($this->input->post('nominal', true))
        ];

        $this->model->edit('kriteria', $data, $where);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Update Data Berhasil ');
            redirect('kriteria');
        } else {
            $this->session->set_flashdata('error', 'Edit Data Gagal');
            redirect('kriteria');
        }
    }

    public function del($kode)
    {
        $this->model->hapus('user', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Berhasil ');
            redirect('user');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('user');
        }
    }
}