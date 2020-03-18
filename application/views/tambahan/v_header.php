<!-- Header starts -->
		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3">
					  <!-- Logo. Use class "color" to add color to the text. -->
					  <div class="logo">
						<h1><a href="<?php echo base_url(); ?>">CoE<span class="color bold">CLEAR</span></a></h1>
						<p class="meta">something goes in meta area</p>
					  </div>
					</div>
					<div class="col-md-9 col-sm-9">
						<!-- Navigation -->
						<div class="navbar bs-docs-nav" role="banner">	
							<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
							<ul class="nav navbar-nav">
								  <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
								  <li><a href="<?php echo base_url(); ?>">Profil</a></li>
								  <li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Kegiatan <b class="caret"></b></a>
									<ul class="dropdown-menu">										
									   <li>
									   <a href="<?php echo base_url();?>coe/kegiatan/fgd">FGD</a>									  
									   </li>
									   <li><a href="<?php echo base_url();?>coe/kegiatan/workshop">Workshop</a></li>
									   <li><a href="<?php echo base_url();?>coe/kegiatan/Pelatihan">Pelatihan</a></li>
									   <li><a href="<?php echo base_url();?>coe/kegiatan/cross">Cross-Visit</a></li>
									   <li><a href="<?php echo base_url();?>coe/kegiatan/kerjasama">Kerja Sama</a></li>
									</ul>
								  </li>
								   <li class="dropdown">
										<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Staff <span class="caret"></span></a>
										<ul class="dropdown-menu">
										<?php
											$u = base_url();
											foreach($jenisStaff as $js)
											{
												if($js->keterangan != 'staff ahli')
												{
													echo"<li><a href='".$u."coe/staff/$js->keterangan/$js->bidang'>$js->keterangan</a></li>";
												}
												else
												{
													echo"<li class='dropdown-submenu'>
															<a href=''>Tenaga Ahli</a>
															<ul class='dropdown-menu'>";
																foreach($jenisStaffAhli as $jsa)
																{
																	echo"<li><a href='".$u."coe/staff/$jsa->keterangan/$jsa->bidang'>$jsa->bidang</a></li>";
																}											
															echo"</ul>
														</li>
													";
												}
											}
										?>
										</ul>
									</li>
								  <li class="dropdown">
									 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Product <b class="caret"></b></a>
									 <ul class="dropdown-menu">
									   <li><a href="<?php echo base_url();?>coe/produk/dokumen">Document Reviewed</a></li>
									   <li><a href="<?php echo base_url();?>coe/produk/best">Best Practices</a></li>
									   <li><a href="<?php echo base_url();?>coe/produk/policy">Policy Brief</a></li>
									   <li><a href="<?php echo base_url();?>coe/produk/technical">Technical Reviewed</a></li>
									   <li><a href="<?php echo base_url();?>coe/produk/training">Training Modul</a></li>
									   <li><a href="<?php echo $u."coe/produk/buku"; ?>">Buku</a></li>
									   <li><a href="<?php echo base_url();?>coe/produk/artikel">Artikel Ilmiah</a></li>								
									 </ul>
								  </li>                   
								    <li class="dropdown">
									 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <b class="caret"></b></a>
									 <ul class="dropdown-menu">
									   <li><a href="<?php echo $u."coe/training"; ?>">Training</a></li>
									   <li><a href="<?php echo $u."coe/konsultasi"; ?>">Konsultasi</a></li>									  
									 </ul>
								  </li>     
								  <li><a href="<?php echo base_url(); ?>coe/kontak">Kontak</a></li>
								 
								  
								</ul>
							</nav><!--/ navbar nav end -->
						</div>
						<!--/ Navigation end -->
					</div>
				</div>
			</div>
		</header>
		<!-- Seperator -->
		<div class="sep"></div>