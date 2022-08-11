<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) return;
if(!CModule::IncludeModule("aspro.allcorp")) return;
	
if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ID")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;
if(!defined("WIZARD_THEME_ID")) return;

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
//$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."/";

// iblocks ids
$servicesIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0];
$staffIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_staff"][0];
$reviewsIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_reviews"][0];
$projectsIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_projects"][0];
$catalogIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_catalog"]["aspro_allcorp_catalog"][0];

$stockIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_stock"][0];
$newsIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_news"][0];
$articlesIBlockID = CCache::$arIBlocks[WIZARD_SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_articles"][0];

// XML_ID => ID (here XML_ID - old ID, ID - new ID)
if(!CModule::IncludeModule("aspro.allcorp")) return;
$arServices = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($servicesIBlockID), "GROUP" => array("XML_ID"), "RESULT" => array("ID"))), array("IBLOCK_ID" => $servicesIBlockID), false, false, array("ID", "XML_ID"));
$arStaff = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($staffIBlockID), "GROUP" => array("XML_ID"), "RESULT" => array("ID"))), array("IBLOCK_ID" => $staffIBlockID), false, false, array("ID", "XML_ID"));
$arReviews = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($reviewsIBlockID), "GROUP" => array("XML_ID"), "RESULT" => array("ID"))), array("IBLOCK_ID" => $reviewsIBlockID), false, false, array("ID", "XML_ID"));
$arProjects = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($projectsIBlockID), "GROUP" => array("XML_ID"), "RESULT" => array("ID"))), array("IBLOCK_ID" => $projectsIBlockID), false, false, array("ID", "XML_ID"));
$arCatalog = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($catalogIBlockID), "GROUP" => array("XML_ID"), "RESULT" => array("ID"))), array("IBLOCK_ID" => $catalogIBlockID), false, false, array("ID", "XML_ID"));

// update links in stock
$arStockElements = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($stockIBlockID), "GROUP" => array("ID"), "RESULT" => array("XML_ID", "PROPERTY_LINK_SERVICES_VALUE", "PROPERTY_LINK_GOODS_VALUE"))), array("IBLOCK_ID" => $stockIBlockID), false, false, array("ID", "XML_ID", "PROPERTY_LINK_SERVICES", "PROPERTY_LINK_GOODS"));
foreach($arStockElements as $ElementID => $arElementProps){
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_SERVICES_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arServices[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arServices[$linkXML_ID];
			}
		}
	}
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_GOODS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arCatalog[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arCatalog[$linkXML_ID];
			}
		}
	}
	//echo "<pre>";echo $ElementID." ";print_r($arElementProps);echo "</pre>";
	CIBlockElement::SetPropertyValuesEx($ElementID, $stockIBlockID, array("LINK_SERVICES" => $arElementProps["PROPERTY_LINK_SERVICES_VALUE"], "LINK_GOODS" => $arElementProps["PROPERTY_LINK_GOODS_VALUE"]));
}

// update links in news
$arNewsElements = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($newsIBlockID), "GROUP" => array("ID"), "RESULT" => array("XML_ID", "PROPERTY_LINK_GOODS_VALUE"))), array("IBLOCK_ID" => $newsIBlockID), false, false, array("ID", "XML_ID", "PROPERTY_LINK_GOODS"));
foreach($arNewsElements as $ElementID => $arElementProps){
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_GOODS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arCatalog[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arCatalog[$linkXML_ID];
			}
		}
	}
	//echo "<pre>";echo $ElementID." ";print_r($arElementProps);echo "</pre>";
	CIBlockElement::SetPropertyValuesEx($ElementID, $newsIBlockID, array("LINK_GOODS" => $arElementProps["PROPERTY_LINK_GOODS_VALUE"]));
}

// update links in articles
$arArticlesElements = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($articlesIBlockID), "GROUP" => array("ID"), "RESULT" => array("XML_ID", "PROPERTY_LINK_GOODS_VALUE"))), array("IBLOCK_ID" => $articlesIBlockID), false, false, array("ID", "XML_ID", "PROPERTY_LINK_GOODS"));
foreach($arArticlesElements as $ElementID => $arElementProps){
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_GOODS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arCatalog[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arCatalog[$linkXML_ID];
			}
		}
	}
	//echo "<pre>";echo $ElementID." ";print_r($arElementProps);echo "</pre>";
	CIBlockElement::SetPropertyValuesEx($ElementID, $articlesIBlockID, array("LINK_GOODS" => $arElementProps["PROPERTY_LINK_GOODS_VALUE"]));
}

