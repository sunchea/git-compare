$(document).ready(function () {
    var menu1 = new toolbar('access_toolbar', false);

}); // end ready()

function toolbar(id) {
    this.$id = $('#' + id);
    this.$rootItems = this.$id.find('button');
    this.$items = this.$id.find('button');
    this.$allItems = this.$items;
    this.$btnGroup = this.$id.find('.btn-group');

    this.$firstButton = [];
    for (i = 1; i <= this.$btnGroup.length; i++) {
        this.$firstButton[i - 1] = this.$btnGroup.eq(i).find('button:first');
    }

    this.$activeItem = null;

    this.keys = {
        tab: 9,
        enter: 13,
        esc: 27,
        space: 32,
        left: 37,
        up: 38,
        right: 39,
        down: 40
    };
    this.bindHandlers();

    if ($('#mibok_special_auth_timeout').is('div')) {
        var time_out = $('#mibok_special_auth_timeout').attr('data-time-out');
        setInterval(function () {
            if (!$('.panel-auth').is('.active')) {
                $('.panel-auth').slideDown({
                    duration: 'fast',
                    complete: function () {
                        $.scrollTo('.panel-auth', '100', function () {
                            $('.panel-auth').addClass('active').attr('aria-hidden', 'false');
                            $('.panel-auth .help-block').focus();
                            $('.panel-auth h3').attr('tabindex', '0');
                            $('.panel-auth p.help-block-default').attr('tabindex', '0');
                            $('.panel-auth input').attr('tabindex', '0');
                            $('.panel-auth button').attr('tabindex', '0');
                        });
                    },
                    start: function () {
                        $focused = $(':focus');
                    }
                });
            }
        }, time_out);
        $('.panel-auth h3').attr('tabindex', '-1');
        $('.panel-auth p').attr('tabindex', '-1');
        $('.panel-auth input').attr('tabindex', '-1');
        $('.panel-auth button').attr('tabindex', '-1');
    }
}
;
toolbar.prototype.bindHandlers = function () {
    var thisObj = this;
    this.$items.mouseenter(function (e) {
        if ($(this).is('.checked')) {
            $(this).addClass('menu-hover-checked');
        }
        else {
            $(this).addClass('menu-hover');
        }
        return true;
    });
    this.$items.mouseout(function (e) {
        $(this).removeClass('menu-hover menu-hover-checked');
        return true;
    });
	
	
	
    this.$allItems.click(function (e) {
        return thisObj.handleClick($(this), e);
    });
    this.$allItems.keydown(function (e) {
        return thisObj.handleKeyDown($(this), e);
    });
    this.$allItems.keypress(function (e) {
        return thisObj.handleKeyPress($(this), e);
    });
    this.$allItems.focus(function (e) {
        return thisObj.handleFocus($(this), e);
    });
    this.$allItems.blur(function (e) {
        return thisObj.handleBlur($(this), e);
    });
    $(document).click(function (e) {
        return thisObj.handleDocumentClick(e);
    });

}; // end bindHandlers()
toolbar.prototype.handleClick = function ($item, e) {
    this.processMenuChoice($item);
    this.$allItems.removeClass('menu-hover menu-hover-checked menu-focus menu-focus-checked');
    e.stopPropagation();
    return false;

}; // end handleClick()
toolbar.prototype.handleFocus = function ($item, e) {

    // if activeItem is null, we are getting focus from outside the menu. Store
    // the item that triggered the event
    if (this.$activeItem == null) {
        this.$activeItem = $item;
    }
    else if ($item[0] != this.$activeItem[0]) {
        return true;
    }

    // remove focus styling from all other menu items
    this.$allItems.removeClass('menu-focus menu-focus-checked');

    // add styling to the active item
    if (this.$activeItem.is('.checked')) {
        this.$activeItem.addClass('menu-focus-checked');
    }
    else {
        this.$activeItem.addClass('menu-focus');
    }

    return true;

} // end handleFocus()
toolbar.prototype.handleBlur = function ($item, e) {

    $item.removeClass('menu-focus menu-focus-checked');

    return true;

} // end handleBlur()
toolbar.prototype.handleKeyDown = function ($item, e) {

	
    if (e.altKey || e.ctrlKey) {
        // Modifier key pressed: Do not process
        return true;
    }
    switch (e.keyCode) {
        case this.keys.tab:
        {
            this.$allItems.removeClass('menu-focus');
            this.$activeItem = null;
            break;
        }
        case this.keys.esc:
        {
            e.stopPropagation();
            return false;
        }
        case this.keys.enter:
        case this.keys.space:
        {
            this.processMenuChoice($item);
            this.$allItems.removeClass('menu-hover menu-hover-checked');
            this.$allItems.removeClass('menu-focus menu-focus-checked');
            this.$activeItem = null;
            /*this.textarea.$id.focus();*/
            e.stopPropagation();
            return false;
        }
        case this.keys.left:
        {
            this.$activeItem = this.moveToPrevious($item);
            this.$activeItem.focus();
            e.stopPropagation();
            return false;
        }
        case this.keys.right:
        {
            this.$activeItem = this.moveToNext($item);
            this.$activeItem.focus();
            e.stopPropagation();
            return false;
        }
        case this.keys.up:
        {
            e.stopPropagation();
            return false;
        }
        case this.keys.down:
        {
            e.stopPropagation();
            return false;
        }
    }
    return true;
};
toolbar.prototype.moveToNext = function ($item) {

    var $itemUL = $item.parents('.access-toolbar'); // $item's containing menu 
    var $menuItems = $itemUL.find('button:not(.disabled)'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;
    if ($itemUL.is('.access-toolbar')) {
        if (menuIndex < menuNum - 1) {
            $newItem = $menuItems.eq(menuIndex + 1);
        }
        else {
            $newItem = $menuItems.first();
        }
        $item.removeClass('menu-focus');
    }
    return $newItem;
};
toolbar.prototype.moveToPrevious = function ($item) {

    var $itemUL = $item.parents('.access-toolbar'); // $item's containing menu 
    var $menuItems = $itemUL.find('button:not(.disabled)'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;

    if ($itemUL.is('.access-toolbar')) {
        if (menuIndex > 0) {
            $newItem = $menuItems.eq(menuIndex - 1);
        }
        else {
            $newItem = $menuItems.last();
        }
        $item.removeClass('menu-focus');
    }
    return $newItem;
};
toolbar.prototype.moveDown = function ($item, startChr) {

};
toolbar.prototype.moveUp = function ($item) {

};
toolbar.prototype.handleKeyPress = function ($item, e) {

if($item.hasClass('disabled'))
		e.stopPropagation();


    if (e.altKey || e.ctrlKey || e.shiftKey) {
        // Modifier key pressed: Do not process
        return true;
    }

    switch (e.keyCode) {
        case this.keys.tab:
        {
            return true;
        }
        case this.keys.esc:
        case this.keys.enter:
        case this.keys.space:
        case this.keys.up:
        case this.keys.down:
        case this.keys.left:
        case this.keys.right:
        {
            e.stopPropagation();
            return false;
        }
        default :
        {
            this.$activeItem.focus();
            e.stopPropagation();
            return false;
        }

    }

    return true;

}; // end handleKeyPress()
toolbar.prototype.handleDocumentClick = function (e) {
    this.$allItems.removeClass('menu-focus menu-focus-checked');
    this.$activeItem = null;
    return true;

}; // end handleDocumentClick()
toolbar.prototype.processSetChoice = function (param, value) {
    $.ajax({
        type: "POST",
        cache: false,
        url: this.$id.attr('data-path-params'),
        data: [{name: param, value: value}],
        success: function (data) {

        }
    });
    return false;
}
toolbar.prototype.processMenuChoice = function ($item) {
    var choice = $item.attr('data-choice');
    $item.parent().find('button').removeClass('checked').attr('aria-checked', 'false');
    switch (choice) {
        default :
        {
            return false;
        }
        case 'content':
        {
            $.scrollTo('#main_content .page-header:first', '100', function () {
                $('#main_content .page-header:first').focus();
            });
            break;
        }
        case 'font-size-100':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('font-size-100');
            $('#content').removeClass('font-size-150 font-size-200');
            this.processSetChoice('FONT_SIZE', 'font-size-100');
            break;
        }
        case 'font-size-150':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('font-size-150');
            $('#content').removeClass('font-size-100 font-size-200');
            this.processSetChoice('FONT_SIZE', 'font-size-150');
            break;
        }
        case 'font-size-200':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('font-size-200');
            $('#content').removeClass('font-size-100 font-size-150');
            this.processSetChoice('FONT_SIZE', 'font-size-200');
            break;
        }
				
        case 'images':
        {
            /*if ($('#content').is('.not-images')) {
                $('#content').removeClass('not-images');
                this.processSetChoice('IMAGES', 'images');
            } else {
                $item.attr('aria-checked', 'true').addClass('checked');
                $('#content').addClass('not-images');
                this.processSetChoice('IMAGES', 'not-images');
            }*/
			$item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('images');
            $('#content').removeClass('not-images');
			$('.btn-mono').removeClass('disabled');
            this.processSetChoice('IMAGES', 'images');
            break;
        }
		case 'not-images':
        {
			$item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('not-images');
            $('#content').removeClass('images mono');
			$('.btn-mono').addClass('disabled').removeClass('checked');
            this.processSetChoice('IMAGES', 'not-images');
            break;
        }
        case 'mono':
        {
            if ($('#content').is('.mono')) {
                $('#content').removeClass('mono');
                this.processSetChoice('MONO_IMAGES', 'not-mono');
            } else {
                $item.attr('aria-checked', 'true').addClass('checked');
                $('#content').addClass('mono');
                this.processSetChoice('MONO_IMAGES', 'mono');
            }
            break;
        }
        case 'flash':
        {
            if ($('#content').is('.not-flash')) {
                $('#content').removeClass('not-flash');
                $('object').css('margin-left', 0);
                this.processSetChoice('FLASH', 'flash');
            } else {
                $item.attr('aria-checked', 'true').addClass('checked');
                $('#content').addClass('not-flash');
                $('object')
                        .wrap('<div class="fl-wrapper">')
                        .parent().css({'overflow': 'hidden'})
                        .children().css({'margin-left': -99999});
                this.processSetChoice('FLASH', 'not-flash');
            }
            break;
        }
        case 'color-1':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content, #c_panel_special').addClass('color-1');
            $('#content, #c_panel_special').removeClass('color-2 color-3 color-4 color-5');
            this.processSetChoice('COLOR', 'color-1');
            break;
        }
        case 'color-2':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content, #c_panel_special').addClass('color-2');
            $('#content, #c_panel_special').removeClass('color-1 color-3 color-4 color-5');
            this.processSetChoice('COLOR', 'color-2');
            break;
        }
        case 'color-3':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content, #c_panel_special').addClass('color-3');
            $('#content, #c_panel_special').removeClass('color-1 color-2 color-4 color-5');
            this.processSetChoice('COLOR', 'color-3');
            break;
        }
		case 'color-4':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content, #c_panel_special').addClass('color-4');
            $('#content, #c_panel_special').removeClass('color-1 color-2 color-3 color-5');
            this.processSetChoice('COLOR', 'color-4');
			
            break;
        }
		case 'color-5':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content, #c_panel_special').addClass('color-5');
            $('#content, #c_panel_special').removeClass('color-1 color-2 color-3 color-4');
            this.processSetChoice('COLOR', 'color-5');
			
            break;
        }
        case 'kerning-1':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('kerning-1');
            $('#content').removeClass('kerning-2 kerning-3');
            this.processSetChoice('KERNING', 'kerning-1');
            break;
        }
        case 'kerning-2':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('kerning-2');
            $('#content').removeClass('kerning-1 kerning-3');
            this.processSetChoice('KERNING', 'kerning-2');
            break;
        }
        case 'kerning-3':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('kerning-3');
            $('#content').removeClass('kerning-1 kerning-2');
            this.processSetChoice('KERNING', 'kerning-3');
            break;
        }
		
        case 'line-1':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('line-1');
            $('#content').removeClass('line-2 line-3');
            this.processSetChoice('LINE', 'line-1');
            break;
        }
        case 'line-2':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('line-2');
            $('#content').removeClass('line-1 line-3');
            this.processSetChoice('LINE', 'line-2');
            break;
        }
        case 'line-3':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('line-3');
            $('#content').removeClass('line-1 line-2');
            this.processSetChoice('LINE', 'line-3');
            break;
        }
		
        case 'garnitura-1':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('garnitura-1');
            $('#content').removeClass('garnitura-2 garnitura-3');
            this.processSetChoice('GARNITURA', 'garnitura-1');
            break;
        }
        case 'garnitura-2':
        {
            $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('garnitura-2');
            $('#content').removeClass('garnitura-1 garnitura-3');
            this.processSetChoice('GARNITURA', 'garnitura-2');
            break;
        }
		case 'voice-1':
        {
           $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('voice-1');
			$('#content').attr('data-volume', 0);
            $('#content').removeClass('voice-2 voice-3 voice-4');
			document.getElementById('start_sound').volume = 0;
			if($('.play_voice').length)
			if($('.play_voice').length)
			{
				$('.play_voice').each(function(){
					$(this)[0].volume = 0;
				})
			}
				//document.getElementById('play_voice').volume = 0;
				//document.querySelector(".play_voice").volume = 0;
            this.processSetChoice('VOICE', 'voice-1');
			this.processSetChoice('VOLUME',0 );
			$('#current-volume').text(0);
           // this;
            break;
        }
		case 'voice-2':
        {
           $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('voice-2');
            $('#content').removeClass('voice-1 voice-3 voice-4');
            this.processSetChoice('VOICE', 'voice-2');
			
			var volume = 0.1;
			var data_volume = 0;
			data_volume = $('#content').attr('data-volume');
			if(data_volume > 0.1)
				volume = (data_volume - volume).toFixed(1);
			$('#content').attr('data-volume', volume);
			
			document.getElementById('start_sound').volume = volume;
			if($('.play_voice').length)
			{
				$('.play_voice').each(function(){
					$(this)[0].volume = volume;
				})
			}
				//document.querySelector(".play_voice").volume = volume;
			this.processSetChoice('VOLUME',volume);
			document.getElementById("start_sound").play();
			$('#current-volume').text(volume * 100);
            break;
        }
		case 'voice-3':
        {
           $item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('voice-3');
			$('#content').attr('data-volume', 0.5);
            $('#content').removeClass('voice-2 voice-1  voice-4');
            this.processSetChoice('VOICE', 'voice-3');
			document.getElementById('start_sound').volume = 0.5;
			if($('.play_voice').length)
			{
				$('.play_voice').each(function(){
					$(this)[0].volume = 0.5;
				})
			}
				//document.querySelector(".play_voice").volume = 0.5;
			this.processSetChoice('VOLUME',0.5 );
			document.getElementById("start_sound").play();
			$('#current-volume').text(50);
            break;
        }
		case 'voice-4':
        {
			$item.attr('aria-checked', 'true').addClass('checked');
            $('#content').addClass('voice-4');
            $('#content').removeClass('voice-2 voice-1 voice-3');
            this.processSetChoice('VOICE', 'voice-4');
			
			var volume = 0.1;
			var data_volume = 0;
			data_volume = parseFloat($('#content').attr('data-volume'));
			if(data_volume < 1)
			{
				console.log(data_volume);
				volume = (volume + data_volume).toFixed(1);
			}
			else if(data_volume == 1)
				volume  = 1;
			$('#content').attr('data-volume', volume);
			
			
			document.getElementById('start_sound').volume = volume;
			if($('.play_voice').length)
			{
				$('.play_voice').each(function(){
					$(this)[0].volume = volume;
				})
			}
				//document.querySelector(".play_voice").volume = volume;
			this.processSetChoice('VOLUME',volume);
			document.getElementById("start_sound").play();
			$('#current-volume').text(volume * 100);
            break;
        }
        case 'reset':
        {
            for (i = 1; i <= this.$firstButton.length; i++) {
                //console.log(this.$firstButton[i - 1]);
                this.resetMenuChoice(this.$firstButton[i - 1]);
            }
            this.processSetChoice('RESET', 'Y');
            break;
        }
        case 'setting':
        {
            if (this.$id.find('.panel-subsetting').is('.active')) {
                this.$id.find('.panel-subsetting').slideUp({
                    duration: 'fast',
                    complete: function () {
                        $(this).removeClass('active').attr('aria-hidden', 'true');
                    },
                    start: function () {

                    }
                });
            } else {
                this.$id.find('.panel-subsetting').slideDown({
                    duration: 'fast',
                    complete: function () {
                        $(this).addClass('active').attr('aria-hidden', 'false');
                    },
                    start: function () {

                    }
                });
            }
            break;
        }
        case 'resume':
        {
            this.resumeAuth();
            break;
        }
        case 'no-resume':
        {
            this.resumeNoAuth();
            break;
        }
    } // end switch

}; // end processMenuChoice()

