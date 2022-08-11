<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if( !empty( $arResult["CATEGORIES"] ) ){
	foreach( $arResult["CATEGORIES"] as $category_id => $arCategory ){
		foreach( $arCategory["ITEMS"] as $i => $arItem ){
			if( !empty( $arItem["MODULE_ID"] ) ){?>
				<div class="ui-menu-item"><a href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?></a></div>
			<?}elseif( $category_id === 'all' ){?>
				<div class="all-results"><a href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?><span class="ic"></span></a></div>
			<?}
		}
	}
}?>