'use strict';

$(function() {
    $('.js-item-tab').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        if ($this.hasClass('active')) {
            return false
        }
        var tabTarget = $this.attr('href');
        $this.closest('.item-tab-wrapper__head').find('.item-tab-wrapper__link').removeClass('active');
        $this.addClass('active');
        $this.closest('.item-tab-wrapper').find('.item-tab-wrapper__item').removeClass('active');
        $this.closest('.item-tab-wrapper').find(tabTarget).addClass('active');

    });

    $('.js-number-input').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.closest('.item-detail__count-wrap').find('.item-detail__count-input');
        var $currentVal = $input.val();

        switch ($this.attr('data-count')) {
            case 'plus':
                $currentVal++;

                break;
            case 'minus':
                if ($currentVal == 1) {
                    return false;
                }
                $currentVal--;
                break;
        }
        $input.val($currentVal)
    });

    $('.js-item-favorite').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
    })


});

var photosDetailPage = (function() {
    var $btn = $('.js-show-big-photo');
    var $photoWrap = $('.item-detail__main-photo-image');

    $btn.on('click', function(e) {
        e.preventDefault();
        if ($(this).hasClass('active')) {
            return false;
        }

        var $photoTarget = $(this).attr('href');
        $photoWrap.attr('src', $photoTarget);
        $btn.removeClass('active');
        $(this).addClass('active');

    })
})();


var presentSlider = (function() {
    var $btn = $('.js-show-present');
    var $sliderWrap = $('.present-wrap__slider');
    var $slider = $('.js-present-slider');
    var isShow = true;


    $btn.on('click', function(e) {
        e.preventDefault();



        if ($btn.hasClass('active')) {
            $sliderWrap.hide();
        } else {
            $sliderWrap.show();
            if (isShow) {
                $sliderWrap.css('opacity', '0');
                $slider.slick({
                    infinite: true,
                    slidesToShow: 5,
                    arrows: false,
                    responsive: [{
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 767,
                            settings: {
                                slidesToShow: 1,
                            }
                        },
                    ]
                });
                setTimeout(function() {
                    $sliderWrap.css('opacity', '1');
                }, 10);
                $('.js-present-arrows').on('click', function (e) {
                    e.preventDefault();
                    $slider.slick($(this).attr('data-slider'));
                })
                isShow = !isShow;
            }
        }
        $btn.toggleClass('active');
    });
})();
