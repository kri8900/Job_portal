document.addEventListener('DOMContentLoaded', (event) => {
    var multipleCardCarousel = document.querySelector("#carouselExampleControls");

    if (window.matchMedia("(min-width: 768px)").matches) {
        var carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false,
        });

        var carouselWidth = document.querySelector('.carousel-inner').scrollWidth;
        var cardWidth = document.querySelector('.carousel-item').offsetWidth;
        var scrollPosition = 0;

        document.querySelector("#carouselExampleControls .carousel-control-next").addEventListener('click', function() {
            if (scrollPosition < carouselWidth - cardWidth * 3) {
                scrollPosition += cardWidth;
                document.querySelector('.carousel-inner').scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        });

        document.querySelector("#carouselExampleControls .carousel-control-prev").addEventListener('click', function() {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                document.querySelector('.carousel-inner').scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
            }
        });
    } else {
        multipleCardCarousel.classList.add('slide');
    }
});
document.getElementById('post-job-button').addEventListener('click', function() {
    window.location.href = 'post-job.html';
});


