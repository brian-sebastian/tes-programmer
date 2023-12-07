<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Status_model');
    }

    public function index()
    {
        $data['status'] =  $this->Status_model->getAllStatus();


        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('status/index', $data);
        $this->load->view('layout/footer');
    }

    public function tambah()
    {
        $field = [
            [
                'field' => 'nama_status',
                'label' => 'Nama Status',
                'rules' => 'required|max_length[100]|is_unique[status.nama_status]'
            ]
        ];

        $this->form_validation->set_rules($field);
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_status' => htmlspecialchars($this->input->post('nama_status')),
            ];


            if ($this->Status_model->tambah_data($data)) {
                $data_json['status'] = 'berhasil';
                $data_json['response'] = 'data berhasil ditambahkan';
            } else {
                $data_json['status'] = 'gagal';
                $data_json['response'] = 'data gagal ditambahkan';
            }
        } else {
            $data_json['status'] = 'error';
            $data_json['err_nama_status'] = form_error('nama_status');
        }
        echo json_encode($data_json);
    }

    public function tampilan_edit()
    {
        $field = [
            [
                'field' => 'id_status',
                'label' => 'ID Status',
                'rules' => 'required|trim'
            ]
        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() === true) {

            $id_status = htmlspecialchars($this->input->post("id_status"));

            $res = $this->Status_model->findById($id_status);

            if ($res) {

                $data_json["status"]    = "berhasil";
                $data_json["response"]  = $res;
            } else {

                $data_json["status"]    = "gagal";
                $data_json["response"]  = "Data tidak ada";
            }
        } else {

            $data_json["status"]    = "error";
            $data_json["response"]  = form_error("id_status");
        }

        echo json_encode($data_json);
    }

    public function edit()
    {
        $field = [
            [
                'field' => 'id_status',
                'label' => 'Status ID',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'status_edit',
                'label' => 'Nama Status',
                'rules' => 'required|trim|max_length[100]|is_unique[status.nama_status]'
            ],

        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'id_status' => htmlspecialchars($this->input->post('id_status')),
                'nama_status' => htmlspecialchars($this->input->post('status_edit'))
            ];

            if ($this->Status_model->edit_data($data)) {
                $data_json['status']    = "berhasil";
                $data_json['response']  = "data berhasil di ubah";
            } else {
                $data_json['status']    = "gagal";
                $data_json['response']  = "data gagal di ubah";
            }
        } else {
            $data_json['status']                = "error";
            $data_json['err_status_edit']    = form_error('status_edit');
        }

        echo json_encode($data_json);
    }

    public function hapus($id)
    {
        $this->Status_model->hapus_data(base64_decode($id));
        $this->session->set_flashdata('berhasil', 'Berhasil di hapus');
        redirect('status');
    }
}
