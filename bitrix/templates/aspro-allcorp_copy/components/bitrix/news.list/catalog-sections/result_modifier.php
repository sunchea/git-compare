<?
$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y");
if($arParams["PARENT_SECTION"]){
	$arFilter = array_merge($arFilter, array("SECTION_ID" => $arParams["PARENT_SECTION"], ">DEPTH_LEVEL" => "1"));
}
else{
	$arFilter["DEPTH_LEVEL"] = "1";
}

$arResult["SECTIONS"] = CCache::CIBLockSection_GetList(array("SORT" => "ASC", "NAME" => "ASC", "CACHE" => array("TAG" => CCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "GROUP" => array("ID"), "MULTI" => "N")), $arFilter, false, array("ID", "NAME", "IBLOCK_ID", "DEPTH_LEVEL", "SECTION_PAGE_URL", "PICTURE", "DETAIL_PICTURE", "UF_INFOTEXT", "DESCRIPTION"));

foreach($arResult["SECTIONS"] as $SID => $arSection){
	$arSectButtons = CIBlock::GetPanelButtons($arSection["IBLOCK_ID"], 0, $arSection["ID"],	array("SESSID" => false, "CATALOG" => true));
	$arResult["SECTIONS"][$SID]["EDIT_LINK"] = $arSectButtons["edit"]["edit_section"]["ACTION_URL"];
	$arResult["SECTIONS"][$SID]["DELETE_LINK"] = $arSectButtons["edit"]["delete_section"]["ACTION_URL"];
	$arResult["SECTIONS"][$SID]["PREVIEW_PICTURE"] = CFile::GetFileArray($arSection["PICTURE"]);
	$arResult["SECTIONS"][$SID]["SECTION_PAGE_URL"] = $arSection["SECTION_PAGE_URL"];
	$arResult["SECTIONS"][$SID]["PREVIEW_TEXT"] = $arSection["DESCRIPTION"];
	$arResult["SECTIONS"][$SID]["PREVIEW_TEXT_TYPE"] = $arSection["DESCRIPTION_TYPE"];
}