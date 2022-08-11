<div class="row_filter">
<!--     $arParams["IBLOCK_TYPE"]
    $arParams["IBLOCK_ID"]
    $arResult['VARIABLES']['SECTION_ID'] -->
    <? $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter", 
        "catalog_new", 
        array(
            "COMPONENT_TEMPLATE" => "catalog_new",
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
            "FILTER_NAME" => "arrFilter",
            "HIDE_NOT_AVAILABLE" => "N",
            "TEMPLATE_THEME" => "blue",
            "FILTER_VIEW_MODE" => "horizontal",
            "DISPLAY_ELEMENT_COUNT" => "Y",
            "SEF_MODE" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "SAVE_IN_SESSION" => "N",
            "INSTANT_RELOAD" => "Y",
            "PAGER_PARAMS_NAME" => "arrPager",
            "PRICE_CODE" => array(
                0 => "BASE",
            ),
            "CONVERT_CURRENCY" => "Y",
            "XML_EXPORT" => "N",
            "SECTION_TITLE" => "-",
            "SECTION_DESCRIPTION" => "-",
            "POPUP_POSITION" => "left",
            "SEF_RULE" => "",
            "SECTION_CODE_PATH" => "",
            "CURRENCY_ID" => "RUB"
        ),
        false
    ); ?>
</div>