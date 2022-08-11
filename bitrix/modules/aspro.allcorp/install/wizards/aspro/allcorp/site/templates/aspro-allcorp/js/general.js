CheckTopMenuDotted = function(){
	var menu = $('nav.mega-menu');
	var menuMoreItem = menu.find('td.js-dropdown');
	if(menu.parents('.collapse').css('display') == 'none'){
		return false;
	}
	
	var block_w = menu.closest('div').actual('width');
	var	menu_w = menu.find('table').actual('outerWidth');
	var afterHide = false;
	
	while(menu_w > block_w) {
		menuItemOldSave = menu.find('td').not('.nosave').last();
		if(menuItemOldSave.length){
			menuMoreItem.show();
			menuItemNewSave = '<li class="' + (menuItemOldSave.hasClass('dropdown') ? 'dropdown-submenu ' : '') + (menuItemOldSave.hasClass('active') ? 'active ' : '') + '" data-hidewidth="' + menu_w + '">' + menuItemOldSave.find('.wrap').html() + '</li>';
			menuItemOldSave.remove();
			menuMoreItem.find('> .wrap > .dropdown-menu').prepend(menuItemNewSave);
			menu_w = menu.find('table').actual('outerWidth');
			afterHide = true;
		}
		else{
			break;
		}
	}
	
	if(!afterHide) {
		do {
			var menuItemOldSaveCnt = menuMoreItem.find('.dropdown-menu').find('li').length;
			menuItemOldSave = menuMoreItem.find('.dropdown-menu').find('li').first();
			if(!menuItemOldSave.length) {
				menuMoreItem.hide();
				break;
			}
			else {
				var hideWidth = menuItemOldSave.attr('data-hidewidth');
				if(hideWidth > block_w) {
					break
				}
				else {
					menuItemNewSave = '<td class="' + (menuItemOldSave.hasClass('dropdown-submenu') ? 'dropdown ' : '') + (menuItemOldSave.hasClass('active') ? 'active ' : '') + '" data-hidewidth="' + block_w + '"><div class="wrap">' + menuItemOldSave.html() + '</div></td>';
					menuItemOldSave.remove();
					$(menuItemNewSave).insertBefore(menu.find('td.js-dropdown'));
					if(!menuItemOldSaveCnt) {
						menuMoreItem.hide();
						break;
					}
				}
			}
			menu_w = menu.find('table').actual('outerWidth');
		}
		while(menu_w <= block_w);
	}
	
	menu.find('td').css('visibility', 'visible');
	
	return false;
}

CheckTopVisibleMenu = function(that) {
	var dropdownMenu = $('.dropdown-menu:visible').last();
	if(dropdownMenu.length){
		var isMenuType1 = arAllcorpOptions['THEME']['MENU'] = 'first';
		dropdownMenu.find('a').css('white-space', '');
		dropdownMenu.css('left', '');
		dropdownMenu.css('right', '');
		dropdownMenu.removeClass('toright');
		if(isMenuType1){
			dropdownMenu.css('margin-left', '');
		}

		var dropdownMenu_left = dropdownMenu.offset().left;
		if(typeof(dropdownMenu_left) != 'undefined'){
			var menu = dropdownMenu.parents('.mega-menu');
			var menu_width = menu.outerWidth();
			var menu_left = menu.offset().left;
			var menu_right = menu_left + menu_width;
			var isToRight = dropdownMenu.parents('.toright').length > 0;
			var parentsDropdownMenus = dropdownMenu.parents('.dropdown-menu');
			var isHasParentDropdownMenu = parentsDropdownMenus.length > 0;
			if(isHasParentDropdownMenu){
				var parentDropdownMenu_width = parentsDropdownMenus.first().outerWidth();
				var parentDropdownMenu_left = parentsDropdownMenus.first().offset().left;
				var parentDropdownMenu_right = parentDropdownMenu_width + parentDropdownMenu_left;
			}
			var addleft = 0;

			if(parentDropdownMenu_right + dropdownMenu.outerWidth() > menu_right){
				dropdownMenu.find('a').css('white-space', 'normal');
			}
			
			if(isMenuType1 && !isHasParentDropdownMenu){
				var punktMenu = dropdownMenu.parents('td');
				if((dropdownMenu.outerWidth() < punktMenu.outerWidth()) || punktMenu.index() > 0){
					//dropdownMenu.css("left", "50%");
					//dropdownMenu.css("margin-left", "-" + Math.floor(dropdownMenu.outerWidth() / 2) + "px");
					dropdownMenu_left = dropdownMenu.offset().left;
				}
			}
			
			var dropdownMenu_width = dropdownMenu.outerWidth();
			var dropdownMenu_right = dropdownMenu_left + dropdownMenu_width;
			
			if(dropdownMenu_right > menu_right || isToRight){
				addleft = menu_right - dropdownMenu_right;
				if(isHasParentDropdownMenu || isToRight){
					dropdownMenu.css('left', 'auto');
					dropdownMenu.css('right', '100%');
					dropdownMenu.addClass('toright');
				}
				else{
					var dropdownMenu_curLeft = parseInt(dropdownMenu.css('left'));
					dropdownMenu.css('left', (dropdownMenu_curLeft + addleft) + 'px');
				}
			}
		}
	}
}

