</div>
<!-- End Content -->

<div class="card online-card minimized">
	<div class="card-header p-3 online-action cursor d-flex align-items-center">
		<span class="dot"></span> online users
	</div>
	<div class="card-body p-3" id="online-users">
		<ul class="list-checked list-checked-bg-success online-list">
			<?php if(!empty($online_users)):?>
			<?php foreach($online_users as $key => $val):?>
			<li class="list-checked-item online-list-text"><?= $val->name;?></li>
			<?php endforeach;?>
			<?php else:?>
			<li class="text-center">no users online</li>
			<?php endif;?>
		</ul>
	</div>
</div>

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== SECONDARY CONTENTS ========== -->
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

<!-- JS Implementing Plugins -->
<script src="<?= base_url(); ?>assets/vendor/hs-header/dist/hs-header.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/list.js/dist/list.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/prism/prism.js"></script>
<script src="<?= base_url(); ?>assets/vendor/aos/dist/aos.js"></script>
<script src="<?= base_url(); ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/prism/prism.js"></script>
<script src="<?= base_url(); ?>assets/vendor/fslightbox/index.js"></script>
<script src="<?= base_url(); ?>assets/vendor/imask/dist/imask.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="<?= base_url(); ?>assets/js/flatpickr.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/fslightbox/index.js"></script>
<!-- JS Front -->
<script src="<?= base_url(); ?>assets/js/theme.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js?<?=time();?>"></script>

<!-- JS Plugins Init. -->
<script>

	function tournow() {
		introJs().setOptions({
			disableInteraction: true,
			steps: [{
				intro: "Welcome to Middle East Youth Summit webApp, we will briefly explain our feature`s"
			}, {
				element: document.querySelector('#tour-landing-button'),
				intro: "Go to landing page with ease"
			}, {
				element: document.querySelector('#tour-dashboard'),
				intro: "Overview your website on this page"
			}, {
				element: document.querySelector('#tour-statistics'),
				intro: "See all statistics of your website in here"
			}, {
				element: document.querySelector('#tour-participans'),
				intro: "View and manage all participans information on this page"
			}, {
				element: document.querySelector('#tour-payments'),
				intro: "Manage participans payments with ease on this page"
			}, {
				element: document.querySelector('#tour-payment-batch'),
				intro: "Manage payments batch for participans at here"
			}, {
				element: document.querySelector('#tour-payment-settings'),
				intro: "Manage payment settings with ease on this page"
			}, {
				element: document.querySelector('#tour-payment-xendit'),
				intro: "Manage xendit payment gateway settings with ease on this page"
			}, {
				element: document.querySelector('#tour-ambassador'),
				intro: "You can manage all your ambassador on here"
			}, {
				element: document.querySelector('#tour-eligilibity-countries'),
				intro: "You can manage all eligilibity countries data on here"
			}, {
				element: document.querySelector('#tour-announcements'),
				intro: "You can manage all announcements on here"
			}, {
				element: document.querySelector('#tour-landing'),
				intro: "You can manage landing page setting from home to gallery in here"
			}, {
				element: document.querySelector('#tour-website'),
				intro: "You can manage website setting on this page"
			}]
		}).start();
	};

	(function () {
		// INITIALIZATION OF HEADER
		// =======================================================
		new HSHeader('#header').init()

		// INITIALIZATION OF BOOTSTRAP VALIDATION
		// =======================================================
		HSBsValidation.init('.js-validate', {
			onSubmit: data => {
				$('button[type=submit]').prop("disabled", true);
				// add spinner to button
				$('button[type=submit]').html(
					`<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
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


		// INITIALIZATION OF INPUT MASK
		// =======================================================
		HSCore.components.HSMask.init('.js-input-mask')

		// INITIALIZATION OF  QUANTITY COUNTER
		// =======================================================
		new HSQuantityCounter('.js-quantity-counter')


		// INITIALIZATION OF SWIPER
		// =======================================================
		let activeIndex = 0
		var sliderThumbs = new Swiper('.js-swiper-thumbs', {
			slidesPerView: 1,
			autoplay: false,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			followFinger: false,
			loop: true,
			on: {
				'slideChangeTransitionEnd': function (event) {
					if (sliderMain === undefined) return
					sliderMain.slideTo(event.activeIndex)
				}
			}
		});

		var sliderMain = new Swiper('.js-swiper-main', {
			effect: 'fade',
			autoplay: false,
			disableOnInteraction: true,
			loop: true,
			navigation: {
				nextEl: '.js-swiper-main-button-next',
				prevEl: '.js-swiper-main-button-prev',
			},
			thumbs: {
				swiper: sliderThumbs
			},
			on: {
				'slideChangeTransitionEnd': function (event) {
					if (sliderThumbs === undefined) return
					sliderThumbs.slideTo(event.activeIndex)
				}
			}
		})

		// Clients
		var swiper = new Swiper('.js-swiper-clients', {
			slidesPerView: 2,
			breakpoints: {
				380: {
					slidesPerView: 3,
					spaceBetween: 15,
				},
				768: {
					slidesPerView: 4,
					spaceBetween: 15,
				},
				1024: {
					slidesPerView: 5,
					spaceBetween: 15,
				},
			},
		});

		// Card Grid
		var swiper = new Swiper('.js-swiper-card-blocks', {
			slidesPerView: 1,
			pagination: {
				el: '.js-swiper-card-blocks-pagination',
				dynamicBullets: true,
				clickable: true,
			},
			breakpoints: {
				620: {
					slidesPerView: 2,
					spaceBetween: 15,
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 15,
				},
			},
		});

		// INITIALIZATION OF ADD FIELD
		// =======================================================
		new HSAddField('.js-add-field')

		// INITIALIZATION OF SELECT
		// =======================================================
		HSCore.components.HSTomSelect.init('.js-select')

		// INITIALIZATION OF STEP FORM
		// =======================================================
		new HSStepForm('.js-step-form', {
			finish($el) {
				const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

				$successMessageTempalte.style.display = 'block'

				$el.style.display = 'none'
				$el.parentElement.appendChild($successMessageTempalte)
			}
		})
	})()

</script>
</body>

</html>
