<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$aMenuLinksExt = array();
$arSections = CCache::CIBlockSection_GetList(array("SORT" => "ASC", "ID" => "ASC", "CACHE" => array("TAG" => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0]), "MULTI" => "Y")), array("IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y"));
$arSectionsByParentSectionID = CCache::GroupArrayBy($arSections, array("MULTI" => "Y", "GROUP" => array("IBLOCK_SECTION_ID")));
$arItems = CCache::CIBlockElement_GetList(array("SORT" => "ASC", "ID" => "DESC", "CACHE" => array("TAG" => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0]), "MULTI" => "Y")), array("IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0], "ACTIVE" => "Y", "SECTION_GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y", "INCLUDE_SUBSECTIONS" => "Y"));
$arItemsBySectionID = CCache::GroupArrayBy($arItems, array("MULTI" => "Y", "GROUP" => array("IBLOCK_SECTION_ID")));

if($arSections){
	aspro::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);
}
else{
	foreach($arItems as $arItem){
		$aMenuLinksExt[] = array($arItem["NAME"], $arItem["DETAIL_PAGE_URL"], array(), array("FROM_IBLOCK" => 1, "DEPTH_LEVEL" => 1));
	}
}

if($aMenuLinksExt){
	$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
}
?>