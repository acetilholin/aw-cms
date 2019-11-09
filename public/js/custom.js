
$(document).ready(function() {
    $(window).scroll(function() {
        if($(this).scrollTop() > 300) {
            $('.navbar').addClass('solid');
        } else {
            $('.navbar').removeClass('solid');
        }
        if (navigator.userAgent.match(/i(Phone|Pad)/i) || navigator.userAgent.match(/Android/i)) {
            if ($(this).scrollTop() > 5) {
                $('.navbar').addClass('solid');
            } else {
                $('.navbar').removeClass('solid');
            }
        }
    });
});

$(document).ready(function () {
    $(document).click(function (event) {
        var clickover = $(event.target);
        var _opened = $(".navbar-collapse").hasClass("show");
        if (_opened === true && !clickover.hasClass("navbar-toggler")) {
            $(".navbar-toggler").click();
        }
    });
});


$(document).ready(function(){
    $("a").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;

            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash;
            });
        }
    });
});

$(document).ready(function () {
    $('.second-button').on('click', function () {
        $('.animated-icon2').toggleClass('open');
    });
});

$(function() {
    $("#message").fadeTo(4000, 500).slideUp(500, function () {
        $("#message").slideUp(500);
    });
});

$(document).ready(function(){
    $(window).scroll(function(){
        $(".arrow").css("opacity", 1 - $(window).scrollTop() / 250);
    });
});


$(document).ready(function(){
    $("#cars-in-offer").owlCarousel({
            items:3,
            autoplay:true,
            smartSpeed:900,
            loop:true,
            autoplayHoverPause:true,
            responsive : {
                0 : {
                    items: 1,
                },
                576 : {
                    items: 2,
                },
                768 : {
                    items: 3
                }
            }
        }
    );
});


$(document).ready(function() {
    $('.counter').counterUp({
        delay: 10,
        time: 1800
    });
});


$(document).ready(function(){
    $("#cars-in-offer").owlCarousel({
            items:3,
            autoplay:true,
            smartSpeed:1700,
            loop:true,
            autoplayHoverPause:true,
            responsive : {
                0 : {
                    items: 1
                },

                576 : {
                    items: 2
                },
                768: {
                    items: 3
                }
            }
        }
    );
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 500) {
            $('.top-scroll').fadeIn();
        } else {
            $('.top-scroll').fadeOut();
        }
    });
});

$(function () {
    $('[data-toggle="transport-info"]').tooltip();
    $('[data-toggle="diesel-info"]').tooltip();
});
