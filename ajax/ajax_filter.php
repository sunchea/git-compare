<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arParams      = $_REQUEST['arParams'];
$data_filter   = $_REQUEST['data_filter'];
$arDisplayNoneProps = $_REQUEST['displayNoneAr'];
$arSort        = $_REQUEST['sortAr'];
$curCompEls    = $_REQUEST['curCompEls'];

global $arFilter;
foreach ($data_filter as $key => $element) {

    switch ($element['display_type']) {
        case 'range':
            $element['val']['min'] = str_replace(',', '.', $element['val']['min']);
            $element['val']['max'] = str_replace(',', '.', $element['val']['max']);

            if($element['val']['min'] === '' && $element['val']['max'] === '') {
			} elseif($element['val']['min'] === '') {
        		$arFilter["<=PROPERTY_{$key}"] = $element['val']['max'];
        	} elseif($element['val']['max'] === '') {
        		$arFilter[">=PROPERTY_{$key}"] = $element['val']['min'];
        	} else {
	    		$arFilter["><PROPERTY_{$key}"] = array($element['val']['min'], $element['val']['max']);
        	}
            break;
        case 'list':
            $arFilter["PROPERTY_{$key}"][] = 'OR';
            foreach ($element['val'] as $value) {
                $arFilter["PROPERTY_{$key}"][] = $value; 
            }
            break;
        case 'key':
            if($element['val']) {
                $arFilter["PROPERTY_{$key}"] = "%".$element['val']."%";
            }
            break;
        case 'more':
            $element['val'] = str_replace(',', '.', $element['val']);

            if($element['val'] === '') {
                continue;
            } 

        	$arFilter["<=PROPERTY_{$key}"] = $element['val'];
        	break;
        case 'less':
            $element['val'] = str_replace(',', '.', $element['val']);

            if($element['val'] === '') {
                continue;
            } 

	        $arFilter[">=PROPERTY_{$key}"] = $element['val'];
        	break;
    }
}

if(!empty($curCompEls)) {
    $arFilter[count($arFilter)]['LOGIC'] = 'OR';
}
foreach ($curCompEls as $idEl) {
    $arFilter[count($arFilter)-1][]['=ID'] = $idEl;
}

$params = Array(
            "AJAX_MODE" => "Y",
            "DISPLAY" => $arParams['display'],
            "COUNT_IN_LINE" => $arParams["COUNT_IN_LINE"],
            "COUNT_LIST_LINE" => $arParams["COUNT_LIST_LINE"],
            "VIEW_TYPE" => $arParams["VIEW_TYPE"],
            "SHOW_TABS" => $arParams["SHOW_TABS"],
            "SHOW_NAME" => $arParams["SHOW_NAME"],
            "SHOW_DETAIL" => $arParams["SHOW_DETAIL"],
            "SHOW_IMAGE" => $arParams["SHOW_IMAGE"],
            "IMAGE_POSITION" => $arParams["IMAGE_POSITION"],
            "IBLOCK_TYPE"   =>  $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" =>  $arParams["IBLOCK_ID"],
            "NEWS_COUNT"    =>  $arParams["NEWS_COUNT"],
            "FIELD_CODE"    =>  $arParams["LIST_FIELD_CODE"],
            "PROPERTY_CODE" =>  $arParams["LIST_PROPERTY_CODE"],
            "DISPLAY_PANEL" =>  $arParams["DISPLAY_PANEL"],
            "SET_TITLE" =>  $arParams["SET_TITLE"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "INCLUDE_IBLOCK_INTO_CHAIN" =>  $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
            "ADD_SECTIONS_CHAIN"    =>  $arParams["ADD_SECTIONS_CHAIN"],
            "CACHE_TYPE"    =>  $arParams["CACHE_TYPE"],
            "CACHE_TIME"    =>  $arParams["CACHE_TIME"],
            "CACHE_FILTER"  =>  'N',
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "DISPLAY_TOP_PAGER" =>  $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER"  =>  $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE"   =>  $arParams["PAGER_TITLE"],
            "PAGER_TEMPLATE"    =>  $arParams["PAGER_TEMPLATE"],
            "PAGER_SHOW_ALWAYS" =>  $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_DESC_NUMBERING"  =>  $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME"   =>  $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
            "DISPLAY_DATE"  =>  $arParams["DISPLAY_DATE"],
            "DISPLAY_NAME"  =>  "Y",
            "DISPLAY_PICTURE"   =>  $arParams["DISPLAY_PICTURE"],
            "DISPLAY_PREVIEW_TEXT"  =>  $arParams["DISPLAY_PREVIEW_TEXT"],
            "PREVIEW_TRUNCATE_LEN"  =>  $arParams["PREVIEW_TRUNCATE_LEN"],
            "ACTIVE_DATE_FORMAT"    =>  $arParams["LIST_ACTIVE_DATE_FORMAT"],
            "USE_PERMISSIONS"   =>  $arParams["USE_PERMISSIONS"],
            "GROUP_PERMISSIONS" =>  $arParams["GROUP_PERMISSIONS"],
            "FILTER_NAME"   =>  'arFilter',
            "HIDE_LINK_WHEN_NO_DETAIL"  =>  $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
            "CHECK_DATES"   =>  $arParams["CHECK_DATES"],
            "INCLUDE_SUBSECTIONS" => "N",
            "PARENT_SECTION" => $arParams['PARENT_SECTION'],
            "NO_DISPLAY_PROPS" => $arDisplayNoneProps
        );

if($arSort) {
    foreach ($arSort as $key => $prop) {
    	$count = $key + 1;
        $params["SORT_BY{$count}"] = 'PROPERTY_'.$prop['code'];
        $params["SORT_ORDER{$count}"] = strtoupper($prop['direction']);
    }
} else {
    $params['SORT_BY1'] = 'SORT';
    $params['SORT_ORDER1'] = 'ASC';
    $params['SORT_BY2'] = 'ID';
    $params['SORT_ORDER2'] = 'DESC';
}

echo "<pre style=\"display:none;font-size:11px;\">";
print_r($params);
echo "</pre>";

$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"catalog-table-filter",
		$params
	);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
