<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?if($arResult["isFormNote"] == "Y"){?>
    <div class="alert alert-success" role="alert" tabindex="0">
        <p><span class="glyphicon glyphicon glyphicon-ok-sign"></span>&nbsp;<?=$arResult["FORM_NOTE"]?></p>
    </div>
<?}?>
<?if($arResult["isFormNote"] != "Y"){?>
    <div>
        <?=$arResult["FORM_HEADER"]?>
        <?if($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y"){?>
            <?if($arResult["isFormTitle"]){?>
                <h3><?=$arResult["FORM_TITLE"]?></h3>
            <?}?>
            <?if($arResult["isFormImage"] == "Y"){?>
                <a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
            <?}?>        	
        <?}?>
        <p><?=$arResult["FORM_DESCRIPTION"]?></p>
        <?if($arResult["isFormErrors"] == "Y"):?>
            <div class="alert alert-danger" role="alert" tabindex="0">
                <p><span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=strip_tags($arResult["FORM_ERRORS_TEXT"]);?></p>
            </div>
        <?endif;?>	
        <div class="help-form-wrapper">
            <button type="button" class="btn btn-default btn-help-form" aria-label="<?=GetMessage("FORM_ALERT_INFO_SUB_TITLE")?>" tabindex="0"><span class="glyphicon glyphicon glyphicon-info-sign"></span>&nbsp;<?=GetMessage("FORM_ALERT_INFO_SUB_TITLE")?></button>
            <div class="alert alert-info alert-info-form" role="alert" tabindex="-1">		
                <p><strong><?=GetMessage("FORM_ALERT_INFO_TITLE")?></strong></p>
                <ul>
                    <?
                    $arFieldType = array(
                        'text' => GetMessage("FORM_FIELD_TYPE_TEXT"),
                        'textarea' => GetMessage("FORM_FIELD_TYPE_TEXTAREA"),
                        'email' => GetMessage("FORM_FIELD_TYPE_EMAIL"),
                        'file' => GetMessage("FORM_FIELD_TYPE_FILE"),
                        'radio' => GetMessage("FORM_FIELD_TYPE_RADIO"),
                        'checkbox' => GetMessage("FORM_FIELD_TYPE_CHECKBOX"),
                        'dropdown' => GetMessage("FORM_FIELD_TYPE_DROPDOWN"),
                        'multiselect' => GetMessage("FORM_FIELD_TYPE_MULTISELECT"),
                        'date' => GetMessage("FORM_FIELD_TYPE_DATE"),
                        'image' => GetMessage("FORM_FIELD_TYPE_IMAGE"),
                        'url' => GetMessage("FORM_FIELD_TYPE_URL"),
                        'password' => GetMessage("FORM_FIELD_TYPE_PASSWORD"),
                    );
                    foreach($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion){
                        if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] != 'hidden'){
                            $type = GetMessage("FORM_FIELD_TYPE")."&nbsp;";
                            if($arFieldType[$arQuestion['STRUCTURE'][0]['FIELD_TYPE']]){
                                $type = $type.$arFieldType[$arQuestion['STRUCTURE'][0]['FIELD_TYPE']];
                            }else{
                                $type = $type.$arQuestion['STRUCTURE'][0]['FIELD_TYPE'];
                            }
                            ?><li>&laquo;<?=$arQuestion["CAPTION"]?>&raquo; - <?=$type?><?if($arQuestion["REQUIRED"] == "Y"):?> <?=GetMessage("FORM_FIELD_REQUIRED")?><?endif;?></li><?
                        }
                    }
                    ?>  
                </ul>
                <?
                if($arResult["isUseCaptcha"] == "Y"){
                    ?><p><?=GetMessage("FORM_FIELD_USE_CAPTCHA")?></p><?
                }
                ?>	
            </div>	
        </div>
        <br />
        <?
        foreach($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion){
            if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'){
                echo $arQuestion["HTML_CODE"];
            }else{                
                $label_id = 'bx_form_'.$arResult['arForm']['ID'].'_label_'.$FIELD_SID;
                $field_id = 'bx_form_'.$arResult['arForm']['ID'].'_field_'.$FIELD_SID;
                $bFieldSet = false;
                $bCheckBox = false;
                if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'radio' || $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'checkbox'){
                    $bCheckBox = true;
                }
                if(count($arQuestion['STRUCTURE']) > 1 && $bCheckBox){
                    $bFieldSet = true;
                }
                ?>
                <div class="form-group <?=($bCheckBox ? 'checkbox radio' : NULL)?>">			
                    <?if($bFieldSet){?>
                        <fieldset>				
                    <?}?>
                    <?if(is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                        <span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
                    <?endif;?>
                    <?if($bFieldSet){?>
                        <legend class="control-label" id="<?=$label_id?>">
                    <?}else{?>
                        <label class="control-label" id="<?=$label_id?>">
                    <?}?>
                        <?=$arQuestion["CAPTION"]?>
                        <?if($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>            
                        <?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'date'){?>(DD.MM.YYYY)<?}?>            
                    <?if($bFieldSet){?>
                        </legend>
                    <?}else{?>
                        </label>    
                    <?}?>			
                    <?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>            
                    <?
                    $html_code = $arQuestion["HTML_CODE"];
                    if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'date'){
                        $html_code = str_replace('type="text"', 'type="text" class="form-control"', $html_code);
                    }else if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'dropdown'){
                        $html_code = str_replace('<select', '<select class="form-control"', $html_code);
                    }else{
                        $html_code = str_replace('inputtextarea', 'form-control', $html_code);
                        $html_code = str_replace('inputtext', 'form-control', $html_code);
                        $html_code = str_replace('inputfile', 'form-control', $html_code);
                        $html_code = str_replace('inputselect', 'form-control', $html_code);
                    }
                    if($arQuestion["REQUIRED"] == "Y"){
                        $html_code = str_replace('name=', 'required="required" name=', $html_code);
                    }
                    if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'email'){
                        $html_code = str_replace('type="text"', 'type="email"', $html_code);
                    }
                    if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'radio' || $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'checkbox'){
                        #p(count($arQuestion['STRUCTURE']));
                    }
                    //echo $arQuestion['STRUCTURE'][0]['FIELD_TYPE'];
                    $html_code = str_replace('name=', 'aria-describedby="'.$label_id.'" name=', $html_code);
                    ?>
                    <?=$html_code?>
                    <?if($bFieldSet){?>
                        </fieldset>
                    <?}?>
                </div>     
            <?}?>        
        <?}?>    
        <?if($arResult["isUseCaptcha"] == "Y"){?>
            <div class="form-group">
                <label class="control-label" id="bx_form_<?=$arResult['arForm']['ID']?>_label_capthca_sid"><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></label>
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                <div><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" alt="<?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>" width="180" height="40" /></div>
            </div>
            <div class="form-group">
                <label class="control-label" id="bx_form_<?=$arResult['arForm']['ID']?>_label_capthca_code"><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?></label><?=$arResult["REQUIRED_SIGN"];?>
                <input type="text" class="form-control" aria-describedby="bx_form_<?=$arResult['arForm']['ID']?>_label_capthca_code" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />		
            </div>
        <?}?>
        <?if($arResult["F_RIGHT"] >= 15):?>
            <input type="hidden" name="web_form_apply" value="Y" />
        <?endif;?>    
        <br />    
        <input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" class="btn btn-default" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />        
        <input type="reset" class="btn btn-default" value="<?=GetMessage("FORM_RESET");?>" />			           
        <?=$arResult["FORM_FOOTER"]?>
    </div>
    <br />
    <p><?=GetMessage("FORM_REQUIRED_FIELDS")?> <?=GetMessage("FORM_REQUIRED_FIELDS_SUB")?> <?=$arResult["REQUIRED_SIGN"];?></p>
<?}?>