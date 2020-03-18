<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ad extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ad');
		if ($this->session->userdata('login_status') != TRUE) {
			redirect('Auth');
		}
	}
	public function index()
	{

		$data['title'] = 'Beranda Adminnn';
		$d['course'] = $this->M_ad->getAllData();
		$d['pemasukan'] = $this->M_ad->getPemasukan();
		$d['pemasukanBulanan'] = $this->M_ad->getPemasukanMonth();
		$d['order'] = $this->M_ad->getJumlahOrder();
		$d['orderBulanan'] = $this->M_ad->getJumlahOrderBulanan();


		$this->load->view('admin/v_head', $data);
		$this->load->view('admin/v_sidebar', $d);
		$this->load->view('admin/v_dash');
	}
	
	public function getMakananById($id)
	{
		$data['title'] = 'Edit Makanan';
		$d['course'] = $this->M_ad->getMakananById($id);
		$this->load->view('admin/v_head', $data);
		$this->load->view('admin/v_sidebar', $d);
		$this->load->view('admin/v_editMakanan');
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
		if (!empty($_FILES["thumb"]["name"])) {
			echo "ada";
		} else {
			echo "tidak ";
		}
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload("thumb")) {
			echo json_encode(array("status" => FALSE));
		} else {
			$up = $this->upload->data();
			$v = $up['file_name'];
			$data['thumb'] = "data/thumb/" . $v;
			$this->M_ad->insertMakanan($data);
			redirect('Ad/');
			//  echo json_encode(array("status" => TRUE));				   
		}
	}

	public function deleteMakanan($id)
	{
		$this->M_ad->deleteMakanan($id);
		echo json_encode(array("status" => TRUE));
	}
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

		$l = count($q)-1;
		for ($j = 0; $j < count($q)-1; $j++) {
			$data[++$i] = array($in, $q[$j]->tanggal, $q[$j]->p, $q[$j]->m, $q[$j]->jumlah, $q[$j]->subtotal);			
			$in++;
			$t = $t + $q[$j]->subtotal;
			$total = $total + $q[$j]->subtotal;
			if ($q[$j+1]->notrx == $q[$j]->notrx) {				
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
		echo array_to_csv($data,'InvoiceLengkap.csv');                  
		die();
	}

	public function editMakanan()
	{
		$data['judul'] = $this->input->post('judul');
		$data['cat'] = $this->input->post('category');
		$data['desk'] = $this->input->post('desk');
		$data['id'] = $this->input->post('id');
		$data['h'] = $this->input->post('harga');

		if (!empty($_FILES["thumb"]["name"])) {
			$config['upload_path']    = "./data/thumb/";
			$config['allowed_types']  = 'jpg';
			$config['max_size']       = '200000';
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload("thumb")) {
				echo json_encode(array("status" => FALSE));
			} else {
				$up = $this->upload->data();
				$v = $up['file_name'];
				$data['thumb'] = "data/thumb/" . $v;
				$this->M_ad->editMakanan($data);
				redirect('Ad/');
				//  echo json_encode(array("status" => TRUE));				   
			}
		} else {
			$data['thumb'] = "";
			$this->M_ad->editMakanan($data);
			redirect('Ad/');
		}
	}
	//promoooo

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
			redirect('Ad/promo');
			//  echo json_encode(array("status" => TRUE));				   
		}
	}
	public function promo()
	{

		$data['title'] = 'Promo Adminnn';
		$d['course'] = $this->M_ad->getPromo();

		$this->load->view('admin/v_head', $data);
		$this->load->view('admin/v_sidebar', $d);
		$this->load->view('admin/v_promo');
	}	
	public function getPromoById($id)
	{
		$data['title'] = 'Edit Makanan';
		$d['promo'] = $this->M_ad->getPromoById($id);
		$this->load->view('admin/v_head', $data);
		$this->load->view('admin/v_sidebar', $d);
		$this->load->view('admin/v_editPromo');
	}
	public function editPromo()
	{
		$data['judul'] = $this->input->post('judul');
		$data['desk'] = $this->input->post('desk');
		$data['id'] = $this->input->post('id');
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
				redirect('Ad/promo');
				//  echo json_encode(array("status" => TRUE));				   
			}
		} else {
			$data['thumb'] = "";
			$this->M_ad->editPromo($data);
			redirect('Ad/promo');
		}
	}
	public function deletePromo($id)
	{
		$this->M_ad->deletePromo($id);
		echo json_encode(array("status" => TRUE));
	}
}
