<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ID")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;
if(!defined("WIZARD_THEME_ID")) return;

if(!WIZARD_INSTALL_DEMO_DATA){
	return;
}

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
//$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/";

// copy files
CopyDirFiles(
    WIZARD_TEMPLATE_ABSOLUTE_PATH."/themes/",
    $bitrixTemplateDir."themes/",
    $rewrite = true, 
    $recursive = true,
    $delete_after_copy = false,
    $exclude = "description.php"
);

// favicon
CopyDirFiles(
	WIZARD_TEMPLATE_ABSOLUTE_PATH."/themes/".WIZARD_THEME_ID."/images/favicon.ico",
	WIZARD_SITE_PATH."/favicon.ico",
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false
);

COption::SetOptionString("main", "wizard_".WIZARD_TEMPLATE_ID."_theme_id", WIZARD_THEME_ID, "", WIZARD_SITE_ID);

// theme
COption::SetOptionString("aspro.allcorp", "COLOR", WIZARD_THEME_ID, "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "THEME_SWITCHER", "N", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "WIDTH", "auto", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "MENU", "first", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SIDEMENU", "left", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "PHONE_MASK", "+7 (999) 999-99-99", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "VALIDATE_PHONE_MASK", "^[+][0-9] [(][0-9]{3}[)] [0-9]{3}[-][0-9]{2}[-][0-9]{2}$", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "VALIDATE_FILE_EXT", "png|jpg|jpeg|gif|doc|docx|xls|xlsx|txt|pdf|odt|rtf", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "DATE_FORMAT", "dot", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "USE_CAPTCHA_FORM", "N", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "CATALOG_INDEX", "N", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "SERVICES_INDEX", "Y", "", WIZARD_SITE_ID);
COption::SetOptionString("aspro.allcorp", "FILTER_VIEW", "NONE", "", WIZARD_SITE_ID);

// captcha colors
COption::SetOptionString("main", "CAPTCHA_arBorderColor", "BDBDBD");
COption::SetOptionString("main", "CAPTCHA_arTextColor_1", "636363");
COption::SetOptionString("main", "CAPTCHA_arTextColor_2", "636363");

// color scheme for main.interface.grid/form
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/classes/".strToLower($GLOBALS["DB"]->type)."/favorites.php");
CUserOptions::SetOption("main.interface", "global", array("theme" => WIZARD_THEME_ID), true);
?>