<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
if($arParams["DISPLAY"] == 'table'){
	$arParams["VIEW_TYPE"] = "table";
	$isList = false;
	$arParams["COUNT_IN_LINE"] = ($arParams["COUNT_IN_LINE"] ? $arParams["COUNT_IN_LINE"] : '3');
}elseif($arParams["DISPLAY"] == 'list'){
	$isList = true;
	$arParams["VIEW_TYPE"] = "list";
}elseif($arParams["DISPLAY"] == 'price'){
	$isList = true;
}	
?>
<?
$frame = $this->createFrame()->begin();
$frame->setAnimation(true);
?>
<div class="catalog group tabs item-views <?=$arParams["VIEW_TYPE"]?>">
	<?if($arResult["ITEMS"]):?>
		<?if( $arParams["DISPLAY_TOP_PAGER"] ){?>
			<?=$arResult["NAV_STRING"]?>
		<?}?>

		<?if( !function_exists("showAllItems") ){
			function showAllItems( $this_, $arSection, $arParams, $inx = 0, $isList ){
						$size=($arParams["VIEW_TYPE"] == "table" ? $arParams["COUNT_IN_LINE"] : 0);
						$size=(int)$size<=0 ? 1 : $size;?>
						<div class="row">
						<?
							$i = 1;
								foreach( $arSection["ITEMS"] as $arItem ){
									$this_->AddEditAction( $arItem["ID"].$arSection["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID( $arItem["IBLOCK_ID"], "ELEMENT_EDIT" ) );
									$this_->AddDeleteAction( $arItem["ID"].$arSection["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID( $arItem["IBLOCK_ID"], "ELEMENT_DELETE" ), array( "CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM") ) );

									ob_start();
									if($isList){?>
										<div class="row noright titles">
											<div class="col-md-<?=( $arItem["PROPERTIES"]["PRICE"]["VALUE"] ? '8' : '12')?>">
									<?}
									if( $arParams["SHOW_NAME"] == "Y" ){?>
										<div class="title">
											<?if( $arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
												<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
											<?}else{?>
												<?=$arItem["NAME"]?>
											<?}?>
											
										</div>
									<?}
									if( !empty( $arItem["SECTION_NAME"] ) && ($arParams["DISPLAY"]!=='price') ){?>
										<div class="section_name"><?=$arItem["SECTION_NAME"]?></div>
										<?if($arItem["PROPERTIES"]["STATUS"]["VALUE_XML_ID"]):?>
											<span class="label label-<?=$arItem["PROPERTIES"]["STATUS"]["VALUE_XML_ID"]?> noradius"><?=$arItem["PROPERTIES"]["STATUS"]["VALUE"]?></span>
										<?endif;?>
									<?}
									if($isList) {?>
										</div>
									<?}
									if( $arItem["PROPERTIES"]["PRICE"]["VALUE"] ){?>
										<?if($isList) {?>
											<div class="col-md-4 text-right">
										<?}?>
										<div class="price">
											<div class="price_new"><span class="price_val"><?=$arItem["PROPERTIES"]["PRICE"]["VALUE"]?></span></div>
											<?if( $arItem["PROPERTIES"]["PRICEOLD"]["VALUE"] ){?>
												<div class="price_old"><span class="price_val"><?=$arItem["PROPERTIES"]["PRICEOLD"]["VALUE"]?></span></div>
											<?}?>
										</div>
										<?if($isList){?>
											</div>
										<?}
									}
									if($isList){?>
										</div>
										<?if( !empty( $arItem["PREVIEW_TEXT"] ) ){?>
											<div class="row noright">
												<div class="col-md-12 hr">												
													<div class="description">
														<?if( $arItem["PREVIEW_TEXT_TYPE"] == "text" ){?>
															<p><?=$arItem["PREVIEW_TEXT"]?></p>
														<?}else{?>
															<?=$arItem["PREVIEW_TEXT"]?>
														<?}?>
													</div>
												</div>
											</div>
										<?}?>
									<?}
									if( !empty( $arItem["PROPERTIES"]["TITLE_BUTTON"]["VALUE"] ) && !empty( $arItem["PROPERTIES"]["LINK_BUTTON"]["VALUE"] ) ){?>
										<div>
											<a class="btn btn-primary" href="<?=$arItem["PROPERTIES"]["LINK_BUTTON"]["VALUE"]?>" target="_blank">
												<?=$arItem["PROPERTIES"]["TITLE_BUTTON"]["VALUE"]?>
											</a>
										</div>
									<?}
									if($isList){?>
										<div class="row noright">
											<div class="col-md-12 bottom">
									<?}
									if( $arParams["VIEW_TYPE"] == "list" && $arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn btn-<?=($isList ? 'default grey' : 'primary')?> btn-sm"><?=GetMessage("TO_ALL")?></a>
									<?}
									if($isList){?>
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_order_product"][0]?>" data-product="<?=$arItem["NAME"]?>" data-name="order_product"><?=GetMessage("TO_ORDER")?></a>
									<?}
									if($isList){?>
											</div>
										</div>
									<?}
									$text = ob_get_clean();
									
									if( $arParams["SHOW_IMAGE"] == "Y" ){
										ob_start();?>
										<div class="image">
											<?if( $arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
												<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
											<?}elseif( is_array( $arItem["DETAIL_PICTURE"] ) ){?>
												<a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="img-inside fancybox">
											<?}
													if( is_array( $arItem["PREVIEW_PICTURE"] ) ){?>
														<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
													<?}else{?>
														<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
													<?}
											if( $arParams["SHOW_DETAIL"] == "Y" && !( $arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && empty( $arItem["DETAIL_TEXT"] ) ) ){?>
												</a>
											<?}elseif( is_array( $arItem["DETAIL_PICTURE"] ) ){?>
													<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
												</a>
											<?}?>
										</div>
										<?$img = ob_get_clean();
									}?>
									
									<?if( $arParams["VIEW_TYPE"] == "list" ){?>
										<div id="<?=$this_->GetEditAreaId( $arItem["ID"].$arSection["ID"] )?>" class="col-md-12">
											<div class="item">
												<div class="row">
													<?if( $arParams["SHOW_IMAGE"] != "Y" ){?>
														<div class="col-md-12">
															<?=$text?>
														</div>
													<?}elseif( $arParams["IMAGE_POSITION"] == "right" ){?>
														<div class="col-md-9 col-sm-7 text_info">
															<?=$text?>
														</div>
														<div class="col-md-3 col-sm-5 images">
															<?=$img?>
														</div>
													<?}else{?>
														<div class="col-md-3 col-sm-5 images">
															<?=$img?>
														</div>
														<div class="col-md-9 col-sm-7 text_info">
															<?=$text?>
														</div>
													<?}?>
												</div>
											</div>
										</div>
									<?}elseif( $arParams["VIEW_TYPE"] == "table" ){?>
										<div class="col-md-<?=floor( 12 / $arParams["COUNT_IN_LINE"] )?>" id="<?=$this_->GetEditAreaId( $arItem['ID'].$arSection["ID"] )?>">
											<div class="item">
												<?if( $arParams["SHOW_IMAGE"] != "Y" ){?>
													<div class="text">
														<?=$text?>
													</div>
												<?}elseif( $arParams["IMAGE_POSITION"] == "bottom" ){?>
													<div class="text">
														<?=$text?>
													</div>
													<?=$img?>
												<?}else{?>
													<?=$img?>
													<div class="text">
														<?=$text?>
													</div>
												<?}?>
											</div>
										</div>
										<?if( $i % $size == 0 && $i < count( $arSection["ITEMS"] ) ){?>
											</div>
											<div class="row">
										<?}
										$i++;
									}
								}?>
							</div>
					<script>
						$(document).ready(function(){
							setTimeout(function(){
								<?if( $arParams["VIEW_TYPE"] == "table" ){?>
									$('.catalog.group.item-views.<?=$arParams["VIEW_TYPE"]?> .row .image').sliceHeight( { slice: <?=$size?>, lineheight:-3 } );
									$('.catalog.group.item-views.<?=$arParams["VIEW_TYPE"]?> .row .text').sliceHeight( { slice: <?=$size?> } );
								<?}?>
							}, 600)
						})
					</script>
				<?
			}
		}?>	
		<div class="group-content">
			<?$i = 0;?>
			<?showAllItems( $this, $arResult, $arParams, $i, $isList );?>
		</div>
		
		<?if( $arParams["DISPLAY_BOTTOM_PAGER"] ){?>
			<?=$arResult["NAV_STRING"]?>
		<?}?>
	<?endif;?>
	
	<?// section description?>
	<?if(is_array($arResult["SECTION"]["PATH"])):?>
		<?$arCurSectionPath = end($arResult["SECTION"]["PATH"]);?>
		<?if(strlen($arCurSectionPath["DESCRIPTION"]) && strpos($_SERVER["REQUEST_URI"], "PAGEN") === false):?>
			<div class="cat-desc"><?=$arCurSectionPath["DESCRIPTION"]?></div>
		<?endif;?>
	<?endif;?>
</div>
<?$frame->end();?>