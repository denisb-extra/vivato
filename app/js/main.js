$(document).ready(function ($) {
    window.addEventListener('scroll', onScroll);
    function onScroll(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop;
            shrinkOn = 30;
        if (distanceY > shrinkOn) {
            $("header" ).addClass("scrolled");
        } else {
            $("header" ).removeClass("scrolled");
        }
    }
    onScroll();
    $(".mobile_menu").simpleMobileMenu({
        "menuStyle": "slide",
    });

    $("[scroll-to]").on("click", function(){
        var trgt = $(this).attr('scroll-to');
        $('html, body').animate({
            scrollTop: $(trgt).offset().top
        }, 1000);
    });

    $(".text-hidden").each(function(){
        var h = $(".text", this).height();
        var text = $(".text", this);
        if(h > 200) {
            text.height(200);
            text.attr("original-height", h);
            text.addClass("is-hidden");

            $(".read-more", this).on('click', function(){
                if(text.hasClass("is-hidden")) {
                    text.removeClass("is-hidden");
                    text.height( text.attr("original-height"));
                }
                else {
                    text.addClass("is-hidden");
                    text.height(200);
                }
            });
        }
    });

    document.addEventListener( 'wpcf7mailsent', function( event ) {
        var inputs = event.detail.inputs;
        thankyouPage = getFieldValueByName(inputs, "thankyou-page");
        if(thankyouPage) window.location = thankyouPage;
    }, false );
});

function getFieldValueByName(ar, name){
    var result = "";
    ar.forEach(function(item) {
        if(item.name == name) result = item.value;
    });
    return result;
}