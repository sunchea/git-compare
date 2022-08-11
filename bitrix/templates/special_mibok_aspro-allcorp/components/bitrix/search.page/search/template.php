<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false){?>
<?}else if($arResult["ERROR_CODE"]!=0){?>
    <div class="alert alert-danger" role="alert" tabindex="0">
            <span class="glyphicon glyphicon glyphicon-remove-sign"></span>&nbsp;<?=GetMessage("SEARCH_NOTHING_TO_FOUND");?>		
            <p><?=GetMessage("SEARCH_ERROR")?></p>
            <p><?=$arResult["ERROR_TEXT"];?></p>
            <p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
    </div>	
<?}?>
<div class="help-form-wrapper">
    <button type="button" class="btn btn-default btn-help-form" aria-label="<?=GetMessage("FIELD_DESCRIPTION_TITLE")?>" tabindex="0"><span class="glyphicon glyphicon glyphicon-info-sign"></span>&nbsp;<?=GetMessage("FIELD_DESCRIPTION_TITLE")?></button>
    <div class="alert alert-info alert-info-form" role="alert" tabindex="-1">		
        <p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
        <table border="0" cellpadding="5">
                <tr>
                        <td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
                        <td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
                </tr>
                <tr>
                        <td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
                        <td><?=GetMessage("SEARCH_AND_ALT")?></td>
                </tr>
                <tr>
                        <td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
                        <td><?=GetMessage("SEARCH_OR_ALT")?></td>
                </tr>
                <tr>
                        <td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
                        <td><?=GetMessage("SEARCH_NOT_ALT")?></td>
                </tr>
                <tr>
                        <td align="center" valign="top">( )</td>
                        <td valign="top">&nbsp;</td>
                        <td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
                </tr>
        </table>	
    </div>	
</div>	
<div class="search-page">
<form action="" method="get">
    <div class="form-group">
        <label for="search_query"><?=GetMessage("INPUT_QUERY_TITLE")?></label>
	<input class="form-control" type="text" id="search_query" aria-label="<?=GetMessage("INPUT_QUERY_LABEL")?>" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />	
    </div>
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
        <div class="btn-group btn-group-no-resume" role="group">
            <input type="submit" class="btn btn-default" aria-label="<?=GetMessage("SEARCH_GO")?>" value="<?=GetMessage("SEARCH_GO")?>" />
        </div>
</form><br />

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>

<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
<?elseif(count($arResult["SEARCH"])>0):?>	
	<?foreach($arResult["SEARCH"] as $arItem):?>
		<a href="<?echo $arItem["URL"]?>"><?echo $arItem["TITLE_FORMATED"]?></a>
		<p><?echo $arItem["BODY_FORMATED"]?><br />	
                    <small><?=GetMessage("SEARCH_MODIFIED")?> <?=$arItem["DATE_CHANGE"]?></small>
                </p>
                <hr />
	<?endforeach;?>
	<?=$arResult["NAV_STRING"]?>
	<br />
	<p>
	<?if($arResult["REQUEST"]["HOW"]=="d"):?>
		<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
	<?else:?>
		<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
	<?endif;?>
	</p>
<?else:?>
	
<?endif;?>
</div>