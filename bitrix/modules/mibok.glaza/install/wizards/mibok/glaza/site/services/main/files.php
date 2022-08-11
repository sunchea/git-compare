<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID"))
	return;

if (!defined("WIZARD_SITE_DIR"))
	return;
 

$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"); 


$handle = @opendir($path);
if ($handle)
{
        while ($file = readdir($handle))
        {
                if (in_array($file, array(".", "..")))
                        continue; 
/*			elseif (
                        is_file($path.$file) 
                        && 
                        (
                                ($file == "index.php"  && trim(WIZARD_SITE_PATH, " /") == trim(WIZARD_SITE_ROOT_PATH, " /"))
                                || 
                                ($file == "_index.php" && trim(WIZARD_SITE_PATH, " /") != trim(WIZARD_SITE_ROOT_PATH, " /"))
                        )
                )
                        continue; 
*/
                CopyDirFiles(
                        $path.$file,
                        WIZARD_SITE_PATH."/".$file,
                        $rewrite = true, 
                        $recursive = true,
                        $delete_after_copy = false
                );
        }
}	


function ___writeToAreasFile($fn, $text)
{
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
		@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}

CheckDirPath(WIZARD_SITE_PATH."glaza_mibok_include/");

$wizard =& $this->GetWizard();

___writeToAreasFile(WIZARD_SITE_PATH."glaza_mibok_include/site_slogan.php", $wizard->GetVar("siteSlogan"));
___writeToAreasFile(WIZARD_SITE_PATH."glaza_mibok_include/site_address.php", $wizard->GetVar("siteAddress"));
___writeToAreasFile(WIZARD_SITE_PATH."glaza_mibok_include/site_email.php", $wizard->GetVar("siteEmail"));
___writeToAreasFile(WIZARD_SITE_PATH."glaza_mibok_include/site_phone.php", $wizard->GetVar("sitePhone"));
___writeToAreasFile(WIZARD_SITE_PATH."glaza_mibok_include/site_copy.php", $wizard->GetVar("siteCopy"));

/*if(LANG_CHARSET == 'windows-1251'){
	$special_menu_path = WIZARD_SITE_PATH."/.glazamibok.menu.php";
	$special_menu_content = file_get_contents($special_menu_path);
	file_put_contents($special_menu_path, iconv('UTF-8', 'CP1251', $special_menu_content));
}*/


if(LANG_CHARSET != 'windows-1251'){
	$special_js_path = WIZARD_ABSOLUTE_PATH."/site/templates/site_template/js/app.js";
	$special_js_content = file_get_contents($special_js_path);
	file_put_contents($special_js_path, mb_convert_encoding($special_js_content, 'UTF-8', 'CP1251'));
	
	$special_js_path = WIZARD_ABSOLUTE_PATH."/site/templates/site_template/js/voice.js";
	$special_js_content = file_get_contents($special_js_path);
	file_put_contents($special_js_path, mb_convert_encoding($special_js_content, 'UTF-8', 'CP1251'));
}
/*if(LANG_CHARSET == 'windows-1251')
{	
	$special_js_path = WIZARD_ABSOLUTE_PATH."/site/templates/site_template/js/voice.js";
	$special_js_content = file_get_contents($special_js_path);
	file_put_contents($special_js_path, iconv('UTF-8', 'CP1251', $special_js_content));
}*/


UnRegisterModuleDependences('main', 'OnBeforeProlog', 'main', 'CWizardSolPanel', 'ShowPanel', '/modules/main/install/wizard_sol/panel_button.php');
?>