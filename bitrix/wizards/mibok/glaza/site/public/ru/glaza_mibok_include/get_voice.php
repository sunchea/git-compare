<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

ini_set("max_execution_time", "90");
CModule::IncludeModule('mibok.glaza');


$APPLICATION->RestartBuffer();


if(!empty($_POST['txt'])) {
    $voice = new MibokSpecialVoice();
    $voice->textToVoice($_POST['txt'], $_SERVER['HTTP_REFERER']);
    echo json_encode(array('url' => $voice->getVoiceUrl($_SERVER['HTTP_REFERER'])));
} else {
    echo json_encode(array('error' => 'y'));
}
