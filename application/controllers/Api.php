<?php 
// if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header('Access-Control-Allow-Origin: *');
class Api extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ad');		
	}
	public function login()
	{
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');
		$result = $this->M_ad->getUserByEmail($data['email'], $data['password']);
		echo json_encode($result);
	}
	public function index()
	{

		$data['title'] = 'Beranda Adminnn';
		$d['course'] = $this->M_ad->getAllData();
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
	public function getMakanan()
	{
        $d = $this->M_ad->getAllData();
        echo json_encode($d);
	}	
	public function getMakananOffset($start,$offset)
	{
        $d = $this->M_ad->getMakananOffset($start,$offset);
        echo json_encode($d);
	}	
	public function getMaxTrx()
	{
        $d = $this->M_ad->getMaxTrx();
        echo json_encode($d);
	}	
	public function getJUser($hp)
	{
        $d = $this->M_ad->getJUser($hp);
        echo json_encode($d);
	}	
	public function getJumlahOrder()
	{
        $d = $this->M_ad->getJumlahOrder();
        echo json_encode($d);
	}	
	public function getPemasukan()
	{
        $d = $this->M_ad->getPemasukan();
        echo json_encode($d);
	}	
	public function jumlahPelanggan()
	{
        $d = $this->M_ad->jumlahPelanggan();
        echo json_encode($d);
	}	
	public function addMakanan()
	{
		$nama = $this->input->post('nama');
		echo $nama."ini tes";
	}
	public function insertInvoice()
	{
		$hp = $this->input->post('hp');
		$nama = $this->input->post('nama');
		$makanan = $this->input->post('mkn');
		$jumlah = $this->input->post('jmlh');
		$trx = $this->input->post('trx');
		$st = $this->input->post('st');
		$outlet = $this->input->post('cab');
		$address = $this->input->post('alamat');
		$dd = $this->M_ad->cekUser($hp);
		if($this->M_ad->cekUser($hp)){			 
			// echo$hp;
			$this->M_ad->insertInvoice($hp,$nama,$makanan,$jumlah,$trx,$st,$outlet,$address,true);
		}else{
			// echo $dd->id;
			$this->M_ad->insertUser($nama,$hp);			
			$this->M_ad->insertInvoice($hp,$nama,$makanan,$jumlah,$trx,$st,$outlet,$address,false);
			// $this->M_ad->del($dd->id,$hp);			
		}		
	}
	public function insertCabang()
	{
		$alamat = $this->input->post('alamat');
		$nama = $this->input->post('nama');
		$this->M_ad->insertCabangX($nama,$alamat);
	}

	
	///-=======================================
	public function insertUser($n,$hp)
	{
		$this->M_ad->insertUser($n,$hp);
	}
	public function promo()
	{
        $d = $this->M_ad->getPromo();
        echo json_encode($d);
	}	
	public function getCabang()
	{
        $d = $this->M_ad->getCabang();
        echo json_encode($d);
	}	
	public function getTrx($hp)
	{
        $d = $this->M_ad->getTrx($hp);
        echo json_encode($d);
	}	
	public function getTrxById($notrx)
	{
        $d = $this->M_ad->getTrxById($notrx);
        echo json_encode($d);
	}	
	public function getCabangOrder()
	{
        $d = $this->M_ad->getCabangOrder();
        echo json_encode($d);
	}	
	public function getTrxByCabang($id)
	{
        $d = $this->M_ad->getTrxByCabang($id);
        echo json_encode($d);
	}	
	public function finish($notrx,$status)
	{
        $d = $this->M_ad->finish($notrx,$status);
        echo json_encode($d);
	}	
	public function deleteTrx($notrx)
	{
        $d = $this->M_ad->deleteTrx($notrx);
        echo json_encode($d);
	}	
	public function getNewTrx()
	{
        $d = $this->M_ad->getNewTrx()->row();
        echo $d->jumlah;
	}	

}
