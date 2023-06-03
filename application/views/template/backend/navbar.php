  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand navbar-fixed navbar-end navbar-light navbar-sticky-lg-top bg-transparant">
  	<div class="container-fluid">
  		<nav class="navbar-nav-wrap">
  			<div class="row flex-grow-1">
  				<!-- Default Logo -->
  				<div class="docs-navbar-sidebar-container d-flex justify-content-center align-items-center mb-0 mb-lg-0 p-0">
  					<a class="navbar-brand" href="<?= site_url('dashboard'); ?>" aria-label="Space">
  						<img class="navbar-brand-logo" src="<?= base_url(); ?><?= $web_logo;?>" alt="Logo">
  					</a>
  					<a>
  						<span class="badge bg-soft-primary text-primary">v2.5.2</span>
  					</a>
  				</div>
  				<!-- End Default Logo -->

  				<div class="col-md px-lg-0">
  					<div class="d-flex justify-content-between align-items-center px-lg-5 px-xl-10">
  						<!-- Navbar -->
  						<ul class="navbar-nav p-0 d-sm-flex justify-space-center">
  							<li class="nav-item float-sm-start">
  								<a class="btn btn-ghost-secondary btn-sm" onclick="tournow()">
  									Help center <i class="bi-question-diamond-fill ms-1"></i>
  								</a>
  							</li>
  							<li class="nav-item">
  								<a class="btn btn-outline-secondary btn-sm" href="<?= site_url('sign-out'); ?>">
  									<i class="bi-power me-1"></i> Sign out
  								</a>
  							</li>
  						</ul>
  						<!-- End Navbar -->
  					</div>
  				</div>
  				<!-- End Col -->
  			</div>
  			<!-- End Row -->
  		</nav>
  	</div>
  </header>
  <!-- ========== END HEADER ========== -->
