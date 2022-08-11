<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) return;
	
if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ID")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;
if(!defined("WIZARD_THEME_ID")) return;

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
//$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/";

$iblockShortCODE = "stock";
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/".$iblockShortCODE.".xml";
$iblockTYPE = "aspro_allcorp_content";
$iblockXMLID = "aspro_allcorp_".$iblockShortCODE."_".WIZARD_SITE_ID;
$iblockCODE = "aspro_allcorp_".$iblockShortCODE;
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockXMLID, "TYPE" => $iblockTYPE));
if ($arIBlock = $rsIBlock->Fetch()) {
	$iblockID = $arIBlock["ID"]; 
	if (WIZARD_INSTALL_DEMO_DATA) {
		// delete if already exist & need install demo
		CIBlock::Delete($arIBlock["ID"]); 
		$iblockID = false; 
	}
}
	
if(WIZARD_INSTALL_DEMO_DATA){
	if(!$iblockID){
		// add new iblock
		$permissions = array("1" => "X", "2" => "R");
		$dbGroup = CGroup::GetList($by = "", $order = "", array("STRING_ID" => "content_editor"));
		if($arGroup = $dbGroup->Fetch()){
			$permissions[$arGroup["ID"]] = 'W';
		};
		
		// replace macros IN_XML_SITE_ID & IN_XML_SITE_DIR in xml file - for correct url links to site
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
			@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
		}
		@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back");
		CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, Array("IN_XML_SITE_DIR" => WIZARD_SITE_DIR));
		CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, Array("IN_XML_SITE_ID" => WIZARD_SITE_ID));
		$iblockID = WizardServices::ImportIBlockFromXML($iblockXMLFile, $iblockCODE, $iblockTYPE, WIZARD_SITE_ID, $permissions);
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
			@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
		}
		if ($iblockID < 1)	return;
			
		// iblock fields
		$iblock = new CIBlock;
		$arFields = array(
			"ACTIVE" => "Y",
			"CODE" => $iblockCODE,
			"XML_ID" => $iblockXMLID,
			"FIELDS" => array(
				'IBLOCK_SECTION' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				),
				'ACTIVE' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => 'Y',
				),
				'ACTIVE_FROM' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				),
				'ACTIVE_TO' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				),
				'SORT' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'NAME' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => '',
				), 
				'PREVIEW_PICTURE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'FROM_DETAIL' => 'Y',
						'SCALE' => 'Y',
						'WIDTH' => '200',
						'HEIGHT' => '200',
						'IGNORE_ERRORS' => 'N',
						'METHOD' => 'resample',
						'COMPRESSION' => 95,
						'DELETE_WITH_DETAIL' => 'N',
						'UPDATE_WITH_DETAIL' => 'N',
					),
				), 
				'PREVIEW_TEXT_TYPE' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => 'text',
				), 
				'PREVIEW_TEXT' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'DETAIL_PICTURE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'SCALE' => 'Y',
						'WIDTH' => '1500',
						'HEIGHT' => '1500',
						'IGNORE_ERRORS' => 'N',
						'METHOD' => 'resample',
						'COMPRESSION' => 95,
					),
				), 
				'DETAIL_TEXT_TYPE' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => 'text',
				), 
				'DETAIL_TEXT' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'XML_ID' =>  array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'CODE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'UNIQUE' => 'Y',
						'TRANSLITERATION' => 'Y',
						'TRANS_LEN' => 100,
						'TRANS_CASE' => 'L',
						'TRANS_SPACE' => '-',
						'TRANS_OTHER' => '-',
						'TRANS_EAT' => 'Y',
						'USE_GOOGLE' => 'N',
					),
				),
				'TAGS' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'SECTION_NAME' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => '',
				), 
				'SECTION_PICTURE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'FROM_DETAIL' => 'Y',
						'SCALE' => 'Y',
						'WIDTH' => '200',
						'HEIGHT' => '200',
						'IGNORE_ERRORS' => 'N',
						'METHOD' => 'resample',
						'COMPRESSION' => 95,
						'DELETE_WITH_DETAIL' => 'Y',
						'UPDATE_WITH_DETAIL' => 'Y',
					),
				), 
				'SECTION_DESCRIPTION_TYPE' => array(
					'IS_REQUIRED' => 'Y',
					'DEFAULT_VALUE' => 'text',
				), 
				'SECTION_DESCRIPTION' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'SECTION_DETAIL_PICTURE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'SCALE' => 'Y',
						'WIDTH' => '1500',
						'HEIGHT' => '1500',
						'IGNORE_ERRORS' => 'N',
						'METHOD' => 'resample',
						'COMPRESSION' => 95,
					),
				), 
				'SECTION_XML_ID' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => '',
				), 
				'SECTION_CODE' => array(
					'IS_REQUIRED' => 'N',
					'DEFAULT_VALUE' => array(
						'UNIQUE' => 'Y',
						'TRANSLITERATION' => 'Y',
						'TRANS_LEN' => 100,
						'TRANS_CASE' => 'L',
						'TRANS_SPACE' => '-',
						'TRANS_OTHER' => '-',
						'TRANS_EAT' => 'Y',
						'USE_GOOGLE' => 'N',
					),
				), 
			),
		);
		
		$iblock->Update($iblockID, $arFields);
	}
	else{
		// attach iblock to site
		$arSites = array(); 
		$db_res = CIBlock::GetSite($iblockID);
		while ($res = $db_res->Fetch())
			$arSites[] = $res["LID"]; 
		if (!in_array(WIZARD_SITE_ID, $arSites)){
			$arSites[] = WIZARD_SITE_ID;
			$iblock = new CIBlock;
			$iblock->Update($iblockID, array("LID" => $arSites));
		}
	}

	// iblock user fields
	$dbSite = CSite::GetByID(WIZARD_SITE_ID);
	if($arSite = $dbSite -> Fetch()) $lang = $arSite["LANGUAGE_ID"];
	if(!strlen($lang)) $lang = "ru";
	WizardServices::IncludeServiceLang("editform_useroptions.php", $lang);
	$arProperty = array();
	$dbProperty = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockID));
	while($arProp = $dbProperty->Fetch())
		$arProperty[$arProp["CODE"]] = $arProp["ID"];

	// edit form user oprions
	CUserOptions::SetOption("form", "form_element_".$iblockID, array(
		'tabs' => 'edit1--#--'.GetMessage("WZD_IBLOCK_STOCK").'--,--ACTIVE--#--'.GetMessage("WZD_OPTION_ACTIVE").'--,--ACTIVE_FROM--#--'.GetMessage("WZD_OPTION_ACTIVE_FROM").'--,--ACTIVE_TO--#--'.GetMessage("WZD_OPTION_ACTIVE_TO").'--,--NAME--#--'.GetMessage("WZD_OPTION_NAME_").'--,--CODE--#--'.GetMessage("WZD_OPTION_CODE").'--,--SORT--#--'.GetMessage("WZD_OPTION_SORT").'--,--PROPERTY_'.$arProperty["PERIOD"].'--#--'.GetMessage("WZD_OPTION_PROP_PERIOD").'--,--PROPERTY_'.$arProperty["FORM_QUESTION"].'--#--'.GetMessage("WZD_OPTION_PROP_FORM_QUESTION").'--,--PROPERTY_'.$arProperty["FORM_ORDER"].'--#--'.GetMessage("WZD_OPTION_PROP_FORM_ORDER").'--;--edit5--#--'.GetMessage("WZD_PREVIEW").'--,--PREVIEW_PICTURE--#--'.GetMessage("WZD_OPTION_PREVIEW_PICTURE").'--,--PREVIEW_TEXT--#--'.GetMessage("WZD_OPTION_PREVIEW_TEXT").'--;--edit6--#--'.GetMessage("WZD_DETAIL").'--,--DETAIL_PICTURE--#--'.GetMessage("WZD_OPTION_DETAIL_PICTURE").'--,--PROPERTY_'.$arProperty["PHOTOPOS"].'--#--'.GetMessage("WZD_OPTION_PROP_PHOTOPOS").'--,--PROPERTY_'.$arProperty["PHOTOS"].'--#--'.GetMessage("WZD_OPTION_PROP_PHOTOS").'--,--PROPERTY_'.$arProperty["DOCUMENTS"].'--#--'.GetMessage("WZD_OPTION_PROP_DOCUMENTS").'--,--DETAIL_TEXT--#--'.GetMessage("WZD_OPTION_DETAIL_TEXT").'--;--cedit--#--'.GetMessage("WZD_LINKS").'--,--PROPERTY_'.$arProperty["LINK_GOODS"].'--#--'.GetMessage("WZD_OPTION_PROP_LINK_GOODS").'--,--PROPERTY_'.$arProperty["LINK_SERVICES"].'--#--'.GetMessage("WZD_OPTION_PROP_LINK_SERVICES").'--;--edit14--#--'.GetMessage("WZD_SEO").'--,'.GetMessage("WZD_OPTION_SEOALL").';--edit2--#--'.GetMessage("WZD_SECTIONS").'--,--SECTIONS--#--'.GetMessage("WZD_OPTION_SECTIONS").'--;--',
	));
	// list user options
	CUserOptions::SetOption("list", "tbl_iblock_list_".md5($iblockTYPE.".".$iblockID), array(
		'columns' => 'NAME,PREVIEW_PICTURE,PROPERTY_'.$arProperty["PERIOD"].',ACTIVE,SORT,TIMESTAMP_X,ID', 'by' => 'sort', 'order' => 'asc', 'page_size' => '20', 
	));
}

if ($iblockID){
	// replace macros IBLOCK_TYPE & IBLOCK_ID & IBLOCK_CODE
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_STOCK_TYPE" => $iblockTYPE));
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_STOCK_ID" => $iblockID));
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("IBLOCK_STOCK_CODE" => $iblockCODE));
	CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_STOCK_TYPE" => $iblockTYPE));
	CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_STOCK_ID" => $iblockID));
	CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("IBLOCK_STOCK_CODE" => $iblockCODE));
}
?>