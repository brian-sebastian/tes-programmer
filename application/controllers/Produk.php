<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Kategori_model');
        $this->load->model('Status_model');
    }

    public function index()
    {
        $data['produk'] =  $this->Produk_model->getAllProduk();
        $data['kategori'] = $this->Kategori_model->getAllkategori();
        $data['status'] = $this->Status_model->getAllStatus();

        // dump($data['produk']);
        // die();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar');
        $this->load->view('produk/index', $data);
        $this->load->view('layout/footer');
    }

    public function tesApi()
    {
        $client = new GuzzleHttp\Client();
        $url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';
        $username = "tesprogrammer071223C14";
        $password = "bisacoding-07-12-23";
        $passwordHash = md5($password);
        // Set various headers on a request

        $response = $client->request(
            'POST',
            $url,
            [
                'form_params' => [
                    'username' => $username,
                    'password' => $passwordHash,
                ]
            ]
        );

        $a = $response->getBody();
        $getStatusCode = $response->getStatusCode();

        //status oke
        if ($getStatusCode == 200) {
            $data = json_decode($a, true);
            $dataProduk = $data['data'];

            $idbaru = $this->Produk_model->tambah_data_api($dataProduk);
            if ($idbaru) {
                echo "Data berhasil disimpan " . $idbaru;
            } else {
                echo "Data gagal disimpan";
            }
        } else {
            echo "data gagal diambil";
        }
    }

    public function tambah()
    {
        $field = [
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required'
            ],
            [
                'field' => 'harga',
                'label' => 'Harga',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'kategori_id',
                'label' => 'Kategori Id',
                'rules' => 'required'
            ],
            [
                'field' => 'status_id',
                'label' => 'Status Id',
                'rules' => 'required'
            ],
        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() == TRUE) {

            $data = [
                'nama_produk' => htmlspecialchars($this->input->post('nama_produk')),
                'harga' => htmlspecialchars($this->input->post('harga')),
                'kategori_id' => htmlspecialchars($this->input->post('kategori_id')),
                'status_id' => htmlspecialchars($this->input->post('status_id')),
            ];

            if ($this->Produk_model->tambah_data($data)) {
                $data_json['status'] = 'berhasil';
                $data_json['response'] = 'data berhasil ditambahkan';
            } else {
                $data_json['status'] = 'gagal';
                $data_json['response'] = 'data gagal ditambahkan';
            }
        } else {
            $data_json['status'] = 'error';
            $data_json['err_nama_produk'] = form_error('nama_produk');
            $data_json['err_harga'] = form_error('harga');
            $data_json['err_kategori_id'] = form_error('kategori_id');
            $data_json['err_status_id'] = form_error('status_id');
        }

        echo json_encode($data_json);
    }

    public function tampilan_edit()
    {
        $field = [
            [
                'field' => 'id_produk',
                'label' => 'ID PROUDUK',
                'rules' => 'required'
            ]
        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() == TRUE) {
            $id_produk = htmlspecialchars($this->input->post('id_produk'));
            $res = $this->Produk_model->findById($id_produk);

            if ($res) {

                $data_json["status"]    = "berhasil";
                $data_json["response"]  = $res;
            } else {

                $data_json["status"]    = "gagal";
                $data_json["response"]  = "Data tidak ada";
            }
        } else {
            $data_json["status"]    = "error";
            $data_json["response"]  = form_error("id_produk");
        }

        echo json_encode($data_json);
    }

    public function edit()
    {
        $field = [
            [
                'field' => 'id_produk',
                'label' => 'ID PRODUK',
                'rules' => 'required'
            ],
            [
                'field' => 'nama_produk_edit',
                'label' => 'Nama Produk',
                'rules' => 'required'
            ],
            [
                'field' => 'harga_edit',
                'label' => 'Harga',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'kategori_id_edit',
                'label' => 'Kategori Id',
                'rules' => 'required'
            ],
            [
                'field' => 'status_id_edit',
                'label' => 'Status Id',
                'rules' => 'required'
            ],

        ];

        $this->form_validation->set_rules($field);

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'id_produk' => htmlspecialchars($this->input->post('id_produk')),
                'nama_produk' => htmlspecialchars($this->input->post('nama_produk_edit')),
                'harga' => htmlspecialchars($this->input->post('harga_edit')),
                'kategori_id' => htmlspecialchars($this->input->post('kategori_id_edit')),
                'status_id' => htmlspecialchars($this->input->post('status_id_edit')),
            ];

            if ($this->Produk_model->edit_data($data)) {
                $data_json['status']    = "berhasil";
                $data_json['response']  = "data berhasil di ubah";
            } else {

                $data_json['status']    = "gagal";
                $data_json['response']  = "data gagal di ubah";
            }
        } else {
            $data_json['status']                = "error";
            $data_json['err_nama_produk_edit']    = form_error('nama_produk_edit');
            $data_json['err_harga_edit']    = form_error('harga_edit');
            $data_json['err_kategori_id_edit']    = form_error('kategori_id_edit');
            $data_json['err_status_id_edit']    = form_error('status_id_edit');
        }

        echo json_encode($data_json);
    }

    public function hapus($id)
    {
        $this->Produk_model->hapus_data(base64_decode($id));
        $this->session->set_flashdata('berhasil', 'data berhasil di hapus');
        redirect('produk');
    }
}
