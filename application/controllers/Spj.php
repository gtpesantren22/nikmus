<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spj extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('SpjModel', 'model');
        $this->load->model('Auth_model');
        $this->tahun = $this->session->userdata('tahun');

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
        $data['judul'] = 'spj';
        $data['data'] = $this->model->data($this->tahun)->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('spj', $data);
        $this->load->view('foot');
    }

    public function add()
    {
        $data['judul'] = 'spj';
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan_add', $data);
        $this->load->view('foot');
    }

    public function edit($kode)
    {
        $data['judul'] = 'pengajuan';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('pengajuan_edit', $data);
        $this->load->view('foot');
    }

    public function saveAdd()
    {
        $data1 = $this->db->query("SELECT max(substring(kode_pengajuan, 6)) as maxKode FROM pengajuan ")->row();
        $kodeBarang = $data1->maxKode == null ? '0000' : $data1->maxKode;
        $noUrut = (int) substr($kodeBarang, 0, 4);
        $noUrut++;
        $char = "NMKS";
        $kodeBarang = $char . sprintf("%04s", $noUrut);
        $kode = htmlspecialchars($kodeBarang);

        $transport = $this->model->getBy('transport', 'kode_transport', $this->input->post('transport', true))->row();
        $kriteria = $this->model->getBy('kriteria', 'kode_kriteria', $this->input->post('kriteria', true))->row();

        $data = [
            'kode_pengajuan' => $kode,
            'nama' => $this->input->post('nama', true),
            'kriteria' => $kriteria->nama,
            'nom_kriteria' => $kriteria->nominal,
            'daerah' => $transport->daerah,
            'transport' => $transport->nominal,
            'sopir' => $transport->sopir,
            'tgl_jalan' => $this->input->post('tgl_jalan', true),
            'tahun' => $this->tahun,
            'status' => 'belum',
            'created' => date('Y-m-d H:i')
        ];


        $this->model->simpan('pengajuan', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data Berhasil Ditambahkan');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Tambah Data Gagal');
            redirect('pengajuan');
        }
    }

    public function editAct()
    {
        $where = $this->input->post('kode_pengajuan', true);
        $lama = $this->input->post('file_lama', true);

        $config['upload_path']          = FCPATH . '/assets/berkas/';
        $config['allowed_types']        = 'pdf';
        $config['file_name']            = 'SPJ-' . $where . random(3);
        $config['overwrite']            = true;
        $config['max_size']             = 0;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $data['error'] = $this->upload->display_errors();
        } else {
            if ($lama != '') {
                unlink('/assets/berkas/' . $lama);
            }
            $uploaded_data = $this->upload->data();
            $new_data = [
                'berkas' => $uploaded_data['file_name'],
                'tgl_upload' => $this->input->post('tgl_upload', true),
                'status' => 'proses'
            ];
            $data4 = [
                'kode_pengajuan' => $where,
                'status' => 'SPJ',
                'ket' => 'Upload File SPJ oleh Humas Pesantren',
                'oleh' => 'Humas Pesantren',
                'at' => date('Y-m-d H:i')
            ];

            $this->model->edit('spj', $new_data, $where);
            $this->model->simpan('history', $data4);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('ok', 'SPJ Berhasil di ajukan');
                redirect('spj');
            } else {
                $this->session->set_flashdata('error', 'Pengajuana Data Gagal');
                redirect('spj');
            }
        }
    }

    public function ajukan($kode)
    {
        $data = ['status' => 'proses'];
        $data4 = [
            'kode_pengajuan' => $kode,
            'status' => 'SPJ',
            'ket' => 'SPJ diajukan oleh Humas Pesantren kepada Accounting',
            'oleh' => 'Humas Pesantren',
            'at' => date('Y-m-d H:i')
        ];
        $this->model->simpan('history', $data4);
        $this->model->edit('pengajuan', $data, $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Pengajuan Berhasil. Silahkan menunggu verval dari accounting!');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('pengajuan');
        }
    }

    public function del($kode)
    {
        $this->model->hapus('pengajuan', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Berhasil ');
            redirect('pengajuan');
        } else {
            $this->session->set_flashdata('error', 'Hapus Data Gagal');
            redirect('pengajuan');
        }
    }

    public function down($kode)
    {
        $file = $this->model->getFile($kode)->row();
        force_download('/assets/berkas/' . $file->berkas, NULL);
        // echo base_url('/assets/berkas/' . $file->berkas);
        // redirect('spj');
    }

    public function setujui($kode)
    {
        $data = ['status' => 'selesai'];
        $data4 = [
            'kode_pengajuan' => $kode,
            'status' => 'SPJ',
            'ket' => 'SPJ disetujui oleh Accounting',
            'oleh' => 'Accounting',
            'at' => date('Y-m-d H:i')
        ];
        $this->model->simpan('history', $data4);
        $this->model->edit('spj', $data, $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'SPJ sudah Disetujui!');
            redirect('spj');
        } else {
            $this->session->set_flashdata('error', 'Persetujuan Data Gagal');
            redirect('spj');
        }
    }

    public function tolak($kode)
    {
        $data = ['status' => 'ditolak'];
        $data4 = [
            'kode_pengajuan' => $kode,
            'status' => 'SPJ',
            'ket' => 'SPJ ditolak oleh Accounting dengan catatan : ',
            'oleh' => 'Accounting',
            'at' => date('Y-m-d H:i')
        ];
        $this->model->simpan('history', $data4);
        $this->model->edit('spj', $data, $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'SPJ Ditolak');
            redirect('spj');
        } else {
            $this->session->set_flashdata('error', 'Persetujuan Data Gagal');
            redirect('spj');
        }
    }
}
