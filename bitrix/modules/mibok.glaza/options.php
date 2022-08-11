<?
$module_id = "mibok.glaza";
include_once($GLOBALS["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/include.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/include.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/options.php");
IncludeModuleLangFile(__FILE__);

$GKL_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ($GKL_RIGHT>="R") :

$aTabs = array(
    array(
        "DIV" => "settings",
        "TAB" => GetMessage("MIBOK_SPECIAL_TAB_SETTINGS"),
        "TITLE" => GetMessage("MIBOK_SPECIAL_TITLE_SETTINGS"),
        "OPTIONS" => Array(
			"bootstrap_adaptive" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_BOOTSTRAP_ADAPTIVE"), Array("checkbox")),
			"view_h1" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_VIEW_H1"), Array("checkbox")),
			"voice" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_VOICE"), Array("checkbox")),
			"disk_space" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_DISK_SPACE"), Array("text")),
			"size_synthes" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_SIZE_SYNTHES"), Array("text")),
			"off_reindex" => Array(GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_OFF_REINDEX"), Array("checkbox")),
		)),
	array(
		"DIV" => "rights",
		"TAB" => GetMessage("MAIN_TAB_RIGHTS"),
		"TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS"),
	),
);

$arNotes = array(
    "note_size_synthes" => GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_NOTE_SIZE_SYNTHES"),
    "note_off_reindex" => GetMessage("MIBOK_SPECIAL_TAB_SETTINGS_NOTE_OFF_REINDEX"),
    );

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$redirect_to_url="";

if($REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid() && $GKL_RIGHT=="W") 
{

	if (strlen($RestoreDefaults)>0)
	{
		COption::RemoveOption($module_id);
		$z = CGroup::GetList($v1="id",$v2="asc", array("ACTIVE" => "Y", "ADMIN" => "N"));
		while($zr = $z->Fetch())
			$APPLICATION->DelGroupRight($module_id, array($zr["ID"]));

		$redirect_to_url = $APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam();
	
	} else {
		$arOption = array();
		foreach($aTabs as $i => $aTab)
		{
			foreach($aTab["OPTIONS"] as $name => $arOption)
			{
				$val = $_POST[$name];
				if($arOption[1][0]=="checkbox" && $val!="Y")
					$val="N";
               
                if($name == 'size_synthes' && (int)$val > 50)
                    $val = 50;
                
                if($name == 'off_reindex' && $val == 'Y')
                    CAdminNotify::DeleteByModule("mibok.glaza");

				COption::SetOptionString($module_id, $name, $val, $arOption[0]);
			}
		}

		if(strlen($_REQUEST["back_url_settings"])>0) $redirect_to_url=$_REQUEST["back_url_settings"]; 

	}

}

$tabControl->Begin();
?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialchars($mid)?>&lang=<?echo LANG?>" name="ara">
<?

foreach($aTabs as $aTab):
    
	$tabControl->BeginNextTab();

	if ($aTab["DIV"]=="rights") require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");

	else foreach($aTab["OPTIONS"] as $name => $arOption):
		$val = COption::GetOptionString($module_id, $name);
		$type = $arOption[1];
	?>
		<tr>
			<td valign="top" width="50%"><?if($type[0]=="checkbox")
							echo "<label for=\"".htmlspecialchars($name)."\">".$arOption[0]."</label>";
						else
							echo $arOption[0];?></td>
			<td valign="top" width="50%">
					<?if($type[0]=="checkbox"):?>
						<input type="checkbox" name="<?echo htmlspecialchars($name)?>" id="<?echo htmlspecialchars($name)?>" value="Y"<?if($val=="Y")echo" checked";?>>
					<?elseif($type[0]=="text"):?>
						<input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialchars($val)?>" name="<?echo htmlspecialchars($name)?>">
					<?elseif($type[0]=="textarea"):?>
						<textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialchars($name)?>"><?echo htmlspecialchars($val)?></textarea>
					<?elseif($type[0]=="selectbox"):?>
						<select  name="<?echo htmlspecialchars($name)?>">
							<?foreach($type[1] as $k=>$v):?>
								<option value="<?=$k?>" <? if($val==$k) echo 'selected';?>><?=$v?></option>
							<?endforeach?>
						</select>
					<?endif?>
                    <?
                    if(array_key_exists('note_'.$name, $arNotes))
                    {
                        echo BeginNote();
                        echo $arNotes['note_'.$name];
                        echo EndNote();
                    }
                    ?>
			</td>
		</tr>
	<?endforeach;
endforeach;?>


<?$tabControl->Buttons();?>
<input type="submit" <?if ($GKL_RIGHT<"W") echo "disabled" ?> name="Update" value="<?echo GetMessage("MAIN_SAVE")?>">
<input type="hidden" name="Update" value="Y">
<?if(strlen($_REQUEST["back_url_settings"])>0):?>
	<input type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialchars(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
	<input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
<?endif?>
<input type="reset" name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
	<input type="submit" <?if ($GKL_RIGHT<"W") echo "disabled" ?> name="RestoreDefaults" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="return confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
	<?=bitrix_sessid_post();?>
<?$tabControl->End();?>
</form>
<?
if(strlen($redirect_to_url)>0) LocalRedirect($redirect_to_url);
?>
<?endif;?>
