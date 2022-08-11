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
?>
<pre style="display: none;"><?print_r($arResult)?></pre>
<? if ($arResult['SECTIONS']): ?>

    <? foreach ($arResult['SECTIONS'] as $arSection): ?>

        <a class="galleries__item" href="<?=$arSection['SECTION_PAGE_URL']?>" title="<?=$arSection['NAME']?>">
            <img src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>" class="galleries__image">
            <p class="galleries__name"><?=$arSection['NAME']?></p>
        </a>

    <? endforeach; ?>

<? endif; ?>

