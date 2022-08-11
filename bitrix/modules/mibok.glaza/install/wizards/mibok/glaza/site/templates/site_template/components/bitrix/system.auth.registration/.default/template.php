<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if($arParams["AUTH_RESULT"]['TYPE'] == 'ERROR'){?>
    <div class="alert alert-danger" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?></p>
    </div>
<?}?>
<?if($arParams["AUTH_RESULT"]['TYPE'] == 'OK'){?>
    <div class="alert alert-success" role="alert" tabindex="0">
        <p>
            <span class="glyphicon glyphicon glyphicon-ok-sign"></span>&nbsp;<?=$arParams["~AUTH_RESULT"]['MESSAGE'];?>
            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>    
                <br /><?echo GetMessage("AUTH_EMAIL_SENT")?>
            <?endif?>
            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>   
                <br /><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?>
            <?endif?>
        </p>  
    </div>
<?}else{?>
    <noindex>
    <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
        <?if (strlen($arResult["BACKURL"]) > 0){?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?}?>
        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="REGISTRATION" />
        <div class="form-group">	
            <label class="control-label" id="bx_auth_user_name"><?=GetMessage("AUTH_NAME")?></label>
            <input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="form-control" aria-describedby="bx_auth_user_name" />
        </div>
        <div class="form-group">	
            <label class="control-label" id="bx_auth_user_last_name"><?=GetMessage("AUTH_LAST_NAME")?></label>
            <input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="form-control" aria-describedby="bx_auth_user_last_name" />
        </div>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_login"><span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN_MIN")?></label>
            <input type="text" required="required" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="form-control" aria-describedby="bx_auth_user_login" />
        </div>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_password"><span class="starrequired">*</span><?=GetMessage("AUTH_PASSWORD_REQ")?></label>
            <input type="password" required="required" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="form-control" aria-describedby="bx_auth_user_password" />
        </div>        
        <?if($arResult["SECURE_AUTH"]):?>
            <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none"><div class="bx-auth-secure-icon"></div></span>
            <noscript><span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>"><div class="bx-auth-secure-icon bx-auth-secure-unlock"></div></span></noscript>
            <script type="text/javascript">
                document.getElementById('bx_auth_secure').style.display = 'inline-block';
            </script>
        <?endif?>

        <div class="form-group">
            <label class="control-label" id="bx_auth_user_confirm_password"><span class="starrequired">*</span><?=GetMessage("AUTH_CONFIRM")?></label>
            <input type="password" required="required" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="form-control" aria-describedby="bx_auth_user_confirm_password" />
        </div>
        <div class="form-group">
            <label class="control-label" id="bx_auth_user_email"><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?><?=GetMessage("AUTH_EMAIL")?></label>
            <input type="email" <?if($arResult["EMAIL_REQUIRED"]):?>required="required"<?endif?> name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="form-control" aria-describedby="bx_auth_user_email" />
        </div>            
        <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
            <?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
            <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
            <?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;
                    ?><?=$arUserField["EDIT_FORM_LABEL"]?>:
                            <?$APPLICATION->IncludeComponent(
                                    "bitrix:system.field.edit",
                                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
            <?endforeach;?>
        <?endif;?>
        <?if($arResult["USE_CAPTCHA"] == "Y"){?>
            <div class="form-group">         
                <?=GetMessage("CAPTCHA_REGF_TITLE")?>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                <div><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
            </div>
            <div class="form-group">                
                <label class="control-label" id="bx_auth_user_captcha"><?=GetMessage("CAPTCHA_REGF_PROMT")?>:</label>
                <input type="text" required="required" name="captcha_word" maxlength="50" value="" class="form-control" aria-describedby="bx_auth_user_captcha" />
            </div>
        <?}?>	
        <div class="brn-group">
            <input class="btn btn-default" type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
        </div>
        <br />
        <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
        <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
        <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
    </form>
    </noindex>
    <script type="text/javascript">
    document.bform.USER_NAME.focus();
    </script>
<?}?>