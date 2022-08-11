<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views <?=$arParams["VIEW_TYPE"]?> <?=($arParams["SHOW_TABS"] == "Y" ? "with_tabs" : "")?> <?=($arParams["IMAGE_POSITION"] ? "image_".$arParams["IMAGE_POSITION"] : "")?> <?=($templateName = $component->{"__parent"}->{"__template"}->{"__name"})?>">
	<?// top pagination?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>

	<?if($arResult["SECTIONS"]):?>
		<?// tabs?>
		<?if($arParams["SHOW_TABS"] == "Y"):?>
			<div class="tabs">
				<ul class="nav nav-tabs">
					<?$i = 0;?>
					<?foreach($arResult["SECTIONS"] as $SID => $arSection):?>
						<?
						if(!$SID) continue;
						$this->AddEditAction($arSection['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT"));
						$this->AddDeleteAction($arSection['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CATALOG_ELEMENT_DELETE_CONFIRM')));
						?>
						<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="<?=$i++ == 0 ? 'active' : ''?>"><a data-toggle="tab" href="#tab_<?=$arSection["ID"]?>"><?=$arSection["NAME"]?></a></li>
					<?endforeach;?>
				</ul>
		<?endif;?>
		
				<div class="<?=($arParams["SHOW_TABS"] == "Y" ? "tab-content" : "group-content")?>">
					<?// group elements by sections?>
					<?foreach($arResult["SECTIONS"] as $SID => $arSection):?>
						<?if($arParams["SHOW_TABS"] == "Y"):?>
							<div id="tab_<?=($arSection["ID"] > 0 ? $arSection["ID"] : 0)?>" class="tab-pane <?=(!$si++ || !$arSection["ID"] ? "active" : "")?>">
						<?endif;?>

							<?if($arParams["SHOW_SECTION_PREVIEW_DESCRIPTION"] == "Y"):?>
								<?// section name?>
								<?if(strlen($arSection["NAME"])):?>
									<h4><?=$arSection["NAME"]?></h4>
								<?endif;?>
								
								<?// section description text/html?>
								<?if(strlen($arSection["DESCRIPTION"])):
									if($arSection["DESCRIPTION_TYPE"] == "text"):?>
										<p><?=$arSection["DESCRIPTION"]?></p>
									<?else:?>
										<p><?=$arSection["DESCRIPTION"]?></p>
									<?endif;?>
								<?endif;?>
							<?endif;?>
							
							<?// show section items?>
							<?$iCnt = 0;?>
							<?foreach($arSection["ITEMS"] as $i => $arItem):?>
								<?
								// edit/add/delete buttons for edit mode
								$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
								// use detail link?
								$bDetailLink = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && !strlen($arItem["DETAIL_TEXT"]));
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
									
									<?// element preview text?>
									<?if(strlen($arItem["FIELDS"]["PREVIEW_TEXT"])):?>
										<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
											<p><?=$arItem["FIELDS"]["PREVIEW_TEXT"]?></p>
										<?else:?>
											<?=$arItem["FIELDS"]["PREVIEW_TEXT"]?>
										<?endif;?>
									<?endif;?>
									
									<?// element detail text?>
									<?if(strlen($arItem["FIELDS"]["DETAIL_TEXT"])):?>
										<?if($arItem["DETAIL_TEXT_TYPE"] == "text"):?>
											<p><?=$arItem["FIELDS"]["DETAIL_TEXT"]?></p>
										<?else:?>
											<?=$arItem["FIELDS"]["DETAIL_TEXT"]?>
										<?endif;?>
									<?endif;?>
									
									<?// element display properties?>
									<?if($arItem["DISPLAY_PROPERTIES"]):?>
										<div class="properties">
											<?foreach($arItem["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
												<div class="property">
													<?if(!($PCODE == "PAY" && $arParams["VIEW_TYPE"] == "accordion")):?>
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
													<?endif;?>
												</div>
											<?endforeach;?>
										</div>
									<?endif;?>
									<button class="btn btn-primary" data-event="jqm" data-name="resume" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_resume"][0]?>" data-autoload-POST="<?=$arItem["NAME"]?>" data-autohide=""><?=GetMessage("BUTTON")?></button>
								<?$textPart = ob_get_clean();?>
								
								<?if($bPreviewPicture):?>
									<?ob_start();?>
										<div class="image">
											<?if($bDetailLink):?>
												<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
											<?elseif($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
												<a href="<?=$arItem["FIELDS"]["DETAIL_PICTURE"]["SRC"]?>" class="img-inside fancybox">
											<?endif;?>
											
												<img src="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
												
											<?if($bDetailLink):?>
												</a>
											<?elseif($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
													<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
												</a>
											<?endif;?>
										</div>
									<?$imagePart = ob_get_clean();?>
								<?endif;?>
								
								<?if($arParams["VIEW_TYPE"] == "list"):?>
									<div id="<?=$this->GetEditAreaId($arItem["ID"])?>" class="item">
										<div class="row">
											<?if(!$bPreviewPicture):?>
												<div class="col-md-12"><div class="text"><?=$textPart?></div></div>
											<?elseif($arParams["IMAGE_POSITION"] == "right"):?>
												<div class="col-md-9 col-sm-9 col-xs-12"><div class="text"><?=$textPart?></div></div>
												<div class="col-md-3 col-sm-3 col-xs-12"><?=$imagePart?></div>
											<?else:?>
												<div class="col-md-3 col-sm-3 col-xs-12"><?=$imagePart?></div>
												<div class="col-md-9 col-sm-9 col-xs-12"><div class="text"><?=$textPart?></div></div>
											<?endif;?>
										</div>
									</div>
									<hr />
								<?elseif($arParams["VIEW_TYPE"] == "accordion"):?>
									<div class="accordion-type-2">
										<div class="item" id="<?=$this->GetEditAreaId($arItem["ID"])?>">
											<div class="accordion-head accordion-close" data-toggle="collapse" data-parent="#accordion<?=$arSection["ID"]?>" href="#accordion<?=$arItem["ID"]?>_<?=$arSection["ID"]?>">
												<a href="#"><?=$arItem["NAME"]?><i class="icon icon-angle-down"></i></a>
												<?if(in_array("PAY", $arParams["PROPERTY_CODE"])):?>
													<div class="pay">
														<?if($arItem["DISPLAY_PROPERTIES"]["PAY"]["VALUE"]):?>
															<?=GetMessage("PAY_ABOUT")?>&nbsp;<b><?=$arItem["DISPLAY_PROPERTIES"]["PAY"]["VALUE"]?></b>
														<?else:?>
															<?=GetMessage("PAY_INTERVIEWS")?>
														<?endif;?>
													</div>
												<?endif;?>
											</div>
											<div id="accordion<?=$arItem["ID"]?>_<?=$arSection["ID"]?>" class="panel-collapse collapse">
												<div class="accordion-body">
													<div class="row">
														<?if(!$bPreviewPicture):?>
															<div class="col-md-12"><div class="text"><?=$textPart?></div></div>
														<?elseif($arParams["IMAGE_POSITION"] == "right"):?>
															<div class="col-md-9"><div class="text"><?=$textPart?></div></div>
															<div class="col-md-3"><?=$imagePart?></div>
														<?else:?>
															<div class="col-md-3"><?=$imagePart?></div>
															<div class="col-md-9"><div class="text"><?=$textPart?></div></div>
														<?endif;?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?endif;?>
							<?endforeach;?>
						<?if($arParams["SHOW_TABS"] == "Y"):?>
							</div>
						<?endif;?>
						
						<?// slice elements height?>
						<?if($arParams["VIEW_TYPE"] == "table"):?>
							<script>
							var templateName = '<?=$templateName?>';
							$(document).ready(function(){
								setTimeout(function(){
									$(".table." + templateName + " .row.sid-<?=$arSection["ID"]?> .image").sliceHeight({slice: <?=$arParams["COUNT_IN_LINE"]?>, lineheight:-3});
									$(".table." + templateName + " .row.sid-<?=$arSection["ID"]?> .text").sliceHeight({slice: <?=$arParams["COUNT_IN_LINE"]?>});
								}, 500)
							})
							</script>
						<?endif;?>
					<?endforeach;?>
				</div>
		<?if($arParams["SHOW_TABS"] == "Y"):?>
			</div>
		<?endif;?>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>