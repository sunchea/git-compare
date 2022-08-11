<?php

$props = CIBlockSectionPropertyLink::GetArray($arParams['IBLOCK_ID'], $arParams['PARENT_SECTION']);
$arResult['props_info'] = $props;

// get section names elements
foreach($arResult["ITEMS"] as $arItem){
	$arSectionsIDs[] = $arItem["IBLOCK_SECTION_ID"];
}
if($arSectionsIDs){
	$arSectionsIDs = array_unique($arSectionsIDs);
	$arSectionsTmp = aspro::cacheSection(false, array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arSectionsIDs), false, array("ID", "NAME"));
	foreach($arSectionsTmp as $arSection){
		$arSections[$arSection["ID"]] = $arSection;
	}
}

$arProps = CustomPropForFilter::getFilterOptionsValue($arParams['IBLOCK_ID'], $arParams['PARENT_SECTION']);


foreach($arResult["ITEMS"] as $i => $arItem){
	$arItem['SECTION_NAME'] = $arSections[$arItem["IBLOCK_SECTION_ID"]]["NAME"];
	$arResult["ITEMS"][$i] = $arItem;

	$arResult["ITEMS"][$i]['PROPERTIES'] = CustomPropForFilter::sortPropsForList($arItem['PROPERTIES'], $arParams['IBLOCK_ID'], $arParams['PARENT_SECTION']);

	foreach ($arResult["ITEMS"][$i]['PROPERTIES'] as $key => $prop) {
		$arResult["ITEMS"][$i]['PROPERTIES'][$key]['WIDTH'] = $arProps[$prop['ID']]['width'];
		$arResult["ITEMS"][$i]['PROPERTIES'][$key]['TEXT_CENTERING'] = $arProps[$prop['ID']]['text_centering'];
	}
}

$activeElements = CIBlockSection::GetSectionElementsCount($arParams['PARENT_SECTION'], Array("ACTIVE"=>"Y"));
$arResult['all_page'] = $activeElements;

$nav = CIBlockSection::GetNavChain(false, $arParams['PARENT_SECTION']);
while ($arSection = $nav->GetNext()) {
    $arrDescriptions[] = $arSection['DESCRIPTION'];
}
foreach($arrDescriptions as $description) {
    if($description) {
        $arResult['RESULT_NOTE'] = $description;
    }
}
