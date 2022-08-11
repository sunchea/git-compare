<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult))return;
?>
<?
$arClasses = array();
$label = '';
if($arParams['ROOT_MENU_TYPE'] == 'top'){
    $arClasses[] = 'top-menu';
    $label = GetMessage("MENU_TOP_TITLE");
}else if($arParams['ROOT_MENU_TYPE'] == 'bottom'){
    $arClasses[] = 'bottom-menu';
    $label = GetMessage("MENU_BOTTOM_TITLE");
}else if($arParams['ROOT_MENU_TYPE'] == 'glazamibok'){
    $arClasses[] = 'special-mibok-menu';
    $label = GetMessage("MENU_SPECIAL_TITLE");
}else if($arParams['ROOT_MENU_TYPE'] == 'left'){
    $arClasses[] = 'left-menu';
    $label = GetMessage("MENU_LEFT_TITLE");
}else{
    $arClasses[] = 'mibok-menu';
    if($arParams['TITLE']){
        $label = $arParams['TITLE'];
    }else{
        $label = GetMessage("MENU_SERVICE_TITLE");
    }    
}
$menu_id = md5(serialize($arParams));
?>
<nav class="navbar navbar-default <?=implode(' ', $arClasses)?>">
    <div class="container-fluid">
        <div class="collapse " id="bs-navbar-<?=$menu_id?>">
            <ul class="nav navbar-nav bx-components-menu" role="menubar" id="mb_<?=$menu_id?>" aria-label="<?=$label?>">

<?

$previousLevel = 0;
$firstRoot = false;


foreach($arResult as $itemIdex => $arItem)
{
	if($arItem['DEPTH_LEVEL'] >= 2 && $arItem['IS_PARENT'] == 1)
		$arResult[$itemIdex]['IS_PARENT'] = false;
	if($arItem['DEPTH_LEVEL'] >= 3)
		unset($arResult[$itemIdex]);
}



foreach($arResult as $itemIdex => $arItem):
if (!is_array($arItem))
	continue;
?>

<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
	<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>	
<?endif?>

<?if ($arItem["IS_PARENT"]):
	$countSub=0;?>
	<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                
                <li role="menuitem" aria-haspopup="true" class="dropdown <?if ($arItem["SELECTED"]):?>active<?endif?>" tabindex="<?=($firstRoot ? '-1' : '0')?>" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>">
                    <a href="<?=$arItem["LINK"]?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" tabindex="-1"><?=$arItem["TEXT"]?><span class="caret"></span></a>			
				<ul class="dropdown-menu" role="menu" aria-hidden="true">			
	<?else:?>
				<li role="menuitem" aria-haspopup="true" class="<?if ($arItem["SELECTED"]):?>active<?endif?>" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>"><a href="<?=$arItem["LINK"]?>" role="button" tabindex="-1"><?=$arItem["TEXT"]?></a>
						<ul class="dropdown-menu" role="menu" aria-hidden="true">
	<?endif?>
<?else:?>
	<?if ($arItem["PERMISSION"] > "D"):?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li role="menuitem" aria-haspopup="false" <?if ($arItem["SELECTED"]):?>class="active"<?endif?> tabindex="<?=($firstRoot ? '-1' : '0')?>" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>">
				<a href="<?=$arItem["LINK"]?>" role="button" tabindex="-1">
					<?=$arItem["TEXT"]?>
				</a>
			</li>
		<?else:?>			
			<li role="menuitem" aria-haspopup="false" <?if ($arItem["SELECTED"]):?>class="active"<?endif?> tabindex="-1" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>">
				<?if($arItem["DEPTH_LEVEL"] == 3 && $countSub==0):?>
					<em></em>
				<?$countSub++;
				endif?>
				<a href="<?=$arItem["LINK"]?>" role="button" tabindex="-1"><?=$arItem["TEXT"]?></a>
			</li>
		<?endif?>
	<?else:?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li role="menuitem" aria-haspopup="false" <?if ($arItem["SELECTED"]):?>class="active"<?endif?> tabindex="<?=($firstRoot ? '-1' : '0')?>" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>" role="button" tabindex="-1"><?=$arItem["TEXT"]?></a></li>
		<?else:?>
			<li role="menuitem" aria-haspopup="false" tabindex="-1" aria-label="<?=GetMessage("MENU_ITEM_LABEL")?> <?=$arItem["TEXT"]?>"><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>" role="button" tabindex="-1"><?=$arItem["TEXT"]?></a></li>
		<?endif?>
	<?endif;?>
<?endif;

	$previousLevel = $arItem["DEPTH_LEVEL"];
	if ($arItem["DEPTH_LEVEL"] == 1){
            $firstRoot = true;
        }        
?>
<?endforeach;
if ($previousLevel > 1):
	echo str_repeat("</ul></li>", ($previousLevel-1));
endif;?>
            </ul>
        </div>
    </div>
</nav>