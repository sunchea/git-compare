<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult["NavPageCount"] != 1 && empty($arResult["bShowAll"]) && $arResult["nEndPage"] > 0):?>
	<?
	$count_item = 5;
	$arResult["nStartPage"] = $arResult["NavPageNomer"] - $count_item;
	$arResult["nStartPage"] = $arResult["nStartPage"] <= 0 ? 1 : $arResult["nStartPage"];
	
	$arResult["nEndPage"] = $arResult["NavPageNomer"] + $count_item;
	$arResult["nEndPage"] = $arResult["nEndPage"] > $arResult["NavPageCount"] ? $arResult["NavPageCount"] : $arResult["nEndPage"];
	
	$strNavQueryString = !empty($arResult["NavQueryString"]) ? $arResult["NavQueryString"].'&amp;' : '';
	$strNavQueryStringFull = !empty($arResult["NavQueryString"]) ? "?".$arResult["NavQueryString"] : '';
	?>
	<div class="wrap_pagination">
		<ul class="pagination">
			<?if($arResult["NavPageNomer"] > 1):?>
				<li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><i class="icon icon-chevron-left"></i></a></li>
			<?endif;?>
			<?if($arResult["nStartPage"] > 1):?>
				<li><span>...</span></li>
			<?endif;?>
			<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>			
				<?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<li class="active"><span><?=$arResult["nStartPage"]?></span></li>
				<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<li><a data-number-page="<?=$arResult['nStartPage']?>" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
				<?else:?>
					<li><a data-number-page="<?=$arResult['nStartPage']?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
				<?endif;?>
				<?++$arResult["nStartPage"];?>
			<?endwhile;?>
			<?if($arResult["nEndPage"] < $arResult["NavPageCount"]):?>
				<li><span>...</span></li>
			<?endif;?>
			<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
				<li><a data-number-page="<?=($arResult["NavPageNomer"]+1)?>" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><i class="icon icon-chevron-right"></i></a></li>
			<?endif;?>
		</ul>
	</div>
<?endif;?>