<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();

/* show sort property */
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
$arPropertySort=array();
$arPropertySort["name"] = GetMessage('V_NAME');
$arPropertySort["sort"] = GetMessage('V_SORT');
while ($arr=$rsProp->Fetch())
{
	$arPropertySort[$arr["CODE"]] = $arr["NAME"];
}

/* show view template */
$arPropertyView = array("list" => GetMessage('V_LIST'), "table" => GetMessage('V_TABLE'));

/* show sort direction */
$arSortDirection = array("asc" => GetMessage('SD_ASC'), "desc" => GetMessage('SD_DESC'));

$arTemplateParameters = array(
	"VIEW_TYPE" => array(
		"SORT" => 100,
		"NAME" => GetMessage("VIEW_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"list" => GetMessage("VIEW_TYPE_LIST"),
			"table" => GetMessage("VIEW_TYPE_TABLE"),
			/*"accordion" => GetMessage("VIEW_TYPE_ACCORDION"),*/
		),
		"DEFAULT" => "list",
		"REFRESH" => "Y"
	),
	/*"SHOW_TABS" => array(
		"SORT" => 100,
		"NAME" => GetMessage("SHOW_TABS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),*/
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
	"SORT_PROP" => array(
		"PARENT" => "DATA_SOURCE",
		"NAME" => GetMessage('T_SORT_PROP'),
		"TYPE" => "LIST",
		"VALUES" => $arPropertySort,
		"SIZE" => 3,
		"MULTIPLE" => "Y"
	),
	"SORT_PROP_DEFAULT" => array(
		"PARENT" => "DATA_SOURCE",
		"NAME" => GetMessage('T_SORT_PROP_DEFAULT'),
		"TYPE" => "LIST",
		"VALUES" => $arPropertySort
	),
	"SORT_DIRECTION" => array(
		"PARENT" => "DATA_SOURCE",
		"NAME" => GetMessage('T_SORT_DIRECTION'),
		"TYPE" => "LIST",
		"VALUES" => $arSortDirection
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
}
?>
