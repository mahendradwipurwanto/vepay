</div>
<!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== FOOTER ========== -->
<footer class="bg-dark" style="background-image: url(<?= base_url();?>assets/svg/components/wave-pattern-light.svg);">
	<div class="container pb-1 pb-lg-5">
		<div class="row content-space-t-2">
			<div class="col-lg-3 mb-7 mb-lg-0">
				<!-- Logo -->
				<div class="mb-5">
					<a class="navbar-brand" href="<?= base_url();?>" aria-label="Logo">
						<img class="navbar-brand-logo" src="<?= base_url();?><?= $web_logo_white;?>"
							alt="Image Description">
					</a>
				</div>
				<!-- End Logo -->

				<!-- List -->
				<ul class="list-unstyled list-py-1">
					<li><a class="link-sm link-light" href="<?= base_url();?>"><i class="bi-geo-alt-fill me-1"></i>
							<?= $web_alamat;?></a></li>
					<li><a class="link-sm link-light" href="tel:<?= $web_telepon;?>"><i
								class="bi-telephone-inbound-fill me-1"></i><?= $web_telepon;?></a></li>
				</ul>
				<!-- End List -->

			</div>
			<!-- End Col -->

			<div class="col-sm offset-sm-3 mb-7 mb-sm-0">
				<h5 class="text-white mb-3">Information</h5>

				<!-- List -->
				<ul class="list-unstyled list-py-1 mb-0">
					<li><a class="link-sm link-light" href="<?= site_url('about');?>">About us</a></li>
					<li><a class="link-sm link-light" href="<?= site_url('partnership-sponshorship');?>">Sponsorship</a>
					</li>
				</ul>
				<!-- End List -->
			</div>
			<!-- End Col -->

			<div class="col-sm">
				<h5 class="text-white mb-3">Helps</h5>

				<!-- List -->
				<ul class="list-unstyled list-py-1 mb-5">
					<li><a class="link-sm link-light" href="<?= site_url('help-center');?>"><i
								class="bi-question-circle-fill me-1"></i> Help Center</a>
					</li>
					<li><a class="link-sm link-light" href="<?= site_url('faq');?>"><i
								class="bi-chat-left-dots me-1"></i> FAQ</a>
					</li>
				</ul>
				<!-- End List -->
			</div>
			<!-- End Col -->
		</div>
		<!-- End Row -->

		<div class="border-top border-white-10 my-7"></div>

		<div class="row mb-7">
			<div class="col-sm mb-3 mb-sm-0">
			</div>

			<div class="col-sm-auto">
				<!-- Socials -->
				<ul class="list-inline mb-0">
					<?php if(isset($sosmed_ig)):?>
					<li class="list-inline-item">
						<a class="btn btn-soft-light btn-xs btn-icon" href="https://instagram.com/<?= $sosmed_ig;?>">
							<i class="bi-instagram"></i>
						</a>
					</li>
					<?php endif;?>

					<?php if(isset($sosmed_facebook)):?>
					<li class="list-inline-item">
						<a class="btn btn-soft-light btn-xs btn-icon"
							href="https://facebook.com/<?= $sosmed_facebook;?>">
							<i class="bi-facebook"></i>
						</a>
					</li>
					<?php endif;?>

					<?php if(isset($sosmed_twitter)):?>
					<li class="list-inline-item">
						<a class="btn btn-soft-light btn-xs btn-icon" href="https://twitter.com/<?= $sosmed_twitter;?>">
							<i class="bi-twitter"></i>
						</a>
					</li>
					<?php endif;?>

					<?php if(isset($sosmed_yt)):?>
					<li class="list-inline-item">
						<a class="btn btn-soft-light btn-xs btn-icon" href="https://youtube.com/<?= $sosmed_yt?>">
							<i class="bi-youtube"></i>
						</a>
					</li>
					<?php endif;?>
				</ul>
				<!-- End Socials -->
			</div>
		</div>

		<!-- Copyright -->
		<div class="w-md-85 text-lg-center mx-lg-auto">
			<p class="text-white-50 small">&copy; 2022 <?= $web_title;?>. All rights reserved.</p>
			<p class="text-white-50 small">When you visit or interact with our sites, services or tools, we or
				our
				authorised service providers may use cookies for storing information to help provide you with a
				better, faster and safer experience and for marketing purposes.</p>
		</div>
		<!-- End Copyright -->
	</div>
</footer>
<!-- ========== END MAIN CONTENT ========== -->
<!-- Go To -->
<a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
	<i class="bi-chevron-up"></i>
</a>
<!-- ========== END SECONDARY CONTENTS ========== -->

