<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Motor extends CI_Controller
{


    public function index()
    {

        $data['judul'] = "Tambah Motor";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $data['merk'] = $this->modelMerk->getMerk();
        $data['motor'] = $this->modelMotor->getMotor();


        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('motor/index', $data);
        $this->load->view('templates/admin/footer');
    }

    public function tambahMotor()
    {
        $data['judul'] = "Tambah Motor";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['merk'] = $this->modelMerk->getMerk();




        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('mesin', 'mesin', 'required');
        $this->form_validation->set_rules('merk', 'merk', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar', $data);
            $this->load->view('motor/tambah', $data);
            $this->load->view('templates/admin/footer');
        } else {


            $config['upload_path']          = './assets/img/moge';
            $config['allowed_types']        = 'gif|jpg|png';


            $this->load->library('upload', $config);


            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert assets-message alert-danger " role="alert">
                    Upload Gambar Gagal!!
                    </div>'
                );

                redirect('motor/tambahMotor');
            } else {
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name'];

                $insert = $this->modelMotor->tambahMotor($image);

                if ($insert) {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert assets-message alert-danger " role="alert">
                        Upload Gambar Gagal!!
                        </div>'
                    );
                    redirect('motor/tambahMotor');
                }
            }

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert assets-message alert-success " role="alert">
                Motor Baru Ditambahkan!!
                </div>'
            );


            redirect('motor');
        }
    }

    public function ubahMotor()
    {
        $data['judul'] = "Ubah Motor";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['merk'] = $this->modelMerk->getMerk();


        $data['motor'] = $this->modelMotor->getMotorWhere(['Kd_kendaraan' => $this->uri->segment(3)])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('mesin', 'mesin', 'required');
        $this->form_validation->set_rules('merk', 'merk', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar', $data);
            $this->load->view('motor/edit', $data);
            $this->load->view('templates/admin/footer');
        } else {


            //konfigurasi sebelum gambar diupload
            $config['upload_path']          = './assets/img/moge/';
            $config['allowed_types']        = 'gif|jpg|png';

            //memuat atau memanggil library upload
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('gambar')) {
                $image = $this->upload->data();
                unlink('assets/img/moge/' . $this->input->post('gambar_lama', TRUE));
                $gambar = $image['file_name'];
            } else {
                $gambar = $this->input->post('gambar_lama');
            }
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert assets-message alert-success " role="alert">
                Motor Berhasil Diubah!!
                </div>'
            );

            $data = [
                'Nama_motor' => $this->input->post('nama'),
                'Harga_jual' => $this->input->post('harga'),
                'Stock' => $this->input->post('stok'),
                'Id_Merk' => $this->input->post('merk'),
                'Gambar' => $gambar,
                'Mesin' => $this->input->post('mesin'),
                'Deskripsi' => $this->input->post('desk')
            ];

            $this->modelMotor->updateMotor($data, ['Kd_kendaraan' => $this->input->post('id')]);


            redirect('motor');
        }
    }

    public function motorInfo()
    {
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Info Motor';
        // $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();


        $data['motor'] = $this->modelMotor->getMotorWhere(['Kd_kendaraan' => $this->uri->segment(3)])->row_array();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('motor/info', $data);
        $this->load->view('templates/admin/footer');
    }

    public function hapusMotor($id)
    {

        $this->modelMotor->deleteMotor($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">
                    Motor Berhasil Dihapus!!
            </div>'
        );
        redirect('motor');
    }
}
