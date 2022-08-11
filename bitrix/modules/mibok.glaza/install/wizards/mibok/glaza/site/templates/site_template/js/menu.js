$(document).ready(function () {
    var $menuItems = $('.bx-components-menu');
    for(i=0;i<$menuItems.length; i++){
        new menubar($menuItems.eq(i).attr('id'), false);
    }
    /*var menu1 = new menubar('mb1', false);
    var menu2 = new menubar('mb2', false);
    var menu3 = new menubar('mb3', false);
    var menu4 = new menubar('mb4', false);*/
}); // end ready()

/////////////// begin menu widget definition /////////////////////
//
// Function menubar() is the constructor of a menu widget
// The widget will bind to the ul passed to it.
//
// @param(id string) id is the HTML id of the ul to bind to
//
// @param(vmenu boolean) vmenu is true if menu is vertical; false if horizontal
//
// @return N/A
//
function menubar(id, vmenu) {

    // define widget properties
    this.$id = $('#' + id);

    this.$rootItems = this.$id.children('li'); // jQuerry array of all root-level menu items

    this.$items = this.$id.find('li').not('.separator'); // jQuery array of menu items
    this.$parents = this.$id.find('.dropdown'); // jQuery array of menu items
    this.$allItems = this.$parents.add(this.$items); // jQuery array of all menu items
    this.$activeItem = null; // jQuery object of the menu item with focus

    this.vmenu = vmenu;
    this.bChildOpen = false; // true if child menu is open

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

    // bind event handlers
    this.bindHandlers();

    // associate the menu with the textArea it controls
    /*this.textarea = new textArea(this.$id.attr('aria-controls'));*/
}
;

//
// Function bindHandlers() is a member function to bind event handlers for the widget.
//
// @return N/A
//
menubar.prototype.bindHandlers = function () {

    var thisObj = this;

    ///////// bind mouse event handlers //////////

    // bind a mouseenter handler for the menu items
    this.$items.mouseenter(function (e) {
        if ($(this).is('.checked')) {
            $(this).addClass('menu-hover-checked');
        }
        else {
            $(this).addClass('menu-hover');
        }
        return true;
    });

    // bind a mouseout handler for the menu items
    this.$items.mouseout(function (e) {
        $(this).removeClass('menu-hover menu-hover-checked');
        return true;
    });

    // bind a mouseenter handler for the menu parents
    this.$parents.mouseenter(function (e) {
        return thisObj.handleMouseEnter($(this), e);
    });

    // bind a mouseleave handler
    this.$parents.mouseleave(function (e) {
        return thisObj.handleMouseLeave($(this), e);
    });

   

    //////////// bind key event handlers //////////////////

    // bind a keydown handler
    this.$allItems.keydown(function (e) {
        return thisObj.handleKeyDown($(this), e);
    });

    // bind a keypress handler
    this.$allItems.keypress(function (e) {
        return thisObj.handleKeyPress($(this), e);
    });

    // bind a focus handler
    this.$allItems.focus(function (e) {
        return thisObj.handleFocus($(this), e);
    });

    // bind a blur handler
    this.$allItems.blur(function (e) {
        return thisObj.handleBlur($(this), e);
    });

    

} // end bindHandlers()

//
// Function handleMouseEnter() is a member function to process mouseover
// events for the top menus.
//
// @param($item object) $item is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns false;
//
menubar.prototype.handleMouseEnter = function ($item, e) {

    // add hover style
    if ($item.is('.checked')) {
        $item.addClass('menu-hover-checked');
    }
    else {
        $item.addClass('menu-hover');
    }

    // expand the first level submenu
    if ($item.attr('aria-haspopup') == 'true') {
        $item.addClass('open');
        $item.children('ul').show().attr('aria-hidden', 'false');
        this.bChildOpen = true;
    }
    //e.stopPropagation();
    return true;

} // end handleMouseEnter()

//
// Function handleMouseOut() is a member function to process mouseout
// events for the top menus.
//
// @param($item object) $item is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns false;
//
menubar.prototype.handleMouseOut = function ($item, e) {

    // Remover hover styles
    $item.removeClass('menu-hover menu-hover-checked');

    //e.stopPropagation();
    return true;

} // end handleMouseOut()

