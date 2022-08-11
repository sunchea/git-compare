<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="vote-note-box vote-note-error">
	<div class="vote-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"])?></div>
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

if (empty($arResult["VOTE"]) || empty($arResult["QUESTIONS"]) ):
	return true;
endif;

?>


<?
$iCount = 0;
foreach ($arResult["QUESTIONS"] as $arQuestion):
	$iCount++;

?>
	<div class="form-group checkbox radio">            		
                
                <h4 tabindex="0"><?=$iCount?>. <?if($arQuestion["IMAGE"] !== false):?><img src="<?=$arQuestion["IMAGE"]["SRC"]?>" width="30" height="30" /><?endif;?><?=$arQuestion["QUESTION"]?></h4>                		
                <table width="100%" class="vote-answer-table">
                <?foreach ($arQuestion["ANSWERS"] as $arAnswer):?>
                        <? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])):?>
                                <tr><td></td><td style='vertical-align:middle;'><div style='width:80%; height:1px; background-color:#<?=$arAnswer["COLOR"]?>;'></div></td></tr>
                        <? endif; ?>
                        <tr>
                                <? $percent = round($arAnswer["BAR_PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td ?>
                                        <td width="24%" style=''>
                                        <?=$arAnswer["MESSAGE"]?>
                                        <? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])) 
                                        {
                                                if (trim($arAnswer["MESSAGE"]) != '') 
                                                        echo '&nbsp';
                                                echo '('.GetMessage('VOTE_GROUP_TOTAL') .')';
                                        }
                                        ?>
                                &nbsp;</td>
                                <td><div class="vote-answer-bar" style="width:<?=$percent?>%;background-color:#<?=$arAnswer["COLOR"]?>"></div>
                                <span class="vote-answer-counter"><nobr><?=($arAnswer["COUNTER"] > 0?'&nbsp;':'')?><?=$arAnswer["COUNTER"]?> (<?=$arAnswer["PERCENT"]?>%)</nobr></span></td>
                                <? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])): ?>
                                        <? $arGroupAnswers = $arResult['GROUP_ANSWERS'][$arAnswer['ID']]; ?> 
                                        </tr>
                                        <?foreach ($arGroupAnswers as $arGroupAnswer):?>
                                                <? $percent = round($arGroupAnswer["PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td ?>
                                                <tr>
                                                        <td width="24%">
                                                                <? if (trim($arAnswer["MESSAGE"]) != '') { ?>
                                                                        <span class='vote-answer-lolight'><?=$arAnswer["MESSAGE"]?>:&nbsp;</span>
                                                                <? } ?>
                                                                <?=$arGroupAnswer["MESSAGE"]?>
                                                        </td>
                                                        <td><div class="vote-answer-bar" style="width:<?=$percent?>%;background-color:#<?=$arAnswer["COLOR"]?>"></div>
                                                        <span class="vote-answer-counter"><nobr><?=($arGroupAnswer["COUNTER"] > 0?'&nbsp;':'')?><?=$arGroupAnswer["COUNTER"]?> (<?=$arGroupAnswer["PERCENT"]?>%)</nobr></span></td>
                                                </tr>
                                        <?endforeach?>
                                        <tr><td></td><td style='vertical-align:middle;'><div style='width:80%; height:1px; background-color:#<?=$arAnswer["COLOR"]?>;'></div></td></tr>
                                <? else: ?>
                        </tr>
                                <? endif; ?>
                <?endforeach?>
                </table>
            </div>        
<?
endforeach;

?>