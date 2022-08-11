/* Add here all your JS customizations */

$( document ).ready(function() {

    // $('body').on('hover', 'tr.char', function(){
    //     $(this).find('.icons').focus();
    // });

    // $('body').on('blur', 'tr.char', function(){
    //     $(this).find('.icons').blur();
    // });
    // $('tr.char').hover(
    //     function(){
    //         $(this).find('.icons').mouseenter();
    //         console.log('навели');
    //         },
    //     function(){
    //         $(this).find('.icons').mouseleave();
    //         console.log('вывели');
    // });

	localStorage.removeItem("compareEl");
	localStorage.removeItem("compareElAfterCompare");

	var filter = $('.filter-catalog-main .filter_catalog');

	filter.find('input').on('input', function() {
		var element = $('.filter_catalog');
		var data_filter = parseForm(element);

		var displayNoneAr = checkDisplayNoneCeil();

		var params = new Object();

		var curCompElsAfter = getCurCompElsAfterCompare();

		params['arParams']      = arParams;
		params['data_filter']   = data_filter;
		params['displayNoneAr'] = displayNoneAr;
		params['curCompEls']    = curCompElsAfter;

		ajaxFilterResult(params);
	});

	$('body').on('click', '.filter_catalog .arrows_sort', function() {
		var statusSort = $(this).attr('data-status-sort');

		if(statusSort === 'desc') {
			var numberSort = 0;
		} else {
			var numberSort = getNumberSort();
		}

		$(this).attr('data-number-sort', numberSort);

		switch(statusSort) {
			case 'asc':
				$(this).attr('data-status-sort', 'desc');
				$(this).attr('src', '/images/arrow_desc.png');
				break;
			case 'desc':
				$(this).attr('data-status-sort', 'none');
				$(this).attr('src', '/images/arrows.png');
				break;
			case 'none':
				$(this).attr('data-status-sort', 'asc');
				$(this).attr('src', '/images/arrow_asc.png');
				break;
		}

		var element = $('.filter_catalog');
		var data_filter = parseForm(element);

		var displayNoneAr = checkDisplayNoneCeil();
		var sortAr = getSortAr();
		var curCompElsAfter = getCurCompElsAfterCompare();

		var params = new Object();

		params['arParams']      = arParams;
		params['data_filter']   = data_filter;
		params['displayNoneAr'] = displayNoneAr;
		params['sortAr']        = sortAr;
		params['curCompEls']    = curCompElsAfter;

		ajaxFilterResult(params);
	});

	$('body').on('click', '.select-outer .select_open', function() {
		var _thisItems = $(this).parents('.select-outer').find('.items');
		var display = _thisItems.css('display');

		if (display == 'none') {
			_thisItems.animate({height: 'show'}, 400);
		} else {
			_thisItems.animate({height: 'hide'}, 400);
		}
	});

	$('body').on('click', '.checkbox-table-filter input[type=checkbox]', function() {
		var _this = $(this);
		var _thisParent = $(this).parents('.items');

		if ($(this).val() === 'all') {
			var checkedAll = $(this).prop('checked');

			$.each(_thisParent.find('input[value!=all]'), function() {
				$(this).prop('checked', checkedAll);
			});
		} else {
			var checkedAll = true;
			$.each(_thisParent.find('input[value!=all]'), function() {
				if(!$(this).prop('checked')) {
					checkedAll = false;
				}
			});

			_thisParent.find('input[value=all]').prop('checked', false);
		}
	});

	$('body').on('click', '.reset_filter .reset', function() {
		var params = new Object();
		params['arParams'] = arParams;

		ajaxFilterResult(params);

		$('.ceil-table').css({'display': 'inline-block'});

		$.each(filter.find('input'), function() {

			switch($(this).data('display')) {
				case 'less':
				case 'more':
				case 'key':
				case 'range':
					$(this).val('');
					break;
				case 'list':
					$(this).prop('checked', true);
					break;
				// case 'range':
					// var startValue = $(this).data('start-value');
					// $(this).val(startValue);
					// break;
			}
		});

		filter.find('.bx_filter_parameters_box').css({'display':'inline-block'});

		$('.arrows_sort').attr('data-number-sort', 0);
		$('.arrows_sort').attr('data-status-sort', 'none');
		$('.arrows_sort').attr('src', '/images/arrows.png');

		$('.compare').removeClass('active');

		localStorage.removeItem("compareElAfterCompare");
	});

	$('body').on('click', '.btn_hide_element', function() {
		var propsCode = $(this).data('code-hide');

		$.each(propsCode, function(index, el) {
			$('.bx_filter_parameters_box[data-prop-code='+el+']').hide();
			$('.ceil-table[data-prop-code='+el+']').hide();
		});
	});

	if($(".row_filter").length > 0) {
	  	var target = $('.row_filter');
		var scrollToElem = target.offset().top;
		var winHeight = $(window).height();

		$(window).scroll(function() {
	  		var winScrollTop = $(this).scrollTop();

	  		calcFilterHeight();

		  	if(winScrollTop > scrollToElem) {
		  		target.css({'position' : 'fixed', 'top' : '0'});
		  		$('.filter-catalog-main .bx_filter_parameters_box:first-child').css({'position' : 'fixed', 'top' : '35px'});
		  		$('.filter-catalog-main .bx_filter_section').css({'margin-left' : marginLeftFilterHead+'px'});
		  		$('.new-list-table').css({'padding-top' : target.height()+20+'px'});

  				$('.reset_filter').css({'top': '0px', 'position' : 'fixed'});
  				$('.info_show').css({'top': '170px', 'position' : 'fixed'});
				$('.filter-catalog-main').css({'margin-top' : '26px', 'padding-bottom' : '20px'});
		  	}

		  	if(winScrollTop < scrollToElem) {
		  		target.css({'position' : 'sticky'});
		  		$('.filter-catalog-main .bx_filter_parameters_box:first-child').css({'position' : 'sticky', 'top' : '0px'});
		  		$('.filter-catalog-main .bx_filter_section').css({'margin-left' : '0px'});
		  		$('.new-list-table').css({'padding-top' : '0'});

  				$('.info_show').css({'top': '170px', 'position' : 'sticky'});
  				$('.reset_filter').css({'top': '0px', 'position' : 'sticky'});
				$('.filter-catalog-main').css({'margin-top' : '0px', 'padding-bottom' : '0px'});
		  	}
		});
	}

	$('body').on('click', '.compare_input', function() {
		var curCompEls = getCurCompEls();
		var idEl = $(this).data('id');

		if($(this).prop("checked")) {
			curCompEls.push(idEl);
		} else {
			$.each(curCompEls, function(i, el) {
				if(el == idEl) {
					curCompEls.splice(i, 1);
				}
			});
		}

		localStorage.setItem('compareEl', JSON.stringify(curCompEls));

		if(curCompEls.length >= 2) {
			$('.compare').addClass('active');
		} else {
			$('.compare').removeClass('active');
		}
	});

	$('body').on('click', '.compare.active', function() {
		var curCompEls = getCurCompEls();

		var element = $('.filter_catalog');
		var data_filter = parseForm(element);

		var displayNoneAr = checkDisplayNoneCeil();
		var sortAr = getSortAr();

		var params = new Object();

		params['arParams']      = arParams;
		params['displayNoneAr'] = displayNoneAr;
		params['sortAr']        = sortAr;
		params['curCompEls']    = curCompEls;

		ajaxFilterResult(params);
		localStorage.setItem('compareElAfterCompare', JSON.stringify(curCompEls));
		localStorage.removeItem("compareEl");

		$('.compare').removeClass('active');
	});

	$('.table-filter-container').scroll(function() {
		var scroll = $(this).scrollLeft();
		$('.row_filter').css({'left' : '-'+scroll+'px'});
	});

	$('body').on('click', '.filter-catalog-pag a', function(e) {
		e.preventDefault();

		var element = $('.filter_catalog');
		var data_filter = parseForm(element);

		var displayNoneAr = checkDisplayNoneCeil();
		var sortAr = getSortAr();

		var params = new Object();

		params['arParams']      = arParams;
		params['data_filter']   = data_filter;
		params['displayNoneAr'] = displayNoneAr;
		params['sortAr']        = sortAr;
		params['page']          = $(this).attr('data-number-page');

		ajaxFilterResult(params);
	});

	if(filter.length > 0) {
		updateCountEl();
		calcFilterHeight();
	}
});

