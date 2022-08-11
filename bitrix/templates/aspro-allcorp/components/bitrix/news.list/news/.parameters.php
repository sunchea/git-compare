<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();
$arTemplateParameters = array(
	"IMAGE_POSITION" => array(
		"SORT" => 250,
		"NAME" => GetMessage("IMAGE_POSITION"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"left" => GetMessage("IMAGE_POSITION_LEFT"),
			"right" => GetMessage("IMAGE_POSITION_RIGHT"),
		),
		"DEFAULT" => "left",
	),
	"USE_SHARE" => array(
		"SORT" => 600,
		"NAME" => GetMessage("USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	)
);
?>