var WI = WI || {}

WI.purchase = {
	sParam: {},
	nPage: 1,
	oPage: 1,
	nowCount: 0,
	oldCount: 0,
	init: function(){
		this.eventAdd();
		this.purChange();
		this.ulrClearQuery();
	},
	eventAdd: function(){
		$('[data-action="reset"]').click(this.purClear);
		$('[data-action="search"]').click(this.purSearch);
		$('.purchase_filter .purchase_line input').keyup(this.purSearch)
		$('body').on('click', '.wi-close', this.popupClose);
		$('body').on('click', '[data-plink]', this.purLinkSelect);
		$('body').on('click', '.purchase-pag li', this.pageChange);
	},
	purChange: function(){
		WI.purchase.sParam = {};

		$('[data-param]').each(function(i, obj){
			if ($(obj).val() != "") {
				WI.purchase.sParam[encodeURIComponent($(obj).attr('data-param'))] = encodeURIComponent($(obj).val());
			}
		});

		$.ajax({
			dataType: 'json',
			type: "POST",
			url: window.location.href,
			data: "type=purchase&json=" + JSON.stringify(WI.purchase.sParam),
			success: function(data){
				WI.purchase.purBuilder(data);
			}
		});
	},
	purSearch: function(e){
		if ($('[data-block="purchase"]').hasClass('purchase-blink'))
			return;

		if (e.type == "keyup" && e.keyCode != 13)
			return;

		WI.purchase.nPage = 1;
		WI.purchase.oPage = 1;

		$('[data-block="purchase"]').addClass('purchase-blink');

		WI.purchase.purChange();
	},
	purBuilder: function(data, type){
		WII = WI.purchase;
		var switcher = $('.purchase-switcher li span');

		if (typeof(data["NOW"]) != "undefined"/* && data["NOW"]["COUNT"] != 0*/) {
			WII.nowCount = +data["NOW"]["COUNT"];
			$('#purchase li[data-current="1"]').html("Список пуст");
			switcher.eq(0).html(data["NOW"]["COUNT"]);

			if (data["NOW"]["COUNT"] > 0) {
				$('#purchase li[data-current="1"]').html(WII.purTamplate(data["NOW"]["ELEM"]));
				var pages = WII.pageCalc(WII.nowCount);
				$('#purchase li[data-current="1"]').append(WII.paginationBuilder(pages, WII.nPage));
			}
		}

		if (typeof(data["OLD"]) != "undefined"/* && data["OLD"]["COUNT"] != 0*/) {
			WII.oldCount = +data["OLD"]["COUNT"];
			$('#purchase li[data-current="0"]').html("Список пуст");
			switcher.eq(1).html(data["OLD"]["COUNT"]);

			if (data["OLD"]["COUNT"] > 0) {
				$('#purchase li[data-current="0"]').html(WII.purTamplate(data["OLD"]["ELEM"]));
				var pages = WII.pageCalc(WII.oldCount);
				$('#purchase li[data-current="0"]').append(WII.paginationBuilder(pages, WII.oPage));
			}
		}
		
		$('[data-block="purchase"]').removeClass('purchase-blink');

		if (typeof(type) != 'undefined' && type != "ps")
			WII.switcherInit();
	},
	purTamplate: function(data) {
		var content = '';

		for (key in data) {
			var element = '';

			element += '<div class="purchase_item">'
			+ '<div class="uk-grid">'
			+ '<div class="uk-width-medium-2-10 uk-width-small-1-1 center">'
			+ '<div class="purchase_num">' + data[key]["NAME"] + '</div>'
			+ '<div class="purchase_item_date">Дата объявления:<br><span>' + data[key]["DFROM"] + '</span></div>'
			+ '<div class="purchase_item_date purchase_item_marg">Прием заявок до:<br><span>' + data[key]["DTO"] + ' МСК</span></div>'
			+ '</div>'
			+ '<div class="uk-width-medium-7-10 uk-width-small-1-1">'
			+ '<div class="purchase_item_text">' + data[key]["TEXT"] + '</div>';

			if (Object.keys(data[key]["ATTACH"]).length > 0) {
				for (att in data[key]["ATTACH"]) {

					element += '<a href="' + data[key]["ATTACH"][att]["URL"] + '" title="'
					+ data[key]["ATTACH"][att]["NAME"] + '" class="purchase_item_attachment left" target="_blank">'
					+ '<img src="' + data[key]["ATTACH"][att]["IMG"] + '">'
					+ data[key]["ATTACH"][att]["NAME"] + '<br><span>' + data[key]["ATTACH"][att]["SIZE"] + ' Мб</span>'
					+ '</a>';
				}
			}

			element += '</div>'
			+ '<div class="uk-width-medium-1-10 uk-width-small-1-1 center"><div data-plink="'
				+ encodeURI(window.location["origin"]	+ window.location["pathname"] + '?n='
					+ data[key]["NAME"]) + '" title="Ссылка на закупку"></div></div>'
			+ '</div>'
			+ '</div>' + "\n";

			content += element;
		}

		return content;
	},
	purLinkPopup: function(link) {
		$('.wi-blink').remove();

		var tamplate = '';

		tamplate += '<div class="wi-blink"><div class="wi-block purLink-popup">'
			+ '<div class="wi-popup-text">' + link + '</div>'
			+ '<div class="wi-close">&times;</div>'
			+ '</div></div>';

		$('body').prepend(tamplate);

		$('.wi-blink').css('margin-left', '-' + $('.wi-blink').width() / 2 + 'px');
		$('.wi-blink').animate({
			opacity: 1
		}, 100);
	},
	popupClose: function() {
		$(this).parents('.wi-blink').eq(0).remove();
	},
	switcherInit: function() {
		WII = WI.purchase;
		var swith = $('ul.purchase-switcher li');
		var swithCont = $('#purchase li[data-current]');
		
		if (WII.nowCount > 0) {
			$(swith).eq(0).attr('aria-expanded', 'true').addClass('uk-active');
			$(swithCont).eq(0).attr('aria-hidden', 'false').attr('style', 'animation-duration: 200ms;').addClass('uk-active');
			$(swith).eq(1).attr('aria-expanded', 'false').removeClass('uk-active');
			$(swithCont).eq(1).attr('aria-hidden', 'true').removeClass('uk-active');
			return;
		} else if (WII.oldCount > 0) {
			$(swith).eq(0).attr('aria-expanded', 'false').removeClass('uk-active');
			$(swithCont).eq(0).attr('aria-hidden', 'true').removeClass('uk-active');
			$(swith).eq(1).attr('aria-expanded', 'true').addClass('uk-active');
			$(swithCont).eq(1).attr('aria-hidden', 'false').attr('style', 'animation-duration: 200ms;').addClass('uk-active');
			return;
		}
	},
	purLinkSelect: function() {
		WI.purchase.purLinkPopup($(this).attr('data-plink'));
	},
	inputParamBuilder: function(arValue) {
		var tamplate = '';

		if (typeof(arValue) == "object") {
			for (key in arValue) {
				tamplate += '<option value="' + arValue[key]["ID"] + '">' + arValue[key]["NAME"] + '</option>' + "\n";
			}

			$('[data-param="PROPERTY_TYPE"]').append(tamplate);
		}

	},
	purClear: function(){
		$('[data-param]').val('');
		$('[data-param="PROPERTY_TYPE"]')
			.val($('[data-param="PROPERTY_TYPE"] option').eq(0).attr('value'));
	},
	pageCalc: function(elems){
		return Math.ceil(+elems / WI.IBParam["COUNT"]);
	},
	paginationBuilder: function(pages, curPage){
		if (pages <= 1)
			return;

		var start = +curPage - 2;
		var counter = 0;

		if (start <= 0)
			start = 1;

		if (curPage + 2 > pages && pages > 5)
			start = +curPage - (curPage + 2 - pages) - 2;

		var tamplate = '';
		tamplate += '<div class="uk-grid purchase-pag">'
			+ '<div class="uk-width-1-1">'
				+ '<ul class="uk-pagination spagination">';

				if (curPage > 1 && pages > 5)
					tamplate += '<li data-page="1" class="spfirst"><a href="#">Первая</a></li>';

						for (start; start <= pages; start++) {
							if (counter == 5)
								break;

								tamplate += '<li data-page="' + start + '" '
									+ (start == curPage ? 'class="spactive">' + start + '</li>'
										: '><a href="#">' + start + '</a></li>');

							counter++;
						}

				if (curPage < pages && pages > 5)
					tamplate += '<li data-page="' + pages + '" class="splast"><a href="#">Последняя</a></li>';

				tamplate += '</ul>'
			+ '</div>'
		+ '</div>' + "\n";

		return tamplate;
	},
	pageChange: function(e) {
		WII = WI.purchase;

		if ($(this).hasClass('spactive'))
			return;

		$('[data-block="purchase"]').addClass('purchase-blink');

		if ($(this).parents('li[data-current="1"]').length > 0) {
			var pages = WII.pageCalc(WII.nowCount);
			WII.nPage = +$(this).attr('data-page');
			$('#purchase li[data-current="1"]').find('.purchase-pag').remove();
			$('#purchase li[data-current="1"]').append(WII.paginationBuilder(pages, WII.nPage));

			$.ajax({
				dataType: 'json',
				type: "POST",
				url: window.location.href,
				data: "type=purchase&json=" + JSON.stringify(WI.purchase.sParam)
					+ "&page=" + WII.nPage
					+ "&param=NOW",
				success: function(data){
					WI.purchase.purBuilder(data, "ps");
				}
			});

		} else {
			var pages = WII.pageCalc(WII.oldCount);
			WII.oPage = +$(this).attr('data-page');
			$('#purchase li[data-current="0"]').find('.purchase-pag').remove();
			$('#purchase li[data-current="0"]').append(WII.paginationBuilder(pages, WII.oPage));

			$.ajax({
				dataType: 'json',
				type: "POST",
				url: window.location.href,
				data: "type=purchase&json=" + JSON.stringify(WI.purchase.sParam)
					+ "&page=" + WII.oPage
					+ "&param=OLD",
				success: function(data){
					WI.purchase.purBuilder(data, "ps");
				}
			});
		}

		e.preventDefault();
	},
	urlParse: function() {
		if (window.location["search"].length == 0)
			return false;

		var arRparam = {};
		var arReques = window.location["search"].substr(1).split('&');
		
		for (key in arReques) {
			arRparam[arReques[key].split('=')[0]] = arReques[key].split('=')[1];
		}

		return arRparam;
	},
	ulrClearQuery: function() {
		history.pushState('', '', window.location["pathname"]);
		return false;
	}
}

$(document).ready(function(){
	WI.purchase.init();



});