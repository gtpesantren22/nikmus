<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SantriModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('sentral', true);
    }

    function baru()
    {
        $this->db->where('aktif', 'Y');
        $this->db->from('tb_santri');
        return $this->db->get();
    }

    public function syncSantri()
    {
        try {
            // Ambil data santri aktif dari database sentral
            $this->db2->where('aktif', 'Y');
            $santriSentral = $this->db2->get('tb_santri');

            if (!$santriSentral) {
                return false;
            }

            $data = $santriSentral->result_array();
            $total = count($data);

            if ($total > 0) {
                // Dapatkan kolom yang ada di tabel lokal tb_santri
                $localFields = $this->db->list_fields('tb_santri');
                $fieldsMap = array_flip($localFields);

                // Filter setiap baris data agar hanya kolom yang ada di database lokal yang dimasukkan
                $filteredData = [];
                foreach ($data as $row) {
                    $filteredData[] = array_intersect_key($row, $fieldsMap);
                }

                $this->db->trans_start();
                $this->db->truncate('tb_santri');

                // Insert data dalam batch per 500 baris agar optimal
                $chunks = array_chunk($filteredData, 500);
                foreach ($chunks as $chunk) {
                    $this->db->insert_batch('tb_santri', $chunk);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    return false;
                }
                return $total;
            }
            return 0;
        } catch (\Exception $e) {
            log_message('error', 'Sync Santri Error: ' . $e->getMessage());
            return false;
        }
    }

    function apikey()
    {
        $this->db->select('*');
        $this->db->from('api');
        return $this->db->get();
    }
}