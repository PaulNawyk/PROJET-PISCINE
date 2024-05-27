$(document).ready(function () {
    var $carousel = $('#carrousel');
    var $carouselInner = $carousel.find('.carousel-inner');
    var $carouselItems = $carouselInner.children('.carousel-item');
    var currentIndex = 0;
    var totalItems = $carouselItems.length;
    var interval;

    function showSlide(index) {
        $carouselItems.removeClass('active');
        $carouselItems.eq(index).addClass('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalItems;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        showSlide(currentIndex);
    }

    function startCarousel() {
        interval = setInterval(nextSlide, 3000);
    }

    function stopCarousel() {
        clearInterval(interval);
    }

    $carousel.find('.carousel-control-next').click(function () {
        stopCarousel();
        nextSlide();
        startCarousel();
    });

    $carousel.find('.carousel-control-prev').click(function () {
        stopCarousel();
        prevSlide();
        startCarousel();
    });

    $carousel.hover(stopCarousel, startCarousel);

    showSlide(currentIndex);
    startCarousel();
});
