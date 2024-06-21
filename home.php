<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home extends CI_Controller
{

	public function index()
	{
		$data['judul'] = "Home";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('web/home');
		$this->load->view('templates/footer');
	}

	public function Motor()
	{
		$data['judul'] = "motor";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['motor'] = $this->modelMotor->getMotor();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('web/motor');
		$this->load->view('templates/footer');
	}


	public function details()
	{
		$data['judul'] = "motor";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['motor'] = $this->modelMotor->getMotorWhere(['Kd_kendaraan' => $this->uri->segment(3)])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('web/details');
		$this->load->view('templates/footer');
	}

	public function transaksi()
	{


		$data['judul'] = "transaksi";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['motor'] = $this->modelMotor->getMotorWhere(['Kd_kendaraan' => $this->uri->segment(3)])->row_array();

		$this->form_validation->set_rules(
			'nama_pelanggan',
			'Nama Anda',
			'required',
			[
				'required' => 'Nama Anda Belum diisi!!'
			]
		);

		$this->form_validation->set_rules(
			'no_hp',
			'No Hp',
			'required',
			[
				'required' => 'No Hp Belum diis!!'
			]
		);

		$this->form_validation->set_rules(
			'jml_beli',
			'Jumlah Beli',
			'required',
			[
				'required' => 'Jumlah Beli Wajib diis!!'
			]
		);

		$this->form_validation->set_rules(
			'kode_pos',
			'Kode Pos',
			'required',
			[
				'required' => 'Kode Pos Wajib diis!!'
			]
		);

		$this->form_validation->set_rules(
			'alamat',
			'Alamat',
			'required',
			[
				'required' => 'Alamat Belum Diisi!!'
			]
		);

		$this->form_validation->set_rules(
			'catatan',
			'Catatan',
			'required',
			[
				'required' => 'Tinggalkan Catatan Pengiriman!!'
			]
		);


		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar');
			$this->load->view('web/transaksi');
			$this->load->view('templates/footer');
		} else {

			$this->ModelTransaksi->pesanan();

			$date_input = date("d-m-Y");

			$jumlah_beli = $this->input->post('jml_beli');
			$harga = $this->input->post('harga');

			$hitungs = $harga * $jumlah_beli;

			// Ini Untuk Tampilan OutputNya khusus DI website..
			$data = [
				'nama_pelanggan' => $this->input->post('nama_pelanggan'),
				'no_hp' => $this->input->post('no_hp'),
				'kode_pos' => $this->input->post('kode_pos'),
				'alamat' => $this->input->post('alamat'),
				'jumlah_beli' => $jumlah_beli,
				'harga' => $harga,
				'catatan' => $this->input->post('catatan'),
				'tgl_beli' => $date_input,
				'total_bayar' => $hitungs,
			];

			$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
			$data['motor'] = $this->modelMotor->getMotorWhere(['Kd_kendaraan' => $this->uri->segment(3)])->row_array();
			$data['judul'] = "output";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('web/output', $data);
			$this->load->view('templates/footer');
		}
	}


	// public function output()
	// {
	// 	$data['judul'] = "output";
	// 	$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
	// 	$this->load->view('templates/ header ', $data);
	// 	$this->load->view('templates/topbar');
	// 	$this->load->view('web / output ');
	// 	$this->load->view('templates / footer ');
	// }





	public function about()
	{
		$data['judul'] = "About";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar',);
		$this->load->view('web/about');
		$this->load->view('templates/footer');
	}

	public function contact()
	{
		$data['judul'] = "contact";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('web/contact');
		$this->load->view('templates/footer');
	}

	public function service()
	{
		$data['judul'] = "service";
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('web/service');
		$this->load->view('templates/footer');
	}
}
