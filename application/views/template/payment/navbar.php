  <!-- ========== HEADER ========== -->
  <header id="header"
  	class="navbar navbar-expand-lg navbar-end navbar-absolute-top <?= isset($navbar_style) ? $navbar_style : 'navbar-light';?>"
  	data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'>
  	<!-- Topbar -->
  	<div class="container navbar-topbar">
  		<nav class="js-mega-menu navbar-nav-wrap">
  			<!-- Toggler -->
  			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNavDropdown"
  				aria-controls="topbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  				<span class="d-flex justify-content-between align-items-center">
  					<span class="text-dark">Topbar</span>

  					<span class="navbar-toggler-default">
  						<i class="bi-list ms-2"></i>
  					</span>
  					<span class="navbar-toggler-toggled">
  						<i class="bi-x ms-2"></i>
  					</span>
  				</span>
  			</button>
  			<!-- End Toggler -->

  			<div id="topbarNavDropdown" class="navbar-nav-wrap-collapse collapse navbar-collapse">
  				<ul class="navbar-nav">
  					<!-- Demos -->
  					<li class="nav-item">
  						<a class="nav-link fs-15 <?= $this->uri->segment(1) == 'faq' ? 'active' : '';?>"
  							aria-current="page" href="<?= site_url('faq');?>" role="button">FAQ</a>
  					</li>
  					<!-- End Demos -->
  					<!-- Demos -->
  					<li class="nav-item">
  						<a class="nav-link fs-15 <?= $this->uri->segment(1) == 'help-center' ? 'active' : '';?>"
  							aria-current="page" href="<?= site_url('help-center');?>" role="button">Help Center</a>
  					</li>
  					<li class="nav-item">
  						<a class="nav-link fs-15 <?= $this->uri->segment(1) == 'eligible-countries' ? 'active' : '';?>"
  							aria-current="page" href="<?= site_url('eligible-countries');?>" role="button">Eligible
  							Countries</a>
  					</li>
  					<?php if($this->session->userdata('logged_in') || $this->session->userdata('logged_in') == true):?>
  					<!-- End Demos -->
  					<li class="hs-has-sub-menu nav-item fs-15"
  						data-hs-mega-menu-item-options='{"desktop": { "maxWidth": "20rem"}}'>
  						<a id="docsMegaMenu"
  							class="hs-mega-menu-invoker nav-link dropdown-toggle <?= $this->uri->segment(1) == 'user' ? 'active' : '';?>"
  							href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account</a>

  						<!-- Mega Menu -->
  						<div class="hs-sub-menu hs-position-right dropdown-menu" aria-labelledby="docsMegaMenu"
  							style="min-width: 14rem;">
  							<a class="dropdown-item <?= ($this->uri->segment(1) == 'user' && !$this->uri->segment(2)) || $this->uri->segment(2) == 'overview' ? 'active' : '';?>"
  								href="<?= site_url('user'); ?>"><i class="bi bi-person"></i> Your
  								profile</a>
  							<a class="dropdown-item <?= $this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'settings' ? 'active' : '';?>"
  								href="<?= site_url('user/settings'); ?>"><i class="bi bi-gear"></i> Settings</a>
  							<div class="dropdown-divider"></div>
  							<a class="dropdown-item " href="<?= site_url('sign-out'); ?>"><i
  									class="bi bi-box-arrow-right"></i> Sign out</a>
  						</div>
  						<!-- End Mega Menu -->
  					</li>
  					<?php endif;?>
  				</ul>
  			</div>
  		</nav>
  	</div>
  	<!-- End Topbar -->
  	<div class="container">
  		<nav class="js-mega-menu navbar-nav-wrap">
  			<!-- Default Logo -->
  			<a class="navbar-brand" href="<?= base_url();?>" aria-label="Front">
  				<img class="navbar-brand-logo"
  					src="<?= base_url(); ?><?= isset($logo_style) ? $web_logo_white : $web_logo;?>" alt="Logo">
  			</a>
  			<!-- End Default Logo -->

  			<!-- Toggler -->
  			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
  				aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  				<span class="navbar-toggler-default">
  					<i class="bi-list"></i>
  				</span>
  				<span class="navbar-toggler-toggled">
  					<i class="bi-x"></i>
  				</span>
  			</button>
  			<!-- End Toggler -->

  			<!-- Collapse -->
  			<div class="collapse navbar-collapse" id="navbarNavDropdown">
  				<div class="navbar-absolute-top-scroller">
  					<ul class="navbar-nav">

  						<!-- Beranda -->
  						<li class="nav-item">
  							<a class="nav-link <?= $this->uri->segment(1) == 'home' || !$this->uri->segment(1) ? 'active' : '';?>"
  								href="<?= base_url();?>">Home</a>
  						</li>
  						<!-- End Beranda -->

  						<!-- Beranda -->
  						<li class="nav-item">
  							<a class="nav-link <?= $this->uri->segment(1) == 'announcements' ? 'active' : '';?>"
  								href="<?= site_url('announcements');?>">Announcements</a>
  						</li>
  						<!-- End Beranda -->

  						<!-- Beranda -->
  						<li class="nav-item">
  							<a class="nav-link <?= $this->uri->segment(1) == 'about' ? 'active' : '';?>"
  								href="<?= site_url('about');?>">About MEYS</a>
  						</li>
  						<!-- End Beranda -->

  						<!-- Beranda -->
  						<li class="nav-item">
  							<a class="nav-link <?= $this->uri->segment(1) == 'partnership-sponshorship' ? 'active' : '';?>"
  								href="<?= site_url('partnership-sponshorship');?>">Partnership & Sponshorship</a>
  						</li>
  						<!-- End Beranda -->

  						<?php if($this->session->userdata('logged_in') == false || !$this->session->userdata('logged_in')):?>

  						<!-- Button -->
  						<li class="nav-item">
  							<a class="btn btn-sm <?= isset($btn_sign_up) ? $btn_sign_up : 'btn-primary';?> btn-transition"
  								href="<?= site_url('sign-up');?>">Sign
  								up</a>
  						</li>
  						<!-- End Button -->

  						<!-- Button -->
  						<li class="nav-item">
  							<a class="btn btn-sm <?= isset($btn_sign_in) ? $btn_sign_in : 'btn-outline-primary';?> btn-transition"
  								href="<?= site_url('sign-in');?>">Sign in</a>
  						</li>
  						<!-- End Button -->
  						<?php endif;?>
  					</ul>
  				</div>
  			</div>
  			<!-- End Collapse -->
  		</nav>
  	</div>
  </header>

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main" class="overflow-hidden">

  	<!-- Breadcrumb -->
  	<div class="navbar-dark bg-dark"
  		style="background-image: url(<?= base_url(); ?>assets/svg/components/wave-pattern-light.svg);">
  		<div class="container content-space-4 content-space-b-lg-3">
  			<div class="row align-items-center">
  				<div class="col">
  					<div class="d-none d-lg-block">
  						<h1 class="h2 text-white">Payment Transaction</h1>
  					</div>

  					<!-- Breadcrumb -->
  					<nav aria-label="breadcrumb">
  						<ol class="breadcrumb breadcrumb-light mb-0">
  							<li class="breadcrumb-item">Payment</li>
  							<li class="breadcrumb-item active" aria-current="page">
  								<?= !empty($this->uri->segment(2)) ? str_replace('-', ' ', $this->uri->segment(2)) : 'Overview'; ?>
  							</li>
  						</ol>
  					</nav>
  					<!-- End Breadcrumb -->
  				</div>
  				<!-- End Col -->

  				<div class="col-auto">
  					<!-- Responsive Toggle Button -->
  					<button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
  						data-bs-target="#sidebarNav" aria-controls="sidebarNav" aria-expanded="false"
  						aria-label="Toggle navigation">
  						<span class="navbar-toggler-default">
  							<i class="bi-list"></i>
  						</span>
  						<span class="navbar-toggler-toggled">
  							<i class="bi-x"></i>
  						</span>
  					</button>
  					<!-- End Responsive Toggle Button -->
  				</div>
  				<!-- End Col -->
  			</div>
  			<!-- End Row -->
  		</div>
  	</div>
  	<!-- End Breadcrumb -->

  	<!-- Content -->
  	<div class="container content-space-1 content-space-t-lg-0 content-space-b-lg-2 mt-lg-n10">
