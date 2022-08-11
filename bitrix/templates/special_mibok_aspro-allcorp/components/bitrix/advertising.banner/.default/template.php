<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
#print_r($arResult);?>
<?if($arResult["BANNER"]):
    $arResult["BANNER"]=str_replace("</a>",$arResult['BANNER_PROPERTIES']['NAME'].'</a>',$arResult["BANNER"]);?>
    <?/*<li>
            <?=$arResult["BANNER"]?>	
            <p><?=$arResult['BANNER_PROPERTIES']["IMAGE_ALT"]?></p>
    </li>*/?>
    <div class="btn-group" role="group">
        <a href="<?=($arResult['BANNER_PROPERTIES']["URL"] ? $arResult['BANNER_PROPERTIES']["URL"] : '#')?>" class="btn btn-default btn-banner" title="<?=($arResult['BANNER_PROPERTIES']["IMAGE_ALT"] ? $arResult['BANNER_PROPERTIES']["IMAGE_ALT"] : $arResult['BANNER_PROPERTIES']["NAME"])?>" target="<?=($arResult['BANNER_PROPERTIES']["URL_TARGET"] ? $arResult['BANNER_PROPERTIES']["URL_TARGET"] : '_blank')?>"><?=$arResult['BANNER_PROPERTIES']["NAME"]?></a>
    </div>
<?endif?>