CheckPopupTop = function(){
	var popup = $('.jqmWindow.show');
	if(popup.length){
		var documentScollTop = $(document).scrollTop();
		var windowHeight = $(window).height();
		var popupTop = parseInt(popup.css('top'));
		var popupHeight = popup.height();
		if((documentScollTop < popupTop) || (documentScollTop > (popupTop + popupHeight))){
			popupTop = documentScollTop + ((windowHeight > popupHeight) ? (windowHeight - popupHeight) / 2 : 0);
			popup.css('top', popupTop + 'px');
		}
	}
}

CheckStickyFooter = function() {
	$(window).resize(function() { //  BX.addCustomEvent('onWindowResize', function(eventdata) {
		try{
			var footerHeight = $('footer').outerHeight();
			ignoreResize.push(true);
			$('footer').css('margin-top', '-' + footerHeight + 'px');
			$('.body').css('margin-bottom', '-' + footerHeight + 'px');
			$('.main[role=main]').css('padding-bottom', footerHeight + 25 + 'px');
			ignoreResize.pop();
		}
		catch(e){}
	});
}

/*
getGridSize = function(counts) {
	var z = parseInt($('.body_media').css('top'));
	return (z == 2 ? counts[0] : z == 1 ? counts[1] : counts[2]);
}

CheckFlexSlider = function(){
	$('.flexslider:not(.thmb)').each(function(){
		var slider = $(this);
		slider.resize();
		var counts = slider.data('flexslider').vars.counts;
		if(typeof(counts) != 'undefined'){
			var cnt = getGridSize(counts);
			var to0 = (cnt != slider.data('flexslider').vars.minItems || cnt != slider.data('flexslider').vars.maxItems || cnt != slider.data('flexslider').vars.move);
			if(to0){
				slider.data('flexslider').vars.minItems = cnt;
				slider.data('flexslider').vars.maxItems = cnt;
				slider.data('flexslider').vars.move = cnt;
				slider.flexslider(0);
				slider.resize();
				slider.resize(); // twise!
			}
		}
	});
}
*/

scrollToTop = function(){
	var _isScrolling = false;
	// Append Button
	$('body').append($('<a />').addClass('scroll-to-top').attr({'href': '#', 'id': 'scrollToTop'}).append($('<i />').addClass('fa fa-chevron-up fa-white')));
	$('#scrollToTop').click(function(e){
		e.preventDefault();
		$('body, html').animate({scrollTop : 0}, 500);
		return false;
	});
	// Show/Hide Button on Window Scroll event.
	$(window).scroll(function(){
		if(!_isScrolling) {
			_isScrolling = true;
			if( $(window).scrollTop() > 150 ){
				$('#scrollToTop').stop(true, true).addClass('visible');
				_isScrolling = false;
			}else{
				$('#scrollToTop').stop(true, true).removeClass('visible');
				_isScrolling = false;
			}
		}
	});
}

