<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
		"SOCIAL" => array(
			"SORT" => 110,
			"NAME" => GetMessage("SOCIAL"),
		)
	),
	"PARAMETERS" => array(
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BND_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"VK" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_VK"),
			"TYPE" => "STRING",
		),
		"FACEBOOK" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_FACEBOOK"),
			"TYPE" => "STRING",
		),
		"TWITTER" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_TWITTER"),
			"TYPE" => "STRING",
		),
		"ODNOKLASSNIKI" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_ODNOKLASSNIKI"),
			"TYPE" => "STRING",
		),
		"MAILRU" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_MAILRU"),
			"TYPE" => "STRING",
		),
		"LIVEJOURNAL" => array(
			"PARENT" => "SOCIAL",
			"NAME" => GetMessage("SOCIAL_LIVEJOURNAL"),
			"TYPE" => "STRING",
		)
	),
);?>
