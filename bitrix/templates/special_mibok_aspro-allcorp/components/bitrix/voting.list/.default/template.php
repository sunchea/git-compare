<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="element-list">
<?
$iCount = 0;
foreach ($arResult["VOTES"] as $arVote):
	$iCount++;
?>
    <div class="element-item">
	<div class="element-content">
		
            <div class="vote-item-header">			
			
<?
	if (strlen($arVote["TITLE"]) > 0):
?>
                <h4 tabindex="0" class="element-title"><?=$arVote["TITLE"];?></h4>
<?
		if ($arVote["LAMP"]=="green"):
/*?>
			<span class="vote-item-lamp vote-item-lamp-green">[ <span class="active"><?=GetMessage("VOTE_IS_ACTIVE_SMALL")?></span> ]</span>
<?*/
		elseif ($arVote["LAMP"]=="red"):
?>
			<span class="vote-item-lamp vote-item-lamp-red">[ <span class="disable"><?=GetMessage("VOTE_IS_NOT_ACTIVE_SMALL")?></span> ]</span>
<?
		endif;
	endif;
?>
			<div class="vote-clear-float"></div>
		</div>            
<?
	
	if ($arVote["DATE_START"] || ($arVote["DATE_END"] && $arVote["DATE_END"] != "31.12.2030 23:59:59")):
?>
		<p class="vote-item-date">
<?
		if ($arVote["DATE_START"]):
?>
			<span class="vote-item-date-start"><?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arVote["DATE_START"]))?></span>
<?

		endif;
		if ($arVote["DATE_END"] && $arVote["DATE_END"]!="31.12.2030 23:59:59"):
			if ($arVote["DATE_START"]):
?>
			<span class="vote-item-date-sep"> - </span>
<?
			endif;
?>
			<span class="vote-item-date-end"><?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arVote["DATE_END"]))?></span>
<?
		endif;
?>
		</p> 
<?
	endif;
?>
		<p class="vote-item-counter"><span><?=GetMessage("VOTE_VOTES")?>:</span> <?=$arVote["COUNTER"]?></p>
<?
	if (strlen($arVote["TITLE"]) <= 0):
		if ($arVote["LAMP"]=="green"):
?>
		<p class="vote-item-lamp vote-item-lamp-green"><span class="active"><?=GetMessage("VOTE_IS_ACTIVE")?></span></p>
<?
		elseif ($arVote["LAMP"]=="red"):
?>
		<p class="vote-item-lamp vote-item-lamp-red"><span class="disable"><?=GetMessage("VOTE_IS_NOT_ACTIVE")?></span></p>
<?
		endif;
	endif;
	
	if ($arVote["IMAGE"] !== false || !empty($arVote["DESCRIPTION"])):
?>
		<div class="vote-item-footer">
<?
		if ($arVote["IMAGE"] !== false):
?>
			<div class="vote-item-image">
				<img src="<?=$arVote["IMAGE"]["SRC"]?>" width="<?=$arVote["IMAGE"]["WIDTH"]?>" height="<?=$arVote["IMAGE"]["HEIGHT"]?>" border="0" />
			</div>
<?
		endif;
	
		if (!empty($arVote["DESCRIPTION"])):
?>
			<p><?=$arVote["DESCRIPTION"];?></p>
<?
		endif
?>
			<div class="vote-clear-float"></div>
		</div>
<?
	endif;
?>
            <div class="vote-item-links float-links">
    <?
            if ($arVote["LAMP"]=="green" && $arVote["MAX_PERMISSION"] >= 2 && $arVote["USER_ALREADY_VOTE"] != "Y"):
    ?>
                                    <a class="btn btn-default" href="<?=$arVote["VOTE_FORM_URL"]?>"><?=GetMessage("VOTE_VOTING")?></a>
    <?
            endif;

            if ($arVote["MAX_PERMISSION"] >= 1):
    ?>
                                    <a class="btn btn-default" href="<?=$arVote["VOTE_RESULT_URL"]?>"><?=GetMessage("VOTE_RESULTS")?></a>
    <?
            endif;
    ?>
            </div>
	</div>
        </div>
<?
endforeach;
?>
</div>
<?if (strlen($arResult["NAV_STRING"]) > 0):?>
    <?=$arResult["NAV_STRING"]?>	
<?endif;?>