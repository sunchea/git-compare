				<?if($isIndex):?>
					<hr>
					<?// opening tag in header.php <div>?>
						<div class="row">
							<div class="col-md-12">
								<?/*$APPLICATION->IncludeComponent("bitrix:news.list", "front-partners", array(
									"IBLOCK_TYPE" => "aspro_allcorp_content",
									"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_partners"][0],
									"NEWS_COUNT" => "20",
									"SORT_BY1" => "ACTIVE_FROM",
									"SORT_ORDER1" => "DESC",
									"SORT_BY2" => "SORT",
									"SORT_ORDER2" => "ASC",
									"FILTER_NAME" => "",
									"FIELD_CODE" => array(
										0 => "DETAIL_TEXT",
										1 => "DETAIL_PICTURE",
										2 => "",
									),
									"PROPERTY_CODE" => array(
										0 => "",
										1 => "",
									),
									"CHECK_DATES" => "Y",
									"DETAIL_URL" => "",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "N",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "100000",
									"CACHE_FILTER" => "N",
									"CACHE_GROUPS" => "N",
									"PREVIEW_TRUNCATE_LEN" => "",
									"ACTIVE_DATE_FORMAT" => "d.m.Y",
									"SET_TITLE" => "N",
									"SET_STATUS_404" => "N",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
									"ADD_SECTIONS_CHAIN" => "N",
									"HIDE_LINK_WHEN_NO_DETAIL" => "N",
									"PARENT_SECTION" => "",
									"PARENT_SECTION_CODE" => "",
									"INCLUDE_SUBSECTIONS" => "Y",
									"PAGER_TEMPLATE" => ".default",
									"DISPLAY_TOP_PAGER" => "N",
									"DISPLAY_BOTTOM_PAGER" => "N",
									"PAGER_TITLE" => "Новости",
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_DESC_NUMBERING" => "N",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "N",
									"ITEM_IN_BLOCK" => "6",
									"SHOW_LINK" => "Y",
									"AJAX_OPTION_ADDITIONAL" => ""
									),
									false
								);*/?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"catalog-main",
									Array(
										"PARENT_SECTION" => 0,
										"COUNT_IN_LINE" => 4,
										"VIEW_TYPE" => "table",
										"SHOW_TABS" => "",
										"SHOW_NAME" => "Y",
										"SHOW_DETAIL" => "Y",
										"SHOW_IMAGE" => "Y",
										"IMAGE_POSITION" => "top",
										"IBLOCK_TYPE"	=>	"aspro_allcorp_catalog",
										"IBLOCK_ID"	=>	11,
										"NEWS_COUNT"	=>	20,
										"SORT_BY1"	=>	"ID",
										"SORT_ORDER1"	=>	"DESC",
										"SORT_BY2"	=>	"ID",
										"SORT_ORDER2"	=>	"DESC",
										"SET_TITLE"	=>	"N",
										"SET_STATUS_404" => "Y",
										"INCLUDE_IBLOCK_INTO_CHAIN"	=>	"N",
										"DISPLAY_NAME"	=>	"Y",
										"PREVIEW_TRUNCATE_LEN"	=>	0,
									),
									$component
								);?>
							</div>
						</div>
					</div>
				<?endif;?>
				<?CAllCorp::checkRestartBuffer();?>
				<?if($isMenu && $arTheme["SIDEMENU"] == "left" && !$isPersonal):?>
						</div>
					</div>
				<?endif;?>
				<?if($isMenu && $arTheme["SIDEMENU"] == "right" && !$isPersonal):?>
						</div>
						<div class="col-md-3 right-menu-md">
							<aside class="sidebar">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "left", array(
									"ROOT_MENU_TYPE" => "left",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MAX_LEVEL" => "4",
									"CHILD_MENU_TYPE" => "subleft",
									"USE_EXT" => "Y",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "Y"
									),
									false
								);?>
							</aside>
							<div class="sidearea">
								<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
								<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/under_sidebar.php"), false);?>
							</div>
						</div>
					</div>
				<?endif;?>
				<?if($isPersonal):?>
						<script>
							var JOINING_TARRIFS = <?=json_encode($GLOBALS['JOINING_TARRIFS'])?>;
						</script>
						<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/calc.js');?>
						
						</div>
						<div class="col-md-3 right-menu-md">
							<aside class="sidebar">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => "/include/calc.php",
									)
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => "/include/zayavki.php",
									)
								);?>
							</aside>
						</div>
					</div>
				<?endif;?>
				<?if(!CSite::InDir(SITE_DIR."/index.php")):?>
							</div>
						</div>
					</div>
				<?endif;?>
			</div>
		</div>
		<footer id="footer">
			<div class="container maxwidth-theme">
				<div class="row">
					<div class="col-md-2">
						<div class="logo">
							<a href="<?=SITE_DIR?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo-white.png" alt="<?=$arSite["SITE_NAME"]?>" /></a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="copy row">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/copy.php", Array(), Array(
									"MODE"      => "html",
									"NAME"      => "Copyright",
								)
							);?>
							<br /><br />
							<?$APPLICATION->IncludeFile(SITE_DIR."include/site-address.php", Array(), Array(
									"MODE"      => "html",
									"NAME"      => "Address",
								)
							);?>
						</div>
					</div>
					<div class="col-md-5">
						<div class="menu">
							<div class="row">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
									"ROOT_MENU_TYPE" => "bottom",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "",
									"USE_EXT" => "N",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
									),
									false
								);?>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="info" style="padding:0px">
							<div class="email">
								<!-- <i class="icon icon-envelope"></i> -->
								<?/*$APPLICATION->IncludeFile(SITE_DIR."include/site-email.php", array(), array(
										"MODE" => "html",
										"NAME" => "E-mail",
									)
								);*/?>
							</div>
							<div class="phone">
								<!-- <i class="icon icon-phone"></i> -->
								<?/*$APPLICATION->IncludeFile(SITE_DIR."include/site-phone.php", array(), array(
										"MODE" => "html",
										"NAME" => "Phone",
									)
								);*/?>
								<?/*<a href="/kontakty/">Контакты</a>*/?>
								<div style="display:flex;
justify-content:center; align-items:center; flex-direction:column">
								<a href="http://soyuzmash32.ru/"><img src="http://soyuzmash32.ru/wp-content/uploads/2017/06/LOGO_souzmas_White.png"></a> <br>
								<a href="https://www.chipfind.ru/"><img src="https://www.chipfind.ru/static/button/80x15_gray.gif" width=80 height=15 border=0 alt="ChipFind - поисковая система по электронным компонентам"></a>
								</div>
							</div>
							<?/*<div class="skype">
								<i class="icon icon-skype"></i>
								<?$APPLICATION->IncludeFile(SITE_DIR."include/site-skype.php", array(), array(
										"MODE" => "html",
										"NAME" => "Skype",
									)
								);?>
							</div>*/?>
						</div>
					</div>
				</div>
				<div id="bx-composite-banner"></div>
			</div>
		</footer>
		<div class="bx_areas">
			<?$APPLICATION->IncludeFile(SITE_DIR."include/invis-counter.php", Array(), Array(
					"MODE" => "text",
					"NAME" => "Counters place for Yandex.Metrika, Google.Analytics",
				)
			);?>
		</div>
		<?CAllCorp::SetSeoMetaTitle();?>
	</body>
</html>