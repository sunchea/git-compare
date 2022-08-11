<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$arFiles = $arResult["PROPERTIES"]["GALLERY"]['VALUE']; ?>

<div class="our-team-gallery">

    <?foreach($arFiles as $arFile): ?>
    	<?
    	$imageMin = CFile::ResizeImageGet($arFile,
            array('width' => 265, 'height' => 395),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
    	?>
    	<div class="our-team-gallery__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a href="<?= CFile::GetPath($arFile) ?>" class="our-team-gallery__item__image-wrapper" rel="group" alt="<?= $arResult['NAME'] ?>" title="<?= $arResult['NAME'] ?>">
                <img src="<?= CFile::GetPath($arFile) ?>" class="our-team-gallery__item__image">
            </a>
    	</div>
    <?endforeach;?>

</div>

<script>
    $(document).ready(function() {
        $(".our-team-gallery__item__image-wrapper").fancybox();
    });
</script>