<?php
// if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header('Access-Control-Allow-Origin: *');
class WebApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelWeb');
		$this->load->model('M_ad');
	}
	//auth
	public function login()
	{
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');
		$result = $this->ModelWeb->getUserByEmail($data['email'], $data['password']);
		echo json_encode($result);
	}
	//makanan
	public function getMakanan()
	{
		$d = $this->ModelWeb->getAllData();
		echo json_encode($d);
	}
	public function deleteMakanan($id)
	{
		$this->ModelWeb->deleteMakanan($id);
		echo json_encode(array("status" => TRUE));
	}
	public function insertMakanan()
	{
		$data['judul'] = $this->input->post('judul');
		$data['cat'] = $this->input->post('category');
		$data['desk'] = $this->input->post('desk');
		$data['h'] = $this->input->post('harga');

		$config['upload_path']    = "./data/thumb/";
		$config['allowed_types']  = 'jpg';
		$config['max_size']       = '200000';
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload("thumb")) {
			echo json_encode(array("status" => FALSE));
		} else {
			$up = $this->upload->data();
			$v = $up['file_name'];
			$data['thumb'] = "data/thumb/" . $v;
			$this->M_ad->insertMakanan($data);
		}
	}
	public function getMakananById($id)
	{
		$d = $this->M_ad->getMakananById($id);
		echo json_encode($d);
	}
	public function editMakanan()
	{
		$data['judul'] = $this->input->post('judul');
		$data['cat'] = $this->input->post('category');
		$data['desk'] = $this->input->post('desk');
		$data['id'] = $this->input->post('id');
		$data['h'] = $this->input->post('harga');
		$th = $this->input->post('image');
		if ($th == "kosong") {
			echo "ksg";
			$data['thumb'] = "";
			$this->M_ad->editMakanan($data);
		} else {
			if (!empty($_FILES["thumb"]["name"])) {
				$config['upload_path']    = "./data/thumb/";
				$config['allowed_types']  = 'jpg';
				$config['max_size']       = '200000';
				$config['encrypt_name'] = TRUE;
				echo "adaa";
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload("thumb")) {
					echo json_encode(array("status" => FALSE));
				} else {
					$up = $this->upload->data();
					$v = $up['file_name'];
					$data['thumb'] = "data/thumb/" . $v;
					$this->M_ad->editMakanan($data);
					//  echo json_encode(array("status" => TRUE));				   
				}
			}
		}
	}

	//report
	public function daftarPelanggan()
	{
		$this->load->library('csvimport'); //meload library csvimport.php
		$data = array();
		$header = array();
		$i = 2;
		$in = 1;
		$data[1] = array('No.', 'Nama', 'Telepon');
		$data[2] = array('');
		$header[1] = array('');
		$header[2] = array('', '', '');
		$header[3] = array('', '', '');
		$header[4] = array('', '', '');
		$this->load->helper('csv');
		$q = $this->M_ad->getAllUser();
		foreach ($q as $row) {
			$data[++$i] = array($in, $row->nama, $row->nomorhp);
			$in++;
		}
		echo array_to_csv($header);
		echo array_to_csv($data, 'Pelanggan.csv');
		die();
	}
	public function daftarOrder()
	{
		$this->load->library('csvimport'); //meload library csvimport.php
		$data = array();
		$header = array();
		$i = 2;
		$in = 1;
		$data[1] = array('No.', 'Tanggal', 'Nama Pelanggan', 'Nama Makanan', 'JumlahOrder', 'SubTotal');
		$data[2] = array('');
		$header[1] = array('');
		$header[2] = array('', '', '');
		$header[3] = array('', '', '');
		$header[4] = array('', '', '');
		$this->load->helper('csv');
		$q = $this->M_ad->daftarOrder();
		$t = 0;
		$total = 0;

		$l = count($q) - 1;
		for ($j = 0; $j < count($q) - 1; $j++) {
			$data[++$i] = array($in, $q[$j]->tanggal, $q[$j]->p, $q[$j]->m, $q[$j]->jumlah, $q[$j]->subtotal);
			$in++;
			$t = $t + $q[$j]->subtotal;
			$total = $total + $q[$j]->subtotal;
			if ($q[$j + 1]->notrx == $q[$j]->notrx) {
			} else {
				$data[++$i] = array('', ' ', ' ', ' ', ' ', $t);
				$t = 0;
			}
		}
		$data[++$i] = array($in, $q[$l]->tanggal, $q[$l]->p, $q[$l]->m, $q[$l]->jumlah, $q[$l]->subtotal);
		$in++;
		$data[++$i] = array('', ' ', ' ', ' ', 'Total Pemasukan ', $total);

		// foreach ($q as $row) {     
		// 	$data[++$i] = array($in,$row->tanggal,$row->p,$row->m,$row->jumlah,$row->subtotal);
		// 	$in++;			
		// 	if($tmp==$row->notrx){
		// 		$t=$t+$row->subtotal;
		// 	}else{
		// 		$data[++$i] = array($in,' ',' ',' ',' ',$t);
		// 		$in++;	
		// 		$t=0;
		// 	}
		// 	$tmp = $row->notrx;	
		// } 
		echo array_to_csv($header);
		echo array_to_csv($data, 'InvoiceLengkap.csv');
		die();
	}

	//dashboard
	public function pemasukan()
	{
		$harian = $this->ModelWeb->getPemasukan();
		$bulanan = $this->ModelWeb->getPemasukanMonth();
		$orderH = $this->ModelWeb->getJumlahOrder();
		$orderB = $this->ModelWeb->getJumlahOrderBulanan();
		// echo $d;
		echo json_encode(array(
			"status" => $bulanan, "harian" => $harian,
			"oh" => $orderH, "ob" => $orderB,
		));
	}


	//promo
	public function promo()
	{
		$d = $this->ModelWeb->getPromo();
		echo json_encode($d);
	}
	public function insertPromo()
	{
		$data['judul'] = $this->input->post('judul');
		$data['desk'] = $this->input->post('desk');
		$config['upload_path']    = "./data/promo/";
		$config['allowed_types']  = 'jpg';
		$config['max_size']       = '200000';
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload("thumb")) {
			echo json_encode(array("status" => FALSE));
		} else {
			$up = $this->upload->data();
			$v = $up['file_name'];
			$data['thumb'] = "data/promo/" . $v;
			$this->M_ad->insertPromo($data);
			echo json_encode(array("status" => TRUE));
		}
	}
	public function getPromoById($id)
	{
		$d = $this->M_ad->getPromoById($id);
		echo json_encode($d);
	}
	public function editPromo()
	{
		$data['judul'] = $this->input->post('judul');
		$data['desk'] = $this->input->post('desk');
		$data['id'] = $this->input->post('id');
		$th = $this->input->post('image');
		if ($th == "kosong") {
			echo "ksg";
			$data['thumb'] = "";
			$this->M_ad->editPromo($data);
		} else {
			if (!empty($_FILES["thumb"]["name"])) {
				$config['upload_path']    = "./data/promo/";
				$config['allowed_types']  = 'jpg';
				$config['max_size']       = '200000';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload("thumb")) {
					echo json_encode(array("status" => FALSE));
				} else {
					$up = $this->upload->data();
					$v = $up['file_name'];
					$data['thumb'] = "data/promo/" . $v;
					$this->M_ad->editPromo($data);
					//  echo json_encode(array("status" => TRUE));				   
				}
			}
		}
	}
	public function deletePromo($id)
	{
		$this->M_ad->deletePromo($id);
		echo json_encode(array("status" => TRUE));
	}

	public function getCabang()
	{
		$d = $this->ModelWeb->getCabang();
		echo json_encode($d);
	}
	public function getTrx($hp)
	{
		$d = $this->ModelWeb->getTrx($hp);
		echo json_encode($d);
	}
	public function getTrxById($notrx)
	{
		$d = $this->ModelWeb->getTrxById($notrx);
		echo json_encode($d);
	}
	public function getCabangOrder()
	{
		$d = $this->ModelWeb->getCabangOrder();
		echo json_encode($d);
	}
	public function getTrxByCabang($id)
	{
		$d = $this->ModelWeb->getTrxByCabang($id);
		echo json_encode($d);
	}
	public function finish($notrx, $status)
	{
		$d = $this->ModelWeb->finish($notrx, $status);
		echo json_encode($d);
	}
	public function deleteTrx($notrx)
	{
		$d = $this->ModelWeb->deleteTrx($notrx);
		echo json_encode($d);
	}
	public function getNewTrx()
	{
		$d = $this->ModelWeb->getNewTrx()->row();
		echo $d->jumlah;
	}
}
