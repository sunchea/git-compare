<?
class MibokSpecialSiteTemplates{
    
    protected $id;
    protected $arParams;
    protected $arCopyParams;
            
    function __construct($template_id){
        if($arTemplate = MibokSpecialSiteTemplates::GetByID($template_id)){
            $this->id = $template_id;
            $this->arParams = $arTemplate;
            $this->arCopyParams = array();
        }        
    }   
    function CopyPrepare($prefix){
        
        $new_template = $prefix.'_'.$this->arParams['TEMPLATE'];
        $new_condition_value = '';
        $new_condition_rule = '($_GET["'.MIBOK_SPECIAL_PREFIX_GET.'"] == "Y" || $_SESSION["'.MIBOK_SPECIAL_PREFIX_GET.'"] == "Y")';
        if(strlen($this->arParams['CONDITION']) > 0){
            $new_condition_value = $this->arParams['CONDITION'].' && '.$new_condition_rule;
        }else{
            $new_condition_value = $new_condition_rule;
        }
       
        $arCopyParams = MibokSpecialSiteTemplates::GetPath($new_template, false, $this->arParams['TEMPLATE']);
        $arCopyParams['TEMPLATE'] = $new_template;
        $arCopyParams['CONDITION'] = $new_condition_value;
        $this->arCopyParams = array_merge($this->arParams, $arCopyParams);  
        
    }
    function MakeTemplateDir(){
        $arMakeDir = array();
        if($this->arParams['PATH'] && $this->arCopyParams['PATH']){
            $arMakeDir[] = $this->arCopyParams['PATH'];
        }
        if($this->arParams['COMPONENTS_PATH'] && $this->arCopyParams['COMPONENTS_PATH']){
            $arMakeDir[] = $this->arCopyParams['COMPONENTS_PATH'];
        }
        foreach($arMakeDir as $arMakeDirItem){
            MibokSpecialUtil::MakeDir($arMakeDirItem);
        }
    }
    function CopySpecialTemplate(){        
        $template_path = $this->arParams['PATH'];
        $master_path = MIBOK_SPECIAL_MASTER_TEMPLATE_PATH;        
        $from = $master_path;
        $to = $this->arCopyParams['PATH'];      
		
		if(LANG_CHARSET != 'windows-1251')
		{
			
			$special_js_path = $master_path."/js/voice.js";
			$special_js_content = file_get_contents($special_js_path);
			//file_put_contents($special_js_path, mb_convert_encoding($special_js_content, 'UTF-8'/*, 'CP1251'*/));
			if (!preg_match('//u', $special_js_content))
				file_put_contents($special_js_path, iconv('CP1251', 'UTF-8', $special_js_content));
			//file_put_contents($special_js_path, iconv('CP1251', 'UTF-8', $special_js_content));
		}
        
        if(file_exists($from) && file_exists($to)){
            MibokSpecialUtil::CopyDir($from, $to);
            $obMibokTemplate = new MibokSpecialParse($template_path, $master_path);
            $arTemplateCode = $obMibokTemplate->GetTemplate();   
            
            $descrTemplate = file_get_contents($to."/description.php");
            $descrTemplate = str_replace("#NAME_TEMPLATE#", $this->arCopyParams['TEMPLATE'], $descrTemplate);
            file_put_contents($to."/description.php", $descrTemplate);
            
            foreach($arTemplateCode as $key=>$arTemplateCodeItem){
                file_put_contents($to.'/'.$key, $arTemplateCodeItem);
            }
            
        }        
    }
    function Copy($prefix){    
        $this->CopyPrepare($prefix);
        $this->MakeTemplateDir();
        $this->CopySpecialTemplate();
    }    
    function GetCopyConditionValue(){
        return $this->arCopyParams['CONDITION'];
    }
    function GetCopyTemplateValue(){
        return $this->arCopyParams['TEMPLATE'];
    }
    function GetCopySortValue(){
        return $this->arCopyParams['SORT'];
    }
    static function GetByID($template_id){
        $arTemplates = MibokSpecialSiteTemplates::GetList();
        if(is_array($arTemplates[$template_id])){
            return $arTemplates[$template_id];
        }
        return false;
    }
    static function GetList($site_id = false, $arExcludeTemplate = array()){        
        if(!is_array($arExcludeTemplate)){
            $arExcludeTemplate = array();
        }
        if(!$site_id){
            $arSiteIDs = array_keys(MibokSpecialSite::GetList());
        }else if(is_array($site_id)){
            $arSiteIDs = $site_id;
        }else{
            $arSiteIDs = array($site_id);
        }
        $arTemplates = array();
        foreach($arSiteIDs as $arSiteIDsItem){        
            $dbTemplate = CSite::GetTemplateList($arSiteIDsItem);
            while($arTemplate = $dbTemplate->Fetch()){  
                if(!in_array($arTemplate['TEMPLATE'], $arExcludeTemplate)){
                    $arPath = MibokSpecialSiteTemplates::GetPath($arTemplate['TEMPLATE'], true, $arTemplate['TEMPLATE']);            
                    $arTemplate = array_merge($arTemplate, $arPath); 
                    $arTemplates[$arTemplate['ID']] = $arTemplate;           
                }
            }
        }

        return $arTemplates;
    }
    
    static function GetPath($template, $bExist = true, $oldTemplate = ''){        
        $arTemplate = array();
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$oldTemplate)/* || $bExist == false*/){
            $arTemplate['PATH'] = $_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$template;   
        }
        elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$oldTemplate)/* || $bExist == false*/){
            $arTemplate['PATH'] = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$template;   
        }
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$oldTemplate.'/components')/* || $bExist == false*/){
            $arTemplate['COMPONENTS_PATH'] = $_SERVER['DOCUMENT_ROOT'].'/local/templates/'.$template.'/components';   
        }
        elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$oldTemplate.'/components')/* || $bExist == false*/){
            $arTemplate['COMPONENTS_PATH'] = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.$template.'/components';   
        }
        return $arTemplate;
    }    
	
	static function DeleteTemplateSpecial()
	{
        $arSiteIDs = array_keys(MibokSpecialSite::GetList());
        $arTemplates = array();
		$obSite = new CSite();
        foreach($arSiteIDs as $arSiteIDsItem)
		{
			$arTmplUpdate = array();
            $dbTemplate = CSite::GetTemplateList($arSiteIDsItem);
            while($arTemplate = $dbTemplate->Fetch())
			{  
                //MKSpecial::p($arTemplate);
				if (!MKSpecial::CheckSpecialTemplate($arTemplate['TEMPLATE']))
					$arTmplUpdate[] = $arTemplate;
            }
			if(!empty($arTmplUpdate))
			{
				MibokSpecialSite::Update($arSiteIDsItem, $arTmplUpdate);
				
			}
        }

	}
}
?>