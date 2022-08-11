<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<div class="front-news">
	<h3><?=GetMessage('BLOCK_NAME')?></h3>
	<?foreach( $arResult["ITEMS"] as $key => $arItem ){
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		$arItem["DETAIL_PAGE_URL"] = str_replace("#YEAR#/", "", $arItem["DETAIL_PAGE_URL"]);
		?>
		<div class="news-item clearfix" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
			<div class="news-image">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<?if( is_array( $arItem["PREVIEW_PICTURE"] ) ){?>
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
					<?}else{?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
					<?}?>
				</a>
			</div>
			<div class="news-info">
				<div class="title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
				<div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
			</div>
		</div>
	<?}?>
	
	<a href="<?=str_replace("#SITE"."_DIR#", SITE_DIR, $arResult["LIST_PAGE_URL"])?>" class="btn btn-default btn-sm"><?=GetMessage('TO_ALL')?>&nbsp;&nbsp;<i class="icon icon-angle-right"></i></a>
</div> 