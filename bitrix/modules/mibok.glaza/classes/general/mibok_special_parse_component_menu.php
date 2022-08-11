<?
class MibokSpecialParseComponentMenu extends MibokSpecialParseComponent{
    function GetMakrosName(){
        switch($this->params['ROOT_MENU_TYPE']) {
            case 'top';
                return 'top_menu';
            case 'bottom';
                return 'bottom_menu';
            case 'left';
                return 'section_menu';
            default;
                return 'bottom_menu';
        }        
    }
}
?>