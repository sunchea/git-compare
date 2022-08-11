<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

ini_set("max_execution_time", "90");
CModule::IncludeModule('mibok.glaza');


$APPLICATION->RestartBuffer();

if(function_exists('opcache_reset'))
	opcache_reset();

if(!empty($_POST['txt'])) {
    $voice = new MibokSpecialVoice();
    $arPreload = $voice->getPreload($_POST['txt']);
    echo json_encode($arPreload);
} else {
    echo json_encode(array('error' => 'y'));
}

