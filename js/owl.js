$(document).ready(function() {
    $('.owl-carousel').owlCarousel({
        item: 3,
        loop: true,
        margin: 50,
        nav: true,
        // stagePadding: 50,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
});