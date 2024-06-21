<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Transaksi';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();


        $data['transaksi'] = $this->ModelTransaksi->JoinTransaksi();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/admin/footer');
    }



    public function hapusTransaksi($id)
    {

        $this->ModelTransaksi->deleteTransaksi($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message show col-lg-6 " role="alert">
                    Transaksi Berhasil Dihapus!!
            </div>'
        );
        redirect('Transaksi');
    }

    public function info()
    {
        $data['judul'] = 'info Transaksi';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $data['transaksi'] = $this->ModelTransaksi->TransaksiWithMotor(['id_pembelian' => $this->uri->segment(3)]);

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('transaksi/info', $data);
        $this->load->view('templates/admin/footer');
    }
}
