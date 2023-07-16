  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
  	<!-- Navbar -->
  	<nav class="js-nav-scroller navbar navbar-expand-lg navbar-sidebar navbar-vertical navbar-light bg-white border-end" data-hs-nav-scroller-options='{
            "type": "vertical",
            "target": ".navbar-nav .active",
            "offset": 80
           }'>
  		<!-- Navbar Toggle -->
  		<button type="button" class="navbar-toggler btn btn-white d-grid w-100" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
  			<span class="d-flex justify-content-between align-items-center">
  				<span class="h3 mb-0">Navigation bar</span>

  				<span class="navbar-toggler-default">
  					<i class="bi-list"></i>
  				</span>

  				<span class="navbar-toggler-toggled">
  					<i class="bi-x"></i>
  				</span>
  			</span>
  		</button>
  		<!-- End Navbar Toggle -->

  		<!-- Navbar Collapse -->
  		<div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
  			<div class="navbar-brand-wrapper border-end p-0" style="height: auto;">
  				<!-- Default Logo -->
  				<div class="d-flex justify-content-center align-items-center mb-0">
  					<a class="navbar-brand" href="<?= site_url('dashboard'); ?>" aria-label="Space">
  						<img class="navbar-brand-logo" src="<?= base_url(); ?><?= $web_logo; ?>" alt="Logo">
  					</a>
  					<a class="navbar-brand-badge">
  						<span class="badge bg-soft-primary text-primary ms-2">v1.0.5</span>
  					</a>
  				</div>
  				<!-- End Default Logo -->
  			</div>
  			<div class="ptc-9">
  				<div class="docs-navbar-sidebar-aside-body navbar-sidebar-aside-body">
  					<ul id="navbarSettings" class="navbar-nav nav nav-vertical nav-tabs nav-tabs-borderless nav-sm">
  						<li class="nav-item" id="tour-dashboard">
  							<a class="nav-link <?= ($this->uri->segment(2) == "dashboard" ? "active" : "") ?>" href="<?= site_url('admin/dashboard'); ?>"><i class="bi bi-window nav-icon"></i>
  								Dashboard</a>
  						</li>
  						<li class="nav-item" id="tour-statistik">
  							<a class="nav-link <?= ($this->uri->segment(2) == "statistik" ? "active" : "") ?>" href="<?= site_url('admin/statistik'); ?>"><i class="bi bi-activity nav-icon"></i>
  								Statistik</a>
  						</li>

  						<li class="nav-item my-2 my-lg-5"></li>

  						<li class="nav-item">
  							<span class="nav-subtitle">Transaksi</span>
  						</li>

  						<li class="nav-item" id="tour-transaksi">
  							<a class="nav-link <?= ($this->uri->segment(2) == "transaksi" ? "active" : "") ?>" href="<?= site_url('admin/transaksi'); ?>"><i class="bi bi-wallet2 nav-icon"></i>
  								Transaksi</a>
  						</li>

  						<li class="nav-item" id="tour-transaksi-referral">
  							<a class="nav-link <?= ($this->uri->segment(2) == "transaksi-referral" ? "active" : "") ?>" href="<?= site_url('admin/transaksi-referral'); ?>"><i class="bi bi-wallet nav-icon"></i>
  								Transaksi Referral</a>
  						</li>

  						<li class="nav-item my-2 my-lg-5"></li>

  						<li class="nav-item">
  							<span class="nav-subtitle">Member</span>
  						</li>
  						<li class="nav-item" id="tour-member">
  							<a class="nav-link <?= ($this->uri->segment(2) == "member" ? "active" : "") ?>" href="<?= site_url('admin/member'); ?>"><i class="bi bi-people nav-icon"></i>
  								Member</a>
  						</li>
  						<li class="nav-item" id="tour-vcc">
  							<a class="nav-link <?= ($this->uri->segment(2) == "vcc-member" ? "active" : "") ?>" href="<?= site_url('admin/vcc-member'); ?>"><i class="bi bi-credit-card nav-icon"></i>
  								VCC</a>
  						</li>
  						<!-- <li class="nav-item" id="tour-referral">
  							<a class="nav-link <?= ($this->uri->segment(2) == "referral" ? "active" : "") ?>" href="<?= site_url('admin/referral'); ?>"><i class="bi bi-command nav-icon"></i>
  								Referral</a>
  						</li> -->

  						<li class="nav-item my-2 my-lg-5"></li>

  						<li class="nav-item">
  							<span class="nav-subtitle">Master</span>
  						</li>
  						<li class="nav-item" id="tour-kategori">
  							<a class="nav-link <?= ($this->uri->segment(2) == "kategori" ? "active" : "") ?>" href="<?= site_url('master/kategori'); ?>"><i class="bi bi-tags nav-icon"></i>
  								Kategori</a>
  						</li>
  						<li class="nav-item" id="tour-faq">
  							<a class="nav-link <?= ($this->uri->segment(2) == "faq" ? "active" : "") ?>" href="<?= site_url('master/faq'); ?>"><i class="bi bi-question-square nav-icon"></i>
  								Faq</a>
  						</li>
  						<li class="nav-item" id="tour-produk">
  							<a class="nav-link <?= ($this->uri->segment(2) == "produk" ? "active" : "") ?>" href="<?= site_url('master/produk'); ?>"><i class="bi bi-box-seam nav-icon"></i>
  								Produk</a>
  						</li>
  						<li class="nav-item" id="tour-blockchain">
  							<a class="nav-link <?= ($this->uri->segment(2) == "blockchain" ? "active" : "") ?>" href="<?= site_url('master/blockchain'); ?>"><i class="bi bi-coin nav-icon"></i>
  								Blockchain</a>
  						</li>
  						<li class="nav-item" id="tour-promo">
  							<a class="nav-link <?= ($this->uri->segment(2) == "promo" ? "active" : "") ?>" href="<?= site_url('master/promo'); ?>"><i class="bi bi-file-earmark-break nav-icon"></i>
  								Promo</a>
  						</li>
  						<li class="nav-item" id="tour-metode-pembayaran">
  							<a class="nav-link <?= ($this->uri->segment(2) == "metode-pembayaran" ? "active" : "") ?>" href="<?= site_url('master/metode-pembayaran'); ?>"><i class="bi bi-credit-card-2-front nav-icon"></i>
  								Metode pembayaran</a>
  						</li>
  						<li class="nav-item" id="tour-metode-withdraw">
  							<a class="nav-link <?= ($this->uri->segment(2) == "metode-withdraw" ? "active" : "") ?>" href="<?= site_url('master/metode-withdraw'); ?>"><i class="bi bi-wallet nav-icon"></i>
  								Metode withdraw</a>
  						</li>

  						<li class="nav-item my-2 my-lg-5"></li>

  						<li class="nav-item">
  							<span class="nav-subtitle">Pengaturan</span>
  						</li>
  						<li class="nav-item" id="tour-website">
  							<a class="nav-link <?= ($this->uri->segment(2) == "pengaturan" ? "active" : "") ?>" href="<?= site_url('admin/pengaturan'); ?>"><i class="bi bi-sliders nav-icon"></i>
  								Website</a>
  						</li>
  					</ul>
  				</div>
  			</div>
  		</div>
  		<!-- End Navbar Collapse -->
  	</nav>
  	<!-- End Navbar -->
  	<!-- Content -->
  	<div class="navbar-sidebar-aside-content content-space-2 content-space-md-3 px-lg-5 px-xl-10">