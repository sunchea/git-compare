$(document).on("click", ".js-processed-calc", function(){	var declared_power = parseInt($("#declared_power").val());
	var price_per_kW = 0;
	console.log(JOINING_TARRIFS);
	if(declared_power > 0){		$(".power_error").hide();		if($("#lvl2").prop("checked")){			//если выбран второй (высокий) уровень напряжения
			$.each(JOINING_TARRIFS[1].power_levels, function(key, val){				if(eval(declared_power+key) && price_per_kW == 0){					price_per_kW = val;					return true;				}			});		}else{			//если выбран первый (низкий) уровень напряжения			$.each(JOINING_TARRIFS[0].power_levels, function(key, val){				if(eval(declared_power+key) && price_per_kW == 0){
					price_per_kW = val;
				}
			});
		}		if(price_per_kW > 0){			var total_cost = declared_power * price_per_kW;			$(".total_cost").html(total_cost.toFixed(2));
			$(".cost").slideDown(500);
		}
	}else{		$(".cost").hide();		$(".power_error").slideDown(500);	}
})