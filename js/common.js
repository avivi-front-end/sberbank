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
    });

    $(window).load(function () {

        $('.pif1-choose__subitem--color').matchHeight({
            byRow: false,
            property: 'height'
        });

    });


});