//
// Function handleMouseLeave() is a member function to process mouseout
// events for the top menus.
//
// @param($menu object) $menu is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns false;
//
menubar.prototype.handleMouseLeave = function ($menu, e) {

    var $active = $menu.find('.menu-focus-checked');

    $active = $active.add($menu.find('.menu-focus'));

    // Remove hover style
    $menu.removeClass('menu-hover menu-hover-checked');

    // if any item in the child menu has focus, move focus to the root item
    if ($active.length > 0) {

        this.bChildOpen = false;

        // remove the focus style from the active item
        $active.removeClass('menu-focus menu-focus-checked');

        // store the active item
        this.$activeItem = $menu;

        // cannot hide items with focus -- move focus to root item
        $menu.focus();
    }

    // hide the child menu
    $menu.removeClass('open');
    $menu.children('ul').hide().attr('aria-hidden', 'true');

    //e.stopPropagation();
    return true;

} // end handleMouseLeave()

// Function handleFocus() is a member function to process focus events
// for the menu.
//
// @param($item object) $item is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns true;
//
menubar.prototype.handleFocus = function ($item, e) {

    // if activeItem is null, we are getting focus from outside the menu. Store
    // the item that triggered the event
    if (this.$activeItem == null) {
        this.$activeItem = $item;
    }
    else if ($item[0] != this.$activeItem[0]) {
        return true;
    }

    // get the set of jquery objects for all the parent items of the active item
    var $parentItems = this.$activeItem.parentsUntil('div').filter('li');

    // remove focus styling from all other menu items
    this.$allItems.removeClass('menu-focus menu-focus-checked');

    // add styling to the active item
    if (this.$activeItem.is('.checked')) {
        this.$activeItem.addClass('menu-focus-checked');
    }
    else {
        this.$activeItem.addClass('menu-focus');
    }

    // add styling to all parent items.
    // This assumes that parent items do not have a checked state
    $parentItems.addClass('menu-focus');

    if (this.vmenu == true) {
        // if the bChildOpen is true, open the active item's child menu (if applicable)
        if (this.bChildOpen == true) {

            var $itemUL = $item.parent();

            // if the itemUL is a root-level menu and item is a parent item,
            // show the child menu.
            if ($itemUL.is('.navbar-nav') && ($item.attr('aria-haspopup') == 'true')) {
                $item.children('ul').show().attr('aria-hidden', 'false');
            }
        }
        else {
            this.vmenu = false;
        }
    }

    return true;

} // end handleFocus()

//
// Function handleBlur() is a member function to process blur events
// for the menu.
//
// @param($item object) $item is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns true;
//
menubar.prototype.handleBlur = function ($item, e) {

    $item.removeClass('menu-focus menu-focus-checked');

    return true;

} // end handleBlur()

//
// Function handleKeyDown() is a member function to process keydown events
// for the menus.
//
// @param($item object) $item is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns false if consuming; true if propagating
//
menubar.prototype.handleKeyDown = function ($item, e) {

    if (e.altKey || e.ctrlKey) {
        // Modifier key pressed: Do not process
        return true;
    }

    switch (e.keyCode) {
        case this.keys.tab:
        {

            // hide all menu items and update their aria attributes
            this.$id.find('ul').hide().attr('aria-hidden', 'true');

            // remove focus styling from all menu items
            this.$allItems.removeClass('menu-focus');

            this.$activeItem = null;
            this.bChildOpen == false;

            break;
        }
        case this.keys.esc:
        {
            var $itemUL = $item.parent();

            if ($itemUL.is('.navbar-nav')) {
                // hide the child menu and update the aria attributes
                $item.children('ul').first().hide().attr('aria-hidden', 'true');
            }
            else {

                // move up one level
                this.$activeItem = $itemUL.parent();

                // reset the childOpen flag
                this.bChildOpen = false;

                // set focus on the new item
                this.$activeItem.focus();

                // hide the active menu and update the aria attributes
                $itemUL.hide().attr('aria-hidden', 'true');
            }

            e.stopPropagation();
            return false;
        }
        case this.keys.enter:
        case this.keys.space:
        {
            //this.processMenuChoice($item);
			console.log($item.find('a:first'));
			$item.find('a:first')[0].click();
            /*var $parentUL = $item.parent();

            if ($parentUL.is('.navbar-nav')) {
                // open the child menu if it is closed
                $item.children('ul').first().show().attr('aria-hidden', 'false');
                this.bChildOpen = true;
            }
            else {
                // process the menu choice
                this.processMenuChoice($item);

                // remove hover styling
                this.$allItems.removeClass('menu-hover menu-hover-checked');
                this.$allItems.removeClass('menu-focus menu-focus-checked');

                // close the menu
                this.$id.find('ul').not('.navbar-nav').hide().attr('aria-hidden', 'true');


                // clear the active item
                this.$activeItem = null;

                // move focus to the text area
                this.textarea.$id.focus();
            }
            */
            e.stopPropagation();
            return false;
        }

        case this.keys.left:
        {

            if (this.vmenu == true && $itemUL.is('.navbar-nav')) {
                // If this is a vertical menu and the root-level is active, move
                // to the previous item in the menu
                this.$activeItem = this.moveUp($item);
            }
            else {
                this.$activeItem = this.moveToPrevious($item);
            }

            this.$activeItem.focus();

            e.stopPropagation();
            return false;
        }
        case this.keys.right:
        {

            if (this.vmenu == true && $itemUL.is('.navbar-nav')) {
                // If this is a vertical menu and the root-level is active, move
                // to the next item in the menu
                this.$activeItem = this.moveDown($item);
            }
            else {
                this.$activeItem = this.moveToNext($item);
            }

            this.$activeItem.focus();

            e.stopPropagation();
            return false;
        }
        case this.keys.up:
        {

            if (this.vmenu == true && $itemUL.is('.navbar-nav')) {
                // If this is a vertical menu and the root-level is active, move
                // to the previous root-level menu
                this.$activeItem = this.moveToPrevious($item);
            }
            else {
                this.$activeItem = this.moveUp($item);
            }

            this.$activeItem.focus();

            e.stopPropagation();
            return false;
        }
        case this.keys.down:
        {

            if (this.vmenu == true && $itemUL.is('.navbar-nav')) {
                // If this is a vertical menu and the root-level is active, move
                // to the next root-level menu
                this.$activeItem = this.moveToNext($item);
            }
            else {
                this.$activeItem = this.moveDown($item);
            }

            this.$activeItem.focus();

            e.stopPropagation();
            return false;
        }
    } // end switch

    return true;

} // end handleMenuKeyDown()

