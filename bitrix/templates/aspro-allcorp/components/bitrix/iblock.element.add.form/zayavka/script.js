$(document).ready(function() {
	
	function tochkiSelect() {
		var i = 0;
		$(".tochki_input").find("input").each(function() {
			i++;
			if (i <= $(".tochki :selected").html()) $(this).removeClass("hidden");
			else $(this).addClass("hidden");
		});
	}
	
	tochkiSelect();
	
	$(".tochki select").on("change", function() {
		tochkiSelect()
	});
	
	$("input[type='file']").on("change", function() {
	   $(this).parents("label").siblings("input[type='text']").val($(this).next().html());
	});
	
});