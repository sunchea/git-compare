<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
global $USER; 
if($USER->GetID()){
    $time_out = $_SESSION['SESS_AUTH']['POLICY']['SESSION_TIMEOUT'];
    $user_id = $_SESSION['SESS_AUTH']['USER_ID'];
    $authorized = $_SESSION['SESS_AUTH']['AUTHORIZED'];
    if($time_out && $user_id && $authorized == 'Y'){
        ?>
		<?/*=($time_out * 3600 * 1000)*/?>
		<div id="mibok_special_auth_timeout" data-time-out="<?=($time_out * 60 * 1000)?>"></div><?
    }
}
?>

