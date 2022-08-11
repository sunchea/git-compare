<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="our-team-gallery">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$imageMin = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],
        array('width' => 265, 'height' => 395),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
	?>
	<div class="our-team-gallery__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" class="our-team-gallery__item__image-wrapper" rel="group" title="<?=$arItem['NAME']?>. <?=$arItem['PROPERTIES']['POSITION']['VALUE']?>">
            <img src="<?=$imageMin['src']?>" alt="<?=$arItem['NAME']?>" class="our-team-gallery__item__image">
        </a>
        <p class="our-team-gallery__item__name"><?=$arItem['NAME']?></p>
        <p class="our-team-gallery__item__position"><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></p>
	</div>
<?endforeach;?>

</div>

<script>
    $(document).ready(function() {
        $(".our-team-gallery__item__image-wrapper").fancybox();
    });
</script>