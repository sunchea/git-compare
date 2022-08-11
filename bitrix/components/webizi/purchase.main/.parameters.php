<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arProperty = array(
	"EMPTY" => "",
	"NAME" => GetMessage("WI_PARAM_NAME"),
	"PREVIEW_TEXT" => GetMessage("WI_PARAM_PREVIEW_TEXT"),
	"DETAIL_TEXT" => GetMessage("WI_PARAM_DETAIL_TEXT"),
	"DATE_ACTIVE_FROM" => GetMessage("WI_PARAM_DATE_ACTIVE_FROM"),
	"DATE_ACTIVE_TO" => GetMessage("WI_PARAM_DATE_ACTIVE_TO"),
	);

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-" => " "));

$arIBlocks = array();
$db_iblock = CIBlock::GetList(
	array("SORT"=>"ASC"), 
	array(
		"ACTIVE" => "Y",
		"SITE_ID" => $_REQUEST["site"],
		"TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")
		)
	);

while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$rsProperty = CIBlockProperty::GetList(
	Array("ID" => "ASC", "ID" => "ASC"),
	Array("ACTIVE" => "Y",
		"IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"])
	);

while ($prop_fields = $rsProperty->GetNext(false, false))
{
	$arProperty[$prop_fields["CODE"]] = $prop_fields["NAME"];
}

$arComponentParameters = array(
	"GROUPS" => array(
		"COMPARISON" => array("NAME" => GetMessage("WI_PARAM_FIELD_MAPPING")),
		"CACHE" => array("NAME" => GetMessage("WI_PARAM_CACHE_SETTINGS")),
		),
	"PARAMETERS" => array(
		"SET_TITLE" => array(),
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("WI_PARAM_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "content",
			"REFRESH" => "Y",
			),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("WI_PARAM_IBLOCK_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
			),
		"COMPARISON_NAME" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_NAME"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => "NAME"
			),
		"COMPARISON_PUBLIC_DATE" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_PUBLIC_DATE"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => 'DATE_ACTIVE_FROM',
			),
		"COMPARISON_DETAIL_TEXT" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_DETAIL_TEXT"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => "DETAIL_TEXT"
			),
		"COMPARISON_START_DATE" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_START_DATE"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => "DATE_ACTIVE_FROM"
			),
		"COMPARISON_END_DATE" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_END_DATE"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => "DATE_ACTIVE_TO"
			),
		"COMPARISON_COMPLETED" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_COMPLETED"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty,
			"MULTIPLE" => "N",
			"DEFAULT" => "EMPTY"
			),
		"COMPARISON_ATTACHMENTS" => array(
			"PARENT" => "COMPARISON",
			"NAME" => GetMessage("WI_PARAM_COMPARISON_ATTACHMENTS"),
			"VALUES" => $arProperty,
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"DEFAULT" => "EMPTY"
			),
		"SET_TITLE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("WI_PARAM_SET_TITLE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			),
		"INCLUDE_IBLOCK_INTO_CHAIN" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("WI_PARAM_INCLUDE_IBLOCK_INTO_CHAIN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			),
		"PUR_COUNT" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("WI_PARAM_PUR_COUNT"),
			"TYPE" => "TEXT",
			"MULTIPLE" => "N",
			"DEFAULT" => "10"
			),
		"USE_CACHE" => array(
			"PARENT" => "CACHE",
			"NAME" => GetMessage("WI_PARAM_USE_CACHE"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "N"
			),
		"TIME_CACHE" => array(
			"PARENT" => "CACHE",
			"NAME" => GetMessage("WI_PARAM_TIME_CACHE"),
			"TYPE" => "TEXT",
			"MULTIPLE" => "N",
			"DEFAULT" => "604800"
			),
		"USE_UIKIT" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("WI_PARAM_USE_UIKIT"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "Y"
			),
		"USE_JQUERY" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("WI_PARAM_USE_JQUERY"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"DEFAULT" => "N"
			),
		),
	);
	?>