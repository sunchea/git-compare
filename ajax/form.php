<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$id = (isset($_REQUEST["id"]) ? $_REQUEST["id"] : false);
$captcha = COption::GetOptionString("aspro.allcorp", "USE_CAPTCHA_FORM");
$isCallBack = $id == CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_callback"][0];
$successMessage = ($isCallBack ? "<p>Наш менеджер перезвонит вам в ближайшее время.</p><p>Спасибо за ваше обращение!</p>" : "Спасибо! Ваше сообщение отправлено!");
?>

<span class="jqmClose top-close icon icon-times"></span>
<?if ($id == 1):?>

	<div class="form popup">
		<div class="form-header">
			<i class="icon" style="background:#0088cc url(<?=SITE_TEMPLATE_PATH?>/images/reg-head.png) no-repeat center"></i>
			<div class="text">
				<div class="title">Выберите форму заявки</div>
			</div>
		</div>
		<div class="form-footer clearfix" style="padding: 45px;">
			<div class="pull-left">
				<a href="/personal/zayavka/?fiz=Y" class="btn btn-primary">Физическое лицо</a>
			</div>
			<div class="pull-right">
				<a href="/personal/zayavka/" class="btn btn-primary">Юридическое лицо</a>
			</div>
		</div>
	</div>

<?elseif ($id == 2):?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:main.register", 
		".default", 
		Array(
			"COMPONENT_TEMPLATE" => ".default",
			"SHOW_FIELDS" => array(	// Поля, которые показывать в форме
				0 => "TITLE",
				1 => "WORK_COMPANY",
				2 => "PERSONAL_PHONE",
				3 => "EMAIL",
			),
			"REQUIRED_FIELDS" => "",	// Поля, обязательные для заполнения
			"AUTH" => "Y",	// Автоматически авторизовать пользователей
			"USE_BACKURL" => "N",	// Отправлять пользователя по обратной ссылке, если она есть
			"SUCCESS_PAGE" => "/personal/",	// Страница окончания регистрации
			"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
			"USER_PROPERTY" => "",	// Показывать доп. свойства
			"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
			"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		),
		false
	);?>

<?else:?>

	<?$APPLICATION->IncludeComponent(
		"aspro:form.allcorp",
		$isCallBack ? "callback" : "popup",
		Array(
			"IBLOCK_TYPE" => "aspro_allcorp_form",
			"IBLOCK_ID" => $id,
			"USE_CAPTCHA" => $captcha,
			"AJAX_MODE" => "Y",
			"AJAX_OPTION_JUMP" => "Y",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "100000",
			"AJAX_OPTION_ADDITIONAL" => "",
			//"IS_PLACEHOLDER" => "Y",
			"SUCCESS_MESSAGE" => $successMessage,
			"SEND_BUTTON_NAME" => "Отправить",
			"SEND_BUTTON_CLASS" => "btn btn-primary",
			"DISPLAY_CLOSE_BUTTON" => "Y",
			"POPUP" => "Y",
			"CLOSE_BUTTON_NAME" => "Закрыть",
			"CLOSE_BUTTON_CLASS" => "jqmClose btn btn-primary bottom-close"
		)
	);?>

<?endif;?>