$(document).ready(function(){
	$('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 130,
		itemMargin: 10,
		asNavFor: '#slider'
	});
   
	$('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		touch: true,
		animationLoop: false,
		slideshow: false,
		sync: "#carousel"
	});
	setTimeout(function(th){
		$('#slider.flexslider li').each(function(){
			var height = $(this).parent().height();
			if(height > 3){
				$(this).css('line-height', (height - 3) + 'px');
			}
		})
	},100);
})