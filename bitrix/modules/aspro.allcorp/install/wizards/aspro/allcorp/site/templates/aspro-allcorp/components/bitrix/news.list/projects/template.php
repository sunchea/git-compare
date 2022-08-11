<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="projects-list">
	<?if( $arParams["DISPLAY_TOP_PAGER"] ){?>
		<?=$arResult["NAV_STRING"]?>
	<?}?>

	<?						
		foreach( $arResult["ITEMS"] as $arItem ){
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));			
			
			echo '<div class="row" id="'.$this->GetEditAreaId($arItem['ID']).'">';
			echo '<div >';
			
			$has_image=false;				
			if (is_array( $arItem["PREVIEW_PICTURE"]) ) {
				$has_image=true;
				?>
				<div class="col-md-4">
					<div class="image">
						<?if(  !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<?}?>					
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />		
						<?if(  !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
							</a>
						<?}?>
					</div>
				</div>
				<?
			}
							
							
			if ($has_image) {
				echo '<div class="col-md-8">';
			} else {
				echo '<div class="col-md-12">';
			}
						
			?><div class="title">
					<?if( !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
					<?}else{?>
						<?=$arItem["NAME"]?>
					<?}?>
			 </div>
			<?
						
			
			if ($arItem["DISPLAY_ACTIVE_FROM"] ) {
				?><div class="period"><span class="label"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span></div><?
			}
				
							
			if( !empty( $arItem["PREVIEW_TEXT"] ) ){
				if( $arItem["PREVIEW_TEXT_TYPE"] == "text" ){?>
					<p><?=$arItem["PREVIEW_TEXT"]?></p>
				<?}else{?>
					<?=$arItem["PREVIEW_TEXT"]?>
				<?}
			}
			

			if( $arParams["VIEW_TYPE"] == "list" && $arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn btn-primary btn-sm"><?=GetMessage("TO_ALL")?>&nbsp;&nbsp;<i class="icon icon-angle-right"></i></a>
			<?}
							
		echo '</div></div></div>';
		echo '<hr/>';
	}?>
	

	<?if( $arParams["DISPLAY_BOTTOM_PAGER"] ){?>
		<?=$arResult["NAV_STRING"]?>
	<?}?>
</div>

<br/><br/>
