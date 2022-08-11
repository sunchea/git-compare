<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
global $USER; 
if($USER->GetID()){
    $time_out = $_SESSION['SESS_AUTH']['POLICY']['SESSION_TIMEOUT'];
    $user_id = $_SESSION['SESS_AUTH']['USER_ID'];
    $authorized = $_SESSION['SESS_AUTH']['AUTHORIZED'];
    if($time_out && $user_id && $authorized == 'Y'){
    ?>
    <div class="panel-auth" aria-hidden="true">
        <h3 class="page-header"><?=GetMessage('PAGE_HEADER')?></h3>
        <form id="panel_auth_form" action="<?=SITE_DIR?>glaza_mibok_include/auth.php?special_version=Y">
            <p class="help-block help-block-default"><?=GetMessage('HELP_BLOCK_DEFAULT')?></p>
            <p class="help-block help-block-success" data-text="<?=GetMessage('HELP_BLOCK_SUCCESS')?>" tabindex="-1"></p>
            <p class="help-block help-block-error" data-text="<?=GetMessage('HELP_BLOCK_ERROR')?>" tabindex="-1"></p>
            <div class="form-group">
              <label for="auth_login"><?=GetMessage('LABEL_LOGIN')?></label>
              <input type="text" class="form-control" name="auth_login" id="auth_login" placeholder="">
            </div>
            <div class="form-group">
              <label for="auth_password"><?=GetMessage('LABEL_PASSWORD')?></label>
              <input type="password" class="form-control" name="auth_password" id="auth_password" placeholder="">
            </div>
            <div class="btn-group btn-group-resume" role="group">
                <button type="button" class="btn btn-default btn-resume" data-choice="resume" aria-label="<?=GetMessage('LABEL_RESUME')?>"><?=GetMessage('LABEL_RESUME')?><span class="hover"></span></button>
            </div>
            <div class="btn-group btn-group-no-resume" role="group">
                <button type="button" class="btn btn-default btn-no-resume" data-choice="no-resume" aria-label="<?=GetMessage('LABEL_NO_RESUME')?>"><?=GetMessage('LABEL_NO_RESUME')?><span class="hover"></span></button>
            </div>
        </form>
    </div>
    <?
    }
}
?>

