<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$frame = $this->createFrame()->begin();
$frame->setAnimation(true); ?>
<div class="new-list-table">
	<?php foreach ($arResult['ITEMS'] as $item) : ?>
		<div class="row-table">

			<div class="ceil-table ceil-table-checkbox ceil-table-sticky">
				<input class="compare_input" type="checkbox" data-id="<?=$item['ID']?>" name="item_<?=$item['ID']?>">
			</div>

			<?php $count = 1; ?>
			<?php foreach ($item["PROPERTIES"] as $prop) : ?>
				<?php if($arResult['props_info'][$prop['ID']]['SMART_FILTER'] == 'Y' && !in_array($prop['CODE'], $arParams['NO_DISPLAY_PROPS'])): ?>
					<?php

					if($prop['CODE'] == 'NAME') {
						$width = $prop['WIDTH'] - 50;
						?>
						<script type="text/javascript">
							var marginLeftFilterHead = <?= $prop['WIDTH'] ?>;
						</script>
						<?php
					} else {
						$width = $prop['WIDTH'];
					}

					if($prop['CODE'] === 'NOTE') {
						$prop['VALUE'] = $prop['VALUE']["TEXT"];
						$classes = "NOTE";
					} else {
						$classes = '';
					}

					if($count === 1) : ?>
						<a href="<?= $item['DETAIL_PAGE_URL'] ?>">
						<?php $classes .= " ceil-table-sticky"; ?>
					<?php endif; ?>
							<div data-prop-code="<?= $prop['CODE'] ?>" class="ceil-table <?= $classes ?>" style="width: <?= $width ?>px; text-align: <?= $prop['TEXT_CENTERING'] ?>">
								<?= $prop['VALUE'] ?>
							</div>
					<?php if($count === 1) : ?>
						</a>
					<?php endif; ?>

					<?php $count++; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>

<div class="display_none_count display_none">
	<div id="cur_el"><?= count($arResult['ITEMS']) ?></div>
	<div id="all_el"><?= $arResult['all_page'] ?></div>
</div>

</div> <!-- table-filter-container -->

<div class="filter-catalog-pag">
	<?= $arResult['NAV_STRING'] ?>

    <?php if($arResult['RESULT_NOTE']): ?>
        <div class="text-center">
            <?= $arResult['RESULT_NOTE'] ?>
        </div>
    <?php endif; ?>
</div>

<?php
	if(!empty($arResult['NAV_STRING'])) : ?>
		<script type="text/javascript">
			var pagination_filter = 'on';
			var pagen = "<?= $_GET['PAGEN_2'] ?>";
			var cur_el = "<?= count($arResult['ITEMS']) ?>";
			var all_el = "<?= $arResult['all_page'] ?>";
		</script>
	<?php endif;
?>

<?$frame->end();?>
