<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");?><?$APPLICATION->IncludeComponent("bitrix:search.page", "search", Array(
	"RESTART" => "Y",	// Искать без учета морфологии (при отсутствии результата поиска)
	"NO_WORD_LOGIC" => "Y",	// Отключить обработку слов как логических операторов
	"CHECK_DATES" => "N",	// Искать только в активных по дате документах
	"USE_TITLE_RANK" => "Y",	// При ранжировании результата учитывать заголовки
	"DEFAULT_SORT" => "rank",	// Сортировка по умолчанию
	"FILTER_NAME" => "",	// Дополнительный фильтр
	"arrFILTER" => array(	// Ограничение области поиска
		0 => "main",
		1 => "iblock_#IBLOCK_CATALOG_TYPE#",
		2 => "iblock_#IBLOCK_NEWS_TYPE#",
	),
	"arrFILTER_main" => "",	// Путь к файлу начинается с любого из перечисленных
	"arrFILTER_iblock_#IBLOCK_CATALOG_TYPE#" => array(	// Искать в информационных блоках типа "iblock_aspro_catalog"
		0 => "all",
	),
	"arrFILTER_iblock_#IBLOCK_NEWS_TYPE#" => array(	// Искать в информационных блоках типа "iblock_aspro_content"
		0 => "all",
	),
	"SHOW_WHERE" => "N",	// Показывать выпадающий список "Где искать"
	"SHOW_WHEN" => "N",	// Показывать фильтр по датам
	"PAGE_RESULT_COUNT" => "50",	// Количество результатов на странице
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над результатами
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под результатами
	"PAGER_TITLE" => "Результаты поиска",	// Название результатов поиска
	"PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
	"PAGER_TEMPLATE" => "",	// Название шаблона
	"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
	"USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>