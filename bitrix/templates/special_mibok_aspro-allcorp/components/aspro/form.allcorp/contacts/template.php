<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="styled-block">
			<div class="form contacts">
				<?if( $arResult["isFormNote"] == "Y" ){?>
					<div class="form-header">
						<i class="icon icon-check"></i>
						<div class="text">
							<div class="title"><?=GetMessage("SUCCESS_TITLE")?></div>
							<?=$arResult["FORM_NOTE"]?>
						</div>
					</div>
					<?if( $arParams["DISPLAY_CLOSE_BUTTON"] ){?>
						<div class="form-footer" style="text-align: center;">
							<?=$arResult["CLOSE_BUTTON"]?>
						</div>
					<?}
				}else{?>
					<?=$arResult["FORM_HEADER"]?>
						<div class="row">
							<div class="col-md-4">
								<?if( $arResult["isIblockTitle"] ){?>
									<div class="title"><?=$arResult["IBLOCK_TITLE"]?></div>
								<?}?>
								<?if( $arResult["isIblockDescription"] ){
									if( $arResult["IBLOCK_DESCRIPTION_TYPE"] == "text" ){?>
										<p><?=$arResult["IBLOCK_DESCRIPTION"]?></p>
									<?}else{?>
										<?=$arResult["IBLOCK_DESCRIPTION"]?>
									<?}
								}?>
							</div>
							<div class="col-md-4">
								<?if(is_array($arResult["QUESTIONS"])):?>
									<?foreach( $arResult["QUESTIONS"] as $FIELD_SID => $arQuestion ){
										if( $FIELD_SID == "MESSAGE" ) continue;
										if( $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ){
											echo $arQuestion["HTML_CODE"];
										}else{?>
											<div class="row" data-SID="<?=$FIELD_SID?>">
												<div class="form-group">
													<div class="col-md-12">
														<?=$arQuestion["CAPTION"]?>
														<div class="input">
															<?=$arQuestion["HTML_CODE"]?>
														</div>
														<?if( !empty( $arQuestion["HINT"] ) ){?>
															<div class="hint"><?=$arQuestion["HINT"]?></div>
														<?}?>
													</div>
												</div>
											</div>
										<?}
									}?>
								<?endif;?>
							</div>
							<div class="col-md-4">
								<div class="row" data-SID="MESSAGE">
									<div class="form-group">
										<div class="col-md-12">
											<?=$arResult["QUESTIONS"]["MESSAGE"]["CAPTION"]?>
											<div class="input">
												<?=$arResult["QUESTIONS"]["MESSAGE"]["HTML_CODE"]?>
											</div>
											<?if( !empty( $arResult["QUESTIONS"]["MESSAGE"]["HINT"] ) ){?>
												<div class="hint"><?=$arResult["QUESTIONS"]["MESSAGE"]["HINT"]?></div>
											<?}?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?
						$frame = $this->createFrame()->begin('');
						$frame->setBrowserStorage(true);
						?>
						<?if( $arResult["isUseCaptcha"] == "Y" ){?>
							<div class="row captcha-row">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									<div class="form-group pull-right" style="margin-top: 21px;">
										<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
										<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="captcha_word"><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><span class="required-star">*</span></label>
										<div class="input">
											<input type="text" name="captcha_word" class="form-control required" value="" />
										</div>
									</div>
								</div>
							</div>
						<?}else{?>
							<div style="display:none;"></div>
						<?}?>
						<?$frame->end();?>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									<?=$arResult["SUBMIT_BUTTON"]?>
								</div>
							</div>
						</div>
					<?=$arResult["FORM_FOOTER"]?>
				<?}?>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').validate({
			highlight: function( element ){
				$(element).parent().addClass('error');
			},
			unhighlight: function( element ){
				$(element).parent().removeClass('error');
			},
			submitHandler: function( form ){
				if( $('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').valid() ){
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
			$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').inputmask("mask", { "mask": arAllcorpOptions['THEME']['PHONE_MASK'] });
			$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('div.error').html(BX.message("JS_REQUIRED"));
					}
				}
			});
		}
		
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.date').inputmask(arAllcorpOptions['THEME']['DATE_MASK'], { "placeholder": arAllcorpOptions['THEME']['DATE_PLACEHOLDER'] });
		
		$('.refresh-page').on('click', function(){
			location.reload();
		})
	});
</script>