$(document).ready(function(){	var count = $(".js-processed-progress-bar").length;
	var j;
	var index = 0;
	function st(){		var $cur = $(".j-processed-slider-bar").eq(index);		$cur.css("transform", "translateX(" +  (- 100 * (1 - $cur.data("value"))) + "%)");
		index++;
		console.log(index);
		if(index > count-1){			clearInterval(j);		}	}
	j = setInterval(st, 1000);
});