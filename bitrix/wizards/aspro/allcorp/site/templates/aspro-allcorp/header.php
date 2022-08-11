<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<!DOCTYPE html>
<html class="<?=($_SESSION['SESS_INCLUDE_AREAS'] ? 'bx_editmode ' : '')?><?=strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0' ) ? 'ie ie7' : ''?> <?=strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0' ) ? 'ie ie8' : ''?> <?=strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0' ) ? 'ie ie9' : ''?>">
	<head>
		<?global $APPLICATION;?>
		<?IncludeTemplateLangFile(__FILE__);?>
		<title><?$APPLICATION->ShowTitle()?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/bootstrap.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/fonts/font-awesome/css/font-awesome.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/vendor/flexslider/flexslider.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery.fancybox.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/theme-elements.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jqModal.css');?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/theme-responsive.css');?>
		<?$APPLICATION->ShowHead()?>
		<?CJSCore::Init(array('jquery', 'fx', 'popup'));?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.actual.min.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.fancybox.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/jquery.easing.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/jquery.appear.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/jquery.cookie.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/bootstrap.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/flexslider/jquery.flexslider-min.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/vendor/jquery.validate.min.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.uniform.min.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jqModal.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.inputmask.bundle.min.js', true)?>
		<?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/detectmobilebrowser.js');?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/general.js');?>
	</head>
	<body>
		<?CAjax::Init();?>
		<div id="panel"><?$APPLICATION->ShowPanel();?></div>
		<?if(!CModule::IncludeModule("aspro.allcorp")):?>
			<?$APPLICATION->SetTitle(GetMessage("ERROR_INCLUDE_MODULE_ALLCORP_TITLE"));?>
			<div class="include_module_error">
				<img src="<?=SITE_TEMPLATE_PATH?>/images/error.jpg" title=":-(">
				<p><?=GetMessage("ERROR_INCLUDE_MODULE_ALLCORP_TEXT")?></p>
			</div>
			<?die();?>
		<?endif;?>
		<?CAllCorp::SetJSOptions();?>
		<?global $arSite, $arTheme;?>
		<?$arSite = CSite::GetByID(SITE_ID)->Fetch();?>
		<?$arTheme = $APPLICATION->IncludeComponent(
			"aspro:theme.allcorp",
			"",
			array(
			),
		false
		);?>
		<div class="body">
			<div class="body_media"></div>
			<div class="top-row">
				<div class="container maxwidth-theme">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="info-text">
										<div class="email">
											<i class="icon icon-envelope"></i>
											<?$APPLICATION->IncludeFile(SITE_DIR."include/site-email.php", array(), array(
													"MODE" => "html",
													"NAME" => "E-mail",
												)
											);?>
										</div>
										<div class="phone">
											<i class="icon icon-phone"></i> 
											<?$APPLICATION->IncludeFile(SITE_DIR."include/site-phone.php", array(), array(
													"MODE" => "html",
													"NAME" => "Phone",
												)
											);?>
										</div>
										<div class="skype hidden-xs">
											<i class="icon icon-skype"></i>
											<?$APPLICATION->IncludeFile(SITE_DIR."include/site-skype.php", array(), array(
													"MODE" => "html",
													"NAME" => "Skype",
												)
											);?>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<?$APPLICATION->IncludeComponent("aspro:social.info.allcorp", "corp", array(
										"VK" => COption::GetOptionString("aspro.allcorp", "SOCIAL_VK", SITE_ID),
										"FACEBOOK" => COption::GetOptionString("aspro.allcorp", "SOCIAL_FACEBOOK", SITE_ID),
										"TWITTER" => COption::GetOptionString("aspro.allcorp", "SOCIAL_TWITTER", SITE_ID),
										"ODNOKLASSNIKI" => COption::GetOptionString("aspro.allcorp", "SOCIAL_ODNOKLASSNIKI", SITE_ID),
										"MAILRU" => COption::GetOptionString("aspro.allcorp", "SOCIAL_MAILRU", SITE_ID),
										"LIVEJOURNAL" => COption::GetOptionString("aspro.allcorp", "SOCIAL_LIVEJOURNAL", SITE_ID),
										"GOOGLE" => COption::GetOptionString("aspro.allcorp", "SOCIAL_GOOGLE", SITE_ID),
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "3600000",
										"CACHE_GROUPS" => "N"
										),
										false
									);?>
								</div>
								<div class="col-md-3">
									<?$APPLICATION->IncludeComponent("bitrix:search.title", "corp", array(
										"NUM_CATEGORIES" => "1",
										"TOP_COUNT" => "5",
										"ORDER" => "date",
										"USE_LANGUAGE_GUESS" => "Y",
										"CHECK_DATES" => "N",
										"SHOW_OTHERS" => "N",
										"PAGE" => SITE_DIR."search/",
										"CATEGORY_0_TITLE" => "",
										"CATEGORY_0" => array(
											0 => "main",
											1 => "iblock_#IBLOCK_CATALOG_TYPE#",
											2 => "iblock_#IBLOCK_NEWS_TYPE#",
										),
										"CATEGORY_0_main" => array(
										),
										"CATEGORY_0_iblock_#IBLOCK_CATALOG_TYPE#" => array(
											0 => "all",
										),
										"CATEGORY_0_iblock_#IBLOCK_NEWS_TYPE#" => array(
											0 => "all",
										),
										"SHOW_INPUT" => "Y",
										"INPUT_ID" => "title-search-input",
										"CONTAINER_ID" => "title-search"
										),
										false
									);?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<header class="<?=($arTheme["MENU"] == "first" ? "menu-type-1" : "menu-type-2")?>">
				<div class="container maxwidth-theme">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<?if($arTheme["MENU"] == "first"):?>
									<div class="col-md-3">
										<div class="logo">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php", Array(), Array("MODE" => "html", "NAME" => "Logo"));?>
										</div>
									</div>
									<div class="col-md-9">
										<button class="btn btn-responsive-nav" data-toggle="collapse" data-target=".nav-main-collapse">
											<i class="icon icon-bars"></i>
										</button>
									</div>
								<?elseif($arTheme["MENU"] == "second"):?>
									<div class="col-md-4">
										<div class="logo">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php", Array(), Array("MODE" => "html", "NAME" => "Logo"));?>
										</div>
									</div>
									<div class="col-md-4 hidable">
										<div class="top-description">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/header-text.php", Array(), Array(
													"MODE" => "text",
													"NAME" => "Text in title",
												)
											);?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="top-callback clearfix hidable pull-right">
											<div class="phone">
												<i class="icon icon-phone"></i>
												<?$APPLICATION->IncludeFile(SITE_DIR."include/site-phone.php", Array(), Array(
														"MODE" => "text",
														"NAME" => "Phone",
													)
												);?>
											</div>
											<div class="callback" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["#IBLOCK_FORM_CALLBACK_TYPE#"]["#IBLOCK_FORM_CALLBACK_CODE#"][0]?>" data-name="callback"><span><?=GetMessage("S_CALLBACK")?></span></div>
										</div>
										<button class="btn btn-responsive-nav" data-toggle="collapse" data-target=".nav-main-collapse">
											<i class="icon icon-bars"></i>
										</button>
									</div>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="nav-main-collapse collapse">
					<div class="container maxwidth-theme">
						<div class="row">
							<div class="col-md-12">
								<?if($arTheme["MENU"] == "first"):?>
									<div class="row">
										<div class="col-md-3">
										</div>
										<div class="col-md-9">
								<?endif;?>
											<nav class="mega-menu <?=$arTheme["MENU"] == 'first' ? 'pull-right' : ''?>">
												<?$APPLICATION->IncludeComponent("bitrix:menu", "top", array(
													"ROOT_MENU_TYPE" => "top",
													"MENU_CACHE_TYPE" => "A",
													"MENU_CACHE_TIME" => "3600000",
													"MENU_CACHE_USE_GROUPS" => "N",
													"MENU_CACHE_GET_VARS" => array(
													),
													"MAX_LEVEL" => "3",
													"CHILD_MENU_TYPE" => "left",
													"USE_EXT" => "Y",
													"DELAY" => "N",
													"ALLOW_MULTI_SELECT" => "N",
													"COUNT_ITEM" => "6"
													),
													false
												);?>
											</nav>
								<?if($arTheme["MENU"] == "first"):?>
										</div>
									</div>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div role="main" class="main">
				<?if(!CSite::InDir(SITE_DIR.'index.php')):?>
					<?if(!CSite::InDir(SITE_DIR.'form/')):?>
						<section class="page-top">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<h1><?$APPLICATION->ShowTitle(false)?></h1>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "corp", array(
											"START_FROM" => "0",
											"PATH" => "",
											"SITE_ID" => SITE_ID
											),
											false
										);?>
									</div>
								</div>
							</div>
						</section>
					<?endif;?>
					<div class="container maxwidth-theme">
						<div class="row">
							<div class="col-md-12">
				<?else:?>
					<div class="maxwidth-theme">
						<?$GLOBALS["arrFilterBanners"] = array("SECTION_CODE" => "big_banners")?>						
						<?$APPLICATION->IncludeComponent("bitrix:news.list", "front-big-banners", array(
							"IBLOCK_TYPE" => "#IBLOCK_ADVT_TYPE#",
							"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["#IBLOCK_ADVT_TYPE#"]["#IBLOCK_ADVT_CODE#"][0],
							"NEWS_COUNT" => "30",
							"SORT_BY1" => "SORT",
							"SORT_ORDER1" => "ASC",
							"SORT_BY2" => "ID",
							"SORT_ORDER2" => "ASC",
							"FILTER_NAME" => "arrFilterBanners",
							"FIELD_CODE" => array(
								0 => "PREVIEW_TEXT",
								1 => "PREVIEW_PICTURE",
								2 => "DETAIL_TEXT",
								3 => "DETAIL_PICTURE"
							),
							"PROPERTY_CODE" => array(
								0 => "BANNERTYPE",
								1 => "TEXTCOLOR",
								2 => "LINKIMG",
								3 => "BUTTON1TEXT",
								4 => "BUTTON1LINK",
								5 => "BUTTON2TEXT",
								6 => "BUTTON2LINK",
								7 => "link"
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600000",
							"CACHE_FILTER" => "Y",
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
							"INCLUDE_SUBSECTIONS" => "N",
							"PAGER_TEMPLATE" => ".default",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "N",
							"PAGER_TITLE" => "�������",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
							"PAGER_SHOW_ALL" => "N",
							"AJAX_OPTION_ADDITIONAL" => ""
							),
							false
						);?>
					</div>
				<?endif;?>
				<?$isMenu = $APPLICATION->GetProperty("menu");?>
				<?$isIndex = CSite::inDir(SITE_DIR."index.php");?>
				<?if($isMenu == "Y" && $arTheme["SIDEMENU"] == "right" && !$isIndex):?>
					<div class="row">
						<div class="col-md-9">
				<?endif;?>
				<?if($isMenu == "Y" && $arTheme["SIDEMENU"] == "left" && !$isIndex):?>
					<div class="row">
						<div class="col-md-3 left-menu-md">
							<aside class="sidebar">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "left", array(
									"ROOT_MENU_TYPE" => "left",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_TIME" => "3600000",
									"MENU_CACHE_USE_GROUPS" => "N",
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
						<div class="col-md-9">
				<?endif;?>
				<?CAllCorp::checkRestartBuffer();?>
					<?if($isIndex):?>
						<div class="container maxwidth-theme">
							<?$GLOBALS["arrFilterBanners"] = array("SECTION_CODE" => "small_banners")?>
							<?$APPLICATION->IncludeComponent("bitrix:news.list", "front-small-banners", array(
								"IBLOCK_TYPE" => "#IBLOCK_ADVT_TYPE#",
								"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["#IBLOCK_ADVT_TYPE#"]["#IBLOCK_ADVT_CODE#"][0],
								"NEWS_COUNT" => "3",
								"SORT_BY1" => "ACTIVE_FROM",
								"SORT_ORDER1" => "DESC",
								"SORT_BY2" => "SORT",
								"SORT_ORDER2" => "ASC",
								"FILTER_NAME" => "arrFilterBanners",
								"FIELD_CODE" => array(
									0 => "DETAIL_TEXT",
									1 => "DETAIL_PICTURE",
									2 => "",
								),
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "link",
									2 => "",
								),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "3600000",
								"CACHE_FILTER" => "Y",
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
								"PAGER_TITLE" => "�������",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
								"PAGER_SHOW_ALL" => "N",
								"AJAX_OPTION_ADDITIONAL" => ""
								),
								false
							);?>
							<?if($arTheme["SERVICES_INDEX"] == "Y"):?>
								<div class="row">
									<div class="col-md-12">
										<?$APPLICATION->IncludeComponent(
											"bitrix:main.include",
											"",
											Array(
												"AREA_FILE_SHOW" => "file",
												"PATH" => SITE_DIR."include/front-services.php",
												"EDIT_TEMPLATE" => "standard.php"
											)
										);?>
										<?$APPLICATION->IncludeComponent("bitrix:news.list", "front-services", array(
											"IBLOCK_TYPE" => "#IBLOCK_MAINLINKS_TYPE#",
											"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["#IBLOCK_MAINLINKS_TYPE#"]["#IBLOCK_MAINLINKS_CODE#"][0],
											"NEWS_COUNT" => "30",
											"SORT_BY1" => "SORT",
											"SORT_ORDER1" => "DESC",
											"SORT_BY2" => "SORT",
											"SORT_ORDER2" => "ASC",
											"FILTER_NAME" => "",
											"FIELD_CODE" => array(
												0 => "NAME",
												1 => "PREVIEW_TEXT",
												2 => "PREVIEW_PICTURE",
												3 => "",
											),
											"PROPERTY_CODE" => array(
												0 => "ICON",
												1 => "LINK",
												2 => "",
											),
											"CHECK_DATES" => "Y",
											"DETAIL_URL" => "",
											"AJAX_MODE" => "N",
											"AJAX_OPTION_JUMP" => "N",
											"AJAX_OPTION_STYLE" => "Y",
											"AJAX_OPTION_HISTORY" => "N",
											"CACHE_TYPE" => "A",
											"CACHE_TIME" => "3600000",
											"CACHE_FILTER" => "Y",
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
											"PAGER_TITLE" => "�������",
											"PAGER_SHOW_ALWAYS" => "N",
											"PAGER_DESC_NUMBERING" => "N",
											"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
											"PAGER_SHOW_ALL" => "N",
											"COLUMN_COUNT" => "3",
											"AJAX_OPTION_ADDITIONAL" => ""
											),
											false
										);?>
									</div>
								</div>
							<?endif;?>
							<?if($arTheme["CATALOG_INDEX"] == "Y"):?>
								<div class="row">
									<div class="col-md-12">
										<?$APPLICATION->IncludeComponent(
											"bitrix:main.include",
											"",
											Array(
												"AREA_FILE_SHOW" => "file",
												"PATH" => SITE_DIR."include/front-catalog.php",
												"EDIT_TEMPLATE" => "standard.php"
											)
										);?>
										<?$APPLICATION->IncludeComponent(
											"bitrix:news.list",
											"catalog-sections",
											Array(
												"IBLOCK_TYPE" => "#IBLOCK_CATALOG_TYPE#",
												"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["#IBLOCK_CATALOG_TYPE#"]["#IBLOCK_CATALOG_CODE#"][0],
												"NEWS_COUNT" => "20",
												"SORT_BY1" => "ACTIVE_FROM",
												"SORT_ORDER1" => "DESC",
												"SORT_BY2" => "SORT",
												"SORT_ORDER2" => "ASC",
												"FILTER_NAME" => "",
												"FIELD_CODE" => array(0=>"",1=>"",),
												"PROPERTY_CODE" => array(0=>"",1=>"",),
												"CHECK_DATES" => "Y",
												"DETAIL_URL" => "",
												"AJAX_MODE" => "N",
												"AJAX_OPTION_JUMP" => "N",
												"AJAX_OPTION_STYLE" => "Y",
												"AJAX_OPTION_HISTORY" => "N",
												"CACHE_TYPE" => "A",
												"CACHE_TIME" => "3600000",
												"CACHE_FILTER" => "Y",
												"CACHE_GROUPS" => "N",
												"PREVIEW_TRUNCATE_LEN" => "",
												"ACTIVE_DATE_FORMAT" => "d.m.Y",
												"SET_TITLE" => "Y",
												"SET_STATUS_404" => "N",
												"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
												"ADD_SECTIONS_CHAIN" => "Y",
												"HIDE_LINK_WHEN_NO_DETAIL" => "N",
												"PARENT_SECTION" => "",
												"PARENT_SECTION_CODE" => "",
												"INCLUDE_SUBSECTIONS" => "Y",
												"PAGER_TEMPLATE" => ".default",
												"DISPLAY_TOP_PAGER" => "N",
												"DISPLAY_BOTTOM_PAGER" => "Y",
												"PAGER_TITLE" => "�������",
												"PAGER_SHOW_ALWAYS" => "Y",
												"PAGER_DESC_NUMBERING" => "N",
												"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
												"PAGER_SHOW_ALL" => "Y",
												"VIEW_TYPE" => "list",
												"COUNT_IN_LINE" => "3",
												"IMAGE_POSITION" => "left",
												"AJAX_OPTION_ADDITIONAL" => ""
											)
										);?>
									</div>
								</div>
							<?endif;?>
							<div class="row">
								<div class="col-md-12">
									<div class="styled-block main">
										<div class="row">
											<div class="col-md-8 col-sm-8">
												<?$APPLICATION->IncludeComponent(
													"bitrix:main.include",
													"",
													Array(
														"AREA_FILE_SHOW" => "file",
														"PATH" => SITE_DIR."include/front-text1.php",
														"EDIT_TEMPLATE" => "standard.php"
													)
												);?>
											</div>
											<div class="col-md-4 col-sm-4 text-right">
												<?$APPLICATION->IncludeComponent(
													"bitrix:main.include",
													"",
													Array(
														"AREA_FILE_SHOW" => "file",
														"PATH" => SITE_DIR."include/front-text2.php",
														"EDIT_TEMPLATE" => "standard.php"
													)
												);?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<?$APPLICATION->IncludeComponent(
												"bitrix:main.include",
												"",
												Array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => SITE_DIR."include/front-about.php",
													"EDIT_TEMPLATE" => "standard.php"
												)
											);?>
										</div>
										<div class="col-md-6">
											<?$APPLICATION->IncludeComponent("bitrix:news.list", "front-news", array(
												"IBLOCK_TYPE" => "#IBLOCK_NEWS_TYPE#",
												"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["#IBLOCK_NEWS_TYPE#"]["#IBLOCK_NEWS_CODE#"][0],
												"NEWS_COUNT" => "3",
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
												"CACHE_TIME" => "3600000",
												"CACHE_FILTER" => "Y",
												"CACHE_GROUPS" => "N",
												"PREVIEW_TRUNCATE_LEN" => "",
												"ACTIVE_DATE_FORMAT" => "j F Y",
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
												"PAGER_TITLE" => "�������",
												"PAGER_SHOW_ALWAYS" => "N",
												"PAGER_DESC_NUMBERING" => "N",
												"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
												"PAGER_SHOW_ALL" => "N",
												"AJAX_OPTION_ADDITIONAL" => ""
												),
												false
											);?>
										</div>
									</div>
								</div>
							</div>
						<?// closing tag in footer.php </div>?>
					<?endif;?>