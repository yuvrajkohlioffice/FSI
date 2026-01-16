	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/wow.js"></script> <!-- WOW JS -->
	<script src="js/isotope.pkgd.min.js"></script> <!-- iSotope JS -->
	<script src="js/owl.carousel.min.js"></script> <!-- OWL Carousle JS -->
	<script src="revolution/js/jquery.themepunch.tools.min.js"></script> <!-- Revolution Slider Tools -->
	<script src="revolution/js/jquery.themepunch.revolution.min.js"></script> <!-- Revolution Slider -->
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.actions.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.carousel.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.migration.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.navigation.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.parallax.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
	<script type="text/javascript" src="revolution/js/extensions/revolution.extension.video.min.js"></script>
	<script src="js/jquery.fancybox.pack.js"></script> <!-- FancyBox -->
	<script src="js/validate.js"></script> <!-- Form Validator JS -->
	<script src="js/jquery.easing.min.js"></script> <!-- jquery easing JS -->
	<script src="js/jquery.fitvids.js"></script> <!-- jquery fitVids JS -->
	<script src="js/jquery.bxslider.min.js"></script> <!-- jquery bx slider JS -->
	<script src="js/custom.js"></script> <!-- Custom JS -->

<script>
	$(document).ready(function () {
	$('#menu-toggle').click(function () {
		$('#sidebar-menu').addClass('active');
	});

	$('#menu-close').click(function () {
		$('#sidebar-menu').removeClass('active');
	});

	$('.has-submenu').click(function (e) {
		e.preventDefault();
		const submenu = $(this).next('.submenu');
		const icon = $(this).find('.toggle-icon');

		submenu.slideToggle();

		// Toggle the icon
		icon.text(icon.text() === '+' ? '−' : '+');
	});
	});
	$('#menu-close').on('click', function () {
		$('#sidebar-menu').removeClass('active');
	});


  let currentIndex = 0;

  $(document).on('keydown', function (e) {
    const menuItems = $('#mainMenu .item');

    if (e.key === 'Tab') {
      e.preventDefault(); // Prevent default tabbing

      menuItems.removeClass('active');
      $('.ui.dropdown').dropdown('hide'); // Hide all dropdowns first

      if (e.shiftKey) {
        // Shift + Tab: Go backward
        currentIndex = (currentIndex - 1 + menuItems.length) % menuItems.length;
      } else {
        // Tab: Go forward
        currentIndex = (currentIndex + 1) % menuItems.length;
      }
      const $currentItem = $(menuItems[currentIndex]);
      $currentItem.addClass('active');

      // If it's a dropdown item, show the dropdown
      if ($currentItem.hasClass('ui dropdown')) {
        $currentItem.dropdown('show');
      }
    }

    // Press Enter to click the active item
    if (e.key === 'Enter') {
      const $activeItem = $('#mainMenu .item.active');

      if ($activeItem.length) {
        $activeItem.trigger('click');
      }
    }
  });

</script>