function getCurCompElsAfterCompare() {
	var curCompElsAfter = JSON.parse(localStorage.getItem('compareElAfterCompare'));

	if(curCompElsAfter === null) {
		var curCompElsAfter = [];
	}

	return curCompElsAfter;
}

function getCurCompEls() {
	var curCompEls = JSON.parse(localStorage.getItem('compareEl'));

	if(curCompEls === null) {
		var curCompEls = [];
	}

	return curCompEls;
}

function updateCountEl() {
    if($(cur_el).attr('id') == 'cur_el') {
        cur_el = $(cur_el).text();
    }

    if($(all_el).attr('id') == 'all_el') {
        all_el = $(all_el).text();
    }

	$('.cur_count').text(cur_el);
	$('.all_count').text(all_el);
}

function calcFilterHeight() {
	var targetAll = $('.table-filter-container');
  	var scrollToElemAll = targetAll.offset().top; // расстояние до фильтра

  	var winScrollTop = $(this).scrollTop(); // насколько просскролено

	var heightFilter = window.innerHeight-(scrollToElemAll-winScrollTop);

	if(window.pagination_filter !== undefined) {
		heightFilter = Number(heightFilter) - 69; // старое значение 47
	} else {
		heightFilter = Number(heightFilter) - 22;
	}

	if(heightFilter < window.innerHeight) {
		targetAll.css({'height': heightFilter+'px'});
	} else {
		targetAll.css({'height': '100vh'});
	}
}

