<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

aspro::getParam($arResult, "width");
aspro::getParam($arResult, "color");
aspro::getParam($arResult, "menu");
aspro::getParam($arResult, "sidemenu");
aspro::getParam($arResult, "catalog_index");
aspro::getParam($arResult, "services_index");
aspro::getParam($arResult, "filter_view");

if(file_exists(str_replace('//', '/', $_SERVER["DOCUMENT_ROOT"].SITE_DIR."/favicon.ico"))){
	$APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.str_replace('//', '/', SITE_DIR.'/favicon.ico').'" type="image/x-icon" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="57x57" href="'.str_replace('//', '/', SITE_DIR.'/favicon_57.png').'" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="72x72" href="'.str_replace('//', '/', SITE_DIR.'/favicon_72.png').'" />', true);
}
elseif(file_exists(str_replace('//', '/', $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/favicon.ico"))){
	$APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.str_replace('//', '/', SITE_TEMPLATE_PATH.'/favicon.ico').'" type="image/x-icon" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="57x57" href="'.str_replace('//', '/', SITE_TEMPLATE_PATH.'/favicon_57.png').'" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="72x72" href="'.str_replace('//', '/', SITE_TEMPLATE_PATH.'/favicon_72.png').'" />', true);
}
else{
	$APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.SITE_TEMPLATE_PATH.'/themes/'.$arResult["COLOR"]["CURRENT"].'/images/favicon.ico" type="image/x-icon" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="57x57" href="'.SITE_TEMPLATE_PATH.'/themes/'.$arResult["COLOR"]["CURRENT"].'/images/favicon_57.png" />', true);
	$APPLICATION->AddHeadString('<link rel="apple-touch-icon" sizes="72x72" href="'.SITE_TEMPLATE_PATH.'/themes/'.$arResult["COLOR"]["CURRENT"].'/images/favicon_72.png" />', true);
}

$active = COption::GetOptionString("aspro.allcorp", "THEME_SWITCHER");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/responsive.css', true);
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/themes/'.$arResult["COLOR"]["CURRENT"].'/style.css', true);
$APPLICATION->AddHeadString(CAllCorp::GetMaxWidthStyle($arResult["WIDTH"]["CURRENT"]), true);
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/custom.css', true);

$arTheme = array(
	"COLOR" => $arResult["COLOR"]["CURRENT"],
	"WIDTH" => $arResult["WIDTH"]["CURRENT"],
	"MENU" => $arResult["MENU"]["CURRENT"],
	"SIDEMENU" => $arResult["SIDEMENU"]["CURRENT"],
	"CATALOG_INDEX" => $arResult["CATALOG_INDEX"]["CURRENT"],
	"SERVICES_INDEX" => $arResult["SERVICES_INDEX"]["CURRENT"],
	"FILTER_VIEW" => $arResult["FILTER_VIEW"]["CURRENT"],
);
?>
<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("options-block");?>
<script type="text/javascript">
arAllcorpOptions['THEME']['THEME_SWITCHER'] = '<?=$active?>';
arAllcorpOptions['THEME']['COLOR'] = '<?=$arResult["COLOR"]["CURRENT"]?>';
arAllcorpOptions['THEME']['WIDTH'] = '<?=$arResult["WIDTH"]["CURRENT"]?>';
arAllcorpOptions['THEME']['MENU'] = '<?=$arResult["MENU"]["CURRENT"]?>';
arAllcorpOptions['THEME']['SIDEMENU'] = '<?=$arResult["SIDEMENU"]["CURRENT"]?>';
arAllcorpOptions['THEME']['CATALOG_INDEX'] = '<?=$arResult["CATALOG_INDEX"]["CURRENT"]?>';
arAllcorpOptions['THEME']['SERVICES_INDEX'] = '<?=$arResult["SERVICES_INDEX"]["CURRENT"]?>';
arAllcorpOptions['THEME']['FILTER_VIEW'] = '<?=$arResult["FILTER_VIEW"]["CURRENT"]?>';
if(typeof(BX.localStorage) != 'undefined'){
	BX.localStorage.set('arAllcorpOptions', arAllcorpOptions, 86400);
}
</script>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("options-block", "");?>
<?if($active == "Y"):?>
	<?$this->IncludeComponentTemplate();?>
<?endif;?>
<?return $arTheme;?>