<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => array(
			"public.php",
			"template.php",
			"theme.php",
			"menu.php",
			"settings.php",
		),
	),
	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
		"STAGES" => Array(
			"types.php",
			"advt.php", 
			"main-links.php", 
			"history.php",
			"licenses.php",
			"partners.php",
			"faq.php",
			"staff.php",
			"vacancy.php",
			"reviews.php",
			"projects.php",
			"catalog.php",
			"services.php",
			"stock.php", 
			"news.php",
			"articles.php",
			"links.php",
			"forms.php",
		),
	),
	"search" => array(
		"NAME" => GetMessage("SERVICE_SEARCH"),
		"STAGES" => array(
			"search.php",
			"site_name.php",
		),
	),
);
?>