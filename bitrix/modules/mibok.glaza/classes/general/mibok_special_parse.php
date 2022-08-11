<?
class MibokSpecialParse{    
    
    protected $template_path;
    protected $master_template_path;
    protected $obComponents;
    protected $arTemplate;
    
    function __construct($template_path, $master_template_path){ 
        $this->template_path = $template_path;
        $this->master_template_path = $master_template_path;
        $this->obComponents = $this->GetComponentsTemplate($this->template_path);        
    }
    protected static function Create($arComponent){ 
        switch($arComponent['DATA']['COMPONENT_NAME']) {
            case 'bitrix:menu';
				$arComponent['DATA']['TEMPLATE_NAME'] = '.default';
                return new MibokSpecialParseComponentMenu($arComponent);
            /*case 'bitrix:search.title';
                return new MibokSpecialParseComponentSearchTitle($arComponent);
            case 'bitrix:system.auth.form';
                return new MibokSpecialParseComponentSystemAuthForm($arComponent);*/
            default;
                return new MibokSpecialParseComponent($arComponent);
        }
    }
    static function ParsePage($path){
        if(!file_exists($path)){
            return false;
        }
        if(is_dir($path) && file_exists($path.'index.php')){
            $path = $path.'index.php';
        }        
        $page_content = file_get_contents($path);
        $obComponents = array();
        $obPHPParser = new PHPParser();            
        $arParsedComponents = $obPHPParser->ParseScript($page_content);
        foreach($arParsedComponents as $arParsedComponentsItem){
            $obComponents[] = self::Create($arParsedComponentsItem);
        }
        if(count($obComponents)){
            return $obComponents;
        }
        return false;
                
    }
    protected function GetComponentsTemplate($path){
        $obComponents = array();        
        foreach($this->ParseComponentsTemplate($path) as $arComponentItem){
            $obComponents[] = self::Create($arComponentItem);
        }
        return $obComponents;
    }
    protected function ParseComponentsTemplate($path){
        $arComponentResult = array();
        foreach(array('header.php', 'footer.php') as $arTemplatePart){
            $obPHPParser = new PHPParser();            
            $arParsedComponents = $obPHPParser->ParseScript(file_get_contents($path.'/'.$arTemplatePart));
            foreach($arParsedComponents as $arParsedComponentsItem){
                $arParsedComponentsItem['TEMPLATE_PART'] = $arTemplatePart;
                $arComponentResult[] = $arParsedComponentsItem;
            }
        }
        return $arComponentResult;
    }
    protected function PasteComponents($part_template){
        $bAdvertising = false;
        $bComplementary = false;
        foreach($this->obComponents as $obComponent){
            $makros_name = $obComponent->GetMakrosNameValue();
            $active = $obComponent->GetActiveValue();
            if($active == 'Y' && $makros_name){                
                if($makros_name == 'advertising'){                                        
                    $paste = $obComponent->Paste().'#'.MIBOK_SPECIAL_PREFIX.'_'.$makros_name.'#';
                    if(!$bAdvertising){
                        $paste = '<div class="row"><div class="btn-toolbar banner-toolbar" aria-label="<?=GetMessage("IMPORTANT_LINKS_TITLE")?>"><div class="container-fluid">'.$paste.'</div></div></div>';
                    }
                    $bAdvertising = true;
                }else if($makros_name == 'complementary'){                    
                    $paste = $obComponent->Paste();
                    $paste = '<div class="bs-docs-section">'.$paste.'</div>'.'#'.MIBOK_SPECIAL_PREFIX.'_'.$makros_name.'#';
                    if(!$bComplementary){
                        $paste = '<div class="container bs-docs-container wcag" role="complementary" id="complementary_content"><div class="row"><div class="col-md-12">'.$paste.'</div></div></div>';
                    }
                    $bComplementary = true;
                }else{
                    $paste = $obComponent->Paste().'#'.MIBOK_SPECIAL_PREFIX.'_'.$makros_name.'#';
                }
                $part_template = str_replace('#'.MIBOK_SPECIAL_PREFIX.'_'.$makros_name.'#', $paste, $part_template);
            }                                    
        }        
        $part_template = $this->ClearMakrosTemplate($part_template);
        return $part_template;
    }
    protected function ClearMakrosTemplate($part_template){
        $part_template = preg_replace('#\#'.MIBOK_SPECIAL_PREFIX.'_.*?\##is', '',$part_template);
        return $part_template;
    }
    protected function MakeTemplate(){
        foreach(array('header.php', 'footer.php') as $arTemplatePart){
            $part_template = file_get_contents($this->master_template_path.'/'.$arTemplatePart);
            $this->arTemplate[$arTemplatePart] = $this->PasteComponents($part_template);
        }    
        return $this->arTemplate;
    }
    public function GetTemplate(){
        return $this->MakeTemplate();
    }
}
?>