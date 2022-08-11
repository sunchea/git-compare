<?

IncludeModuleLangFile(__FILE__);


//define('MIBOK_SPECIAL_MASTER_TEMPLATE_PATH', $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/mibok.special/site_template');
define('MIBOK_SPECIAL_MASTER_TEMPLATE_PATH', $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/mibok.glaza/install/wizards/mibok/glaza/site/templates/site_template');
define('MIBOK_SPECIAL_PREFIX', 'special_mibok');
define('MIBOK_SPECIAL_PREFIX_GET', 'special_version');

CModule::AddAutoloadClasses(
    "mibok.glaza", array(
        "MibokSpecialUtil"                   => "classes/general/mibok_special_util.php",
        "MibokSpecialParse"                  => "classes/general/mibok_special_parse.php",
        "MibokSpecialParseCompare"           => "classes/general/mibok_special_parse_compare.php",
        "MibokSpecialParseComponent"         => "classes/general/mibok_special_parse_component.php",
        "MibokSpecialParseComponentMenu"     => "classes/general/mibok_special_parse_component_menu.php",
        "MibokSpecialSiteComponentTemplates" => "classes/general/mibok_special_site_component_templates.php",
        "MibokSpecialSiteTemplates"          => "classes/general/mibok_special_site_templates.php",
        "MibokSpecialSite"                   => "classes/general/mibok_special_site.php",
        "MibokSpecialExclusion"              => "classes/general/mibok_special_exclusion.php",
        'MibokSpecialVoice'                  => 'lib/voice.php'
    )
);

class MKSpecial{
    function p($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    function CheckSpecialTemplate($template_name){
        if(strpos($template_name, 'special_mibok') === false){
            return false;
        }
        return true;
    }
    function ShowPanel(){
        if($GLOBALS["USER"]->IsAdmin() && COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "mibok_glaza"){
            $GLOBALS["APPLICATION"]->AddPanelButton(array(
                "HREF" => "/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardName=mibok:glaza&wizardSiteID=".SITE_ID."&".bitrix_sessid_get(),
                "ID" => "mibok_glaza",
                "ICON" => "bx-panel-site-wizard-icon",
                "MAIN_SORT" => 2500,
                "TYPE" => "BIG",
                "SORT" => 10,
                "ALT" => GetMessage("SCOM_BUTTON_DESCRIPTION"),
                "TEXT" => GetMessage("SCOM_BUTTON_NAME"),
                "MENU" => array(),
            ));
        }
    }
    function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu){
        $MODULE_ID = basename(dirname(__FILE__));
        
        if(file_exists($path = dirname(__FILE__).'/admin')){
            if($dir = opendir($path)){
                while(false !== $item = readdir($dir)){
                    if(in_array($item, array('.', '..', 'menu.php')))
                        continue;
                    
                    if(!file_exists($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$MODULE_ID.'_'.$item))
                        file_put_contents($file, '<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.$MODULE_ID.'/admin/'.$item.'");?'.'>');                 
                }                
            }
        }
    }
    function OnBeforeProlog(){        
        if(strpos(SITE_TEMPLATE_ID, 'special_mibok') !== false){
            global $APPLICATION;            
            $obComponents = MibokSpecialParse::ParsePage($_SERVER['DOCUMENT_ROOT'].$APPLICATION->GetCurPage());    
            
			if(is_array($obComponents))
			{				
				foreach($obComponents as $obComponentsItem){
					//MKSpecial::p((int)$obComponentsItem->CheckExclude());
					//MKSpecial::p($obComponentsItem);
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'.SITE_TEMPLATE_ID)){
                        $template_path = $_SERVER['DOCUMENT_ROOT'].'/local/templates/'.SITE_TEMPLATE_ID.'/components/'.$obComponentsItem->GetPathValue(); 
                    }
                    elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.SITE_TEMPLATE_ID)){
                        $template_path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.SITE_TEMPLATE_ID.'/components/'.$obComponentsItem->GetPathValue();    
                    }  
					$master_path = MIBOK_SPECIAL_MASTER_TEMPLATE_PATH.'/components/'.$obComponentsItem->GetDefaultPathValue();
					if(!file_exists($template_path) && file_exists($master_path)){
						$bNotExist = true;                                 
						MibokSpecialUtil::CopyDir($master_path, $template_path);
					}
				}
			}         
            if(COption::GetOptionString("mibok.glaza", "off_reindex") != 'Y')
            {
                $arNeedReindex = MibokSpecialParseCompare::GetNeedReindex();
                $res = array_sum($arNeedReindex);
                if($res>0){
                    #$dbNotify = CAdminNotify::GetList(array('ID' => 'DESC'), array('MODULE_ID'=>'mibok.glaza', 'TAG'=>'MIBOK_SPECIAL_NEED_REINDEX'));
                    #if(!$dbNotify->SelectedRowsCount()){
                        $arNotify = Array(
                            "MESSAGE" => GetMessage("SEARCH_REINDEX_NEED").'. '.GetMessage("SEARCH_REINDEX_NEED_TOTAL")." <b>".$res."</b>".GetMessage("SEARCH_REINDEX_MAKE"),
                            "TAG" => "MIBOK_SPECIAL_NEED_REINDEX",
                            "MODULE_ID" => "mibok.glaza",
                            "ENABLE_CLOSE" => "N"
                        );
                        CAdminNotify::Add($arNotify);                
                    #}
                }
            }
        }
    }
}
?>