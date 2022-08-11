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
<div class="order-status">
	<?=GetMessage("ORDER_STATUS")?><?=$arResult['ID'];?>
</div>
<div class="news-detail-order">
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<div class="field_block">
			<div class="field_name"><?=GetMessage("OBJECT")?>:</div> <?=$arResult["NAME"]?>
		</div>
	<?endif;?>
	<?if($arResult["PROPERTIES"]["MAX_POWER"]["VALUE"]):?>
		<div class="field_block">
			<div class="field_name"><?=GetMessage("DECLARED_POWER")?>:</div> <?=$arResult["PROPERTIES"]["MAX_POWER"]["VALUE"][0]?>
		</div>
	<?endif;?>
	<!--<pre><?var_dump($arResult["STAGES"]);?></pre>-->
	
	<div class="progresses_block">
		<?foreach ($arResult["STAGES"] as $stage):?>
			<div class="order-progress-block">
				<?if($stage["CURRENT"] && $stage["COMPLETE"]):?>
					<div class="field_name"><?=$stage["NAME"]?></div>
				<?else:?>
					<div class="field_name gray"><?=$stage["NAME"]?></div>
				<?endif;?>
				<div class="order-progress-bar js-processed-progress-bar">
					<div class="order-progress-bar-slider j-processed-slider-bar" data-value="<?=$stage["FRACTION"]?>"></div>
				</div>
				<span class="days_gray"><?=$stage["DAYS_PASSED"]?> <?=GetMessage("FROM")?></span> <span class="days"><?=$stage["DAYS_TOTAL"]?> <?=GetMessage("DAYS")?></span>
				<?if(!empty($stage["POPUP_COMMENT"])):?>
					<div class="question">
						<div class="popup-comment" style="display: none;">
							<?=$stage["POPUP_COMMENT"]?>
						</div>
					</div>
				<?endif;?>
			</div>
		<?endforeach;?>
	</div>
</div>