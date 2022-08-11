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
    <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
        <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <? endif ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="CHANGE_PWD">
        <p><?=GetMessage("AUTH_CHANGE_PASSWORD")?></p>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_login"><span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN")?></label>
            <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="form-control" aria-describedby="bx_auth_user_login" />
        </div>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_checkword"><span class="starrequired">*</span><?=GetMessage("AUTH_CHECKWORD")?></label>
            <input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="form-control" aria-describedby="bx_auth_user_checkword" />
        </div>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_password"><span class="starrequired">*</span><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></label>
            <input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="form-control" aria-describedby="bx_auth_user_password" />
        </div>
        <?if($arResult["SECURE_AUTH"]):?>
            <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                <div class="bx-auth-secure-icon"></div>
            </span>
            <noscript>
            <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
            </span>
            </noscript>
            <script type="text/javascript">
                document.getElementById('bx_auth_secure').style.display = 'inline-block';
            </script>
        <?endif?>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_confirm_password"><span class="starrequired">*</span><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></label>
            <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="form-control" aria-describedby="bx_auth_user_confirm_password"  />
        </div>
        <div class="btn-group">
            <input class="btn btn-default" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
        </div>
        <br /><br />
        <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
        <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
        <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
    </form>
<?}?>