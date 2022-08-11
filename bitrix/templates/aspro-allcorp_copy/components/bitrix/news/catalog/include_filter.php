<?
global $arTheme;

if(strlen($arParams["FILTER_NAME"])){
	$GLOBALS[$arParams["FILTER_NAME"]] = array_merge((array)$GLOBALS[$arParams["FILTER_NAME"]], $arItemFilter);
}
else{
	$arParams["FILTER_NAME"] = "arrFilter";
	$GLOBALS[$arParams["FILTER_NAME"]] = $arItemFilter;
}

if($arTheme['FILTER_VIEW'] !== 'NONE' && $itemsCnt){
	if($arTheme['FILTER_VIEW'] != 'HORIZONTAL'){
		$this->__component->__template->SetViewTarget('under_sidebar_content');
	}
		$APPLICATION->IncludeComponent(
			'bitrix:catalog.smart.filter', 'corp',
			array(
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'SECTION_ID' => $SectionID,
				'FILTER_NAME' => $arParams['FILTER_NAME'],
				'PRICE_CODE' => $arParams['PRICE_CODE'],
				'CACHE_TYPE' => $arParams['CACHE_TYPE'],
				'CACHE_TIME' => $arParams['CACHE_TIME'],
				'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
				'SAVE_IN_SESSION' => 'N',
				'FILTER_VIEW_MODE' => ($arTheme['FILTER_VIEW'] == 'HORIZONTAL' ? 'HORIZONTAL' : 'VERTICAL'),
				'DISPLAY_ELEMENT_COUNT' => 'Y',
				'POPUP_POSITION' => ($arTheme['SIDEMENU'] == 'left' ? 'right' : 'left'),
				'INSTANT_RELOAD' => 'Y',
				'XML_EXPORT' => 'N',
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME']
			),
			$component
		);
	if($arTheme['FILTER_VIEW'] != 'HORIZONTAL'){
		$this->__component->__template->EndViewTarget();
	}
}
?>