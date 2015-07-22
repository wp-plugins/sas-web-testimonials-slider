jQuery(document).ready(function ($) {          
    
	var mode = SASWEB_Testimonials.transition_type,
		slideMargin = SASWEB_Testimonials.slideMargin,
		speed = SASWEB_Testimonials.slide_transition,
		startSlide = SASWEB_Testimonials.slide_index,
		randomStart = SASWEB_Testimonials.start_slider_random,
		infiniteLoop = SASWEB_Testimonials.infinite_loop,
		hideControlOnEnd = SASWEB_Testimonials.hide_control_on_end;

	//set up default mode
	if(mode === 'horizontal' ||  mode === 'vertical' || mode==='fade') 
	{
		mode = mode;
	}
	else
	{
		mode = 'horizontal';
	}
	//set up default speed
	if(parseInt(speed) >= 0 )
	{
		speed = speed;
	}
	else
	{
		speed = 500;
	}

	//default slide margin
	if(parseInt(slideMargin) >=0)
	{
		slideMargin = slideMargin;
	}else{
		slideMargin = 0;
	}
	//default start slide
	if(startSlide >= 0)
	{
		startSlide = startSlide;
	}
	else{
		startSlide =0;
	}

	randomStart = (randomStart === 0)? 'false' : 'true';
	infiniteLoop = (infiniteLoop === 0)? 'false' : 'true';
	hideControlOnEnd = (hideControlOnEnd === 0)? 'false' : 'true';


    $('.bxslider').bxSlider({
        mode: mode,
        slideMargin: slideMargin,
        auto:true,
        speed: speed,
        randomStart:randomStart,
        infiniteLoop:infiniteLoop,
        hideControlOnEnd:hideControlOnEnd
    });
            
});
