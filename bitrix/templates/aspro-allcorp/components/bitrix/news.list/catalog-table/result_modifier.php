<?
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

foreach($arResult["ITEMS"] as $i => $arItem){
	$arItem['SECTION_NAME'] = $arSections[$arItem["IBLOCK_SECTION_ID"]]["NAME"];
	$arResult["ITEMS"][$i] = $arItem;
}

$nav = CIBlockSection::GetNavChain(false, $arParams['PARENT_SECTION']);
while ($arSection = $nav->GetNext()) {
    $arrDescriptions[] = $arSection['DESCRIPTION'];
}
foreach($arrDescriptions as $description) {
    if($description) {
        $arResult['RESULT_NOTE'] = $description;
    }
}
