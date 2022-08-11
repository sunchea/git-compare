<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult)):?>
	<div class="col-md-3">
		<ul>
			<?$i = 1;?>
			<?foreach($arResult as $arItem):?>
				<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?if($i % 3 == 0 && $i < count($arResult)):?>
						</ul>
					</div>
					<div class="col-md-3">
						<ul>
				<?endif;?>
				<?$i++;?>
			<?endforeach;?>
		</ul>
	</div>
<?endif;?>