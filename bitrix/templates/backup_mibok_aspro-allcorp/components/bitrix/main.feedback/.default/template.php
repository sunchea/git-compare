<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="mfeedback">
<?if(!empty($arResult["ERROR_MESSAGE"])){?>
    <div class="alert alert-danger" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=GetMessage("MFT_ERROR_TITLE")?>
            <ul>
            <?foreach($arResult["ERROR_MESSAGE"] as $v){ echo "<li>".$v."</li>"; }?>
            </ul>
        </p>
    </div>
<?}?>
<?if(strlen($arResult["OK_MESSAGE"]) > 0){?>
    <div class="alert alert-success" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-ok-sign"></span>&nbsp;<?=$arResult["OK_MESSAGE"]?></p>
    </div>
<?}?>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="form-group">
		<label class="control-label" id="bitrix_form_user_name">
			<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</label>
		<input type="text" required="required" class="form-control" aria-describedby="bitrix_form_user_name" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
	<div class="form-group">
		<label class="control-label" id="bitrix_form_user_email">
			<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</label>
		<input type="email" required="required" class="form-control" aria-describedby="bitrix_form_user_email" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	</div>

	<div class="form-group">
		<label class="control-label" id="bitrix_form_message">
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</label>
		<textarea name="MESSAGE" required="required" class="form-control" aria-describedby="bitrix_form_message" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
	</div>

	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="form-group">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
		<input class="form-control" required="required" type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="submit" class="btn btn-default" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>
</div>