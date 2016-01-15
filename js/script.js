/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function($, Drupal, window, document, undefined) {


    // To understand behaviors, see https://drupal.org/node/756722#behaviors
    Drupal.behaviors.my_custom_behavior = {
        attach: function(context, settings) {

            // Place your code here.
            $(window).load(function() {
                $('#block-superfish-1 ul#superfish-1').css('overflow', 'visible');
                $('#block-superfish-2 ul#superfish-2').css('overflow', 'visible');

                $("#superfish-1 ul").prepend("<div class='triangle'></div>");
                $("#superfish-2 ul").prepend("<div class='triangle'></div>");
                // $('.region-header-top #block-menu-block-2').innerHeight($('.region-header-top #block-menu-block-1').innerHeight());
                $(".region-header-top #block-menu-block-2,.region-header-top #block-menu-block-1").wrapAll("<div class='menu_block_wrap' />");

            });
            $(document).ready(function() {
                $(".hot-news-list").append('<ins class="rmax" data-rmax-space-id="be4fb9e9461747b5" data-rmax-space-type="NATIVE" data-target-id=".hot-news-list .views-row-3" data-target-pos="REPLACE"></ins><script async="async" src="//tenmax-static.cacafly.net/ssp/adsbytenmax.js"></script>');
                $(".field-name-field-read-more .field-items").append('<ins class="rmax" data-rmax-space-id="52168cd1d9a04dea" data-rmax-space-type="NATIVE" data-target-id=".field-item" data-target-index="3" data-target-pos="AFTER"></ins><script async="async" src="//tenmax-static.cacafly.net/ssp/adsbytenmax.js"></script>');
            });

            jQuery.grep(jQuery(document).find('img'), function(i) {
                var img = new Image();
                var src = jQuery(i).attr('src');
                img.onload = function() {
                    //when done;
                };
                img.src = src;
                return false;
            });
            //載入圖片讓它快取

            var slideshow_2 = $(".views-field-field-slideshow img").attr("src");
            var node_slideshow_1 = $(".view-eva-article-slideshow img").attr("src");
            var slideshow_1 = $(".view-elle-slideshow img").attr("src")

            var slideshow = [slideshow_1, slideshow_2, node_slideshow_1];

            $.preload(slideshow[0], slideshow[1], slideshow[2]);

            $('.column-area ul.editor-list li.views-row-6.editor-block').after('<li id="ad-destination"></li>');
            $('#block-views-ad-block-block-23').appendTo('#ad-destination');

            $('#content .view-eva-article-postdate-title .view-content .views-row .views-field-sharethis span.st_pinterest_hcount').after('<span id="extra-social" style="display:block"></span>');
            $('.field-name-extra-share .field-items .field-item.even').appendTo('#extra-social');

            $('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693').after('<li id="global-website"></li>')
                //$('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693 ul.menu li.menu-mlid-710').addClass('fa fa-chevron-down');
            $('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693 ul.menu li.menu-mlid-710 ul.menu').appendTo('#global-website');

            $('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693 ul.menu li.menu-mlid-710').click(function() {
                if ($('.region-bottom #block-menu-block-4 ul.menu li#global-website').is(":hidden")) {
                    $('.region-bottom #block-menu-block-4 ul.menu li#global-website').slideDown("slow");
                    $('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693 ul.menu li.menu-mlid-710').toggleClass('fa-chevron-up fa-chevron-down');
                } else {
                    $('.region-bottom #block-menu-block-4 ul.menu li#global-website').slideUp();
                    $('.region-bottom #block-menu-block-4 ul.menu li.menu-mlid-693 ul.menu li.menu-mlid-710').toggleClass('fa-chevron-down fa-chevron-up');

                }
            });



            $(document).ajaxComplete(function() {
                try {
                    FB.XFBML.parse();
                } catch (ex) {}
            });
        }
    };


})(jQuery, Drupal, this, this.document);