toolbar.prototype.resetMenuChoice = function ($item) {
    var choice = $item.attr('data-choice');
    switch (choice) {
        default :
        {
            $item.trigger('click');
            return false;
        }
        case 'content':
        {
            break;
        }
        case 'reset':
        {
            break;
        }
        case 'setting':
        {
            break;
        }
        case 'images':
        {
            if ($('#content').is('.not-images')) {
                $item.trigger('click');
            }
            break;
        }
        case 'flash':
        {
            if ($('#content').is('.not-flash')) {
                $item.trigger('click');
            }
            break;
        }
		case 'voice-1':
		{
			$('.btn-voice-3').trigger('click');
			break;
		}
		case 'mono':
		{
			if ($('#content').is('.mono')) {
                $item.trigger('click');
            }
			break;
		}
    }
};
toolbar.prototype.resumeNoAuth = function () {
    if ($('.panel-auth').is('.active')) {
        $('.panel-auth').slideUp({
            duration: 'fast',
            complete: function () {
                $('.panel-auth').removeClass('success active').attr('aria-hidden', 'true');
                $('.panel-auth button:first').focus();
                $('.panel-auth h3').attr('tabindex', '-1');
                $('.panel-auth p').attr('tabindex', '-1');
                $('.panel-auth input').attr('tabindex', '-1');
                $('.panel-auth button').attr('tabindex', '-1');
                if ($focused.parents('#content').is('div')) {
                    $.scrollTo($focused, 300, function () {
                        $focused.focus();
                    });
                }
            },
            start: function () {

            }
        });
    }
};
toolbar.prototype.resumeAuth = function () {
    if ($('.panel-auth').is('.success')) {
        $('.panel-auth').slideUp({
            duration: 'fast',
            complete: function () {
                $('.panel-auth').removeClass('success active').attr('aria-hidden', 'true');
                $('.panel-auth button:first').focus();
                $('.panel-auth h3').attr('tabindex', '-1');
                $('.panel-auth p').attr('tabindex', '-1');
                $('.panel-auth input').attr('tabindex', '-1');
                $('.panel-auth button').attr('tabindex', '-1');
                if ($focused.parents('#content').is('div')) {
                    $.scrollTo($focused, 300, function () {
                        $focused.focus();
                    });
                }
            },
            start: function () {

            }
        });
    } else {
        $('#panel_auth_form').trigger('submit');
    }
};