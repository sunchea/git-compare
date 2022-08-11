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
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

?>
<div class="filter-catalog-main filter <?=$templateData["TEMPLATE_CLASS"]?> bx_<?=($arParams['FILTER_VIEW_MODE'] == 'HORIZONTAL' ? 'horizontal' : 'vertical')?>">
	<div class="bx_filter_section">
		<form class="filter_catalog" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">

			<?php $count = 0; ?>
			<?	foreach($arResult["ITEMS"] as $key=>$arItem) { ?>

					<div data-prop-code="<?= $arItem['CODE'] ?>" data-display="<?= $arItem["DISPLAY_TYPE"] ?>" class="bx_filter_parameters_box <? if(!$count) echo 'box_filter_sticky'; ?> <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>active<?endif?> <?=($arParams['FILTER_VIEW_MODE'] == 'HORIZONTAL' ? 'col-md-12 col-sm-12 col-xs-12' : 'col-md-12')?>">
						<span class="bx_filter_container_modef"></span>
						<div class="bx_filter_parameters_box_title"><?=$arItem["NAME"]?></div>
						<div class="bx_filter_block">
							<div class="bx_filter_parameters_box_container">
							<?
							$arCur = current($arItem["VALUES"]);
							switch ($arItem["DISPLAY_TYPE"]) {
								case "key": ?>
										<input data-display="<?= $arItem['DISPLAY_TYPE'] ?>" class="key" type="text" 	name="<?= $arItem['CODE'] ?>" value="" />
									<?
									break;
								case "range":
									?>
									<div class="bx_filter_parameters_box_container_block">
										<div class="bx_filter_input_container">
											<input
												class="min-price"
												type="text"
												name="<?= $arItem["CODE"] ?>_MIN"
												value=""
												size="5"
												data-display="<?= $arItem['DISPLAY_TYPE'] ?>"
												data-pair="<?= $arItem['CODE']?>"
												data-start-value="<?= $arItem["VALUES"]["MIN"]["VALUE"]?>"
												/>
										</div>
									</div>

									<div class="bx_filter_parameters_box_container_block">
										<div class="bx_filter_input_container">
										<input
											class="max-price"
											type="text"
											name="<?= $arItem["CODE"] ?>_MAX"
											value=""
											size="5"
											data-display="<?= $arItem['DISPLAY_TYPE'] ?>"
											data-pair="<?= $arItem['CODE']?>"
											data-start-value="<?= $arItem["VALUES"]["MAX"]["VALUE"]?>"
											/>
										</div>
									</div>
									<?
									break;
								case "list":
									?>
									<div class="select-outer" data-name="<?= $arItem["CODE"] ?>">
										<div class="select_open"><?= Loc::getMessage('CT_BCSF_FILTER_TITLE_VALUES') ?></div>

										<div class="items">			
											<label class="checkbox-table-filter display_none">
												<input name="<?= $arItem["CODE"] ?>" type="checkbox" value="all" data-display="<?= $arItem['DISPLAY_TYPE'] ?>" checked>
												<span><?= Loc::getMessage('CT_BCSF_FILTER_ALL') ?></span>
											</label>

											<?php foreach($arItem["VALUES"] as $val => $ar): ?>
												<label class="checkbox-table-filter">
													<input type="checkbox" name="<?= $arItem["CODE"] ?>" value="<?=$val?>" data-display="<?= $arItem['DISPLAY_TYPE'] ?>" checked>
													<span><?= $ar['VALUE'] ?></span>
												</label>
											<?php endforeach; ?>
										</div>
									</div>
									<?
									break;
							}	?>

							</div>
							<div class="clb"></div>
						</div>

						<?php $count++; ?>

						<?php if ($count != 1): ?>
							<div class="hide_element">
								<div class="btn_hide_element">
									<?= Loc::getMessage('CT_BCSF_FILTER_CEIL_HIDE') ?>
								</div>
							</div>
						<?php else: ?>
							<div class="compare_row">
								<div class="compare">
									<?= Loc::getMessage('CT_BCSF_FILTER_COMPARE') ?>
								</div>
							</div>
						<?php endif; ?>

					</div>
				<?
				}
				?>
		</form>
		<div style="clear: both;"></div>
	</div>
</div>