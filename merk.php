<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Merk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }


    public function index()
    {
        $data['judul'] = 'Data Kategori Motor';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $data['merk'] = $this->modelMerk->getMerk();
        $this->form_validation->set_rules('merk', 'Merk', 'required');



        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar', $data);
            $this->load->view('motor/merk/merk', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $this->db->insert('merk', ['Merk' => $this->input->post('merk')]);
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message show" role="alert">
                        Merk Baru Ditambahkan!!
                </div>'
            );
            redirect('Merk');
        }
    }


    public function deleteMerk($id)
    {
        $this->modelMerk->deleteMerk($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message show" role="alert">
                    Merk Berhasil Dihapus!!
            </div>'
        );
        redirect('merk');
    }

    public function ubahMerk()
    {
        $data['judul'] = 'Ubah Merk';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();


        $data['merk'] = $this->modelMerk->getMerkWhere(['id_merk' => $this->uri->segment(3)])->row_array();

        $this->form_validation->set_rules('merk', 'Merk', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar', $data);
            $this->load->view('motor/merk/edit', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $this->modelMerk->editMerkById();;
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message show" role="alert">
                        Merk Berhasil Diubah!!
                </div>'
            );
            redirect('merk');
        }
    }
}
