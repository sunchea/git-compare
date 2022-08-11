<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?$arParams["NEWS_COUNT"] = (($arParams["NEWS_COUNT"] <= 0 || $arParams["NEWS_COUNT"] > 12) ? 1 : $arParams["NEWS_COUNT"]);?>
<div class="row small-banner">
	<div class="col-md-12">
		<div class="row">
			<?foreach($arResult["ITEMS"] as $i => $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$type = $arItem["PROPERTIES"]["BANNERTYPE"]["VALUE_XML_ID"];
				$align = ($type == "T3" ? "right" : ($type == "T4" ? "center" : "left"));
				$bOnlyImage = $type == "T1" || !$type;
				$bLinkOnName = strlen($arItem["PROPERTIES"]["LINKIMG"]["VALUE"]);
				
				if($arItem["DETAIL_PICTURE"]["SRC"]){
					$bg = $arItem["DETAIL_PICTURE"]["SRC"];
					$position = 'background-size:cover;';
				}
				else{
					$bg = '';
					$pos = intval(100 / $arParams["NEWS_COUNT"] * $i);
					$position = 'background-position:'.$pos.'% 20%';
				}
				?>
				<div class="col-md-<?=floor(12 / $arParams["NEWS_COUNT"])?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?if($bLinkOnName && $bOnlyImage):?>
						<a class="banner" href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>" style="text-align:<?=$align?>; <?=($bg ? 'background:url('.$bg.') 0 0 no-repeat;' : '')?> <?=$position?>">
					<?else:?>
						<div class="banner" style="text-align:<?=$align?>; <?=($bg ? 'background:url('.$bg.') 0 0 no-repeat;' : '')?> <?=$position?>">
					<?endif;?>
						<?if($bLinkOnName && !$bOnlyImage):?>
							<div class="title">
								<a href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>">
									<?=str_replace('&lt;br&gt;', '<br/>', $arItem["NAME"])?>
								</a>
							</div>
						<?elseif(!$bOnlyImage):?>
							<?=str_replace('&lt;br&gt;', '<br/>', $arItem["NAME"])?>
						<?endif;?>
					<?if(!$bOnlyImage):?>
						<?=$arItem["PREVIEW_TEXT"]?>
					<?endif;?>
					<?if($bLinkOnName && $bOnlyImage):?>
						</a>
					<?else:?>
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){
		$('.small-banner .banner').sliceHeight({slice: <?=$arParams["NEWS_COUNT"]?>});
	}, 500)
});
</script>