$.fn.equalizeHeights = function( outer ){
	var maxHeight = this.map( function( i, e ){
		$(e).css('height', '');
		if( outer == true ){
			return $(e).actual('outerHeight');
		}else{
			return $(e).actual('height');
		}
	}).get();

	for(var i = 0, c = maxHeight.length; i < c; ++i){
		if(maxHeight[i] % 2){
			--maxHeight[i];
		}
	}
	
	return this.height( Math.max.apply( this, maxHeight ) );
}

$.fn.sliceHeight = function( options ){
	function _slice(el){
		el.each(function() {
			$(this).css('line-height', '');
			$(this).css('height', '');
		});
		if(typeof(options.autoslicecount) == 'undefined' || options.autoslicecount !== false){
			var elw = (el.first().hasClass('item') ? el.first().outerWidth() : el.first().parents('.item').outerWidth());
			var elsw = el.first().parents('.items').outerWidth();
			if(!elsw){
				elsw = el.first().parents('.row').outerWidth();
			}
			if(elsw && elw){
				options.slice = Math.floor(elsw / elw);
			}
		}
		if(options.slice){
			for(var i = 0; i < el.length; i += options.slice){
				$(el.slice(i, i + options.slice)).equalizeHeights(options.outer);
			}
		}
		if(options.lineheight){
			var lineheightAdd = parseInt(options.lineheight);
			if(isNaN(lineheightAdd)){
				lineheightAdd = 0;
			}
			el.each(function() {
				$(this).css('line-height', ($(this).actual('height') + lineheightAdd) + 'px');
			});
		}
	}
	
	var options = $.extend({
		slice: null,
		outer: false,
		lineheight: false,
		autoslicecount: true
	}, options);
	
	var el = $(this);
	_slice(el);
	
	BX.addCustomEvent('onWindowResize', function(eventdata) {
		ignoreResize.push(true);
		_slice(el);
		ignoreResize.pop();
	});
}

waitingExists = function(selector, delay, callback){
	if(typeof(callback) !== 'undefined' && selector.length && delay > 0){
		delay = parseInt(delay);
		delay = (delay < 0 ? 0 : delay);
		
		if(!$(selector).length){
			setTimeout(function(){
				waitingExists(selector, delay, callback);
			}, delay);
		}
		else{
			callback();
		}
	}
}

waitingNotExists = function(selectorExists, selectorNotExists, delay, callback){
	if(typeof(callback) !== 'undefined' && selectorExists.length && selectorNotExists.length && delay > 0){
		delay = parseInt(delay);
		delay = (delay < 0 ? 0 : delay);

		setTimeout(function(){
			if(selectorExists.length && !$(selectorNotExists).length){
				callback();
			}
		}, delay);
	}
}

function onLoadjqm(hash){
	var name = $(hash.t).data('name'), top = $(document).scrollTop() + (($(window).height() > hash.w.height()) ? Math.floor(($(window).height() - hash.w.height()) / 2) : 0) + 'px';
	$.each($(hash.t).get(0).attributes, function(index, attr){
		if(/^data\-autoload\-(.+)$/.test(attr.nodeName)){
			var key = attr.nodeName.match(/^data\-autoload\-(.+)$/)[1];
			var el = $('input[name="'+key.toUpperCase()+'"]');
			el.val( $(hash.t).data('autoload-'+key) ).attr('readonly', 'readonly');
			el.attr('title', el.val());
		}
	});
	if($(hash.t).data('autohide')){
		$(hash.w).data('autohide', $(hash.t).data('autohide'));
	}
	if(name == 'order_product'){
		if($(hash.t).data('product')) {
			$('input[name="PRODUCT"]').val($(hash.t).data('product')).attr('readonly', 'readonly').attr('title', $('input[name="PRODUCT"]').val());
		}
	}
	if(name == 'question'){
		if($(hash.t).data('product')) {
			$('input[name="NEED_PRODUCT"]').val($(hash.t).data('product')).attr('readonly', 'readonly').attr('title', $('input[name="NEED_PRODUCT"]').val());
		}
	}
	hash.w.addClass('show').css({'margin-left': '-' + Math.floor(hash.w.width() / 2) + 'px', 'top': top, 'opacity': 1});
}

