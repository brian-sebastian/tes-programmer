<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
    }

    public function index()
    {
        $data['kategori'] =  $this->Kategori_model->getAllkategori();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('kategori/index', $data);
        $this->load->view('layout/footer');
    }

    public function tambah()
    {
        $field = [
            [
                'field' => 'nama_kategori',
                'label' => 'Nama Kategori',
                'rules' => 'required|max_length[100]|is_unique[kategori.nama_kategori]'
            ]
        ];

        $this->form_validation->set_rules($field);
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori')),
            ];


            if ($this->Kategori_model->tambah_data($data)) {
                $data_json['status'] = 'berhasil';
                $data_json['response'] = 'data berhasil ditambahkan';
            } else {
                $data_json['status'] = 'gagal';
                $data_json['response'] = 'data gagal ditambahkan';
            }
        } else {
            $data_json['status'] = 'error';
            $data_json['err_nama_kategori'] = form_error('nama_kategori');
        }
        echo json_encode($data_json);
    }

    public function tampilan_edit()
    {
        $field = [
            [
                'field' => 'id_kategori',
                'label' => 'ID Kategori',
                'rules' => 'required|trim'
            ]
        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() === true) {

            $id_kategori = htmlspecialchars($this->input->post("id_kategori"));

            $res = $this->Kategori_model->findById($id_kategori);

            if ($res) {

                $data_json["status"]    = "berhasil";
                $data_json["response"]  = $res;
            } else {

                $data_json["status"]    = "gagal";
                $data_json["response"]  = "Data tidak ada";
            }
        } else {

            $data_json["status"]    = "error";
            $data_json["response"]  = form_error("id_kategori");
        }

        echo json_encode($data_json);
    }

    public function edit()
    {
        $field = [
            [
                'field' => 'id_kategori',
                'label' => 'Kategori ID',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'kategori_edit',
                'label' => 'Nama Kategori',
                'rules' => 'required|trim|max_length[100]|is_unique[kategori.nama_kategori]'
            ],

        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'id_kategori' => htmlspecialchars($this->input->post('id_kategori')),
                'nama_kategori' => htmlspecialchars($this->input->post('kategori_edit'))
            ];

            if ($this->Kategori_model->edit_data($data)) {
                $data_json['status']    = "berhasil";
                $data_json['response']  = "data berhasil di ubah";
            } else {
                $data_json['status']    = "gagal";
                $data_json['response']  = "data gagal di ubah";
            }
        } else {
            $data_json['status']                = "error";
            $data_json['err_kategori_edit']    = form_error('kategori_edit');
        }

        echo json_encode($data_json);
    }

    public function hapus($id)
    {
        $this->Kategori_model->hapus_data(base64_decode($id));
        $this->session->set_flashdata('berhasil', 'Berhasil di hapus');
        redirect('kategori');
    }
}
