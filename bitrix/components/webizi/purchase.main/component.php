<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Iblock;

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("webizi.purchase")) {
	echo GetMessage("WI_MODULE_INCLUDE_ERROR");
	die();
}

$arError = array();
$error = '';
$emptyParam = array();
$arResult = array();
$arPropery = array();
$JSParam = array();

$arParams["IBLOCK_ID"] = trim(intval($arParams["IBLOCK_ID"]));
$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["SET_TITLE"] = $arParams["SET_TITLE"]!="N";
$arParams["INCLUDE_IBLOCK_INTO_CHAIN"] = $arParams["INCLUDE_IBLOCK_INTO_CHAIN"]!="N";
$arParams["USE_CACHE"] = $arParams["USE_CACHE"]!="N";
$arParams["TIME_CACHE"] = (intval($arParams["TIME_CACHE"]) > 0) ? $arParams["TIME_CACHE"] : 604800;
$arParams["PUR_COUNT"] = (intval($arParams["PUR_COUNT"]) > 0) ? $arParams["PUR_COUNT"] : 10;
$arParams["USE_UIKIT"] = $arParams["USE_UIKIT"]!="N";
$arParams["USE_JQUERY"] = $arParams["USE_JQUERY"]!="N";

$JSParam["COUNT"] = $arParams["PUR_COUNT"];

if (is_numeric($arParams["IBLOCK_ID"])) {
	$rsIBlock = CIBlock::GetList(array(), array(
		"ACTIVE" => "Y",
		"ID" => $arParams["IBLOCK_ID"],
		));
} else {
	$rsIBlock = CIBlock::GetList(array(), array(
		"ACTIVE" => "Y",
		"CODE" => $arParams["IBLOCK_TYPE"],
		"SITE_ID" => SITE_ID,
		));
}

if ($arResult = $rsIBlock->GetNext(false, false)) {
	$arResult["COMPONENT_PATH"] = $this->GetPath();
} else {
	Iblock\Component\Tools::process404(
		trim($arParams["MESSAGE_404"]) ?: GetMessage("WI_COMPONENT_IBLOCK_NA")
		,true
		,$arParams["SET_STATUS_404"] === "Y"
		,$arParams["SHOW_404"] === "Y"
		,$arParams["FILE_404"]
		);

	return;
}

$rsProperty = CIBlockProperty::GetList(
	Array("ID" => "ASC", "ID" => "ASC"),
	Array("ACTIVE" => "Y",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"])
	);

while ($prop_fields = $rsProperty->GetNext())
{
	$arPropery[$prop_fields["CODE"]] = $prop_fields;
}

foreach ($arParams as $key => $param)
{
	if (stripos($key, "COMPARISON_") === 0 && $param == "EMPTY") {
		$emptyParam[] = $key;
	} else {
		$tkey = str_replace('COMPARISON_', '', $key);

		switch ($tkey)
		{
			// case 'PUBLIC_DATE':
			// if (!isset($arPropery[$param]) || $arPropery[$param]["PROPERTY_TYPE"] != "F")
			// 	$arError[] = GetMessage("WI_COMPONENT_PUBLIC_DATE");
			// break;

			case 'ATTACHMENTS':
			if (!isset($arPropery[$param]) || $arPropery[$param]["PROPERTY_TYPE"] != "F")
				$arError[] = GetMessage("WI_COMPONENT_ATTACHMENTS");
			break;

			case 'COMPLETED':
			if (!isset($arPropery[$param]) || $arPropery[$param]["PROPERTY_TYPE"] != "L")
				$arError[] = GetMessage("WI_COMPONENT_COMPLETED");
			break;

			case 'DETAIL_TEXT':
			if ((!isset($arPropery[$param]) || $arPropery[$param]["PROPERTY_TYPE"] != "S")
				&& $param != "DETAIL_TEXT" && $param != "PREVIEW_TEXT" && $param != "NAME")
				$arError[] = GetMessage("WI_COMPONENT_DETAIL_TEXT");
			break;

			case 'END_DATE':
			if ((!isset($arPropery[$param]) || $arPropery[$param]["USER_TYPE"] != "DateTime")
				&& $param != "DATE_ACTIVE_TO")
				$arError[] = GetMessage("WI_COMPONENT_END_DATE");
			break;

			case 'NAME':
			if ((!isset($arPropery[$param]) || $arPropery[$param]["PROPERTY_TYPE"] != "S")
				&& $param != "DETAIL_TEXT" && $param != "PREVIEW_TEXT" && $param != "NAME")
				$arError[] = GetMessage("WI_COMPONENT_NAME");
			break;

			case 'START_DATE':
			if ((!isset($arPropery[$param]) || $arPropery[$param]["USER_TYPE"] != "DateTime")
				&& $param != "DATE_ACTIVE_FROM")
				$arError[] = GetMessage("WI_COMPONENT_START_DATE");
			break;
		}
	}

	if (stripos($key, "COMPARISON_") === 0) {
		$clearKey = str_replace('COMPARISON_', '', $key);

		if (array_key_exists($param, $arPropery))
			$arResult["PARAM"][$clearKey] = "PROPERTY_" . $param;
		else
			$arResult["PARAM"][$clearKey] = $param;
	}
}

if ($arParams["SET_TITLE"] && isset($arResult["NAME"])) {
	$APPLICATION->SetTitle($arResult["NAME"]);
}

if ($arParams["INCLUDE_IBLOCK_INTO_CHAIN"] && isset($arResult["NAME"])) {
	$APPLICATION->AddChainItem($arResult["NAME"]);
}

$arResult["JSParam"] = $JSParam;

if (count($emptyParam) > 0) {
	$error .= GetMessage("WI_COMPONENT_EMPTY") . "<br>";

	foreach ($emptyParam as $value) {
		$error .= GetMessage("WI_COMPONENT_" . $value) . "<br>";
	}

	$arError[] = $error;
}

$this->InitComponentTemplate();
$template = & $this->GetTemplate();
$arResult["TEMPLATE_FOLDER"] = $template->GetFolder();

$GLOBALS["arResult"] = $arResult;
$GLOBALS["arParams"] = $arParams;

$WI = new WIPurchase();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$GLOBALS['APPLICATION']->RestartBuffer();
	$type = (isset($_POST["type"])) ? htmlspecialchars($_POST["type"]) : false;
	$json = (isset($_POST["json"])) ? $_POST["json"] : Array();
	$page = (isset($_POST["page"])) ? $_POST["page"] : 1;
	$param = (isset($_POST["param"])) ? $_POST["param"] : "ALL";

	switch ($type)
	{
		case 'purchase':
		echo $WI->GetPurchase(json_decode($json, true), $page, $param);
		break;
	}
	die();
} else {
	if (count($arError) > 0) {
		foreach ($arError as $key => $err) {
			ShowError($err);
		}

		return;
	} else {
		$this->IncludeComponentTemplate();
	}
}
?>