<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;

function ___writeToAreasFile($fn, $text){
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS")){
		@chmod($abs_path, BX_FILE_PERMISSIONS);
	}
	if(!$fd = @fopen($fn, "wb")){
		return false;
	}
	if(!$res = @fwrite($fd, $text)){
		@fclose($fd);
		return false;
	}
	@fclose($fd);
	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
//$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/";
$wizard =& $this->GetWizard();

if(COption::GetOptionString("main", "upload_dir") == ""){
	COption::SetOptionString("main", "upload_dir", "upload");
}

if(COption::GetOptionString("aspro.allcorp", "wizard_installed", "N") == 'N'){
	// if need add to init.php
	//$file = fopen(WIZARD_SITE_ROOT_PATH."/bitrix/php_interface/init.php", "ab");
	//fwrite($file, file_get_contents(WIZARD_ABSOLUTE_PATH."/site/services/main/bitrix/init.php"));
	//fclose($file);
	COption::SetOptionString("aspro.allcorp", "wizard_installed", "Y");
}

if(WIZARD_INSTALL_DEMO_DATA){
	// copy files
	CopyDirFiles(
		str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"),
		WIZARD_SITE_PATH,
		$rewrite = true, 
		$recursive = true,
		$delete_after_copy = false,
		$exclude = "bitrix"
	);

	// favicon
	@copy(WIZARD_THEME_ABSOLUTE_PATH."/favicon.ico", WIZARD_SITE_PATH."favicon.ico");
	
	// .htaccess
	WizardServices::PatchHtaccess(WIZARD_SITE_PATH);
	
	// replace macros SITE_DIR & SITE_ID
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_DIR" => WIZARD_SITE_DIR));
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_ID" => WIZARD_SITE_ID));

	// add to UrlRewrite
	$arUrlRewrite = array(); 
	if(file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php")){
		include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
	}
	
	$arNewUrlRewrite = array(
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."company/partners/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."company/partners/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."company/licenses/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."company/licenses/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."company/history/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."company/history/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."company/vacancy/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."company/vacancy/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."company/staff/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."company/staff/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."info/articles/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."info/articles/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."info/stock/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."info/stock/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."info/news/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."info/news/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."info/faq/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."info/faq/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."services/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."services/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."projects/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."projects/index.php",
			"SORT" => "100",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."catalog/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."catalog/index.php",
		),
	);
	
	foreach($arNewUrlRewrite as $arUrl){
		if(!in_array($arUrl, $arUrlRewrite)){
			CUrlRewriter::Add($arUrl);
		}
	}
}

CheckDirPath(WIZARD_SITE_PATH."include/");

// site name
if($wizard->GetVar('siteNameSet', true)){
	$siteName = $wizard->GetVar("siteName");
	COption::SetOptionString("main", "site_name", $siteName);	
	$obSite = new CSite;
	$arFields = array("NAME" => $siteName, "SITE_NAME" => $siteName);			
	$siteRes = $obSite->Update(WIZARD_SITE_ID, $arFields);
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("SITE_NAME" => $siteName));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."company/", Array("SITE_NAME" => $siteName));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."contacts/", Array("SITE_NAME" => $siteName));
}
// copyright
___writeToAreasFile(WIZARD_SITE_PATH."include/copy.php", $wizard->GetVar("siteCopy"));
// phone
$sitePhone = $wizard->GetVar("siteTelephone");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include/site-phone.php", Array("SITE_PHONE" => $sitePhone));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."contacts/index.php", Array("SITE_PHONE" => $sitePhone));
// email
$siteEmail = $wizard->GetVar("siteEmail");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include/site-email.php", Array("SITE_EMAIL" => $siteEmail));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."contacts/index.php", Array("SITE_EMAIL" => $siteEmail));
// skype
$siteSkype = $wizard->GetVar("siteSkype");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include/site-skype.php", Array("SITE_SKYPE" => $siteSkype));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."contacts/index.php", Array("SITE_SKYPE" => $siteSkype));
// address
$siteAddress = $wizard->GetVar("siteAddress");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include/site-address.php", Array("SITE_ADDRESS" => $siteAddress));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."contacts/index.php", Array("SITE_ADDRESS" => $siteAddress));
// schedule
$siteSchedule = $wizard->GetVar("siteSchedule");
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."contacts/index.php", Array("SITE_SCHEDULE" => $siteSchedule));
// meta
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));
// socials
COption::SetOptionString("aspro.allcorp", "SOCIAL_VK", $wizard->GetVar("shopVk"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_FACEBOOK", $wizard->GetVar("shopFacebook"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_TWITTER", $wizard->GetVar("shopTwitter"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_ODNOKLASSNIKI", $wizard->GetVar("shopOdnoklassniki"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_MAILRU", $wizard->GetVar("shopMailru"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_LIVEJOURNAL", $wizard->GetVar("shopLiveJournal"), "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SOCIAL_GOOGLE", $wizard->GetVar("shopGoogle"), "", WIZARD_SITE_ID);

// rewrite /index.php
if($wizard->GetVar('rewriteIndex', true)){
	CopyDirFiles(
		WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/_index.php",
		WIZARD_SITE_PATH."/index.php",
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false
	);
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
}

DeleteDirFilesEx(WIZARD_SITE_PATH."/.left.menu_ext.php");
DeleteDirFilesEx(WIZARD_SITE_PATH."/.bottom.menu_ext.php");
DeleteDirFilesEx(WIZARD_SITE_PATH."/.top.menu_ext.php");
DeleteDirFilesEx(WIZARD_SITE_PATH."/_index.php");
?>