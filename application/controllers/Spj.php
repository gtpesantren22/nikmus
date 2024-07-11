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

        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        }
        //  elseif ($user->level != 'account') {
        //     echo "
        //     <script>
        //     alert('Maaf. Data tidak dapat megakses halaman ini');
        //     window.location = '" . base_url('welcome') . "';
        //     </script>
        //     ";
        // }
    }

    public function index()
    {
        $data['judul'] = 'spj';
        $data['user'] = $this->Auth_model->current_user();
        $data['data'] = $this->model->data($this->tahun, $data['user']->lembaga)->result();
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
        $data['judul'] = 'spj';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['spj'] = $this->model->getBy('spj', 'kode_pengajuan', $kode)->row();
        $data['krit'] = $this->model->krit()->result();
        $data['daerah'] = $this->model->daerah()->result();
        $data['kritPilih'] = $this->model->getBy('kriteria', 'kode_kriteria', $data['data']->kode_kriteria)->row();
        $data['fileFotoNota'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'nota')->result();
        $data['fileFotoHasil'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'hasil')->result();

        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('spj_edit', $data);
        $this->load->view('foot');
    }


    public function editAct()
    {
        $where = $this->input->post('kode_pengajuan', true);
        $hasil = $this->input->post('hasil', true);
        $peserta = $this->input->post('peserta', true);
        $serap = rmRp($this->input->post('serap', true));

        $new_data = [
            'hasil' => $hasil,
            'peserta' => $peserta,
            'tgl_upload' => date('Y-m-d'),
            'status' => 'proses',
            'serap' => $serap,
        ];
        $data4 = [
            'kode_pengajuan' => $where,
            'status' => 'SPJ',
            'ket' => 'Upload File SPJ oleh Humas Lembaga',
            'oleh' => 'Humas Pesantren',
            'at' => date('Y-m-d H:i')
        ];

        $this->model->edit('spj', $new_data, $where);
        $this->model->simpan('history', $data4);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'SPJ Berhasil di ajukan');

            $key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
            $dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $where)->row();
            $pesan = '*INFORMASI SPJ NIKMUS*
Pengajuan SPJ 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Tanggal : ' . date('Y-m-d H:i') . '

Akan segera di cek oleh Humas Pesantren. Terimakasih';

            kirim_group($key->nama_key, '120363279501347686@g.us', $pesan);
            kirim_person($key->nama_key, '085236924510', $pesan);

            redirect('spj');
        } else {
            $this->session->set_flashdata('error', 'Pengajuana Data Gagal');
            redirect('spj');
        }
    }
    public function uploadFoto()
    {
        $where = $this->input->post('kode', true);
        $ket = $this->input->post('ket', true);

        $config['upload_path']          = FCPATH . '/assets/berkas/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['overwrite']            = true;
        $config['max_size']             = 0;

        $new_file_name = 'SPJ-FOTO_' . time();
        $config['file_name'] = $new_file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $data['error'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
        } else {
            $uploaded_data = $this->upload->data();
            $new_data = [
                'kode_pengajuan' => $where,
                'berkas' => $uploaded_data['file_name'],
                'ket' => $ket,
            ];
            $this->model->simpan('file_spj', $new_data);
            if ($this->db->affected_rows() > 0) {
                redirect('spj/edit/' . $where);
            } else {
                $this->session->set_flashdata('error', 'Upload Data Gagal');
                redirect('spj/edit/' . $where);
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
        $this->model->edit('pengajuan', $data, $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Pengajuan Berhasil. Silahkan menunggu verval dari Humas pesantren!');
            $this->model->simpan('history', $data4);
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
            $key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
            $dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
            $pesan = '*INFORMASI SPJ NIKMUS*
Pengajuan SPJ 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Tanggal : ' . date('Y-m-d H:i') . '

SPJ disetujui oleh Humas Pesantren. Selanjutnya bisa melakukan pengajuan berikutnya.
Terimakasih';

            kirim_group($key->nama_key, '120363279501347686@g.us', $pesan);
            kirim_person($key->nama_key, '085236924510', $pesan);
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

            $key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
            $dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
            $pesan = '*INFORMASI SPJ NIKMUS*
Pengajuan SPJ 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Tanggal : ' . date('Y-m-d H:i') . '

SPJ *ditolak* oleh Humas Pesantren.
Terimakasih';

            kirim_group($key->nama_key, '120363279501347686@g.us', $pesan);
            kirim_person($key->nama_key, '085236924510', $pesan);
            redirect('spj');
        } else {
            $this->session->set_flashdata('error', 'Persetujuan Data Gagal');
            redirect('spj');
        }
    }

    public function delFoto($id)
    {
        $data = $this->model->getBy('file_spj', 'id_file', $id)->row();
        $this->model->hapus2('file_spj', 'id_file', $id);
        if ($this->db->affected_rows() > 0) {
            unlink('./assets/berkas/' . $data->berkas);
            redirect('spj/edit/' . $data->kode_pengajuan);
        } else {
            redirect('spj/edit/' . $data->kode_pengajuan);
        }
    }

    public function detail($kode)
    {
        $data['judul'] = 'spj';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['dataSpj'] = $this->model->getBy('spj', 'kode_pengajuan', $kode)->row();
        $data['kritPilih'] = $this->model->getBy('kriteria', 'kode_kriteria', $data['data']->kode_kriteria)->row();
        $data['fileFotoNota'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'nota')->result();
        $data['fileFotoHasil'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'hasil')->result();

        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('head', $data);
        $this->load->view('spj_detail', $data);
        $this->load->view('foot');
    }

    public function cetak($kode)
    {
        $data['judul'] = 'spj';
        $data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
        $data['dataSpj'] = $this->model->getBy('spj', 'kode_pengajuan', $kode)->row();
        $data['kritPilih'] = $this->model->getBy('kriteria', 'kode_kriteria', $data['data']->kode_kriteria)->row();
        $data['daerah'] = $this->model->getBy('transport', 'kode_transport', $data['data']->daerah)->row();
        $data['cair'] = $this->model->getBy('pencairan', 'kode_pengajuan', $kode)->row();
        $data['fileFotoNota'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'nota')->result();
        $data['fileFotoHasil'] = $this->model->getBy2('file_spj', 'kode_pengajuan', $kode, 'ket', 'hasil')->result();

        $data['user'] = $this->Auth_model->current_user();
        $data['tahun'] = $this->tahun;

        $this->load->view('spj_cetak', $data);
    }
}
