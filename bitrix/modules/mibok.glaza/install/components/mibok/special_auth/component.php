<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
IncludeModuleLangFile(__FILE__);

$login = $_REQUEST['auth_login'];
$password = $_REQUEST['auth_password'];

global $USER; 

if(!$USER->GetID()){
    $arAuthResult = $USER->Login($login, $password);
}

$arResult = array();
if($USER->GetID()){
    $arResult = array('status'=>'success', 'message'=>GetMessage('SUCCESS_MESSAGE'));    
}else{
    $arResult = array('status'=>'error', 'message'=>GetMessage('ERROR_MESSAGE'));
}

echo json_encode($arResult);
?>

