var $ = jQuery;

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
	
	$(".link.search .button").on("click", function(e){
		$(".search-box").slideToggle();
	});
	$(".wpulike").on("click", function(e){
		e.stopPropagation();
	});
	$(".cont-like").on("click", function(e){
		e.preventDefault();
		$(this).find(".wpulike button").click();
	});
	
	$(".tabs.accordion .tab .tab-title").on("click", function(){
		var tabs = $(this).closest(".tabs");
		var tab = $(this).closest(".tab");

		$(".tab", tabs).each(function(){
			if($(this)[0] == tab[0]) {
				if($(this).hasClass("active")) {
					$(this).removeClass("active");
					$(".tab-content", this).slideUp();
				}
				else {
					$(this).addClass("active");
					$(".tab-content", this).slideDown();
				}
			} 
			else {
				$(this).removeClass("active");
				$(".tab-content", this).slideUp();
			}
		});
	});
	
	$(".sub-menu").each(function(){
		var ln = $(">li", this).length;
		if(ln > 10) $(this).addClass("cols-2");
	});

	if($(window).width() <= 950) {
		$("footer .col .title").on("click", function(e){
			e.preventDefault();
			var col = $(this).closest(".col");
			$(".content", col).slideToggle();
		});
	}


	$(".button-popup").on("click", function(e) {
		e.preventDefault();
		$(".popup").addClass("open");
	});
	$(".popup .close").on("click", function() {
		$(".popup").removeClass("open");
	});
	
	$(".bar-bottom-hotel .show-hide").on("click", function(){
		var cont = $(this).closest(".bar-bottom-hotel");
		cont.toggleClass('hidden');
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

