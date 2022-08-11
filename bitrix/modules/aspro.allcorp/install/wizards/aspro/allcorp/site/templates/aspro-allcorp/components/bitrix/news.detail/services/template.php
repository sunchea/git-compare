<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?// element name?>
<?if($arParams["DISPLAY_NAME"] != "N" && strlen($arResult["NAME"])):?>
	<h2><?=$arResult["NAME"]?></h2>
<?endif;?>

<?// single detail image?>
<?if($arResult["FIELDS"]["DETAIL_PICTURE"]):?>		
	<?if($arResult["PROPERTIES"]["PHOTOPOS"]["VALUE_XML_ID"] == "LEFT"):?>				
		<div class="image image-left col-md-3 col-sm-3 col-xs-12"><a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="fancybox" title="<?=$arResult["NAME"];?>" alt="<?=$arResult["NAME"];?>"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="img-responsive"/></a></div>
	<?elseif($arResult["PROPERTIES"]["PHOTOPOS"]["VALUE_XML_ID"] == "RIGHT"):?>
		<div class="image image-right col-md-3 col-sm-3 col-xs-12"><a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="fancybox" title="<?=$arResult["NAME"];?>" alt="<?=$arResult["NAME"];?>"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="img-responsive"/></a></div>
	<?else:?>
		<div class="image"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="img-responsive"/></div>
	<?endif;?>
<?endif;?>

<?// ask question?>
<?if($arResult["DISPLAY_PROPERTIES"]["FORM_QUESTION"]["VALUE_XML_ID"] == "YES"):?>
	<div class="ask_a_question">
		<div class="inner">
			<div class="margin-bottom-20">
				<?$APPLICATION->IncludeComponent(
					 "bitrix:main.include",
					 "",
					 Array(
						  "AREA_FILE_SHOW" => "file",
						  "PATH" => SITE_DIR."include/ask_question.php",
						  "EDIT_TEMPLATE" => ""
					 )
				);?>
			</div>
			<span class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_question"][0]?>" data-autoload-need_product="<?=$arResult["NAME"]?>" data-name="question"><span><?=GetMessage("S_ASK_QUESTION")?></span></span>
		</div>
	</div>
<?endif;?>

<?// date active from or dates period active?>
<?if(strlen($arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]) || ($arResult["DISPLAY_ACTIVE_FROM"] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]))):?>
	<div class="period">
		<?if(strlen($arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"])):?>
			<span class="label label-info"><?=$arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]?></span>
		<?else:?>
			<span class="label"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
		<?endif;?>
	</div>
<?endif;?>

<?if(strlen($arResult["FIELDS"]["DETAIL_TEXT"]) || strlen($arResult["FIELDS"]["DETAIL_TEXT"])):?>
	<div class="content">
		<?// element preview text?>
		<?if(strlen($arResult["FIELDS"]["PREVIEW_TEXT"])):?>
			<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?>
				<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];?></p>
			<?else:?>
				<?=$arResult["FIELDS"]["PREVIEW_TEXT"];?>
			<?endif;?>
		<?endif;?>

		<?// element detail text?>
		<?if(strlen($arResult["FIELDS"]["DETAIL_TEXT"])):?>
			<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?>
				<p><?=$arResult["FIELDS"]["DETAIL_TEXT"];?></p>
			<?else:?>
				<?=$arResult["FIELDS"]["DETAIL_TEXT"];?>
			<?endif;?>
		<?endif;?>
	</div>
<?endif;?>

<?// order?>
<?if($arResult["DISPLAY_PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"]=="YES"):?>
	<div class="styled-block">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-5 valign">
				<span class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_order_services"][0]?>" data-autoload-service="<?=$arResult["NAME"]?>" data-name="services"><span><?=GetMessage("S_ORDER_SERVISE")?></span></span>
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

<?// display properties?>
<?$arDisplayPropertiesCodes = array_diff(array_keys($arResult["DISPLAY_PROPERTIES"]), array('PERIOD', 'PHOTOS', 'DOCUMENTS', 'LINK_GOODS', 'LINK_STAFF', 'LINK_REVIEWS', 'LINK_PROJECTS', 'LINK_SERVICES', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS'));?>
<?if($arResult["DISPLAY_PROPERTIES"] && $arDisplayPropertiesCodes):?>
	<div class="properties">
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
			<?if(in_array($PCODE, $arDisplayPropertiesCodes)):?>
				<div class="property">
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
				</div>
			<?endif;?>
		<?endforeach;?>
	</div>
<?endif;?>

<?// docs files?>
<?if($arResult["DISPLAY_PROPERTIES"]["DOCUMENTS"]["VALUE"]):?>
	<div class="wraps">
		<h4><?=GetMessage('T_DOCS')?></h4>
		<div class="row docs">
			<?foreach($arResult["PROPERTIES"]["DOCUMENTS"]["VALUE"] as $docID):?>
				<?$arItem = aspro::get_file_info($docID);?>
				<div class="col-md-6 <?=$arItem["TYPE"]?>">
					<?$FileName = substr($arItem["ORIGINAL_NAME"], 0, strrpos($arItem["ORIGINAL_NAME"], '.'));?>
					<a href="<?=$arItem["SRC"]?>" target="_blank">
						<?if($arItem["DESCRIPTION"]):?>
							<?=$arItem["DESCRIPTION"];?>
						<?else:?>
							<?=$FileName;?>
						<?endif;?>
					</a>
					<?=GetMessage('CT_NAME_SIZE')?>:
					<?=aspro::filesize_format($arItem["FILE_SIZE"]);?>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>	

<?// gallery?>
<?if($arResult["GALLERY"]):?>
	<div class="wraps">
		<h4><?=GetMessage("T_GALLERY")?></h4>
		<div class="row galery">
			<?foreach($arResult["GALLERY"] as $arPhoto):?>
				<div class="col-md-4 col-sm-6">
					<div class="item">
						<a href="<?=$arPhoto["DETAIL"]['SRC']?>" class="fancybox" rel="gallery" target="_blank" title="<?=($arPhoto["DETAIL"]['DESCRIPTION'] ? $arPhoto["DETAIL"]['DESCRIPTION'] : $arResult["NAME"])?>">
							<div class="info_galery">
								<span class="icons"></span>
								<div class="title"><?=($arPhoto["DETAIL"]['DESCRIPTION'] ? $arPhoto["DETAIL"]['DESCRIPTION'] : $arResult["NAME"])?></div>
							</div>
							<img src="<?=$arPhoto["PREVIEW"]['src']?>" class="img-responsive inline" alt="<?=($arPhoto["DETAIL"]['DESCRIPTION'] ? $arPhoto["DETAIL"]['DESCRIPTION'] : $arResult["NAME"])?>"/>
						</a>
					</div>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>