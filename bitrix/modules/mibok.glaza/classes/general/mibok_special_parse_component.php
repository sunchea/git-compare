<?
class MibokSpecialParseComponent{    
    protected $name;
    protected $template;
   // protected $params;
    public $params;
    protected $call;
    protected $part;
    protected $macros_name;
    protected $active;
    protected $special_menu_item;
    protected $special_menu_item_name;
    protected $special_menu_item_url;
    protected $solt;
    protected $compared;
    
    function __construct($arComponent){                  
        $this->name = $arComponent['DATA']['COMPONENT_NAME'];
        $this->template = $arComponent['DATA']['TEMPLATE_NAME'];
        $this->params = $arComponent['DATA']['PARAMS'];
        $this->part = $arComponent['TEMPLATE_PART'];
        $this->macros_name = $this->GetMakrosName();
        $this->solt = $this->GetSolt();
        $this->call = $this->GetCall();
        $this->active = $this->GetActive();
        //$this->solt_decode = $this->GetSolt(true);
        $this->compared = $this->GetCompared();
    }
    function GetSolt($bDecode = null){
		
        $params = $this->params;
        if(is_array($params))
        {
            if(array_key_exists('MIBOK_SPECIAL_KEY', $params)){
                unset($params['MIBOK_SPECIAL_KEY']);            
            }
        }
        if($bDecode){
            return print_r($params, true);
        }
        return md5(print_r($params, true));
    }
    function GetCall(){                
        $this->params['MIBOK_SPECIAL_KEY'] = $this->GetSolt();
        $obPHPParser = new PHPParser();           
        if(!$this->CheckExclude())
        { 
            if(array_key_exists('ROOT_MENU_TYPE', $this->params) && $this->params['ROOT_MENU_TYPE'] != 'top_spec')
            {
                if(!empty($GLOBALS['arTypeMenu']))
                {
                    if(in_array($this->params['ROOT_MENU_TYPE'], $GLOBALS['arTypeMenu']))
                        return;
                }
                
                $GLOBALS['arTypeMenu'][]  = $this->params['ROOT_MENU_TYPE'];
            }
            
            return '<?$APPLICATION->IncludeComponent("'.$this->name.'", "'.$this->template.'", Array('.$obPHPParser->ReturnPHPStr2($this->params, array()).'));?>';
        }
    }
    function GetMakrosName(){
        //$arMakrosName = array('top_menu', 'special_menu', 'section_menu', 'bottom_menu', 'complementary', 'advertising');
        switch($this->name){            
            case 'bitrix:advertising.banner';
                return 'advertising';           
            default;
                return 'complementary';
        }
    }
    function GetActive(){
        switch($this->name){
            case 'bitrix:menu';
            case 'bitrix:advertising.banner';
            case 'bitrix:main.include';
            case 'bitrix:news.list';
                return 'Y';        
            default;
                return 'N';
        }
    }   
    function GetCompared(){

        return $this->params['MIBOK_SPECIAL_COMPARE'];
    }
    function GetMakrosNameValue(){
        return $this->macros_name;
    }
    function GetCallValue(){
        return $this->call;
    }
    function GetActiveValue(){
        return $this->active;
    }
    function GetSoltValue(){
        return $this->solt;
    }
    function GetNameValue(){
        $arName = explode(':', $this->name);
        return $arName[1];
    }
    function GetNameSpaceValue(){
        $arName = explode(':', $this->name);
        return $arName[0];
    }
    function GetTemplateValue(){        
        return $this->template;
    }
    function GetPathValue(){
        return implode('/', array($this->GetNameSpaceValue(), $this->GetNameValue(), $this->GetTemplateValue()));
    }
    function GetDefaultPathValue(){
        return implode('/', array($this->GetNameSpaceValue(), $this->GetNameValue(), '.default'));
    }
    function GetCompareValue(){
        return $this->compared;
    }
    function CheckExclude(){
        if(!is_array($this->params)){
            return false;
        }else if($this->params['MIBOK_SPECIAL_INC'] == 'N'){
            return true;
        }
        return false;
    }
    function Paste(){
        return $this->GetCallValue();
    }
}
?>