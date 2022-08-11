<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
$arParams["COLUMN_COUNT"] = intval(($arParams["COLUMN_COUNT"] < 1 ? 1 : ($arParams["COLUMN_COUNT"] > 4 ? 4 : $arParams["COLUMN_COUNT"])));
$colmd = intval(12 / $arParams["COLUMN_COUNT"]);
?>
<div class="feature">
	<div class="row">
		<?$i = 0;?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if($i % (12 / $colmd) == 0 && $i > 0):?>
				</div>
				<div class="row">
			<?endif;?>
			<div class="col-md-<?=$colmd?>">
				<?
				// edit/add/delete buttons for edit mode
				$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
				?>
				<div class="feature-box" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
					<?// icon or preview picture?>
					<?if($arItem["DISPLAY_PROPERTIES"]["ICON"]["VALUE"] || $arItem["FIELDS"]["PREVIEW_PICTURE"]):?>
						<?if($arItem["FIELDS"]["PREVIEW_PICTURE"]):?>
							<div class="image">
								<img src="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
							</div>
						<?else:?>
							<div class="feature-box-icon">
								<i class="icon <?=$arItem["DISPLAY_PROPERTIES"]["ICON"]["VALUE"]?>"></i>
							</div>
						<?endif;?>
					<?endif;?>
					<div class="feature-box-info">
					
						<?// element name?>
						<?if(strlen($arItem["FIELDS"]["NAME"])):?>
							<div class="title">
								<?if($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]):?>
									<a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arItem["NAME"]?></a>
								<?else:?>
									<span><?=$arItem["NAME"]?></span>
								<?endif;?>
							</div>
						<?endif;?>
						
						<?// element preview text?>
						<?if(strlen($arItem["FIELDS"]["PREVIEW_TEXT"])):?>
							<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
								<p><?=$arItem["FIELDS"]["PREVIEW_TEXT"]?></p>
							<?else:?>
								<?=$arItem["FIELDS"]["PREVIEW_TEXT"]?>
							<?endif;?>
						<?endif;?>
					</div>
				</div>
			</div>
			<?++$i;?>
		<?endforeach;?>
	</div>
</div>