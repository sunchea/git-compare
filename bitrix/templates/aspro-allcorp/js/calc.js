$(document).on("click", ".js-processed-calc", function(){
	var price_per_kW = 0;

	if(declared_power > 0){
			$.each(JOINING_TARRIFS[1].power_levels, function(key, val){
					price_per_kW = val;
				}
			});
		}
			$(".cost").slideDown(500);
		}
	}else{
})