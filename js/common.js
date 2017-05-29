'use strict';
if (!window.console) window.console = {};
if (!window.console.memory) window.console.memory = function () {
};
if (!window.console.debug) window.console.debug = function () {
};
if (!window.console.error) window.console.error = function () {
};
if (!window.console.info) window.console.info = function () {
};
if (!window.console.log) window.console.log = function () {
};

// sticky footer
//-----------------------------------------------------------------------------
if (!Modernizr.flexbox) {
    (function () {
        var
            $pageWrapper = $('#page-wrapper'),
            $pageBody = $('#page-body'),
            noFlexboxStickyFooter = function () {
                $pageBody.height('auto');
                if ($pageBody.height() + $('#header').outerHeight() + $('#footer').outerHeight() < $(window).height()) {
                    $pageBody.height($(window).height() - $('#header').outerHeight() - $('#footer').outerHeight());
                } else {
                    $pageWrapper.height('auto');
                }
            };
        $(window).on('load resize', noFlexboxStickyFooter);
    })();
}
if (ieDetector.ieVersion == 10 || ieDetector.ieVersion == 11) {
    (function () {
        var
            $pageWrapper = $('#page-wrapper'),
            $pageBody = $('#page-body'),
            ieFlexboxFix = function () {
                if ($pageBody.addClass('flex-none').height() + $('#header').outerHeight() + $('#footer').outerHeight() < $(window).height()) {
                    $pageWrapper.height($(window).height());
                    $pageBody.removeClass('flex-none');
                } else {
                    $pageWrapper.height('auto');
                }
            };
        ieFlexboxFix();
        $(window).on('load resize', ieFlexboxFix);
        svg4everybody();
    })();
}

$(function () {

    $(document).ready(function () {

       $('.js-pif1-item').click(function () {
          $('.pif1-choose__item').removeClass('active');
          $(this).addClass('active');
       });

       $('.js-pif1-readmore').click(function () {
           if ($('.pif1-choose__readmore-block').hasClass('active')) {
               $(this).text('показать все');
               $('.pif1-choose__readmore-block').toggleClass('active');
               $('.pif1-choose__btn').toggle();
           } else {
               $('.pif1-choose__readmore-block').toggleClass('active');
               $(this).text('свернуть')
               $('.pif1-choose__btn').toggle();
           }
       });


        var
            range1 = 1740000,
            range2 = 2;
        $('.js-pif2-range1').slider({
            step: 100,
            min: 0,
            max: 5000000,
            value: range1,
            slide: function( event, ui ) {
                $('#pif2-range1').val( ui.value );
            },
            range: "min"
        });

        $( "#pif2-range1" ).val( $( ".js-pif2-range1" ).slider( "value" ) );

        $('.js-pif2-range2').slider({
            animate: "fast",
            step: 1,
            min: 1,
            max: 6,
            value: range2,
            slide: function( event, ui ) {
                $('#pif2-range2').val( ui.value );
            },
            range: "min",
            change: function( event, ui ) {
                if (ui.value == 1) {
                    $('.pif2-range2__text').text('год')
                } else {
                    if (ui.value > 2) {
                        $('.pif2__range2--2').addClass('active')
                    } else {
                        $('.pif2__range2--2').removeClass('active')
                    }
                    if (ui.value > 4) {
                        $('.pif2-range2__text').text('лет');
                        $('.pif2__range2--5').addClass('active');
                    } else {
                        $('.pif2-range2__text').text('года');
                        $('.pif2__range2--5').removeClass('active');
                    }
                }
            }
        });

        $( "#pif2-range2" ).val( $( ".js-pif2-range2" ).slider( "value" ) );

        $('.input-number').on('keyup keypress', function(e) {
            if (e.keyCode == 8 || e.keyCode == 46) {}
            else
            {
                var letters='1234567890';
                return (letters.indexOf(String.fromCharCode(e.which))!=-1);
            }
        });



    });

    $(window).load(function () {

        $('.pif1-choose__subitem--color').matchHeight({
            byRow: false,
            property: 'height'
        });

    });


});