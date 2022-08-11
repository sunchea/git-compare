<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?if( $arResult["isFormErrors"] == "Y" ){?>
	<?=$arResult["FORM_ERRORS_TEXT"]?>
<?}?>

<?=$arResult["FORM_NOTE"]?>

<?if( $arResult["isFormNote"] != "Y" ){?>
	<?=$arResult["FORM_HEADER"]?>
		<table>
			<?if( $arResult["isIblockDescription"] == "Y" || $arResult["isIblockTitle"] == "Y" ){?>
				<tr>
					<td>
						<?if( $arResult["isIblockTitle"] ){?>
							<h3><?=$arResult["IBLOCK_TITLE"]?></h3>
						<?}?>
						<?if( $arResult["isIblockDescription"] ){?>
							<p><?=$arResult["FORM_DESCRIPTION"]?></p>
						<?}?>
					</td>
				</tr>
			<?}?>
		</table>
		<table>
			<thead>
				<tr>
					<th colspan="2">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?foreach( $arResult["QUESTIONS"] as $FIELD_SID => $arQuestion ){
					if( $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ){
						echo $arQuestion["HTML_CODE"];
					}else{?>
					<tr>
						<td>
							<?=$arQuestion["CAPTION"]?>
						</td>
						<td>
							<?=$arQuestion["HTML_CODE"]?>
							<?if( !empty( $arQuestion["HINT"] ) ){?>
								<i><?=$arQuestion["HINT"]?></i>
							<?}?>
						</td>
					</tr>
					<?}
				}?>
				<?
				$frame = $this->createFrame()->begin('');
				$frame->setBrowserStorage(true);
				?>
				<?if( $arResult["isUseCaptcha"] == "Y" ){?>
					<tr>
						<td>&nbsp;</td>
						<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
					</tr>
					<tr>
						<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?>*</td>
						<td><input type="text" name="captcha_word" class="required" value="" /></td>
					</tr>
				<?}else{?>
					<tr style="display:none;"></tr>
				<?}?>
				<?$frame->end();?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<?=$arResult["SUBMIT_BUTTON"]?>
					</th>
				</tr>
			</tfoot>
		</table>
	<?=$arResult["FORM_FOOTER"]?>
<?}?>