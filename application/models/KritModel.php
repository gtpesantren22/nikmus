<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KritModel extends CI_Model
{
    function data()
    {
        return $this->db->get('kriteria');
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
        $this->db->where('kode_kriteria', $where);
        $this->db->update($table, $data);
    }

    function hapus($table, $where)
    {
        $this->db->where('kode_kriteria', $where);
        $this->db->delete($table);
    }
}