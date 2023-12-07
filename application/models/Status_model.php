<?php

class Status_model extends CI_Model
{
    public function getAllStatus()
    {
        $this->db->select('*');
        $this->db->from('status');
        $this->db->order_by('id_status', 'desc');
        return $this->db->get()->result_array();
    }

    public function findById($id)
    {
        $query =  $this->db->get_where('status', ['id_status' => $id]);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return 0;
    }

    public function tambah_data($data)
    {
        $this->db->insert('status', $data);
        return $this->db->affected_rows();
    }

    public function edit_data($data)
    {
        $this->db->where('id_status', $data['id_status']);
        unset($data['id_status']);
        $this->db->update('status', $data);
        return $this->db->affected_rows();
    }


    public function hapus_data($id)
    {
        $this->db->where('id_status', $id);
        $this->db->delete('status');
    }
}
