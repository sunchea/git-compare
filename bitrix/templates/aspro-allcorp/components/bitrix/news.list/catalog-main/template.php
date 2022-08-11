<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>

<?if($arResult["SECTIONS"]):?>
<div class="item-views services groups list sections">	
	<div class="flexslider unstyled" style="box-shadow: none;" data-plugin-options='{"animation": "slide", "directionNav": true, "animationLoop": true, "slideshow": true, "minItems": 2}'>
		<ul class="slides">
			<li>
				<div class="row">
					<?$i = 1;?>
					<?foreach($arResult["SECTIONS"] as $arSection):?>
						<?if(!$arSection["ID"]) continue;?>
						<?
							// edit/add/delete buttons for edit mode
							$this->AddEditAction($arSection["ID"], $arSection["EDIT_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], $arSection["DEPTH_LEVEL"] ? "SECTION_EDIT" : "ELEMENT_EDIT"));
							$this->AddDeleteAction($arSection["ID"], $arSection["DELETE_LINK"], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], $arSection["DEPTH_LEVEL"] ? "SECTION_DELETE" : "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CATALOG_ELEMENT_DELETE_CONFIRM")));
						?>
						<div class="col-md-4">
							<div class="item" id="<?=$this->GetEditAreaId($arSection["ID"])?>">
								<div class="col-md-12">
									<div class="title" style="text-align: center;">
										<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
									</div>
									<div class="row">
										<div class="col-md-3"><br></div>
										<div class="col-md-6">
											<div class="image">
												<a href="<?=$arSection["SECTION_PAGE_URL"]?>">										
													<?if($arSection["PREVIEW_PICTURE"]):?>
														<img src="<?=$arSection["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arSection["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arSection["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
													<?else:?>
														<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=$arSection["NAME"]?>" title="<?=$arSection["NAME"]?>" class="img-responsive" />
													<?endif;?>
												</a>
											</div>
										</div>
									</div>								
								</div>
							</div>
						</div>
						<?if($i % 3 == 0 && $i < count($arResult["SECTIONS"])):?>
								</div>
							</li>
							<li>
								<div class="row">
						<?endif;?>
						<?$i++;?>
					<?endforeach;?>
				</div>
			</li>
		</ul>
	</div>
</div>
<?endif;?>