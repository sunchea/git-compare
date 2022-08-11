<?
IncludeModuleLangFile(__FILE__);
/** @global CMain $APPLICATION */
global $APPLICATION;
$module_id = "mibok.glaza";
if($APPLICATION->GetGroupRight($module_id)!="D")
{
	$aMenu = array(
		"parent_menu" => "global_menu_settings",
		"section" => $module_id,
		"sort" => 200,
		"text" => GetMessage("mnu_mibok_special"),
		"title" => GetMessage("mnu_mibok_special_title"),
		"icon" => "mibok_special_menu_icon",
		"page_icon" => "mibok_special_page_icon",
		"items_id" => "menu_mibok_glaza",
		"items" => array(
			array(
				"text" => GetMessage("mnu_reindex"),
				"url" => $module_id."_reindex.php?lang=".LANGUAGE_ID,
				"more_url" => Array($module_id."_reindex.php"),
				"title" => GetMessage("mnu_reindex_alt"),
			),
                        array(
				"text" => GetMessage("mnu_exclusion"),
				"url" => $module_id."_exclusion.php?lang=".LANGUAGE_ID,
				"more_url" => Array($module_id."_exclusion.php"),
				"title" => GetMessage("mnu_exclusion_alt"),
			)
		)
	);
	return $aMenu;
}
return false;
?>
