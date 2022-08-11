<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

/*echo "WIZARD_SITE_ID=".WIZARD_SITE_ID." | ";
echo "WIZARD_SITE_PATH=".WIZARD_SITE_PATH." | ";
echo "WIZARD_RELATIVE_PATH=".WIZARD_RELATIVE_PATH." | ";
echo "WIZARD_ABSOLUTE_PATH=".WIZARD_ABSOLUTE_PATH." | ";
echo "WIZARD_TEMPLATE_ID=".WIZARD_TEMPLATE_ID." | ";
echo "WIZARD_TEMPLATE_RELATIVE_PATH=".WIZARD_TEMPLATE_RELATIVE_PATH." | ";
echo "WIZARD_TEMPLATE_ABSOLUTE_PATH=".WIZARD_TEMPLATE_ABSOLUTE_PATH." | ";
echo "WIZARD_THEME_ID=".WIZARD_THEME_ID." | ";
echo "WIZARD_THEME_RELATIVE_PATH=".WIZARD_THEME_RELATIVE_PATH." | ";
echo "WIZARD_THEME_ABSOLUTE_PATH=".WIZARD_THEME_ABSOLUTE_PATH." | ";
echo "WIZARD_SERVICE_RELATIVE_PATH=".WIZARD_SERVICE_RELATIVE_PATH." | ";
echo "WIZARD_SERVICE_ABSOLUTE_PATH=".WIZARD_SERVICE_ABSOLUTE_PATH." | ";
echo "WIZARD_IS_RERUN=".WIZARD_IS_RERUN." | ";
die(); */

//$templatesPath = WizardServices::GetTemplatesPath('/bitrix');            
//$arTemplatesAll = WizardServices::GetTemplates($templatesPath);
$arTemplatesBitr = array();
$arTemplatesLocal = array();
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'))
{
    $templatesPath = WizardServices::GetTemplatesPath('/bitrix');            
    $arTemplatesBitr = WizardServices::GetTemplates($templatesPath);
}
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'))
{
    $templatesPath = WizardServices::GetTemplatesPath('/local');            
    $arTemplatesLocal = WizardServices::GetTemplates($templatesPath);
}
$arTemplatesAll = array_merge($arTemplatesBitr, $arTemplatesLocal);


$arSiteTemplates = MibokSpecialSiteTemplates::GetList($wizard->GetVar('siteID'));

foreach($arSiteTemplates as $arSiteTemplatesItem){
    $arSiteTemplatesName[] = $arSiteTemplatesItem['TEMPLATE'];
}
foreach($arTemplatesAll as $template_name=>$arTemplatesAllItem){
    if(in_array($template_name, $arSiteTemplatesName)){
        $arTemplates[$template_name] = $arTemplatesAllItem;
    }
}   

$templateID = $wizard->GetVar("templateID");
$siteID = $wizard->GetVar("siteID");

if (!is_array($templateID) || count($templateID) == 0){
    return;
}

$arExcludeTemplate = array();
foreach($arTemplates as $key=>$arTemplatesItem){
    if(!in_array($key, $templateID)){
        $arExcludeTemplate[] = $key;
    }
}

global $arTypeMenu;
$arTypeMenu = array();

$obMibokSpecialSite = new MibokSpecialSite($siteID, $arExcludeTemplate);
$obMibokSpecialSite->CopySiteTemplates();
$obMibokSpecialSite->CopySiteComponentTemplates();
MibokSpecialExclusion::GenerateExlusion();
$arTypeMenu = array();

//copy custom.css and custom.js
$arTemplate = MibokSpecialSiteTemplates::GetList();
foreach($arTemplate as $arSiteTemplatesItem)
{
    if(MKSpecial::CheckSpecialTemplate($arSiteTemplatesItem['TEMPLATE']))
    {
        CopyDirFiles(WIZARD_SERVICE_ABSOLUTE_PATH."/custom/custom.css", $arSiteTemplatesItem['PATH']."/css/custom.css", false, false);
        CopyDirFiles(WIZARD_SERVICE_ABSOLUTE_PATH."/custom/custom.js", $arSiteTemplatesItem['PATH']."/js/custom.js", false, false);
    }
}

?>
