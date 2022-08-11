<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();

$arTemplateParameters = array(
	"VIEW_TYPE" => array(
		"SORT" => 100,
		"NAME" => GetMessage("VIEW_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"list" => GetMessage("VIEW_TYPE_LIST"),
			"table" => GetMessage("VIEW_TYPE_TABLE"),			
			"price" => GetMessage("VIEW_TYPE_TABLE"),			
			"accordion" => GetMessage("VIEW_TYPE_ACCORDION"),
		),
		"DEFAULT" => "list",
		"REFRESH" => "Y"
	),
	"SHOW_TABS" => array(
		"SORT" => 100,
		"NAME" => GetMessage("SHOW_TABS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_IMAGE" => array(
		"SORT" => 200,
		"NAME" => GetMessage("SHOW_IMAGE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"REFRESH" => "Y"
	),
	"SHOW_NAME" => array(
		"SORT" => 300,
		"NAME" => GetMessage("SHOW_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_DETAIL" => array(
		"SORT" => 400,
		"NAME" => GetMessage("SHOW_DETAIL"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
);

if( $arCurrentValues["SHOW_IMAGE"] == "Y" ){
	if( $arCurrentValues["VIEW_TYPE"] == "list" ){
		$arTemplateParameters["IMAGE_POSITION"] = array(
			"SORT" => 250,
			"NAME" => GetMessage("IMAGE_POSITION"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"left" => GetMessage("IMAGE_POSITION_LEFT"),
				"right" => GetMessage("IMAGE_POSITION_RIGHT"),
			),
			"DEFAULT" => "left",
		);
	}elseif( $arCurrentValues["VIEW_TYPE"] == "table" ){
		$arTemplateParameters["IMAGE_POSITION"] = array(
			"SORT" => 250,
			"NAME" => GetMessage("IMAGE_POSITION"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"top" => GetMessage("IMAGE_POSITION_TOP"),
				"bottom" => GetMessage("IMAGE_POSITION_BOTTOM"),
			),
			"DEFAULT" => "top",
		);
	}
}

if( $arCurrentValues["VIEW_TYPE"] == "table" ){
	$arTemplateParameters["COUNT_IN_LINE"] = array(
		"NAME" => GetMessage("COUNT_IN_LINE"),
		"TYPE" => "STRING",
		"DEFAULT" => "3",
	);
}?>
