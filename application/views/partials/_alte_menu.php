	<!-- =========================== MENU =========================== -->

	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- search form -->
			<!-- <form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</form> -->
			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">NAVIGASI</li>
				<li>
					<a href="<?php echo base_url('order/data_list') ?>">
						<i class="fa fa-home"></i> <span>Order LB</span>
					</a>
				</li>
				<?php if ($this->ion_auth->logged_in()): ?>
					<?php // Jika group CS
					if ($this->ion_auth->in_group('cs')) : ?>
						<li><a href="<?php echo base_url('order') ?>"><i class="fa fa-plus"></i> <span>Buat Order Baru</span></a></li>
						<li><a href="<?php echo base_url('order/history') ?>"><i class="fa fa-list-alt"></i> <span>Riwayat</span></a></li>
					<?php elseif ($this->ion_auth->in_group('toko')) : ?>
						<!-- <li><a href="<?php echo base_url('order/my_order') ?>"><i class="fa fa-list"></i> Order</a></li> -->
						<li><a href="<?php echo base_url('order/completed') ?>"><i class="fa fa-check"></i> <span>Order Selesai</span></a></li>
					<?php endif ?>
					<?php if ($this->ion_auth->is_admin()): ?>
						<!-- Menu Admin -->
						<li class="header">PENGATURAN</li>
						<li>
							<a href="<?php echo base_url('auth') ?>">
								<i class="fa fa-users"></i> <span>Pengguna / Toko</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('cabang') ?>">
								<i class="fa fa-globe"></i> <span>Cabang</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('regional') ?>">
								<i class="fa fa-map-marker"></i> <span>Regional</span>
							</a>
						</li>

					<?php endif ?>
					<li>
						<a href="<?php echo base_url('auth/logout') ?>" onclick="return confirm('Yakin keluar dari aplikasi Layanan Bantu?')">
							<i class="fa fa-sign-out"></i> <span>Logout</span>
						</a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo base_url('auth/login') ?>">
							<i class="fa fa-sign-in"></i> <span>Login</span>
						</a>
					</li>
				<?php endif ?>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- =========================== / MENU =========================== -->
