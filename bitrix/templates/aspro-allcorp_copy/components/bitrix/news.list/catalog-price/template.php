<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$frame = $this->createFrame()->begin();
$frame->setAnimation(true);
?>
<div class="catalog group item-views-<?=$arParams["DISPLAY"]?>">
	<?if($arResult["ITEMS"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
		<div class="group-content">		
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<div class="row">
					<?
					$this->AddEditAction($arItem["ID"].$arResult["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem["ID"].$arResult["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
					?>
					<?if($arParams["SHOW_IMAGE"] == "Y"):?>
						<div class="col-md-1 image col-xs-3">
							<?if($arParams["SHOW_DETAIL"] == "Y" && !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty($arItem["DETAIL_TEXT"]))):?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?elseif(is_array( $arItem["DETAIL_PICTURE"])):?>
								<a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="img-inside fancybox">
							<?endif;?>
								<?if(is_array( $arItem["PREVIEW_PICTURE"])):?>
									<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
								<?else:?>
									<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
								<?endif;?>
							<?if($arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"]))):?>
								</a>
							<?elseif(is_array($arItem["DETAIL_PICTURE"])):?>
									<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
								</a>
							<?endif;?>
						</div>
					<?endif;?>
					<div class="col-md-7">
						<div class="title">
						<?if($arParams["SHOW_DETAIL"] == "Y" && !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty($arItem["DETAIL_TEXT"]))):?>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						<?else:?>
							<?=$arItem["NAME"];?>
						<?endif;?>
						</div>
					</div>											
					<?if($arItem["PROPERTIES"]["PRICE"]["VALUE"]):?>
						<div class="col-md-2 price">
							<div class="price_new"><span class="price_val"><?=$arItem["PROPERTIES"]["PRICE"]["VALUE"]?></span></div>
							<?if($arItem["PROPERTIES"]["PRICEOLD"]["VALUE"]):?>
								<div class="price_old"><span class="price_val"><?=$arItem["PROPERTIES"]["PRICEOLD"]["VALUE"]?></span></div>
							<?endif;?>
						</div>
					<?endif;?>
					<div class="col-md-2">
						<?if($arItem["PROPERTIES"]["STATUS"]["VALUE_XML_ID"]):?>
							<span class='label label-<?=$arItem["PROPERTIES"]["STATUS"]["VALUE_XML_ID"]?> noradius'><?=$arItem["PROPERTIES"]["STATUS"]["VALUE"]?></span>
						<?endif;?>
					</div>
				</div>
				<hr/>
			<?endforeach;?>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
	<?endif;?>
	<?// section description?>
	<?if(is_array($arResult["SECTION"]["PATH"])):?>
		<?$arCurSectionPath = end($arResult["SECTION"]["PATH"]);?>
		<?if(strlen($arCurSectionPath["DESCRIPTION"]) && strpos($_SERVER["REQUEST_URI"], "PAGEN") === false):?>
			<br/><br/>
			<div class="cat-desc"><?=$arCurSectionPath["DESCRIPTION"]?></div>
			<br/><br/>
		<?endif;?>
	<?endif;?>
</div>
<?$frame->end();?>