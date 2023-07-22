<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('sentral', true);
    }

    function data($tahun)
    {
        $this->db->order_by('tgl_jalan', 'DESC');
        $this->db->where('tahun', $tahun);
        return $this->db->get('pengajuan');
    }

    function verval()
    {
        $this->db->where('status', 'proses');
        return $this->db->get('pengajuan');
    }

    function cair()
    {
        $this->db->where('status', 'disetujui');
        return $this->db->get('pengajuan');
    }

    function krit()
    {
        return $this->db->get('kriteria');
    }

    function daerah()
    {
        return $this->db->get('transport');
    }

    function getBy($table, $where, $dtwr)
    {
        $this->db->where($where, $dtwr);
        return $this->db->get($table);
    }

    function simpan($table, $data)
    {
        $this->db->insert($table, $data);
    }

    function apikey()
    {
        $this->db->select('*');
        $this->db->from('api');
        return $this->db->get();
    }

    function edit($table, $data, $where)
    {
        $this->db->where('kode_pengajuan', $where);
        $this->db->update($table, $data);
    }

    function hapus($table, $where)
    {
        $this->db->where('kode_pengajuan', $where);
        $this->db->delete($table);
    }
}
