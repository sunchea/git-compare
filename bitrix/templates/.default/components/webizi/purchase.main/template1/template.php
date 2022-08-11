<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($USER->isAdmin()){
	// echo '<pre>';
	// print_r($arResult);
	// echo '</pre>';
}?>
<div class="uk-grid wi-purchase">
	<div class="uk-width-1-1 relative caption_conteiner">
		<div class="caption_div left relative"><?=GetMessage("WI_TEMPLATE_PURCHASE")?></div>
	</div>
	<div class="uk-width-medium-1-4 uk-width-small-1-1 relative">
		<div class="purchase_back">
			<div class="purchase_title">
				<?=GetMessage("WI_TEMPLATE_PURCHASE_SEARCH")?>
			</div>
			<div class="purchase_filter">
				<div class="purchase_line">
					<div class="purchase_lable">
						<?=GetMessage("WI_TEMPLATE_NUMBER")?>
					</div>
					<input data-param="<?=$arResult["PARAM"]["NAME"]?>" class="purchase_input" type="text" placeholder="<?//=GetMessage("WI_TEMPLATE_NUMBER_VAR")?>" value="<?=htmlspecialchars($_GET["n"])?>">
				</div>
				<div class="purchase_line">
					<div class="purchase_lable">
						<?=GetMessage("WI_TEMPLATE_HAVETEXT")?>
					</div>
					<input data-param="<?=$arResult["PARAM"]["DETAIL_TEXT"]?>" class="purchase_input" type="text">
				</div>
				<div class="purchase_line">
					<div class="purchase_lable">
						<?=GetMessage("WI_TEMPLATE_PERIOD")?>
					</div>
					<div class="purchase_date left">
						<input placeholder="<?=GetMessage("WI_TEMPLATE_START")?>" data-param="<?=$arResult["PARAM"]["START_DATE"]?>" data-uk-datepicker="<?=GetMessage("WI_TEMPLATE_STARTFORMAT")?>" type="text">
						<div class="purchase_date_img"></div>
					</div>
					<div class="purchase_date_line_con left">
						<div class="purchase_date_line"></div>
					</div>
					<div class="purchase_date left">
						<input placeholder="<?=GetMessage("WI_TEMPLATE_END")?>" data-param="<?=$arResult["PARAM"]["END_DATE"]?>" data-uk-datepicker="<?=GetMessage("WI_TEMPLATE_ENDFORMAT")?>" type="text">
						<div class="purchase_date_img"></div>
					</div>
					<div class="purchase_date_line_con left">
						<div class="purchase_date_line"></div>
					</div>
					<div class="purchase_date left">
						<input placeholder="<?=GetMessage("WI_TEMPLATE_PURCHASE_DATE")?>" data-param="<?=$arResult["PARAM"]["PURCHASE_DATE"]?>" data-uk-datepicker="<?=GetMessage("WI_TEMPLATE_PURCHASE_DATE")?>" type="text">
						<div class="purchase_date_img"></div>
					</div>
				</div>
				<input data-action="search" class="purchase_submit" type="submit" value="<?=GetMessage("WI_TEMPLATE_SEARCH")?>">
				<input data-action="reset" class="purchase_submit" type="submit" value="<?=GetMessage("WI_TEMPLATE_RESET")?>">			
			</div>
			<?/*<div class="purinfo">
				<h2><?=GetMessage("WI_TEMPLATE_PURCHASE")?></h2>
				<?=GetMessage("WI_TEMPLATE_ABOUT")?>
				<a href="mailto:info@webizi.ru">info@webizi.ru</a><br>
				<a href="tel:84922529977">+7 (4922) 52-99-77</a>
			</div>*/?>
		</div>
	</div>
	<div data-block="purchase" class="uk-width-medium-3-4 uk-width-small-1-1 purchase-blink">
		<ul class="purchase-switcher" data-uk-switcher="{connect:'#purchase', animation: 'fade'}">
			<li><?=GetMessage("WI_TEMPLATE_CURRENT")?> (<span>0</span>)</li>
			<li><?=GetMessage("WI_TEMPLATE_FINSHED")?> (<span>0</span>)</li>
		</ul>
		<ul id="purchase" class="uk-switcher">
			<li data-current="1"><?=GetMessage("WI_TEMPLATE_CLEAR")?></li>
			<li data-current="0"><?=GetMessage("WI_TEMPLATE_CLEAR")?></li>
		</ul>
	</div>
</div>