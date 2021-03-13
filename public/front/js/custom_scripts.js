
function validateEmail(email) 
{
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}
jQuery(document).ready(function($) {
    function add_header_sticky() {
        if ($(window).scrollTop() >= 50) {
            $('.header-wrapper').addClass('sticky-header');
        } else {
            $('.header-wrapper').removeClass('sticky-header');
        }
    }
    $(window).scroll(add_header_sticky);
    add_header_sticky();
    $("a.menu-bar").click(function() {
        $('body').toggleClass('menubar-show')
    });
    $(document).on('keyup', function(ev) {
        if (ev.keyCode == 27) {
            $(".menubar-show").removeClass();
        }
    });
    if($('#pf-slider').length!=0)
    {


    $('#pf-slider').owlCarousel({
        lazyLoad: true,
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        smartSpeed: 800,
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
	}
    $(document).on('click','.btnSubmit',function(){
		var isErrorFound = false;
		var formSelector = $('#inquiry_form');
		formSelector.find('.required').each(function(){
			var getval = $(this).val();
			if(getval=='')
			{
				$(this).addClass('v-error');
				isErrorFound =true;
			}
			else if($(this).attr("type") == "email"){
				if(!validateEmail($(this).val())){
					$(this).addClass('v-error');
					isErrorFound =true;
				}
				else $(this).removeClass('v-error');
			}
			else {
				$(this).removeClass('v-error');
			}
		});
		if(isErrorFound) return false;
		jQuery.ajax({
	        url: "/form_result.php",
	        data: formSelector.serialize(),
	        type: "POST",
	        success: function(data) {
	           formSelector[0].reset();
	            formSelector.hide();
	            $("#thank-you-block").show();
	            
	        },
	        error: function() {}
	    });
	})
	$(document).on('click','.tabs-head li a',function(e){
		 var c_li=  $(this).parent();
		 var get_index = c_li.index();
		   c_li.siblings().removeClass("active").end().prevAll().addClass("active").end().addClass("active ");
			$('.tabs-content .tabs-content-item').hide().eq(get_index).show();
		/*e.preventDefault();
		$(this).parent('li').addClass('current active');
		var mainSelector = $(".tabs-head li").find(".current");
		mainSelector.prevAll().addClass('active'); 
		mainSelector.nextAll().removeClass('active'); */
		
		return false;
	});
	$(document).on('click','.btnBookTrail',function(){
		var isErrorFound = false;
		var formSelector = $('#formBookTrial');
		formSelector.find('.required').each(function(){
			var getval = $(this).val();
			if(getval=='')
			{
				$(this).addClass('v-error');
				isErrorFound =true;
			}
			else if($(this).attr("type") == "email"){
				if(!validateEmail($(this).val())){
					$(this).addClass('v-error');
					isErrorFound =true;
				}
				else $(this).removeClass('v-error');
			}
			else {
				$(this).removeClass('v-error');
			}
		});
		if(isErrorFound) return false;
		jQuery.ajax({
	        url: "/form_result.php",
	        data: formSelector.serialize(),
	        type: "POST",
	        success: function(data) {
	           formSelector[0].reset();
	            //formSelector.hide();
	            var className = (data=="Message sent!") ? 'alert-success' : 'alert-danger';
	            formSelector.find(".msgResponse").addClass('alert '+className).end().html(data);
	            
	        },
	        error: function() {}
	    });
	});
});