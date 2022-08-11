<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams["AUTH_RESULT"]['TYPE'] == 'ERROR'){?>
    <div class="alert alert-danger" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?></p>
    </div>
<?}?>
<?if($arParams["AUTH_RESULT"]['TYPE'] == 'OK'){?>
    <div class="alert alert-success" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-ok-sign"></span>&nbsp;<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?></p>  
    </div>
<?}else{?>
    <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <?if (strlen($arResult["BACKURL"]) > 0){?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <?}?>
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="SEND_PWD">
    <p><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>
    <p><?=GetMessage("AUTH_GET_CHECK_STRING")?></p>
    <div class="form-group">	
        <label class="control-label" id="bx_auth_user_login"><?=GetMessage("AUTH_LOGIN")?></label>
        <input class="form-control" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" aria-describedby="bx_auth_user_login" />
    </div>
    <div class="form-group">
        <label class="control-label" id="bx_auth_user_email"><?=GetMessage("AUTH_EMAIL")?></label>
        <input class="form-control" type="text" name="USER_EMAIL" maxlength="255" />
    </div>
    <div class="btn-group">
        <input class="btn btn-default" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" aria-describedby="bx_auth_user_email" />
    </div>  
    <br /><br />
    <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p> 
    </form>
<?}?>