//
// Function moveToNext() is a member function to move to the next menu level.
// This will be either the next root-level menu or the child of a menu parent. If
// at the root level and the active item is the last in the menu, this function will loop
// to the first menu item.
//
// If the menu is a horizontal menu, the first child element of the newly selected menu will
// be selected
//
// @param($item object) $item is the active menu item
//
// @return (object) Returns the item to move to. Returns $item is no move is possible
//
menubar.prototype.moveToNext = function ($item) {

    var $itemUL = $item.parent(); // $item's containing menu 
    var $menuItems = $itemUL.children('li'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;

    if ($itemUL.is('.navbar-nav')) {
        // this is the root level move to next sibling. This will require closing
        // the current child menu and opening the new one.

        if (menuIndex < menuNum - 1) { // not the last root menu
            $newItem = $item.next();
        }
        else { // wrap to first item
            $newItem = $menuItems.first();
        }

        // close the current child menu (if applicable)
        if ($item.attr('aria-haspopup') == 'true') {

            var $childMenu = $item.children('ul').first();

            if ($childMenu.attr('aria-hidden') == 'false') {
                // hide the child and update aria attributes accordingly
                $childMenu.hide().attr('aria-hidden', 'true');
                this.bChildOpen = true;
            }
        }

        // remove the focus styling from the current menu
        $item.removeClass('menu-focus');

        // open the new child menu (if applicable)
        if (($newItem.attr('aria-haspopup') == 'true') && (this.bChildOpen == true)) {

            var $childMenu = $newItem.children('ul').first();

            // open the child and update aria attributes accordingly
            $childMenu.show().attr('aria-hidden', 'false');

            /*
             * Uncomment this section if the first item in the child menu should be
             * automatically selected
             *
             if (!this.vmenu) {
             // select the first item in the child menu
             $newItem = $childMenu.children('li').first();
             }
             */

        }
    }
    else {
        // this is not the root level. If there is a child menu to be moved into, do that;
        // otherwise, move to the next root-level menu if there is one
        if ($item.attr('aria-haspopup') == 'true') {

            var $childMenu = $item.children('ul').first();

            $newItem = $childMenu.children('li').first();

            // show the child menu and update its aria attributes
            $childMenu.show().attr('aria-hidden', 'false');
            this.bChildOpen = true;
        }
        else {
            // at deepest level, move to the next root-level menu

            if (this.vmenu == true) {
                // do nothing
                return $item;
            }

            var $parentMenus = null;
            var $rootItem = null;

            // get list of all parent menus for item, up to the root level
            $parentMenus = $item.parentsUntil('div').filter('ul').not('.navbar-nav');

            // hide the current menu and update its aria attributes accordingly
            $parentMenus.hide().attr('aria-hidden', 'true');

            // remove the focus styling from the active menu
            $parentMenus.find('li').removeClass('menu-focus');
            $parentMenus.last().parent().removeClass('menu-focus');

            $rootItem = $parentMenus.last().parent(); // the containing root for the menu

            menuIndex = this.$rootItems.index($rootItem);

            // if this is not the last root menu item, move to the next one
            if (menuIndex < this.$rootItems.length - 1) {
                $newItem = $rootItem.next();
            }
            else { // loop
                $newItem = this.$rootItems.first();
            }

            if ($newItem.attr('aria-haspopup') == 'true') {
                var $childMenu = $newItem.children('ul').first();

                $newItem = $childMenu.children('li').first();

                // show the child menu and update it's aria attributes
                $childMenu.show().attr('aria-hidden', 'false');
                this.bChildOpen = true;
            }
        }
    }

    return $newItem;
}

//
// Function moveToPrevious() is a member function to move to the previous menu level.
// This will be either the previous root-level menu or the child of a menu parent. If
// at the root level and the active item is the first in the menu, this function will loop
// to the last menu item.
//
// If the menu is a horizontal menu, the first child element of the newly selected menu will
// be selected
//
// @param($item object) $item is the active menu item
//
// @return (object) Returns the item to move to. Returns $item is no move is possible
//
menubar.prototype.moveToPrevious = function ($item) {

    var $itemUL = $item.parent(); // $item's containing menu 
    var $menuItems = $itemUL.children('li'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;

    if ($itemUL.is('.navbar-nav')) {
        // this is the root level move to previous sibling. This will require closing
        // the current child menu and opening the new one.

        if (menuIndex > 0) { // not the first root menu
            $newItem = $item.prev();
        }
        else { // wrap to last item
            $newItem = $menuItems.last();
        }

        // close the current child menu (if applicable)
        if ($item.attr('aria-haspopup') == 'true') {

            var $childMenu = $item.children('ul').first();

            if ($childMenu.attr('aria-hidden') == 'false') {
                // hide the child and update aria attributes accordingly
                $childMenu.hide().attr('aria-hidden', 'true');
                this.bChildOpen = true;
            }
        }

        // remove the focus styling from the current menu
        $item.removeClass('menu-focus');

        // open the new child menu (if applicable)
        if (($newItem.attr('aria-haspopup') == 'true') && this.bChildOpen == true) {

            var $childMenu = $newItem.children('ul').first();

            // open the child and update aria attributes accordingly
            $childMenu.show().attr('aria-hidden', 'false');

            /*
             * Uncomment this section if the first item in the child menu should be
             * automatically selected
             *
             if (!this.vmenu) {
             // select the first item in the child menu
             $newItem = $childMenu.children('li').first();
             }
             */

        }
    }
    else {
        // this is not the root level. If there is a parent menu that is not the
        // root menu, move up one level; otherwise, move to first item of the previous
        // root menu.

        var $parentLI = $itemUL.parent();
        var $parentUL = $parentLI.parent();

        var $parentMenus = null;
        var $rootItem = null;

        // if this is a vertical menu or is not the first child menu
        // of the root-level menu, move up one level.
        if (this.vmenu == true || !$parentUL.is('.navbar-nav')) {

            $newItem = $itemUL.parent();

            // hide the active menu and update aria-hidden
            $itemUL.hide().attr('aria-hidden', 'true');

            // remove the focus highlight from the $item
            $item.removeClass('menu-focus');

            if (this.vmenu == true) {
                // set a flag so the focus handler does't reopen the menu
                this.bChildOpen = false;
            }

        }
        else { // move to previous root-level menu

            // hide the current menu and update the aria attributes accordingly
            $itemUL.hide().attr('aria-hidden', 'true');

            // remove the focus styling from the active menu
            $item.removeClass('menu-focus');
            $parentLI.removeClass('menu-focus');

            menuIndex = this.$rootItems.index($parentLI);

            if (menuIndex > 0) {
                // move to the previous root-level menu
                $newItem = $parentLI.prev();
            }
            else { // loop to last root-level menu
                $newItem = this.$rootItems.last();
            }

            // add the focus styling to the new menu
            $newItem.addClass('menu-focus');

            if ($newItem.attr('aria-haspopup') == 'true') {
                var $childMenu = $newItem.children('ul').first();

                // show the child menu and update it's aria attributes
                $childMenu.show().attr('aria-hidden', 'false');
                this.bChildOpen = true;

                $newItem = $childMenu.children('li').first();
            }
        }
    }

    return $newItem;
}

//
// Function moveDown() is a member function to select the next item in a menu.
// If the active item is the last in the menu, this function will loop to the
// first menu item.
//
// @param($item object) $item is the active menu item
//
// @param(startChr char) [optional] startChr is the character to attempt to match against the beginning of the
// menu item titles. If found, focus moves to the next menu item beginning with that character.
//
// @return (object) Returns the item to move to. Returns $item is no move is possible
//
menubar.prototype.moveDown = function ($item, startChr) {

    var $itemUL = $item.parent(); // $item's containing menu 
    var $menuItems = $itemUL.children('li').not('.separator'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;

    if ($itemUL.is('.navbar-nav')) { // this is the root level menu

        if ($item.attr('aria-haspopup') != 'true') {
            // No child menu to move to
            return $item;
        }

        // Move to the first item in the child menu
        $newItemUL = $item.children('ul').first();
        $newItem = $newItemUL.children('li').first();

        // make sure the child menu is visible
        $newItemUL.show().attr('aria-hidden', 'false');
        this.bChildOpen = true;

        return $newItem;
    }

    // if $item is not the last item in its menu, move to the next item. If startChr is specified, move
    // to the next item with a title that begins with that character.
    //
    if (startChr) {
        var bMatch = false;
        var curNdx = menuIndex + 1;

        // check if the active item was the last one on the list
        if (curNdx == menuNum) {
            curNdx = 0;
        }

        // Iterate through the menu items (starting from the current item and wrapping) until a match is found
        // or the loop returns to the current menu item 
        while (curNdx != menuIndex) {

            var titleChr = $menuItems.eq(curNdx).html().charAt(0);

            if (titleChr.toLowerCase() == startChr) {
                bMatch = true;
                break;
            }

            curNdx = curNdx + 1;

            if (curNdx == menuNum) {
                // reached the end of the list, start again at the beginning
                curNdx = 0;
            }
        }

        if (bMatch == true) {
            $newItem = $menuItems.eq(curNdx);

            // remove the focus styling from the current item
            $item.removeClass('menu-focus menu-focus-checked');

            return $newItem
        }
        else {
            return $item;
        }
    }
    else {
        if (menuIndex < menuNum - 1) {
            $newItem = $menuItems.eq(menuIndex + 1);
        }
        else {
            $newItem = $menuItems.first();
        }
    }

    // remove the focus styling from the current item
    $item.removeClass('menu-focus menu-focus-checked');

    return $newItem;
}

//
// Function moveUp() is a member function to select the previous item in a menu.
// If the active item is the first in the menu, this function will loop to the
// last menu item.
//
// @param($item object) $item is the active menu item
//
// @return (object) Returns the item to move to. Returns $item is no move is possible
//
menubar.prototype.moveUp = function ($item) {

    var $itemUL = $item.parent(); // $item's containing menu 
    var $menuItems = $itemUL.children('li').not('.separator'); // the items in the currently active menu
    var menuNum = $menuItems.length; // the number of items in the active menu
    var menuIndex = $menuItems.index($item); // the items index in its menu
    var $newItem = null;
    var $newItemUL = null;

    if ($itemUL.is('.navbar-nav')) { // this is the root level menu

        // nothing to do
        return $item;
    }

    // if $item is not the first item in its menu, move to the previous item
    if (menuIndex > 0) {

        $newItem = $menuItems.eq(menuIndex - 1);
    }
    else {
        // loop to top of menu
        $newItem = $menuItems.last();
    }

    // remove the focus styling from the current item
    $item.removeClass('menu-focus menu-focus-checked');

    return $newItem;
}

//
// Function handleKeyPress() is a member function to process keydown events
// for the menus.
//
// The Opera browser performs some window commands from the keypress event,
// not keydown like Firefox, Safari, and IE. This event handler consumes
// keypresses for relevant keys so that Opera behaves when the user is
// manipulating the menu with the keyboard.
//
// @param($item object) $menu is the jquery object of the item firing the event
//
// @param(e object) e is the associated event object
//
// @return(boolean) Returns false if consuming; true if propagating
//
menubar.prototype.handleKeyPress = function ($item, e) {

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
            var chr = String.fromCharCode(e.which);

            this.$activeItem = this.moveDown($item, chr);
            this.$activeItem.focus();

            e.stopPropagation();
            return false;
        }

    } // end switch

    return true;

} // end handleKeyPress()


// Function processMenuChoice() is a member function to process the user's menu item
// choice. Since the menu will close after this, highlight styling is simply removed.
//
// @param($item object) $item is the jquery object of the menu item firing the event
//
// @return N/A
//
menubar.prototype.processMenuChoice = function ($item) {

    // find the parent menu for this item
    //var menuName = $item.parent().attr('id');
	//console.log($item);
    $item.find('a').trigger('click');
    

}; // end processMenuChoice()

/////////////// end menu widget definition /////////////////////