<?php

class Produk_model extends CI_Model
{
    public function getAllProduk()
    {
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.id_kategori=produk.kategori_id', 'left');
        $this->db->join('status', 'status.id_status=produk.status_id', 'left');
        $this->db->where('status_id', 'bisa dijual');
        $this->db->order_by('id_produk', 'desc');
        return $this->db->get()->result_array();
    }

    public function findById($id)
    {
        $query = $this->db->get_where('produk', ['id_produk' => $id]);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return 0;
    }

    public function tambah_data_api($dataProduk)
    {
        foreach ($dataProduk as $prd) {
            $tambahData = [
                'id_produk' => $prd['id_produk'],
                'nama_produk' => $prd['nama_produk'],
                'harga' => $prd['harga'],
                'kategori_id' => $prd['kategori'],
                'status_id' => $prd['status']
            ];

            $this->db->insert('produk', $tambahData);
        }

        return $this->db->insert_id();
    }

    public function tambah_data($data)
    {
        $this->db->insert('produk', $data);
        return $this->db->affected_rows();
    }

    public function edit_data($data)
    {
        $this->db->where('id_produk', $data['id_produk']);
        unset($data['id_produk']);
        $this->db->update('produk', $data);
        return $this->db->affected_rows();
    }

    public function hapus_data($id)
    {
        $this->db->where('id_produk', $id);
        $this->db->delete('produk');
    }
}
