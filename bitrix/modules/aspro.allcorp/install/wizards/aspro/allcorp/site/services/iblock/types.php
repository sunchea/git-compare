<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) return;

if (COption::GetOptionString("aspro.allcorp", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA){
	return;
}

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
//$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/";

// add iblock types
$arTypes = array(
	array(
		"ID" => "aspro_allcorp_catalog",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 100,
		"LANG" => array(),
	),
	array(
		"ID" => "aspro_allcorp_content",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 200,
		"LANG" => array(),
	),
	array(
		"ID" => "aspro_allcorp_form",
		"SECTIONS" => "N",
		"IN_RSS" => "N",
		"SORT" => 300,
		"LANG" => array(),
	),
);

$arLanguages = array();
$rsLanguage = CLanguage::GetList($by, $order, array());
while($arLanguage = $rsLanguage->Fetch())
	$arLanguages[] = $arLanguage["LID"];

$iblockType = new CIBlockType;
foreach($arTypes as $arType){
	$dbType = CIBlockType::GetList(array(), array("=ID" => $arType["ID"]));
	if($dbType->Fetch()){
		// already exist - don`t add
		continue;
	}

	foreach($arLanguages as $languageID){
		WizardServices::IncludeServiceLang("types.php", $languageID);
		$code = strtoupper($arType["ID"]);
		$arType["LANG"][$languageID]["NAME"] = GetMessage($code."_TYPE_NAME");
		$arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code."_ELEMENT_NAME");
		if ($arType["SECTIONS"] == "Y"){
			$arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code."_SECTION_NAME");
		}
	}

	$iblockType->Add($arType);
}

// replace macros IBLOCK_ALLCORP_CATALOG_TYPE & IBLOCK_ALLCORP_CONTENT_TYPE & IBLOCK_ALLCORP_FORM_TYPE
CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_ALLCORP_CATALOG_TYPE" => "aspro_allcorp_catalog"));
CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_ALLCORP_CONTENT_TYPE" => "aspro_allcorp_content"));
CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_ALLCORP_FORM_TYPE" => "aspro_allcorp_form"));
CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_ALLCORP_CATALOG_TYPE" => "aspro_allcorp_catalog"));
CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_ALLCORP_CONTENT_TYPE" => "aspro_allcorp_content"));
CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_ALLCORP_FORM_TYPE" => "aspro_allcorp_form"));

COption::SetOptionString('iblock','combined_list_mode','Y');
?>