// update links in services
$arServicesElements = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($servicesIBlockID), "GROUP" => array("ID"), "RESULT" => array("XML_ID", "PROPERTY_LINK_STAFF_VALUE", "PROPERTY_LINK_GOODS_VALUE", "PROPERTY_LINK_PROJECTS_VALUE", "PROPERTY_LINK_REVIEWS_VALUE"))), array("IBLOCK_ID" => $servicesIBlockID), false, false, array("ID", "XML_ID", "PROPERTY_LINK_STAFF", "PROPERTY_LINK_GOODS", "PROPERTY_LINK_PROJECTS", "PROPERTY_LINK_REVIEWS"));
foreach($arServicesElements as $ElementID => $arElementProps){
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_STAFF_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arStaff[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arStaff[$linkXML_ID];
			}
		}
	}
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_REVIEWS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arReviews[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arReviews[$linkXML_ID];
			}
		}
	}
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_GOODS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arCatalog[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arCatalog[$linkXML_ID];
			}
		}
	}
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_PROJECTS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arProjects[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arProjects[$linkXML_ID];
			}
		}
	}
	//echo "<pre>";echo $ElementID." ";print_r($arElementProps);echo "</pre>";
	CIBlockElement::SetPropertyValuesEx($ElementID, $servicesIBlockID, array("LINK_STAFF" => $arElementProps["PROPERTY_LINK_STAFF_VALUE"], "LINK_REVIEWS" => $arElementProps["PROPERTY_LINK_REVIEWS_VALUE"], "LINK_GOODS" => $arElementProps["PROPERTY_LINK_GOODS_VALUE"], "LINK_PROJECTS" => $arElementProps["PROPERTY_LINK_PROJECTS_VALUE"]));
}

// update links in catalog
$arCatalogElements = CCache::CIBlockElement_GetList(array("CACHE" => array("TIME" => 0, "TAG" => CCache::GetIBlockCacheTag($catalogIBlockID), "GROUP" => array("ID"), "RESULT" => array("XML_ID", "PROPERTY_LINK_PROJECTS_VALUE"))), array("IBLOCK_ID" => $catalogIBlockID), false, false, array("ID", "XML_ID", "PROPERTY_LINK_PROJECTS"));
foreach($arCatalogElements as $ElementID => $arElementProps){
	if($arLinkXML_ID = &$arElementProps["PROPERTY_LINK_PROJECTS_VALUE"]){
		foreach($arLinkXML_ID as $i => $linkXML_ID){
			if(isset($arProjects[$linkXML_ID])){
				$arLinkXML_ID[$i] = $arProjects[$linkXML_ID];
			}
		}
	}
	//echo "<pre>";echo $ElementID." ";print_r($arElementProps);echo "</pre>";
	CIBlockElement::SetPropertyValuesEx($ElementID, $catalogIBlockID, array("LINK_PROJECTS" => $arElementProps["PROPERTY_LINK_PROJECTS_VALUE"]));
}

// update links in projects
CIBlockElement::SetPropertyValuesEx($arProjects["152"], $projectsIBlockID, array("LINK_PROJECTS" => array($arProjects["211"], $arProjects["153"], $arProjects["152"])));
CIBlockElement::SetPropertyValuesEx($arProjects["211"], $projectsIBlockID, array("LINK_PROJECTS" => array($arProjects["211"], $arProjects["153"], $arProjects["152"])));
CIBlockElement::SetPropertyValuesEx($arProjects["153"], $projectsIBlockID, array("LINK_PROJECTS" => array($arProjects["211"], $arProjects["153"], $arProjects["152"])));
CIBlockElement::SetPropertyValuesEx($arProjects["151"], $projectsIBlockID, array("LINK_PROJECTS" => array($arProjects["154"], $arProjects["151"])));
CIBlockElement::SetPropertyValuesEx($arProjects["154"], $projectsIBlockID, array("LINK_PROJECTS" => array($arProjects["154"], $arProjects["151"])));
?>