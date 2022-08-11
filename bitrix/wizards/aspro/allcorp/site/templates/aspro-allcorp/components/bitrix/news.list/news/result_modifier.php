<?

foreach($arResult["ITEMS"] as $arItem){
	if($SID = ($arItem["IBLOCK_SECTION_ID"] ? $arItem["IBLOCK_SECTION_ID"] : 0)){
		$arSectionsIDs[] = $SID;
	}
}

if($arSectionsIDs){
	$arResult["SECTIONS"] = CCache::CIBLockSection_GetList(array("SORT" => "ASC", "NAME" => "ASC", "CACHE" => array("TAG" => CCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "GROUP" => array("ID"), "MULTI" => "N")), array("ID" => $arSectionsIDs));
}

foreach($arResult["ITEMS"] as $arItem){
	$SID = ($arItem["IBLOCK_SECTION_ID"] ? $arItem["IBLOCK_SECTION_ID"] : 0);
	$arResult["SECTIONS"][$SID]["ITEMS"][$arItem["ID"]] = $arItem;
}


foreach($arResult["SECTIONS"] as $i => $arSection){
	if(!$arSection["ITEMS"]){
		unset($arResult["SECTIONS"][$i]);
	}
}

?>