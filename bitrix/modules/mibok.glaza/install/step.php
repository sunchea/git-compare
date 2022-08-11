<?if(!check_bitrix_sessid()) return;?>

<?IncludeModuleLangFile(__FILE__);
echo CAdminMessage::ShowNote(GetMessage("MOD_INST_OK"));
echo BeginNote(),GetMessage("MOD_GENERATION"),EndNote();
?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
	<input type="hidden" name="lang" value="<?echo LANG?>">
	<input type="submit" name="" value="<?echo GetMessage("MOD_BACK")?>">
<form>
