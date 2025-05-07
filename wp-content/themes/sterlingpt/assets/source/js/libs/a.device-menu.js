var $ = jQuery.noConflict();
$(() => {
    /* Responsive Jquery Navigation */
    $('.hamburger').click(function() {
        $('body').addClass('scroll-fixed');
        var $navContainer = $('nav .wp-block-navigation__responsive-container');
        $navContainer.addClass('has-modal-open');
        $navContainer.addClass('is-menu-open');

        // Set the attributes
        $navContainer.attr({
            'aria-model': 'true',
            'aria-label': 'Menu',
            'role': 'dialog'
        });
    });

    $('.wp-block-navigation__responsive-container-close').click(function() {
        $('body').removeClass('scroll-fixed');
        var $navContainer = $('nav .wp-block-navigation__responsive-container');
        $navContainer.removeClass('has-modal-open');
        $navContainer.removeClass('is-menu-open');

        // Set the attributes
        $navContainer.attr({
            'aria-model': 'true',
            'aria-label': 'Menu',
            'role': 'dialog'
        });
    });

    MobileMenu();

    $(window).resize(function () {
        MobileMenu();
        checkDeviceRotation();
    });

    $(window).on('load', function () {
        MobileMenu();
    });
});

/** Mobile menu function to open and close it. */
function MobileMenu() {
    if ($(window).width() < 992) {
        $(document).off('click', '.wp-block-navigation-submenu__toggle');

        $(document).on('click', '.wp-block-navigation-submenu__toggle', function (e) {
            e.preventDefault();
            const $toggle = $(this);
            const $submenu = $toggle.next('.wp-block-navigation-submenu');
            const isExpanded = $toggle.hasClass('menu-active');

            // Collapse all siblings
            $toggle
                .closest('.wp-block-navigation-item')
                .siblings()
                .find('.wp-block-navigation-submenu')
                .slideUp()
                .prev('.wp-block-navigation-submenu__toggle')
                .removeClass('menu-active')
                .attr('aria-expanded', 'false');

            if (isExpanded) {
                // Collapse current submenu
                $toggle.removeClass('menu-active').attr('aria-expanded', 'false');
                $submenu.slideUp();
            } else {
                // Expand current submenu
                $toggle.addClass('menu-active').attr('aria-expanded', 'true');
                $submenu.slideDown();
            }
        });
    } else {
        $('.wp-block-navigation-submenu').show();
        $(document).off('click', '.wp-block-navigation-submenu__toggle');
    }
}

/** Check the devide > 991 while rotation to close mobile menu. */
function checkDeviceRotation() {
    if ($(window).width() > 991) {
        var $navContainer = $('nav .wp-block-navigation__responsive-container');
        $navContainer.removeClass('has-modal-open');
        $navContainer.removeClass('is-menu-open');
    }
}