<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<div class="top-slider flexslider unstyled" data-plugin-options='{"animation": "slide", "directionNav": true, "animationLoop": true, "slideshow": true, "touch" : true, "controlNav" :true}'>
	<ul class="slides">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$img = is_array($arItem["DETAIL_PICTURE"]) ? $arItem["DETAIL_PICTURE"]["SRC"] : $this->GetFolder()."/images/background.jpg";
			$type = $arItem["PROPERTIES"]["BANNERTYPE"]["VALUE_XML_ID"];
			$bOnlyImage = $type == "T1" || !$type;
			$bLinkOnName = strlen($arItem["PROPERTIES"]["LINKIMG"]["VALUE"]);
			?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="background-image:url('<?=$img?>') !important;">
				<div class="container<?=($bOnlyImage && $bLinkOnName ? ' fa' : '')?>">
					<div class="row <?=$arItem["PROPERTIES"]["TEXTCOLOR"]["VALUE_XML_ID"]?>">
						<?ob_start();?>
						<?if(!$bOnlyImage):?>
							<?if($bLinkOnName):?>
								<a href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>" class="title-link">
									<div class="title"><?=$arItem["NAME"]?></div>
								</a>
							<?else:?>
								<div class="title"><?=$arItem["NAME"]?></div>
							<?endif;?>
							<div class="text-block">
								<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
									<p>
								<?endif;?>
									<?=$arItem["PREVIEW_TEXT"]?>
								<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
									</p>
								<?endif;?>
							</div>
							<?if(strlen($arItem["PROPERTIES"]["BUTTON1TEXT"]["VALUE"]) && strlen($arItem["PROPERTIES"]["BUTTON1LINK"]["VALUE"])):?>
								<a href="<?=$arItem["PROPERTIES"]["BUTTON1LINK"]["VALUE"]?>" class="btn <?=(strlen($arItem["PROPERTIES"]["BUTTON1CLASS"]["VALUE"]) ? $arItem["PROPERTIES"]["BUTTON1CLASS"]["VALUE"] : "btn-primary")?>">
									<?=$arItem["PROPERTIES"]["BUTTON1TEXT"]["VALUE"]?>
								</a>
							<?endif;?>
							<?if(strlen($arItem["PROPERTIES"]["BUTTON2TEXT"]["VALUE"]) && strlen($arItem["PROPERTIES"]["BUTTON2LINK"]["VALUE"])):?>
								<a href="<?=$arItem["PROPERTIES"]["BUTTON2LINK"]["VALUE"]?>" class="btn <?=(strlen($arItem["PROPERTIES"]["BUTTON2CLASS"]["VALUE"] ) ? $arItem["PROPERTIES"]["BUTTON2CLASS"]["VALUE"] : "btn-transparent")?>">
									<?=$arItem["PROPERTIES"]["BUTTON2TEXT"]["VALUE"]?>
								</a>
							<?endif;?>
						<?endif;?>
						<?$text = ob_get_clean();?>
						
						<?ob_start();?>
						<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
							<?if($bLinkOnName):?>
								<a href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>" class="image">
									<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
								</a>
							<?else:?>
								<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
							<?endif;?>
						<?endif;?>
						<?$img = ob_get_clean();?>
						
						<?if(!$bOnlyImage || (is_array($arItem["PREVIEW_PICTURE"]) && !$bOnlyImage)):?>
							<div class="col-md-6 <?=$type == "T2" ? "text" : "img"?>">
								<div class="inner">
									<?=$type == "T2" ? $text : $img?>
								</div>
							</div>
							<div class="col-md-6 <?=$type == "T2" ? "img" : "text"?>">
								<div class="inner">
									<?=$type == "T2" ? $img : $text?>
								</div>
							</div>
						<?elseif($bOnlyImage && $bLinkOnName):?>
							<a href="<?=$arItem["PROPERTIES"]["LINKIMG"]["VALUE"]?>"></a>
						<?endif;?>
					</div>
				</div>
			</li>
		<?endforeach;?>
	</ul>
</div>