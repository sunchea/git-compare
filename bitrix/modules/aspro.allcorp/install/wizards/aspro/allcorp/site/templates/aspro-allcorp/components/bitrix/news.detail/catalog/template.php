<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?
$frame = $this->createFrame('detailelement')->begin('');
$frame->setAnimation(true);
?>
<div class="catalog detail">
	<div class="row">
		<?if($arResult["GALLERY"]):?>
			<div class="col-md-4 item_slider">
				<ul class="slides">					
					<?foreach($arResult["GALLERY"] as $key => $arPhoto):?>
						<li id="photo-<?=$key?>" <?=$key == 0 ? 'class="current"' : ''?>>
							<a href="<?=$arPhoto["DETAIL"]["SRC"]?>" target="_blank" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" rel="item_slider" class="fancybox">
								<span class="lupa" style="display: none;" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>"></span>
								<img border="0" class="img-responsive inline" src="<?=$arPhoto["PREVIEW"]["src"]?>" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
							</a>
						</li>
					<?endforeach;?>
					<?if(!count($arResult["GALLERY"])):?>
						<li class="current">
							<img border="0" class="img-responsive inline" src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
						</li>
					<?endif;?>
				</ul>
				<?if(count($arResult["GALLERY"])> 1):?>
					<div class="thumbs">
						<div class="row item">
							<?foreach($arResult["GALLERY"] as $key => $arPhoto):?>
								<div class="col-md-4 col-sm-3 thumb">
									<div class="item <?=$key == 0 ? 'current' : ''?>">
										<a href="#photo-<?=$key?>">
											<img border="0" src="<?=$arPhoto["THUMB"]["src"]?>" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
										</a>
									</div>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
		<div class="col-md-<?=($arResult["GALLERY"] ? '4' : '8');?> content">
			<div class="section_title"><?=$arResult["SECTION_NAME"]?></div>
			<div class="row prop">
				<?if($arResult["PROPERTIES"]["ARTICLE"]["VALUE"]):?>
					<div class="col-md-12 item">
						<?=GetMessage("ARTICLE")?><span><?=$arResult["PROPERTIES"]["ARTICLE"]["VALUE"];?></span>
					</div>
				<?endif;?>
				<?if($arResult["PROPERTIES"]["BRAND"]["VALUE"]):?>
					<div class="col-md-12 item">
						<?=GetMessage("BRAND")?><span><?=$arResult["PROPERTIES"]["BRAND"]["VALUE"];?></span>
					</div>
				<?endif;?>
			</div>
			<hr/>
			<?if($arResult["PROPERTIES"]["STATUS"]["VALUE_XML_ID"]):?>
				<div class="wrap">
					<span class="label label-<?=$arResult["PROPERTIES"]["STATUS"]["VALUE_XML_ID"];?> noradius"><?=$arResult["PROPERTIES"]["STATUS"]["VALUE"];?></span>
				</div>
				<hr/>
			<?endif;?>
			<?if($arResult["PREVIEW_TEXT"]):?>
				<div class="preview">
					<?=$arResult["PREVIEW_TEXT"];?>
				</div>
			<?endif;?>
		</div>
		<div class="col-md-4">
			<div class="info">
				<div class="price">
					<div class="price_new"><span class="price_val"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></span></div>
					<?if($arResult["PROPERTIES"]["PRICEOLD"]["VALUE"]):?>
						<div class="price_old"><?=GetMessage("DISCOUNT_PRICE")?>&nbsp;<span class="price_val"><?=$arResult["PROPERTIES"]["PRICEOLD"]["VALUE"]?></span></div>
					<?endif;?>
				</div>
				<?if($arResult["PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES" || $arResult["PROPERTIES"]["FORM_QUESTION"]["VALUE_XML_ID"] == "YES"):?>
					<div class="order">
						<?if($arResult["PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES"):?>
							<span class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_order_product"][0]?>" data-product="<?=$arResult["NAME"]?>" data-name="order_product"><?=GetMessage("TO_ORDER")?></span>
							<br/>
						<?endif;?>
						<?if($arResult["PROPERTIES"]["FORM_QUESTION"]["VALUE_XML_ID"] == "YES"):?>
							<span class="btn btn-default btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_question"][0]?>" data-autoload-need_product="<?=$arResult["NAME"]?>" data-name="question"><?=GetMessage("TO_CALL")?></span>
						<?endif;?>
						<div class="text"><?=GetMessage("MORE_TEXT")?></div>
					</div>
				<?endif;?>
				<div class="share">
					<span class="text"><?=GetMessage('SHARE_TEXT')?></span>
					<script type="text/javascript">
					$(document).ready(function() {
						var script = document.createElement('script');
						script.type = 'text/javascript';
						script.src = '//yandex.st/share/share.js';
						$('.detail').append(script);
					});
					</script>
					<?/*<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>*/?>
					<span class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></span>
				</div>
			</div>
		</div>
	</div>
	<?if($arResult["DETAIL_TEXT"]):?>
		<div class="description">
			<?=$arResult["DETAIL_TEXT"];?>
		</div>
	<?endif;?>
	<?if($arResult["PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES"):?>
		<div class="styled-block catalog">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-5 valign">
					<span class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_order_product"][0]?>" data-product="<?=$arResult["NAME"]?>" data-name="order_product"><span><?=GetMessage("TO_ORDER")?></span></span>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-7 valign">
					<div class="right">
						<?$APPLICATION->IncludeComponent(
							 "bitrix:main.include",
							 "",
							 Array(
								  "AREA_FILE_SHOW" => "file",
								  "PATH" => SITE_DIR."include/ask_services.php",
								  "EDIT_TEMPLATE" => ""
							 )
						);?>
					</div>
				</div>
			</div>
		</div>
	<?endif;?>
	<div class="row">
		<?if($arResult["CHARACTERISTICS"]):?>
			<div class="col-md-6 chars">
				<h4 class="char"><?=GetMessage('T_CHARACTERISTICS')?></h4>
				<div class="char-wrapp">
					<table class="props_table">
						<?foreach($arResult["CHARACTERISTICS"] as $arProp):?>
							<tr class="char">
								<td class="char_name">
								<?if ($arProp["HINT"]):?><div class="hint"><span class="icons" data-toggle="tooltip" data-placement="top" title="<?=$arProp["HINT"]?>"></span></div><?endif;?>
								<span><?=$arProp["NAME"]?></span></td>
								<td class="char_value">
									<span>
										<?if(is_array($arProp["DISPLAY_VALUE"])){
											foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
										else{ 
											if($arProp["CODE"] == "SITE"){?>
												<!--noindex-->
												<a href="<?=$arProp["DISPLAY_VALUE"];?>" target="_blank" rel="nofollow"><?=$arProp["DISPLAY_VALUE"];?></a>
												<!--/noindex-->
											<?}else{
												echo $arProp["DISPLAY_VALUE"]; 
											}
										}
										?>
									</span>
								</td>
							</tr>
						<?endforeach;?>
					</table>
				</div>
			</div>
		<?endif;?>
		<?if($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"]):?>
			<div class="col-md-6 docs">
				<h4 class="char"><?=GetMessage('T_DOCS')?></h4>
				<?foreach($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"] as $docID):?>
					<?$arItem = aspro::get_file_info($docID);?>
					<div class="<?=$arItem["TYPE"]?>">
						<?$FileName = substr($arItem["ORIGINAL_NAME"], 0, strrpos($arItem["ORIGINAL_NAME"], '.'));?>
						<a href="<?=$arItem["SRC"]?>" target="_blank"><?if($arItem["DESCRIPTION"]){echo $arItem["DESCRIPTION"];} else {echo $FileName;}?></a>
						<?=GetMessage('CT_NAME_SIZE')?>:
						<?=aspro::filesize_format($arItem["FILE_SIZE"]);?>
					</div>
				<?endforeach;?>
			</div>
		<?endif;?>
	</div>
	<?if($arResult["PROJECTS"]["ITEMS"]):?>
		<div class="wraps nomargin">
			<div class="row projects">
				<div class="col-md-12"><h4><?=GetMessage("T_PROJECTS")?></h4></div>
				<?foreach($arResult["PROJECTS"]["ITEMS"] as $arProject):?>
					<div class="col-md-3 col-sm-4 projects">
						<div class="item">
							<?$src=($arProject["DETAIL"]['SRC'] ? $arProject["DETAIL"]['SRC'] : $arProject["PREVIEW"]['src']);?>
							<a href="<?=$arProject["DETAIL_PAGE_URL"]?>" class="fancybox" rel="gallery" title="<?=($arProject["DETAIL"]['DESCRIPTION'] ? $arProject["DETAIL"]['DESCRIPTION'] : $arProject["NAME"])?>">
								<?$previewSRC = $arProject["PREVIEW"]['src'] ? $arProject["PREVIEW"]['src'] : SITE_TEMPLATE_PATH."/images/noimage.png";?>
								<img src="<?=$previewSRC ?>" class="img-responsive inline <?=(!$arProject["PREVIEW"]['src'] ? "noimage" : "")?>" alt="<?=($arProject["DETAIL"]['DESCRIPTION'] ? $arProject["DETAIL"]['DESCRIPTION'] : $arProject["NAME"])?>"/>
								<div class="projects">
									<span class="icons"></span>
									<div class="title"><?=($arProject["DETAIL"]['DESCRIPTION'] ? $arProject["DETAIL"]['DESCRIPTION'] : $arProject["NAME"])?></div>
									<?if($arProject["PREVIEW_TEXT"]):?>
										<div class="preview_text"><?=$arProject["PREVIEW_TEXT"];?></div>
									<?endif;?>
								</div>
							</a>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
	<?endif;?>
</div>
<?$frame->end();?>