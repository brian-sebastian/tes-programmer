<?php

class Kategori_model extends CI_Model
{
    public function getAllkategori()
    {
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->order_by('id_kategori', 'desc');
        return $this->db->get()->result_array();
    }

    public function findById($id)
    {
        $query =  $this->db->get_where('kategori', ['id_kategori' => $id]);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return 0;
    }

    public function tambah_data($data)
    {
        $this->db->insert('kategori', $data);
        return $this->db->affected_rows();
    }

    public function edit_data($data)
    {
        $this->db->where('id_kategori', $data['id_kategori']);
        unset($data['id_kategori']);
        $this->db->update('kategori', $data);
        return $this->db->affected_rows();
    }


    public function hapus_data($id)
    {
        $this->db->where('id_kategori', $id);
        $this->db->delete('kategori');
    }
}
