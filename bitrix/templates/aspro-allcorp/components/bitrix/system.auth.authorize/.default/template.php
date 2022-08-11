<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<div class="form popup">

<form name="form_auth" method="post" action="<?=$arResult["AUTH_URL"]?>">

	<div class="form-header">
		<i class="icon" style="background:#0088cc url(<?=SITE_TEMPLATE_PATH?>/images/auth-head.png) no-repeat center"></i>
		<div class="text">
			<div class="title">Вход в скрытый раздел</div>
		</div>
	</div>
	
	<div class="form-body">

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="USER_LOGIN"><?=GetMessage("AUTH_LOGIN")?></label>
					<div class="input">
						<input type="text" id="USER_LOGIN" name="USER_LOGIN" class="form-control required" value="<?=$arResult["LAST_LOGIN"]?>" />
						<i class="icon icon-user"></i>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="USER_PASSWORD"><?=GetMessage("AUTH_PASSWORD")?></label>
					<div class="input">
						<input type="password" id="USER_PASSWORD" name="USER_PASSWORD" class="form-control required" autocomplete="off" />
						<i class="icon icon-lock"></i>
					</div>
				</div>
			</div>
		</div>
		
		<?if ($arResult["CAPTCHA_CODE"]) {?>
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></label>
						<div class="input">
							<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
							<?=GetMessage("AUTH_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
							<input type="text" name="captcha_word" maxlength="50" value="" />
						</div>
					</div>
				</div>
			</div>
		<?}?>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
					<label for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
				</div>
			</div>
		</div>
		
	</div>
		
	<div class="form-footer clearfix">
		<div class="pull-left">
			<div class="btn btn-primary" data-event="jqm" data-param-id="2" data-name="register"><?=GetMessage("AUTH_REGISTER")?></div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary" type="submit"><?=GetMessage("AUTH_AUTHORIZE")?></button>
			<input type="hidden" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
		</div>
	</div>
	
</form>
	
</div>

<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"])>0):?>
		try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
		try{document.form_auth.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script>