function onHide(hash){
	if($(hash.w).data('autohide')){
		eval($(hash.w).data('autohide'));
	}
	hash.w.css('opacity', 0).hide();
	hash.w.empty();
	hash.o.remove();
	hash.w.removeClass('show');
}

$.fn.jqmEx = function(){
	$(this).each(function(){
		var _this = $(this);
		var name = _this.data('name');

		if(name.length){
			var script = arAllcorpOptions['SITE_DIR'] + 'ajax/form.php';
			var paramsStr = ''; var trigger = ''; var arTriggerAttrs = {};
			$.each(_this.get(0).attributes, function(index, attr){
				var attrName = attr.nodeName;
				var attrValue = _this.attr(attrName);
				trigger += '[' + attrName + '=\"' + attrValue + '\"]';
				arTriggerAttrs[attrName] = attrValue;
				if(/^data\-param\-(.+)$/.test(attrName)){
					var key = attrName.match(/^data\-param\-(.+)$/)[1];
					paramsStr += key + '=' + attrValue + '&';
				}
			});
			
			var triggerAttrs = JSON.stringify(arTriggerAttrs);
			var encTriggerAttrs = encodeURIComponent(triggerAttrs);
			script += '?' + paramsStr + 'data-trigger=' + encTriggerAttrs;

			if(!$('.' + name + '_frame[data-trigger="' + encTriggerAttrs + '"]').length){
				if(_this.attr('disabled') != 'disabled'){
					$('body').find('.' + name + '_frame[data-trigger="' + encTriggerAttrs + '"]').remove();
					$('body').append('<div class="' + name + '_frame jqmWindow" style="width:500px" data-trigger="' + encTriggerAttrs + '"></div>');
					$('.' + name + '_frame[data-trigger="' + encTriggerAttrs + '"]').jqm({trigger: trigger, onLoad: function(hash){onLoadjqm(hash);}, onHide: function(hash){onHide(hash);}, ajax:script});
				}
			}
		}
	})
}

InitFlexSlider = function() {
	$('.flexslider:not(.thmb):not(.flexslider-init)').each(function(){
		var slider = $(this);
		var options;
		var defaults = {
			animationLoop: false,
			controlNav: false,
			directionNav: true
		}
		var config = $.extend({}, defaults, options, slider.data('plugin-options'));
		/*if(typeof(config.counts) != 'undefined'){
			config.maxItems =  getGridSize(config.counts);
			config.minItems = getGridSize(config.counts);
			config.move = getGridSize(config.counts);
			config.itemWidth = 200;
		}*/
		config.after = config.start = function(slider){
			var eventdata = {slider: slider};
			BX.onCustomEvent('onSlide', [eventdata]);
		}
		
		slider.flexslider(config).addClass('flexslider-init');
		if(config.controlNav)
			slider.addClass('flexslider-control-nav');
		if(config.directionNav)
			slider.addClass('flexslider-direction-nav');
	});
}

