<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
if(!function_exists("ShowSubItems")){
	function ShowSubItems($arItem, $noShowChildLink){
		?>
		<?if($arItem["SELECTED"] && $arItem["CHILD"]):?>
			<?$noMoreSubMenuOnThisDepth = false;?>
			<ul class="submenu">
				<?foreach($arItem["CHILD"] as $arSubItem):?>
					<?if ($arSubItem["PARAMS"]["NO_LINK"] != "Y"):?>
						<li class="<?=($arSubItem["SELECTED"] ? "active" : "")?>">
							<?php
							if($noShowChildLink) {
								$arSubItem["LINK"] = '#';
							}
							?>
							<a href="<?=$arSubItem["LINK"]?>"><?=$arSubItem["TEXT"]?></a>
							<?if(!$noMoreSubMenuOnThisDepth):?>
								<?ShowSubItems($arSubItem, $noShowChildLink);?>
							<?endif;?>
						</li>
					<?endif;?>
					<?$noMoreSubMenuOnThisDepth |= aspro::isChildsSelected($arSubItem["CHILD"]);?>
				<?endforeach;?>
			</ul>
		<?endif;?>
		<?
	}
}
?>
<?if($arResult):?>
	<ul class="nav nav-list side-menu">
		<?foreach($arResult as $arItem):?>
			<?if ($arItem["PARAMS"]["NO_LINK"] != "Y"):?>
				<li class="<?=($arItem["SELECTED"] ? "active" : "")?> <?=($arItem["CHILD"] ? "child" : "")?>">

					<?php /*if(strripos($arItem["TEXT"], 'В разработке')): ?>
						<?php $arItem["LINK"] = '#'; ?>
						<?php $noShowChildLink = true; ?>
					<?php else: ?>
						<?php $noShowChildLink = false; ?>
					<?php endif; */?>

					<?$noShowChildLink = false;?>

					<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					<?ShowSubItems($arItem, $noShowChildLink);?>
				</li>
			<?endif;?>
		<?endforeach;?>
	</ul>
<?endif;?>