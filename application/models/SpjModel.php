<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SpjModel extends CI_Model
{
    function data($tahun, $lembaga)
    {
        if ($lembaga == 'Pesantren') {
            return $this->db->query("SELECT spj.* FROM spj JOIN pengajuan ON spj.kode_pengajuan=pengajuan.kode_pengajuan WHERE spj.tahun = '$tahun' ");
        } else {
            return $this->db->query("SELECT spj.* FROM spj JOIN pengajuan ON spj.kode_pengajuan=pengajuan.kode_pengajuan WHERE spj.tahun = '$tahun' AND pengajuan.lembaga = '$lembaga' ");
        }
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
    function getBy2($table, $where, $dtwr, $where1, $dtwr1)
    {
        $this->db->where($where, $dtwr);
        $this->db->where($where1, $dtwr1);
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
    function hapus2($table, $where, $dtwr)
    {
        $this->db->where($where, $dtwr);
        $this->db->delete($table);
    }

    function getFile($kode)
    {
        $this->db->where('kode_pengajuan', $kode);
        $this->db->from('spj');
        return $this->db->get();
    }
}
