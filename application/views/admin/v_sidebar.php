

 <nav class="navbar-default navbar-static-side" role="navigation"><?php $u=base_url(); ?>
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" width='50px' height='50px' class="img-circle" src="<?php echo base_url(); ?>data/foto/2.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->session->userdata('nama'); ?> </strong>     
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="active">
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?php echo"$u" ?>ad">Daftar Menu</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo"$u" ?>ad/promo"><i class="fa fa-diamond"></i> <span class="nav-label">Promo</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="graph_flot.html">Flot Charts</a></li>
                        <li><a href="graph_morris.html">Morris.js Charts</a></li>
                        <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                        <li><a href="graph_chartjs.html">Chart.js</a></li>
                        <li><a href="graph_chartist.html">Chartist</a></li>
                        <li><a href="graph_peity.html">Peity Charts</a></li>
                        <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                    </ul>
                </li>
          
            </ul>

        </div>
    </nav>
	
	
	<div class="row border-bottom">
				<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>            
					</div>
						<ul class="nav navbar-top-links navbar-right">    
							<li>
								<a href="<?php echo base_url();?>Auth/logout">
									<i class="fa fa-sign-out"></i> Log out
								</a>
							</li>
							<li>
								<a class="right-sidebar-toggle">
									<i class="fa fa-tasks"></i>
								</a>
							</li>
						</ul>
				</nav>
			</div><!--row border-->