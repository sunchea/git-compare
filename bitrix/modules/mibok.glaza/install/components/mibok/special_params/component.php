<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
session_start();
if($_REQUEST['RESET'] == 'Y'){
	$_SESSION['SPECIAL_PARAMS'] = array();
}
if($_REQUEST['FONT_SIZE']){
	if(in_array($_REQUEST['FONT_SIZE'], array('font-size-100', 'font-size-150', 'font-size-200'))){
		$_SESSION['SPECIAL_PARAMS']['FONT_SIZE'] = $_REQUEST['FONT_SIZE'];
	}
}
if($_REQUEST['COLOR']){
	if(in_array($_REQUEST['COLOR'], array('color-1', 'color-2', 'color-3', 'color-4', 'color-5'))){
		$_SESSION['SPECIAL_PARAMS']['COLOR'] = $_REQUEST['COLOR'];
	}
}
if($_REQUEST['KERNING']){
	if(in_array($_REQUEST['KERNING'], array('kerning-1', 'kerning-2', 'kerning-3'))){
		$_SESSION['SPECIAL_PARAMS']['KERNING'] = $_REQUEST['KERNING'];
	}
}
if($_REQUEST['LINE']){
	if(in_array($_REQUEST['LINE'], array('line-1', 'line-2', 'line-3'))){
		$_SESSION['SPECIAL_PARAMS']['LINE'] = $_REQUEST['LINE'];
	}
}
if($_REQUEST['GARNITURA']){
	if(in_array($_REQUEST['GARNITURA'], array('garnitura-1', 'garnitura-2', 'garnitura-3'))){
		$_SESSION['SPECIAL_PARAMS']['GARNITURA'] = $_REQUEST['GARNITURA'];
	}
}

if($_REQUEST['VOICE']){
	if(in_array($_REQUEST['VOICE'], array('voice-1', 'voice-2', 'voice-3', 'voice-4'))){
		$_SESSION['SPECIAL_PARAMS']['VOICE'] = $_REQUEST['VOICE'];
	}
}
if(isset($_REQUEST['VOLUME'])){
	$_SESSION['SPECIAL_PARAMS']['VOLUME'] = 'volume-'.$_REQUEST['VOLUME'];
}
if($_REQUEST['IMAGES'] == 'not-images'){
	$_SESSION['SPECIAL_PARAMS']['IMAGES'] = 'not-images';
}
if($_REQUEST['IMAGES'] == 'images'){
	$_SESSION['SPECIAL_PARAMS']['IMAGES'] = '';
}

if($_REQUEST['MONO_IMAGES'] == 'mono'){
	$_SESSION['SPECIAL_PARAMS']['MONO_IMAGES'] = 'mono';
}
if($_REQUEST['MONO_IMAGES'] == 'not-mono'){
	$_SESSION['SPECIAL_PARAMS']['MONO_IMAGES'] = '';
}

if($_REQUEST['FLASH'] == 'not-flash'){
	$_SESSION['SPECIAL_PARAMS']['FLASH'] = 'not-flash';
}
if($_REQUEST['FLASH'] == 'flash'){
	$_SESSION['SPECIAL_PARAMS']['FLASH'] = '';
}
print_r($_SESSION['SPECIAL_PARAMS']);
?>

