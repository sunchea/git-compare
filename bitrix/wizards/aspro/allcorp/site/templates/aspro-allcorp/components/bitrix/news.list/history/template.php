<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views list <?=($arParams["IMAGE_POSITION"] ? "image_".$arParams["IMAGE_POSITION"] : "")?> <?=($templateName = $component->{"__parent"}->{"__template"}->{"__name"})?>">
	<?// top pagination?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		// edit/add/delete buttons for edit mode
		$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
		// show preview picture?
		$bPreviewPicture = ($arItem["FIELDS"]["PREVIEW_PICTURE"] ? true : false);
		?>
		
		<?ob_start();?>
			<?// element name?>
			<?if(strlen($arItem["FIELDS"]["NAME"])):?>
				<div class="title">
					<?if(!$bDetailLink):?>
						<?=$arItem["NAME"]?>
					<?else:?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
					<?endif;?>
				</div>
			<?endif;?>
		<?$namePart = ob_get_clean();?>
		
		<?ob_start();?>
			<?// element preview text?>
			<?if(strlen($arItem["FIELDS"]["PREVIEW_TEXT"])):?>
				<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
					<p><?=$arItem["FIELDS"]["PREVIEW_TEXT"]?></p>
				<?else:?>
					<?=$arItem["FIELDS"]["PREVIEW_TEXT"]?>
				<?endif;?>
			<?endif;?>
			
			<?// element display properties?>
			<?if($arItem["DISPLAY_PROPERTIES"]):?>
				<div class="properties">
					<?foreach($arItem["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
						<div class="property">
							<?if($arProperty["XML_ID"]):?>
								<i class="icon <?=$arProperty["XML_ID"]?>"></i>&nbsp;
							<?else:?>
								<?=$arProperty["NAME"]?>:&nbsp;
							<?endif;?>
							<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
								<?$val = implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
							<?else:?>
								<?$val = $arProperty["DISPLAY_VALUE"];?>
							<?endif;?>
							<?if($PCODE == "SITE"):?>
								<!--noindex-->
								<?=str_replace("href=", "rel='nofollow' target='_blank' href=", $val);?>
								<!--/noindex-->
							<?elseif($PCODE == "EMAIL"):?>
								<a href="mailto:<?=$val?>"><?=$val?></a>
							<?else:?>
								<?=$val?>
							<?endif;?>
						</div>
					<?endforeach;?>
				</div>
			<?endif;?>
		<?$textPart = ob_get_clean();?>
		
		<?if($bPreviewPicture):?>
			<?ob_start();?>
				<div class="image">
					<?if($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
						<a href="<?=$arItem["FIELDS"]["DETAIL_PICTURE"]["SRC"]?>" class="img-inside fancybox">
					<?endif;?>
					
						<img src="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
						
					<?if($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
							<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
						</a>
					<?endif;?>
				</div>
			<?$imagePart = ob_get_clean();?>
		<?endif;?>
		
		<div id="<?=$this->GetEditAreaId($arItem["ID"])?>" class="item">
			<div class="row">
				<?if(!$bPreviewPicture):?>
					<div class="col-md-1 col-sm-1 col-xs-12"><?=$namePart?></div>
					<div class="col-md-11 col-sm-11 col-xs-12 bordered"><div class="text"><?=$textPart?></div></div>
				<?elseif($arParams["IMAGE_POSITION"] == "right"):?>
					<div class="col-md-1 col-sm-1 col-xs-12"><?=$namePart?></div>
					<div class="col-md-8 col-sm-8 col-xs-12 bordered"><div class="text"><?=$textPart?></div></div>
					<div class="col-md-3 col-sm-3 col-xs-12"><?=$imagePart?></div>
				<?else:?>
					<div class="col-md-1 col-sm-1 col-xs-12"><?=$namePart?></div>
					<div class="col-md-3 col-sm-3 col-xs-12 bordered"><?=$imagePart?></div>
					<div class="col-md-8 col-sm-8 col-xs-12"><div class="text"><?=$textPart?></div></div>
				<?endif;?>
			</div>
		</div>
	<?endforeach;?>

	<?// bottom pagination?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>