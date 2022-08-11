<?
class MibokSpecialParseCompare{
    protected $template_path;
    protected $special_template_path;
    protected $obComponents;
    protected $obComponentsSpecial;
    protected $arTemplate;
    
    function __construct($template_path, $special_template_path){ 
        $this->template_path = $template_path;
        $this->special_template_path = $special_template_path;
        $this->obComponents = $this->GetComponentsTemplate($this->template_path);
        $this->obComponentsSpecial = $this->GetComponentsTemplate($this->special_template_path);        
    }
    protected static function Create($arComponent){ 
        switch($arComponent['DATA']['COMPONENT_NAME']) {
            case 'bitrix:menu';
                return new MibokSpecialParseComponentMenu($arComponent);            
            default;
                return new MibokSpecialParseComponent($arComponent);
        }
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
    public function Compare(){
        $arSolt = array();
        $MibokCompareTypeMenu = array();
        
        foreach($this->obComponents as $obComponent){
           // p($obComponent->params);
            if(array_key_exists('ROOT_MENU_TYPE', $obComponent->params) && $obComponent->params['ROOT_MENU_TYPE'] != 'top_spec')
            {
                if(!empty($MibokCompareTypeMenu))
                {
                    if(in_array($obComponent->params['ROOT_MENU_TYPE'], $MibokCompareTypeMenu))
                        continue;
                }
                $MibokCompareTypeMenu[]  = $obComponent->params['ROOT_MENU_TYPE'];
            }
            if($obComponent->GetActiveValue() == 'Y' && $obComponent->GetCompareValue() != 'N'){
                $arSolt[$obComponent->GetSoltValue()] += 1;
            }
        }
        
       // p($MibokCompareTypeMenu);
        
        
        $MibokCompareTypeMenu = array();
		$arSoltSpecial = array();
        foreach($this->obComponentsSpecial as $obComponent){
            //p($obComponent->params);
            
            
            if(array_key_exists('ROOT_MENU_TYPE', $obComponent->params) && $obComponent->params['ROOT_MENU_TYPE'] != 'top_spec')
            {
                if(!empty($MibokCompareTypeMenu))
                {
                    if(in_array($obComponent->params['ROOT_MENU_TYPE'], $MibokCompareTypeMenu))
                        continue;
                }
                $MibokCompareTypeMenu[]  = $obComponent->params['ROOT_MENU_TYPE'];
            }
            if($obComponent->GetActiveValue() == 'Y' && $obComponent->GetCompareValue() != 'N'){
                $arSoltSpecial[$obComponent->GetSoltValue()] += 1;
            }
        }
        //p($arSoltSpecial);
       // p($MibokCompareTypeMenu);
		$reindex_count = 0;
        foreach($arSolt as $key_solt=>$count_solt){
            if(array_key_exists($key_solt, $arSoltSpecial)){
                if((int)$arSoltSpecial[$key_solt] < $count_solt){
                    $reindex_count += $count_solt - (int)$arSoltSpecial[$key_solt];
                }
            }else{
                $reindex_count += $count_solt;
            }
        }
        $reindex_count_special = 0;
        foreach($arSoltSpecial as $key_solt=>$count_solt){
            if(array_key_exists($key_solt, $arSolt)){
                if((int)$arSolt[$key_solt] < $count_solt){
                    $reindex_count_special += $count_solt - (int)$arSolt[$key_solt];
                }
            }else{
                $reindex_count_special += $count_solt;
            }
        }
		
        return array($reindex_count, $reindex_count_special);        
    }
    public static function GetNeedReindex(){
        $arSiteTemplates = MibokSpecialSiteTemplates::GetList();
        $arNeedReindex = array();
        foreach($arSiteTemplates as $arSiteTemplatesItem){        
            if(MKSpecial::CheckSpecialTemplate($arSiteTemplatesItem['TEMPLATE'])){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$arSiteTemplatesItem['TEMPLATE'])){
                    $template_path = $_SERVER['DOCUMENT_ROOT'].'/local/templates/'.str_replace('special_mibok_', '',$arSiteTemplatesItem['TEMPLATE']);
                    $special_template_path = $_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$arSiteTemplatesItem['TEMPLATE'];
                }
                elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$arSiteTemplatesItem['TEMPLATE'])){
                    $template_path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.str_replace('special_mibok_', '',$arSiteTemplatesItem['TEMPLATE']);
                    $special_template_path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$arSiteTemplatesItem['TEMPLATE'];    
                }
//                $template_path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.str_replace('special_mibok_', '',$arSiteTemplatesItem['TEMPLATE']);
//                $special_template_path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$arSiteTemplatesItem['TEMPLATE'];            
                $obParseCompare = new MibokSpecialParseCompare($template_path, $special_template_path);       
                $arCountNeedReindex = $obParseCompare->Compare();
                
                
                
                if((int)count($arCountNeedReindex)>0){       
                    if($arCountNeedReindex[0] > 0){
                        $arNeedReindex[str_replace('special_mibok_', '',$arSiteTemplatesItem['TEMPLATE'])] = $arCountNeedReindex[0];                    
                    }
                    if($arCountNeedReindex[1] > 0){
                        $arNeedReindex[$arSiteTemplatesItem['TEMPLATE']] = $arCountNeedReindex[1];                    
                    }
                }
            }
        }
        return $arNeedReindex;
    }
}
?>