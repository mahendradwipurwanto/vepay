</main>
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
<script src="<?= site_url()?>assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>

<!-- JS Front -->
<script src="<?= base_url();?>assets/js/theme.min.js"></script>

<!-- JS Plugins Init. -->
<script>
	(function () {

		// INITIALIZATION OF SHOW ANIMATIONS
		// =======================================================
		new HSShowAnimation('.js-animation-link')


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

		// INITIALIZATION OF TOGGLE PASSWORD
		// =======================================================
		new HSTogglePassword('.js-toggle-password')
	})()

</script>
</body>

</html>
