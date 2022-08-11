<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult):?>
	<div class="table-menu hidden-xs">
		<table>
			<tr>
				<?foreach($arResult as $arItem):?>
					<?$bShowChilds = $arParams["MAX_LEVEL"] > 1;?>
					<td class="<?=($arItem["CHILD"] ? "dropdown" : "")?> <?=($arItem["SELECTED"] ? "active" : "")?>">
						<div class="wrap">
							<a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>">
								<?=$arItem["TEXT"]?>
								<?if($arItem["CHILD"] && $bShowChilds):?>
									&nbsp;<i class="icon icon-angle-down"></i>
								<?endif;?>
							</a>
							<?if($arItem["CHILD"] && $bShowChilds):?>
								<ul class="dropdown-menu">
									<?foreach($arItem["CHILD"] as $arSubItem):?>
										<?$bShowChilds = $arParams["MAX_LEVEL"] > 2;?>
										<li class="<?=($arSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=($arSubItem["SELECTED"] ? "active" : "")?>">
											<a href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>"><?=$arSubItem["TEXT"]?></a>
											<?if($arSubItem["CHILD"] && $bShowChilds):?>
												<ul class="dropdown-menu">
													<?foreach($arSubItem["CHILD"] as $arSubSubItem):?>
														<?$bShowChilds = $arParams["MAX_LEVEL"] > 3;?>
														<li class="<?=($arSubSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
															<a href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>"><?=$arSubSubItem["TEXT"]?></a>
															<?if($arSubSubItem["CHILD"] && $bShowChilds):?>
																<ul class="dropdown-menu">
																	<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
																		<li class="<?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
																			<a href="<?=$arSubSubSubItem["LINK"]?>" title="<?=$arSubSubSubItem["TEXT"]?>"><?=$arSubSubSubItem["TEXT"]?></a>
																		</li>
																	<?endforeach;?>
																</ul>
															<?endif;?>
														</li>
													<?endforeach;?>
												</ul>
											<?endif;?>
										</li>
									<?endforeach;?>
								</ul>
							<?endif;?>
						</div>
					</td>
				<?endforeach;?>
				<td class="dropdown js-dropdown nosave" style="display:none;">
					<div class="wrap">
						<a class="dropdown-toggle more-items" href="#">
							<span>...</span>
						</a>
						<ul class="dropdown-menu">
						</ul>
					</div>
				</td>
			</tr>
		</table>
	</div>
<?endif;?>
<?if($arResult):?>
	<ul class="nav nav-pills responsive-menu" id="mainMenu">
		<?foreach($arResult as $arItem):?>
			<?$bShowChilds = $arParams["MAX_LEVEL"] > 1;?>
			<li class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown" : "")?> <?=($arItem["SELECTED"] ? "active" : "")?>">
				<a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>">
					<?=$arItem["TEXT"]?>
					<?if($arItem["CHILD"] && $bShowChilds):?>
						<i class="icon icon-angle-down"></i>
					<?endif;?>
				</a>
				<?if($arItem["CHILD"] && $bShowChilds):?>
					<ul class="dropdown-menu">
						<?foreach($arItem["CHILD"] as $arSubItem):?>
							<?$bShowChilds = $arParams["MAX_LEVEL"] > 2;?>
							<li class="<?=($arSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu dropdown-toggle" : "")?> <?=($arSubItem["SELECTED"] ? "active" : "")?>">
								<a href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>">
									<?=$arSubItem["TEXT"]?>
									<?if($arSubItem["CHILD"] && $bShowChilds):?>
										&nbsp;<i class="icon icon-angle-down"></i>
									<?endif;?>
								</a>
								<?if($arSubItem["CHILD"] && $bShowChilds):?>
									<ul class="dropdown-menu">
										<?foreach($arSubItem["CHILD"] as $arSubSubItem):?>
											<?$bShowChilds = $arParams["MAX_LEVEL"] > 3;?>
											<li class="<?=($arSubSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu dropdown-toggle" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
												<a href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>">
													<?=$arSubSubItem["TEXT"]?>
													<?if($arSubSubItem["CHILD"] && $bShowChilds):?>
														&nbsp;<i class="icon icon-angle-down"></i>
													<?endif;?>
												</a>
												<?if($arSubSubItem["CHILD"] && $bShowChilds):?>
													<ul class="dropdown-menu">
														<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
															<li class="<?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
																<a href="<?=$arSubSubSubItem["LINK"]?>" title="<?=$arSubSubSubItem["TEXT"]?>"><?=$arSubSubSubItem["TEXT"]?></a>
															</li>
														<?endforeach;?>
													</ul>
												<?endif;?>
											</li>
										<?endforeach;?>
									</ul>
								<?endif;?>
							</li>
						<?endforeach;?>
					</ul>
				<?endif;?>
			</li>
		<?endforeach;?>
	</ul>
<?endif;?>