<!-- JS Global Compulsory  -->
<script src="<?= base_url();?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS Implementing Plugins -->
<script src="<?= base_url();?>assets/vendor/hs-header/dist/hs-header.min.js"></script>
<script src="<?= base_url();?>assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
<script src="<?= base_url();?>assets/vendor/hs-show-animation/dist/hs-show-animation.min.js"></script>
<script src="<?= base_url();?>assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="<?= base_url();?>assets/vendor/aos/dist/aos.js"></script>
<script src="<?= base_url();?>assets/vendor/fslightbox/index.js"></script>
<script src="<?= base_url();?>assets/vendor/appear/dist/appear.min.js"></script>
<script src="<?= base_url();?>assets/vendor/circles.js/circles.js"></script>
<script src="<?= base_url();?>assets/vendor/typed.js/lib/typed.min.js"></script>
<script src="<?= base_url();?>assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="<?= base_url();?>assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
<script type="text/javascript" src="<?= site_url();?>assets/js/flatpickr.min.js"></script>
<!-- JS Front -->
<script src="<?= base_url();?>assets/js/theme.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/custom.js?<?=time();?>"></script>

<!-- JS Plugins Init. -->
<script>
	(function () {
		// INITIALIZATION OF HEADER
		// =======================================================
		new HSHeader('#header').init()


		// INITIALIZATION OF MEGA MENU
		// =======================================================
		new HSMegaMenu('.js-mega-menu', {
			desktop: {
				position: 'left'
			}
		})


		// INITIALIZATION OF SHOW ANIMATIONS
		// =======================================================
		new HSShowAnimation('.js-animation-link')


		// INITIALIZATION OF TEXT ANIMATION (TYPING)
		// =======================================================
		HSCore.components.HSTyped.init('.js-typedjs')


		// INITIALIZATION OF BOOTSTRAP DROPDOWN
		// =======================================================
		HSBsDropdown.init()

		// INITIALIZATION OF BOOTSTRAP VALIDATION
		// =======================================================
		HSBsValidation.init('.js-validate', {
			onSubmit: data => {
				$('button[type=submit]').prop("disabled", true);
				// add spinner to button
				$('button[type=submit]').html(
					`<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> Loading...`
				);
				return;
			}
		})


		// INITIALIZATION OF GO TO
		// =======================================================
		new HSGoTo('.js-go-to')


		// INITIALIZATION OF AOS
		// =======================================================
		AOS.init({
			duration: 650,
			once: true
		});


		// INITIALIZATION OF CIRCLES
		// =======================================================
		setTimeout(() => {
			HSCore.components.HSCircles.init('.js-circle')
		})

		// INITIALIZATION OF SWIPER
		// =======================================================
		var navigation = new Swiper('.js-swiper-navigation', {
			loop: true,
			navigation: {
				nextEl: '.js-swiper-navigation-button-next',
				prevEl: '.js-swiper-navigation-button-prev',
			},
		});

		// INITIALIZATION OF SELECT
		// =======================================================
		HSCore.components.HSTomSelect.init('.js-select')



		$(document).ready(function () {
			$('#table').DataTable({
				responsive: true
			});
		})
	})()

	document.addEventListener("DOMContentLoaded", function () {
		var lazyloadImages = document.querySelectorAll("img.lazy");
		var lazyloadThrottleTimeout;

		function lazyload() {
			if (lazyloadThrottleTimeout) {
				clearTimeout(lazyloadThrottleTimeout);
			}

			lazyloadThrottleTimeout = setTimeout(function () {
				var scrollTop = window.pageYOffset;
				lazyloadImages.forEach(function (img) {
					if (img.offsetTop < (window.innerHeight + scrollTop)) {
						img.src = img.dataset.src;
						img.classList.remove('lazy');
					}
				});
				if (lazyloadImages.length == 0) {
					document.removeEventListener("scroll", lazyload);
					window.removeEventListener("resize", lazyload);
					window.removeEventListener("orientationChange", lazyload);
				}
			}, 20);
		}

		document.addEventListener("scroll", lazyload);
		window.addEventListener("resize", lazyload);
		window.addEventListener("orientationChange", lazyload);
	});

	// INITIALIZATION OF STEP FORM
	// =======================================================
	new HSStepForm('.js-step-form-validate', {
		validator: HSBsValidation.init('.js-validate'),
		finish($el) {
			const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

			$successMessageTempalte.style.display = 'block'

			$el.style.display = 'none'
			$el.parentElement.appendChild($successMessageTempalte)
		}
	})

</script>
</body>

</html>