function ajaxFilterResult(params) {
	var arParams = params.arParams;
	var data_filter = params.data_filter;
	var displayNoneAr = params.displayNoneAr;
	var sortAr = params.sortAr;
	var page = params.page;
	var curCompEls = params.curCompEls;

	if(page !== undefined) {
		var strPagen = '?PAGEN_1='+page;
	} else {
		var strPagen = '';
	}

	$.ajax({
		url: "/ajax/ajax_filter.php"+strPagen,
		type: 'post',
		data: { arParams:arParams, data_filter:data_filter, displayNoneAr:displayNoneAr, sortAr:sortAr, curCompEls:curCompEls},
		dataType: 'html',
		success: function(html) {
			var htmlNeedly = $(html).filter('.new-list-table').html();
			var htmlPag = $(html).filter('.filter-catalog-pag').html();
			$('.new-list-table').html(htmlNeedly);
			$('.filter-catalog-pag').html(htmlPag);

			var display_none_count = $(html).filter('.display_none_count').html();
			if(display_none_count !== undefined) {
				display_none_count = display_none_count.trim();
			}
			var cur_el = $(display_none_count).filter('#cur_el').html();
			var all_el = $(display_none_count).filter('#all_el').html();

			$('.cur_count').text(cur_el);
			$('.all_count').text(all_el);

			var curCompEls = getCurCompEls();

			$.each($('.compare_input'), function() {
				var idEl = $(this).data('id');
				if(curCompEls.indexOf(idEl) != -1) {
					$(this).attr("checked","checked");
				}
			});
		}
	});
}

function parseForm(element) {
	var type_inputs = ['select', 'input'];
	var data_filter = new Object();

	$.each(type_inputs, function(index, el) {
		$.each(element.find(el), function(index, el) {
			var val_input    = $(el).val();
			var name_input   = $(el).attr('name');
			var display_type = $(el).data('display');

			if (display_type == 'range') {
				var pair = $(el).data('pair');

				var min = $('input[name='+pair+'_MIN]').val();
				var max = $('input[name='+pair+'_MAX]').val();

				data_filter[pair] = {'val' : {'min' : min, 'max' : max}, 'display_type' : display_type};
			} else if(display_type == 'list') {
				var parentItems = $(el).parents('.select-outer').find('.items');

				var arrayValue = new Array();
				$.each(parentItems.find('input'), function() {
					if ($(this).prop('checked')) {
						arrayValue.push($(this).val());
					}
				});

				if(arrayValue.indexOf( 'all' ) === -1) {
					data_filter[name_input] = {'val' : arrayValue, 'display_type' : display_type};
				}
			} else {
				data_filter[name_input] = {'val' : val_input, 'display_type' : display_type};
			}
		});
	});

	return data_filter;
}


function checkDisplayNoneCeil() {
	var displayNoneAr = new Array();
	$('.bx_filter_parameters_box').each(function(i, el) {
		var display = $(el).css('display');

		if(display == 'none') {
			var name_prop = $(el).data('prop-code');
			displayNoneAr.push(name_prop);

			if($(el).data('child').length > 0) {
				var childs = $(el).data('child').split(' ');

				$.each(childs, function(e, el) {
					if(el.length > 0 ) {
						displayNoneAr.push(el);
					}
				});
			}
		}
	});

	return displayNoneAr;
}

function getNumberSort() {
	var maxNum = 0;
	$('.arrows_sort').each(function() {
		var number = $(this).attr('data-number-sort');
		var number = Number(number);

		if(maxNum < number) {
			maxNum = number;
		}
	});

	return Number(maxNum)+1;
}

function getSortAr() {
	var arSort = new Array();
	$.each($('.arrows_sort'), function(i, el) {
		var number = Number($(this).attr('data-number-sort'));
		var code = $(this).attr('data-prop-code');
		var direction = $(this).attr('data-status-sort');

		if(number != 0) {
			var oEl = new Object;
			oEl.number = number;
			oEl.index = i;
			oEl.code = code;
			oEl.direction = direction;

			arSort.push(oEl);
		}
	});

    for (var i = 0; i < arSort.length; i++) {
        for (var j = i + 1; j < arSort.length; j++) {
            if (arSort[i]['number'] > arSort[j]['number']) {
                var temp = arSort[j];
                arSort[j] = arSort[i];
                arSort[i] = temp;
            }
        }
    }

	$.each(arSort, function(i, el) {
		$('.arrows_sort:eq('+el.index+')').attr('data-number-sort', el.number);
	});

	return arSort;
}
