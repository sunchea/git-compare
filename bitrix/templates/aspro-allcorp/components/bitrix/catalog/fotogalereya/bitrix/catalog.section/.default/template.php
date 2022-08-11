<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

?>
<?/*<div class="our-team-gallery">*/?>

<?foreach($arResult["ITEMS"] as $arItem):?>
        <a class="galleries__item" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>">
            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" class="galleries__image">
            <p class="galleries__name"><?=$arItem['NAME']?></p>
        </a>
<?endforeach;?>
<?/*    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $imageMin = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],
        array('width' => 265, 'height' => 395),
        BX_RESIZE_IMAGE_PROPORTIONAL);
    ?>
    <div class="our-team-gallery__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"
           class="our-team-gallery__item__image-wrapper"
           rel="group"
           title="<?=($arItem['PROPERTIES']['TITLE']['VALUE'] ? $arItem['PROPERTIES']['TITLE']['VALUE'] . '. ' : "" )?><?=$arItem['PROPERTIES']['DESCRIPTION']['VALUE']?>"
        >
            <img src="<?=$imageMin['src']?>" alt="<?=$arItem['NAME']?>" class="our-team-gallery__item__image">
        </a>

        <? if ($arItem['PROPERTIES']['TITLE']['VALUE']): ?>
            <p class="our-team-gallery__item__name"><?=$arItem['PROPERTIES']['TITLE']['VALUE']?></p>
        <? endif; ?>

        <? if ($arItem['PROPERTIES']['DESCRIPTION']['VALUE']): ?>
            <p class="our-team-gallery__item__position"><?=$arItem['PROPERTIES']['DESCRIPTION']['VALUE']?></p>
        <? endif; ?>

    </div>
<?endforeach;?>

</div>

<script>
    $(document).ready(function() {
        $(".our-team-gallery__item__image-wrapper").fancybox();
    });
</script>*/?>