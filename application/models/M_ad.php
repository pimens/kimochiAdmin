<?php
class M_ad extends CI_model
{
	function __construct()
	{
		parent::__construct();
	}
	function getAllData()
	{
		return $this->db->query("select * from makanan")->result();
	}			
	function getAllUser()
	{
		return $this->db->query("select * from user")->result();
	}	
	//makanan		
	function insertMakanan($data)
	{
		$j = $data['judul'];
		$t = $data['thumb'];
		$cat = $data['cat'];
		$desk = $data['desk'];
		$h= $data['h'];
		return $this->db->query("insert into makanan values ('','$j','$h','$t','$desk',$cat,0)");
	}	
	function editMakanan($data)
	{
		$j = $data['judul'];
		$t = $data['thumb'];
		$cat = $data['cat'];
		$id = $data['id'];
		$desk = $data['desk'];
		$h= $data['h'];
		if($t==""){
			return $this->db->query("update makanan set nama='$j', kategori=$cat, deskripsi='$desk',harga='$h' where id=$id");
		}else{
			return $this->db->query("update makanan set gambar='$t',nama='$j', kategori=$cat, deskripsi='$desk',harga='$h' where id=$id");
		}
	}	
	public function deleteMakanan($id)
	{
		return $this->db->query("delete from makanan where id=$id");		
	}
	public function getMakananById($id)
	{
		return $this->db->query("select * from makanan where id=$id")->result();		
	}
	//end maknan



	//api
	function insertInvoice($hp,$n,$m,$j,$trx,$st,$cab,$alamat)
	{
		// $alamat = "xxx";
		$d=$this->db->query("select * from user where nomorhp=$hp")->row();
		if($d){
			$t = date("Y-m-d");
			$this->db->query("insert into trx values('',$d->id,$m,$cab,$j,$st,now(),$trx,'$alamat',0)");			
		}else{
			$this->db->query("insert into user values('','$n','$hp')");
			$d=$this->db->query("select * from user where nomorhp=$hp")->row();			
			$t = date("Y-m-d");
			$this->db->query("insert into trx values('',$d->id,$m,$cab,$j,$st,now(),$trx,'$alamat',0)");
			// echo "insert into trx values('',$d->id,$m,$cab,$j,$st,now(),$trx,'$alamat',0)";
		}	
		// echo "insert into trx values('',$d->id,$m,$cab,$j,$st,now(),$trx,'$alamat',0)";

	}
	public function getMaxTrx()
	{
		return $this->db->query("select max(notrx) as x from trx")->result();		
	}
	public function getJumlahOrder()
	{
		$today = date("Y-m-d");   
		return $this->db->query("select count(*) as jo from (SELECT DISTINCT notrx FROM `trx` where tanggal='$today') as d")->row();		
	}
	public function getJumlahOrderBulanan()
	{
		$today = date("Y-m-d");   
		return $this->db->query("select count(*) as jo from (SELECT DISTINCT notrx,month(tanggal) as tgl FROM `trx`) as d where d.tgl=month(now())")->row();		
	}
	public function getPemasukan()
	{
		$today = date("Y-m-d");   
		return $this->db->query("select sum(subtotal) as total from trx where tanggal='$today'")->row();		
	}
	public function getPemasukanMonth()
	{
		$d = $this->db->query("select sum(subtotal) as total from (select month(tanggal) as t, subtotal from trx) as d where d.t=month(now()) GROUP by d.t")->row();
		if(!$d){
			$d=0;
		}else{
			$d=$d->total;
		}
		return $d;		
	}
	public function jumlahPelanggan()
	{
		$today = date("Y-m-d");   
		return $this->db->query("select count(*) as j from user")->result();		
	}
	public function daftarOrder()
	{		
		return $this->db->query("SELECT notrx,tanggal,user.nama as p,makanan.nama as m,jumlah,subtotal from makanan,trx,user
		WHERE
		id_makanan=makanan.id and user.id=id_user  
		ORDER BY `trx`.`notrx`  desc")->result();		
	}


	//promo
	function insertPromo($data)
	{
		$j = $data['judul'];
		$t = $data['thumb'];
		$desk = $data['desk'];
		return $this->db->query("insert into promo values ('','$j','$desk','$t')");
	}
	function getPromo()
	{
		return $this->db->query("select * from promo")->result();
	}		
	function getPromoById($id)
	{
		return $this->db->query("select * from promo where id=$id")->result();
	}	
	function editPromo($data)
	{
		$j = $data['judul'];
		$t = $data['thumb'];
		$id = $data['id'];
		$desk = $data['desk'];
		if($t==""){
			return $this->db->query("update promo set judul='$j',deskripsi='$desk' where id=$id");
		}else{
			return $this->db->query("update promo set gambar='$t',judul='$j', deskripsi='$desk' where id=$id");
		}
	}	
	public function deletePromo($id)
	{
		return $this->db->query("delete from promo where id=$id");		
	}
	//==end promo
	function getCabang()
	{
		return $this->db->query("select * from cabang")->result();
	}	
	function getTrx($hp)
	{
		return $this->db->query("select trx.alamat as alamat,tanggal, cabang.nama, sum(subtotal) as total, notrx,status from trx, cabang where id_user=(select id from user where nomorhp='$hp') and cabang.id=trx.id_cabang group by notrx")->result();
	}	
	function getTrxById($notrx)
	{
		return $this->db->query("select status,user.nama as user,nomorhp, makanan.gambar as gambar, makanan.nama as nama, trx.jumlah as jumlah, subtotal from trx, makanan,user where user.id=trx.id_user and makanan.id = trx.id_makanan and notrx=$notrx")->result();
	}
	function getCabangOrder()
	{
		return $this->db->query("select cabang.id,COALESCE(jumlah, 0) as jumlah,cabang.nama,cabang.alamat from cabang left join (select count(status) as jumlah,nama, id from (SELECT cabang.alamat as alamat, cabang.id as id, cabang.nama as nama,status from cabang, trx where cabang.id=trx.id_cabang and status<>1 GROUP by notrx) as d group by d.id) as x on cabang.id=x.id")->result();
	}
	function getTrxByCabang($idCabang)
	{
		return $this->db->query("select user.nama as user, tanggal, cabang.nama, sum(subtotal) as total, notrx,trx.alamat,status from trx, cabang,user where trx.id_user=user.id and id_cabang=$idCabang and cabang.id=trx.id_cabang group by notrx order by status asc")->result();
	}
	function finish($notrx,$status)
	{
		return $this->db->query("update trx set status=$status where notrx=$notrx")->result();
	}
	function deleteTrx($notrx)
	{
		return $this->db->query("delete from trx where notrx=$notrx");
	}
	function getNewTrx()
	{
		return $this->db->query("select count(*) as jumlah from (select * from trx where status=0 group by notrx) as data");
	}
}