$(document).ready(function(){
	//scrollToTop();
	CheckStickyFooter();
	CheckTopMenuDotted();
	setTimeout(function() {$(window).resize();}, 350); // need to check resize flexslider & menu
	$(window).scroll();
	
	/*waitingNotExists('#bx-composite-banner .bx-composite-btn', '#footer .col-sm-3.hidden-md.hidden-lg #bx-composite-banner .bx-composite-btn', 500, function() {
		$('#footer .col-sm-3.hidden-md.hidden-lg #bx-composite-banner').html($('#bx-composite-banner .bx-composite-btn').parent().html());
	});*/

	$.extend( $.validator.messages, {
		required: BX.message('JS_REQUIRED'),
		email: BX.message('JS_FORMAT'),
		equalTo: BX.message('JS_PASSWORD_COPY'),
		minlength: BX.message('JS_PASSWORD_LENGTH'),
		remote: BX.message('JS_ERROR'),
	});

	$.validator.addMethod(
		'regexp', function(value, element, regexp){
			var re = new RegExp(regexp);
			return this.optional(element) || re.test(value);
		},
		BX.message('JS_FORMAT')
	);

	$.validator.addMethod(
		'filesize', function(value, element, param){
			return this.optional(element) || (element.files[0].size <= param)
		},
		BX.message('JS_FILE_SIZE')
	);
	
	$.validator.addMethod(
		'date', function( value, element, param ) {
			var status = false;
			if(!value || value.length <= 0){
				status = false;
			}
			else{
				// html5 date allways yyyy-mm-dd
				var re = new RegExp('^([0-9]{4})(.)([0-9]{2})(.)([0-9]{2})$');
				var matches = re.exec(value);
				if(matches){
					var composedDate = new Date(matches[1], (matches[3] - 1), matches[5]);
					status = ((composedDate.getMonth() == (matches[3] - 1)) && (composedDate.getDate() == matches[5]) && (composedDate.getFullYear() == matches[1]));
				}
				else{
					// firefox
					var re = new RegExp('^([0-9]{2})(.)([0-9]{2})(.)([0-9]{4})$');
					var matches = re.exec(value);
					if(matches){
						var composedDate = new Date(matches[5], (matches[3] - 1), matches[1]);
						status = ((composedDate.getMonth() == (matches[3] - 1)) && (composedDate.getDate() == matches[1]) && (composedDate.getFullYear() == matches[5]));
					}
				}
			}
			return status;
		}, BX.message('JS_DATE')
	);
	
	$.validator.addMethod(
		'extension', function(value, element, param){
			param = typeof param === 'string' ? param.replace(/,/g, '|') : 'png|jpe?g|gif';
			return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));
		}, BX.message('JS_FILE_EXT')
	);

	$.validator.addMethod(
		'captcha', function(value, element, params){
			return $.validator.methods.remote.call(this, value, element,{
				url: arAllcorpOptions['SITE_DIR'] + 'ajax/check-captcha.php',
				type: 'post',
				data:{
					captcha_word: value,
					captcha_sid: function(){
						return $(element).closest('.form-body').find('input[name="captcha_sid"]').val();
					}
				}
			});
		},
		BX.message('JS_ERROR')
    );

	/*reload captcha*/
	$('body').on('click', '.refresh', function(e){
		e.preventDefault();
		$.ajax({
			url: arAllcorpOptions['SITE_DIR'] + 'ajax/captcha.php'
		}).done(function(text){
			$('.captcha_sid').val(text);
			$('.captcha_img').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + text);
		});
	});

	$.validator.addClassRules({
		'phone':{
			regexp: arAllcorpOptions['THEME']['VALIDATE_PHONE_MASK']
		},
		'confirm_password':{
			equalTo: 'input[name="REGISTER\[PASSWORD\]"]',
			minlength: 6
		},
		'password':{
			minlength: 6
		},
		'inputfile':{
			extension: arAllcorpOptions['THEME']['VALIDATE_FILE_EXT'],
			filesize: 5000000
		},
		 'captcha':{
			captcha: ''
		}
		,
		 'date':{
			date: ''
		}
	});
	
	InitFlexSlider();
	
	// for check flexslider bug in composite mode
	waitingNotExists('.detail .galery #slider', '.detail .galery #slider .flex-viewport', 1000, function() {
		InitFlexSlider();
		setTimeout(function() {
			$(window).resize();
		}, 350);
	});
	
	$('input[type=file]').uniform({fileButtonHtml: BX.message('UNIFORM_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('UNIFORM_FILE_MESSAGE_DEFAULT')});

	/*check mobile device*/
	if(jQuery.browser.mobile){
		$('.style-switcher').addClass('hidden');
		$('.hint span').remove();
		
		$('*[data-event="jqm"]').live('click', function(e){
			e.preventDefault();
			var _this = $(this);
			var name = _this.data('name');
			
			if(name.length){
				var script = arAllcorpOptions['SITE_DIR'] + 'form/';
				var paramsStr = ''; var arTriggerAttrs = {};
				$.each(_this.get(0).attributes, function(index, attr){
					var attrName = attr.nodeName;
					var attrValue = _this.attr(attrName);
					arTriggerAttrs[attrName] = attrValue;
					if(/^data\-param\-(.+)$/.test(attrName)){
						var key = attrName.match(/^data\-param\-(.+)$/)[1];
						paramsStr += key + '=' + attrValue + '&';
					}
				});
				
				var triggerAttrs = JSON.stringify(arTriggerAttrs);
				var encTriggerAttrs = encodeURIComponent(triggerAttrs);
				script += '?name=' + name + '&' + paramsStr + 'data-trigger=' + encTriggerAttrs;
				
				location.href = script;
			}
		});
		
		$('.fancybox').removeClass('fancybox');
	}
	else{	
		$('*[data-event="jqm"]').live('click', function(e){
			e.preventDefault();
			$(this).jqmEx();
			$(this).trigger('click');
		});
	}
	
	$('a.fancybox:has(img)').fancybox();
	
	// Responsive Menu Events
	var addActiveClass = false;
	
	$('#mainMenu li.dropdown > a, #mainMenu li.dropdown-submenu > a').on('click', function(e){
		e.preventDefault();
		if($(window).width() > 979) return;
		addActiveClass = $(this).parent().hasClass('resp-active');
		$('#mainMenu').find('.resp-active').removeClass('resp-active');
		if(!addActiveClass){
			$(this).parents('li').addClass('resp-active');
		}
	});
	
	$(document).on('click', '.mega-menu .dropdown-menu', function(e){
		e.stopPropagation()
	});
	
	$(document).on('click', '.mega-menu .dropdown-toggle.more-items', function(e){
		e.preventDefault();
	});
	
	$('.table-menu .dropdown,.table-menu .dropdown-submenu,.table-menu .dropdown-toggle').live('mouseenter', function() {
		CheckTopVisibleMenu();
	});
	
	/* toggle */
	var $this = this,
		previewParClosedHeight = 25;
	
	$('section.toggle > label').prepend($('<i />').addClass('icon icon-plus'));
	$('section.toggle > label').prepend($('<i />').addClass('icon icon-minus'));
	$('section.toggle.active > p').addClass('preview-active');
	$('section.toggle.active > div.toggle-content').slideDown(350, function() {});
	
	$('section.toggle > label').click(function(e){
		var parentSection = $(this).parent(),
			parentWrapper = $(this).parents('div.toogle'),
			previewPar = false,
			isAccordion = parentWrapper.hasClass('toogle-accordion');
			
		if(isAccordion && typeof(e.originalEvent) != 'undefined') {
			parentWrapper.find('section.toggle.active > label').trigger('click');
		}
		
		parentSection.toggleClass('active');
		
		// Preview Paragraph
		if( parentSection.find('> p').get(0) ){
			previewPar = parentSection.find('> p');
			var previewParCurrentHeight = previewPar.css('height');
			previewPar.css('height', 'auto');
			var previewParAnimateHeight = previewPar.css('height');
			previewPar.css('height', previewParCurrentHeight);
		}
		
		// Content
		var toggleContent = parentSection.find('> div.toggle-content');
		
		if(parentSection.hasClass('active')){
			$(previewPar).animate({
				height: previewParAnimateHeight
			}, 350, function() {
				$(this).addClass('preview-active');
			});
			toggleContent.slideDown(350, function() {});
		}else{
			$(previewPar).animate({
				height: previewParClosedHeight
			}, 350, function() {
				$(this).removeClass('preview-active');
			});
			toggleContent.slideUp(350, function() {});
		}
	});
	
	/* accordion */
	$('.accordion-head').on('click', function(e){
		e.preventDefault();
		if( $(this).hasClass('accordion-open') ){
			$(this).addClass('accordion-close').removeClass('accordion-open');
		}else{
			$(this).addClass('accordion-open').removeClass('accordion-close');
		}
	});
	
	/* progress bar */
	$('[data-appear-progress-animation]').each(function(){
		var $this = $(this);
		$this.appear(function(){
			var delay = ($this.attr('data-appear-animation-delay') ? $this.attr('data-appear-animation-delay') : 1);
			if( delay > 1 )
				$this.css('animation-delay', delay + 'ms');
			$this.addClass($this.attr('data-appear-animation'));

			setTimeout(function(){
				$this.animate({
					width: $this.attr('data-appear-progress-animation')
				}, 1500, 'easeOutQuad', function() {
					$this.find('.progress-bar-tooltip').animate({
						opacity: 1
					}, 500, 'easeOutQuad');
				});
			}, delay);
		}, {accX: 0, accY: -50});
	});
	
	$('a[rel=tooltip]').tooltip();
	$('span[data-toggle=tooltip]').tooltip();
	
	$('select.sort').live('change', function(){
		location.href = $(this).val();
	});

	setTimeout(function(th){
		$('.catalog.group.list .item').each(function(){
			var th = $(this);
			if((tmp = th.find('.image').outerHeight() - th.find('.text_info').outerHeight()) > 0){
				th.find('.text_info .titles').height(th.find('.text_info .titles').outerHeight() + tmp);
			}
		})
	}, 50);

	/*item galery*/
	$('.thumbs .item a').live('click', function(e){
		e.preventDefault();
		$('.thumbs .item').removeClass('current');
		$(this).closest('.item').toggleClass('current');
		$('.slides li'+$(this).attr('href')).addClass('current').siblings().removeClass('current');
	});
});

// Events

var timerScroll = false, ignoreScroll = [];
$(window).scroll(function(){
	if(!ignoreScroll.length){
		if(timerScroll){
			clearTimeout(timerScroll);
			timerScroll = false;
		}
		timerScroll = setTimeout(function(){
			BX.onCustomEvent('onWindowScroll', false);
		}, 100);
	}
});

var timerResize = false, ignoreResize = [];
$(window).resize(function(){
	if(!ignoreResize.length){
		if(timerResize){
			clearTimeout(timerResize);
			timerResize = false;
		}
		timerResize = setTimeout(function(){
			BX.onCustomEvent('onWindowResize', false);
		}, 100);
	}
});

BX.addCustomEvent('onWindowScroll', function(eventdata) {
	try{
		ignoreScroll.push(true);
		CheckPopupTop();
	}
	catch(e){}
	finally{
		ignoreScroll.pop();
	}
});

BX.addCustomEvent('onWindowResize', function(eventdata) {
	try{
		ignoreResize.push(true);
		CheckPopupTop();
		CheckTopMenuDotted();
		CheckTopVisibleMenu();
		//CheckFlexSlider();
	}
	catch(e){}
	finally{
		ignoreResize.pop();
	}
});

BX.addCustomEvent('onSlide', function(eventdata) {
	try{
		ignoreResize.push(true);
		if(eventdata){
			var slider = eventdata.slider;
			if(slider){
				// add classes .curent & .shown to slide
				slider.find('.item').removeClass('current');
				var curSlide = slider.find('.item').eq(slider.currentSlide);
				curSlide.addClass('current');
				curSlide.addClass('shown');
				slider.resize();
			}
		}
	}
	catch(e){}
	finally{
		ignoreResize.pop();
	}
});