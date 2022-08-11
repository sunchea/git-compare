<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(false);?>
<div class="style-switcher <?=$_COOKIE["styleSwitcher"] == 'open' ? 'active' : ''?>">
	<div class="header"><?=GetMessage("THEME_MODIFY")?><span class="switch"><i class="icon icon-cogs"></i></span></div>
	<form method="POST" name="style-switcher">
		<div class="block clearfix">
			<input type="hidden" name="color" value="<?=strToLower($arResult["COLOR"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_COLOR")?></div>
			<ul class="options colors">
				<?foreach($arResult["COLOR"]["LIST"] as $arColor):?>
					<?$hex = CAllCorp::GetBaseColorHexByCode($arColor["CODE"]);?>
					<li <?=$arColor["CURRENT"] == "Y" ? 'class="active"' : ''?>>
						<a href="javascript:;" data-option-id="color" data-option-value="<?=$arColor["CODE"]?>" title="<?=$arColor["NAME"]?>" style="background-color:<?=$hex?>;"><i></i></a>
					</li>
				<?endforeach;?>
			</ul>
		</div>
		<div class="block">
			<input type="hidden" name="width" value="<?=strToLower($arResult["WIDTH"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_TYPE")?></div>
			<div class="options">
				<?foreach( $arResult["WIDTH"]["LIST"] as $arWidth ){?>
					<a href="javascript:;" data-option-id="width" data-option-value="<?=$arWidth["CODE"]?>" class="<?=$arWidth["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arWidth["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<input type="hidden" name="menu" value="<?=strToLower($arResult["MENU"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_MENUTYPE")?></div>
			<div class="options">
				<?foreach( $arResult["MENU"]["LIST"] as $arMenu ){?>
					<a href="javascript:;" data-option-id="menu" data-option-value="<?=$arMenu["CODE"]?>" class="<?=$arMenu["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arMenu["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<input type="hidden" name="sidemenu" value="<?=strToLower($arResult["SIDEMENU"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_SIDEMENUTYPE")?></div>
			<div class="options">
				<?foreach( $arResult["SIDEMENU"]["LIST"] as $arMenu ){?>
					<a href="javascript:;" data-option-id="sidemenu" data-option-value="<?=$arMenu["CODE"]?>" class="<?=$arMenu["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arMenu["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<input type="hidden" name="catalog_index" value="<?=strToUpper($arResult["CATALOG_INDEX"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_CATALOG_INDEX")?></div>
			<div class="options">
				<?foreach($arResult["CATALOG_INDEX"]["LIST"] as $arValue ){?>
					<a href="javascript:;" data-option-id="catalog_index" data-option-value="<?=$arValue["CODE"]?>" class="<?=$arValue["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arValue["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<input type="hidden" name="services_index" value="<?=strToUpper($arResult["SERVICES_INDEX"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_SERVICES_INDEX")?></div>
			<div class="options">
				<?foreach($arResult["SERVICES_INDEX"]["LIST"] as $arValue ){?>
					<a href="javascript:;" data-option-id="services_index" data-option-value="<?=$arValue["CODE"]?>" class="<?=$arValue["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arValue["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<input type="hidden" name="filter_view" value="<?=strToUpper($arResult["FILTER_VIEW"]["CURRENT"])?>" />
			<div class="block-title"><?=GetMessage("THEME_FILTER_VIEW")?></div>
			<div class="options">
				<?foreach($arResult["FILTER_VIEW"]["LIST"] as $arValue ){?>
					<a href="javascript:;" data-option-id="filter_view" data-option-value="<?=$arValue["CODE"]?>" class="<?=$arValue["CURRENT"] == "Y" ? 'active' : ''?>"><?=$arValue["NAME"]?></a>
				<?}?>
			</div>
		</div>
		<div class="block">
			<div class="buttons">
				<a class="reset" href="javascript:;"><?=GetMessage("THEME_RESET")?><i class="icon icon-refresh"></i></a>
			</div>
		</div>
	</form>
	<script type="text/javascript">
	$(document).ready(function(){
		if($.cookie('styleSwitcher') == 'open'){
			$('.style-switcher').addClass('active');
		}
		
		$('.style-switcher .switch').click(function(e){
			e.preventDefault();
			var styleswitcher = $(this).closest('.style-switcher');
			if(styleswitcher.hasClass('active')){
				styleswitcher.animate({left: '-' + styleswitcher.outerWidth() + 'px'}, 300).removeClass('active');
				$.removeCookie('styleSwitcher', {path: '/'});
			}
			else{
				styleswitcher.animate({left: '0'}, 300).addClass('active');
				var pos = styleswitcher.offset().top;
				if($(window).scrollTop() > pos){
					$('html, body').animate({scrollTop: pos}, 500);
				}
				$.cookie('styleSwitcher', 'open', {path: '/'});
			}
		});
		
		$('.style-switcher .reset').click(function(e){
			$('form[name=style-switcher]').append('<input type="hidden" name="theme" value="default" />');
			$('form[name=style-switcher]').submit();
		});
		
		$('.style-switcher .options a').click(function(e){
			$(this).addClass('active').siblings().removeClass('active');
			$('form[name=style-switcher] input[name=' + $(this).data('option-id') + ']').val($(this).data('option-value'));
			$('form[name=style-switcher]').submit();
		});
	});
	</script>
</div>