<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Auth extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('ModelAuth');
		}
		public function index()
		{			
			
			$data['tit']='Loginn';
			$this->load->view('tambahan/v_head',$data);
			$this->load->view('login');
			$this->load->view('tambahan/jss');
			
			
		}	
		public function indexUser()
		{			
			
			$data['tit']='Loginn';
			$this->load->view('tambahan/v_head',$data);
			$this->load->view('user/login');
			$this->load->view('tambahan/jss');
			
			
		}	
		//admin
		public function login()
		{
			$nama = $this->input->post('nama');
			$pass = $this->input->post('pass');
			// $pass = md5($pass);
			$result = $this->ModelAuth->cekLogin($nama, $pass);
			if($result) {
				$sess_array = array();
				foreach($result as $row) {
					//create the session
					$sess_array = array(
						'nama' => $row->username,
						'email' => $row->email,
						'login_status' => true,
						
					);
					//github				
			
					$this->session->set_userdata($sess_array);	
					$this->session->set_flashdata('msg', '<div id="success-alert" class="alert alert-success alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                 <center>Selamat Datang !</center>
	              </div>');					
					redirect('Ad','refresh');
				}
				
			}		
			if(!$result)
			{
				$this->session->set_flashdata('notif','password salah');
				redirect('Auth','refresh');
			}
			
		}
	
		function logout() {		
				$this->session->unset_userdata('acc');
				$this->session->unset_userdata('login_status');				
				$this->session->set_flashdata('notif','berhasil logout');
				redirect('Auth'); // bisa langsung pake ke CDaftarUser cuman bisa juga ke CUser tapi tetep di direc ke CDaftarUser karena loginstatus false atau unset
		}
		//user

		public function loginUser()
		{
			$nama = $this->input->post('nama');
			$pass = $this->input->post('pass');
			$pass = md5($pass);
			$result = $this->ModelAuth->cekUser($nama, $pass);
			if($result) {
				$sess_array = array();
				foreach($result as $row) {
					//create the session
					$sess_array = array(
						'nama' => $row->username,
						'email' => $row->email,
						'id' => $row->id,

						'login_status' => true,
						
					);
					//github
					$this->session->set_userdata($sess_array);	
					$this->session->set_flashdata('msg', '<div id="success-alert" class="alert alert-success alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                 <center>Selamat Datang !</center>
	              </div>');					
					redirect('User','refresh');
				}
				
			}		
			if(!$result)
			{
				$this->session->set_flashdata('notif','password salah');
				redirect('Auth/indexUser','refresh');
			}
			
		}
	
		function logoutUser() {		
				$this->session->unset_userdata('acc');
				$this->session->unset_userdata('login_status');				
				$this->session->set_flashdata('notif','berhasil logout');
				redirect('Auth/indexUser'); // bisa langsung pake ke CDaftarUser cuman bisa juga ke CUser tapi tetep di direc ke CDaftarUser karena loginstatus false atau unset
		}
		
		
	}


?>