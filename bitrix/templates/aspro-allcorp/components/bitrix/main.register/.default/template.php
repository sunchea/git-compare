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
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>

<div class="form popup">

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">

	<div class="form-header">
		<i class="icon" style="background:#0088cc url(<?=SITE_TEMPLATE_PATH?>/images/reg-head.png) no-repeat center"></i>
		<div class="text">
			<div class="title">Регистрация</div>
		</div>
	</div>

	<div class="form-body">

		<?if($USER->IsAuthorized()):?>
		
			<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>
		
		<?else:?>
		
			<?
			if (count($arResult["ERRORS"]) > 0):
				foreach ($arResult["ERRORS"] as $key => $error)
					if (intval($key) == 0 && $key !== 0) 
						$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
			
				ShowError(implode("<br />", $arResult["ERRORS"]));
			
			elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
			?>
			<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		
		<?endif?>
	
		<?if($arResult["BACKURL"] <> ''):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif;?>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[TITLE]"><?=GetMessage("REGISTER_FIELD_TITLE")?></label>
					<div class="input">
						<input type="text" id="REGISTER[TITLE]" name="REGISTER[TITLE]" class="form-control required" />
						<i class="icon icon-user"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[WORK_COMPANY]"><?=GetMessage("REGISTER_FIELD_WORK_COMPANY")?></label>
					<div class="input">
						<input type="text" id="REGISTER[WORK_COMPANY]" name="REGISTER[WORK_COMPANY]" class="form-control" />
						<i class="icon icon-building-o"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[PERSONAL_PHONE]"><?=GetMessage("REGISTER_FIELD_PERSONAL_PHONE")?></label>
					<div class="input">
						<input type="text" id="REGISTER[PERSONAL_PHONE]" name="REGISTER[PERSONAL_PHONE]" class="form-control phone" />
						<i class="icon icon-phone"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[EMAIL]"><?=GetMessage("REGISTER_FIELD_EMAIL")?></label>
					<div class="input">
						<input type="text" id="REGISTER[EMAIL]" name="REGISTER[EMAIL]" class="form-control required" />
						<i class="icon icon-envelope"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[LOGIN]"><?=GetMessage("REGISTER_FIELD_LOGIN")?></label>
					<div class="input">
						<input type="text" id="REGISTER[LOGIN]" name="REGISTER[LOGIN]" class="form-control required" />
						<i class="icon icon-user"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[PASSWORD]"><?=GetMessage("REGISTER_FIELD_PASSWORD")?></label>
					<div class="input">
						<input type="password" id="REGISTER[PASSWORD]" name="REGISTER[PASSWORD]" autocomplete="off" class="form-control required" />
						<i class="icon icon-lock"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<label for="REGISTER[CONFIRM_PASSWORD]"><?=GetMessage("REGISTER_FIELD_CONFIRM_PASSWORD")?></label>
					<div class="input">
						<input type="password" id="REGISTER[CONFIRM_PASSWORD]" name="REGISTER[CONFIRM_PASSWORD]" autocomplete="off" class="form-control required" />
						<i class="icon icon-lock"></i>
					</div>
				</div>
			</div>
		</div>

		<?if ($arResult["USE_CAPTCHA"] == "Y") {?>
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></label>
						<div class="input">
							<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
							<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
							<input type="text" name="captcha_word" maxlength="50" value="" />
						</div>
					</div>
				</div>
			</div>
		<?}?>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<div class="input">
						<input type="checkbox" id="persinfo"><label for="persinfo"><?=GetMessage("REGISTER_FIELD_PERS_INFO")?></label>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="form-footer clearfix">
		<div class="pull-right">
			<button class="btn btn-primary" type="submit"><?=GetMessage("AUTH_REGISTER")?></button>
			<input type="hidden" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>">
		</div>
	</div>

</form>
<?endif?>
</div>

<script>
	$(document).ready(function(){
		$('form[name="regform"]').validate({
			highlight: function( element ){
				$(element).parent().addClass('error');
			},
			unhighlight: function( element ){
				$(element).parent().removeClass('error');
			},
			submitHandler: function( form ){
				if( $('form[name="regform"]').valid() && $("#persinfo").prop('checked') ){
					$(form).find('button[type="submit"]').attr("disabled", "disabled");
					form.submit();
				}
			},
			errorPlacement: function( error, element ){
				error.insertBefore(element);
			}
		});
		
		if(arAllcorpOptions['THEME']['PHONE_MASK'].length){
			var base_mask = arAllcorpOptions['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
			$('form[name="regform"] input.phone').inputmask("mask", { "mask": arAllcorpOptions['THEME']['PHONE_MASK'] });
			$('form[name="regform"] input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('div.error').html(BX.message("JS_REQUIRED"));
					}
				}
			});
		}
		
		$('.jqmClose').closest('.jqmWindow').jqmAddClose('.jqmClose');
		
		$('.jqmWindow').scrollTop();
	});
</script>