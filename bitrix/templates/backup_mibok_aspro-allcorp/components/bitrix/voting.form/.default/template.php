<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="alert alert-danger" role="alert" tabindex="0">
    <p><span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=$arResult["ERROR_MESSAGE"]?></p>
</div>
<?
endif;

if (!empty($arResult["OK_MESSAGE"])): 
?>
<div class="alert alert-success" role="alert" tabindex="0">
    <p><span class="glyphicon glyphicon glyphicon-ok-sign"></span>&nbsp;<?=$arResult["OK_MESSAGE"]?></p>
</div>
<?
endif;

if (empty($arResult["VOTE"])):
	return false;
elseif (empty($arResult["QUESTIONS"])):
	return true;
endif;

?>
<form action="<?=POST_FORM_ACTION_URI?>" method="post" class="vote-form">
	<input type="hidden" name="vote" value="Y">
	<input type="hidden" name="PUBLIC_VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
	<input type="hidden" name="VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
	<?=bitrix_sessid_post()?>
	
<?
	$iCount = 0;
	foreach ($arResult["QUESTIONS"] as $arQuestion):
		$iCount++;

?>
        <? 
        $label_id = "bx_vote_".$arQuestion['ID'].'_label';        
        ?>
	<div class="form-group checkbox radio">            
                <legend tabindex="0" class="control-label" id="<?=$label_id?>">

<?
		if ($arQuestion["IMAGE"] !== false):
?>
			<div class="vote-item-image"><img src="<?=$arQuestion["IMAGE"]["SRC"]?>" width="30" height="30" /></div>
<?
		endif;
?>
                        <?=$arQuestion["QUESTION"]?><?if($arQuestion["REQUIRED"]=="Y"){echo "<span class='starrequired'>*</span>";}?>
		</legend>
		
		<ol class="vote-items-list vote-answers-list">
<?
		$iCountAnswers = 0;
		foreach ($arQuestion["ANSWERS"] as $arAnswer):
			$iCountAnswers++;
?>
			<li class="vote-item-vote <?=($iCountAnswers == 1 ? "vote-item-vote-first " : "")?><?
						?><?=($iCountAnswers == count($arQuestion["ANSWERS"]) ? "vote-item-vote-last " : "")?><?
						?><?=($iCountAnswers%2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ")?>">
                            
<?
			switch ($arAnswer["FIELD_TYPE"]):
					case 0://radio
						$value=(isset($_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]]) && 
							$_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]] == $arAnswer["ID"]) ? 'checked="checked"' : '';
					break;
					case 1://checkbox
						$value=(isset($_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]]) && 
							array_search($arAnswer["ID"],$_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]])!==false) ? 'checked="checked"' : '';
					break;
					case 2://select
						$value=(isset($_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]] : false;
					break;
					case 3://multiselect
						$value=(isset($_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]] : array();
					break;
					case 4://text field
						$value = isset($_REQUEST['vote_field_'.$arAnswer["ID"]]) ? htmlspecialcharsbx($_REQUEST['vote_field_'.$arAnswer["ID"]]) : '';
					break;
					case 5://memo
						$value = isset($_REQUEST['vote_memo_'.$arAnswer["ID"]]) ?  htmlspecialcharsbx($_REQUEST['vote_memo_'.$arAnswer["ID"]]) : '';
					break;
				endswitch;
?>
<?
                                switch ($arAnswer["FIELD_TYPE"]):
					case 0://radio
?>
						<span class="vote-answer-item vote-answer-item-radio">
						<input aria-describedby="<?=$label_id?>" type="radio" <?=$value?> name="vote_radio_<?=$arAnswer["QUESTION_ID"]?>" <?
								?>id="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?
								?>value="<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?> />
							<label for="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
						</span>
<?
					break;
					case 1://checkbox?>
						<span class="vote-answer-item vote-answer-item-checkbox">
							<input <?=$value?> type="checkbox" name="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>[]" value="<?=$arAnswer["ID"]?>" <?
								?> id="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?> />
							<label for="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
						</span>
					<?break?>

					<?case 2://dropdown?>
						<span class="vote-answer-item vote-answer-item-dropdown">
							<select class="form-control" name="vote_dropdown_<?=$arAnswer["QUESTION_ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?>>
							<?foreach ($arAnswer["DROPDOWN"] as $arDropDown):?>
								<option value="<?=$arDropDown["ID"]?>" <?=($arDropDown["ID"] === $value)?'selected="selected"':''?>><?=$arDropDown["MESSAGE"]?></option>
							<?endforeach?>
							</select>
						</span>
					<?break?>

					<?case 3://multiselect?>
						<span class="vote-answer-item vote-answer-item-multiselect">
							<select class="form-control" name="vote_multiselect_<?=$arAnswer["QUESTION_ID"]?>[]" <?=$arAnswer["~FIELD_PARAM"]?> multiple="multiple">
							<?foreach ($arAnswer["MULTISELECT"] as $arMultiSelect):?>
								<option value="<?=$arMultiSelect["ID"]?>" <?=(array_search($arMultiSelect["ID"], $value)!==false)?'selected="selected"':''?>><?=$arMultiSelect["MESSAGE"]?></option>
							<?endforeach?>
							</select>
						</span>
					<?break?>

					<?case 4://text field?>
						<span class="vote-answer-item vote-answer-item-textfield">
							<label for="vote_field_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
							<input class="form-control" type="text" name="vote_field_<?=$arAnswer["ID"]?>" id="vote_field_<?=$arAnswer["ID"]?>" <?
								?>value="<?=$value?>" size="<?=$arAnswer["FIELD_WIDTH"]?>" <?=$arAnswer["~FIELD_PARAM"]?> /></span>
					<?break?>

					<?case 5://memo?>
						<span class="vote-answer-item vote-answer-item-memo">
							<label for="vote_memo_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label><br />
							<textarea class="form-control" name="vote_memo_<?=$arAnswer["ID"]?>" id="vote_memo_<?=$arAnswer["ID"]?>" <?
								?><?=$arAnswer["~FIELD_PARAM"]?> cols="<?=$arAnswer["FIELD_WIDTH"]?>" <?
							?>rows="<?=$arAnswer["FIELD_HEIGHT"]?>"><?=$value?></textarea>
						</span>
					<?break;
				endswitch;
?>
                                
                            </li>
<?
			endforeach
?>
		</ol>
	</div>
<?
		endforeach
?>
</ol>
    <?if(isset($arResult["CAPTCHA_CODE"])){?>
        <div class="vote-item-header">
            <div class="vote-item-title vote-item-question"><?=GetMessage("F_CAPTCHA_TITLE")?></div>
            <div class="vote-clear-float"></div>
        </div>
        <div class="form-group">
            <input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>"/>
            <img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CAPTCHA_CODE"]?>" alt="<?=GetMessage("F_CAPTCHA_TITLE")?>" />
        </div>
        <div class="form-group">
            <label for="captcha_word"><?=GetMessage("F_CAPTCHA_PROMT")?><span class='starrequired'>*</span></label><br />
            <input class="form-control" type="text" size="20" name="captcha_word" />
        </div>
    <?}?><br />
    <div class="btn-group">
        <input type="submit" class="btn btn-default" name="vote" value="<?=GetMessage("VOTE_SUBMIT_BUTTON")?>" />
    </div><br /><br />
    <p><a name="show_result" href="<?=$arResult["URL"]["RESULT"]?>"><?=GetMessage("VOTE_RESULTS")?></a></p>
</form>
