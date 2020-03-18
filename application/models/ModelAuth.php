<?php
    class ModelAuth extends CI_model
	{
		function __construct()
		{
			parent::__construct();
		}

       function cekLogin($email,$pass)
        {
			   $this->db->select('*');
				$this->db->from('admin');
				$this->db->where('email', $email);
				$this->db->where('password', ($pass));
				$this->db->limit(1);

				//get query and processing
				$query = $this->db->get();
				if($query->num_rows() == 1) {
					return $query->result(); //if data is true
				} else {
					return false; //if data is wrong
				}
		}  		
		function cekUser($email,$pass)
        {
			   $this->db->select('*');
				$this->db->from('user');
				$this->db->where('email', $email);
				$this->db->where('password', ($pass));
				$this->db->limit(1);

				//get query and processing
				$query = $this->db->get();
				if($query->num_rows() == 1) {
					return $query->result(); //if data is true
				} else {
					return false; //if data is wrong
				}
		}  		
}

?>