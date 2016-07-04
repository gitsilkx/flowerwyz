 var ThumbImageWidth = 183;
            var ThumbImageHeight = 183;

            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-57269771-1', 'auto');
            ga('send', 'pageview');
 
 
 var mq = window.matchMedia("(max-width: 320)");
 if (mq.matches) {
  var initTopPosition= $('.your_cart').offset().top;  
  $(window).scroll(function(){
    if($(window).scrollTop() > initTopPosition)
        $('.your_cart').css({'position':'fixed','top':'0px','width':'318px','height':'69','z-index':'9999','margin':'4px',});
    else
        $('.your_cart').css({'position':'absolute','top':initTopPosition+'px','width':'318px','height':'69'});
});   
 } else {
var initTopPosition= $('.your_cart').offset().top;   
$(window).scroll(function(){
    if($(window).scrollTop() > initTopPosition)
        $('.your_cart').css({'position':'fixed','top':'0px','width':'278px','height':'69','z-index':'9999'});
    else
        $('.your_cart').css({'position':'absolute','top':initTopPosition+'px','width':'278px','height':'69'});
});
 }
 
   function validation(){
       var category= $('#category').val();
       var srctxt = $('#srctxt').val();
       if(category == '' && srctxt == ''){
           alert('Please select category or item no.');
           return false;
       }
   }
   
   $(function(event) {

                if (typeof $.fn.superfish == "function") {

                    $("ul.sf-menu").superfish({
                        delay: 800,
                        dropShadows: 0,
                        speed: "fast"

                    })

                            .find("ul")
                            .bgIframe();

                }
				
				$(".fancyboxIframe").fancybox({
                    minWidth: 250,
                    width: '80%',
                    maxWidth: 700,
                    minHeight: 500,
                    height: 500,
                    'autoScale': false,
                    'autoDimensions': false,
                    'scrolling': 'yes',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                });
                $(".splFancyIframe").fancybox({
                    minWidth: 250,
                    maxWidth: 700,
                    width: '90%',
                    minHeight: 500,
                    height: 500,
                    'autoScale': false,
                    'autoDimensions': false,
                    'scrolling': 'yes',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                });
                $(".fancyboxIframeCustome").fancybox({
                    minWidth: '90%',
                    maxWidth: 700,
                    width: '90%',
                    minHeight: 450,
                    height: 450,
                    'autoScale': false,
                    'autoDimensions': false,
                    'scrolling': 'no',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                });

            })

$(document).ready(function(){
    $('#srctxt').focus(function () {
        if ($(this).attr('placeholder') == 'Enter Item No.') {
            $(this).attr("placeholder", "");            
        }
    }).blur(function () {
        if ($(this).attr('placeholder') == '') {
             $(this).attr("placeholder", "Enter Item No."); 
       }
    });
});