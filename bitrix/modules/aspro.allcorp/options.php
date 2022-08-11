<?php
//aspro.allcorp options version 1.12

global  $APPLICATION;
$module_id = "aspro.allcorp";
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/options.php");
$APPLICATION->SetAdditionalCSS($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/css/style.css");
$APPLICATION->AddHeadScript($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/js/jquery.cookie.js");
IncludeModuleLangFile(__FILE__);

if( !function_exists('__AdmSettingsSaveOption_EX') ){
	function __AdmSettingsSaveOption_EX( $module_id, $arOption ){
		if( !is_array($arOption) )
			return false;
		$arControllerOption = CControllerClient::GetInstalledOptions($module_id);
		if( isset($arControllerOption[$arOption[0]]) )
			return false;
		
		$name = $arOption[0];
		$val = $_REQUEST[$name];

		if( array_key_exists(4, $arOption) && $arOption[4] == 'Y' ){
			if( $arOption[3][0] == 'checkbox' ){
				$val = 'N';
			}else{
				return false;
			}
		}
		if( $arOption[3][0] == "checkbox" && $val != "Y" )
			$val = "N";
		if( $arOption[3][0] == "multiselectbox" )
			$val = @implode(",", $val);

		$siteID = end( explode("_", $arOption[0]) );
		$name  = substr( $name, 0, (strlen($name)-strlen($siteID)-1) );
		COption::SetOptionString( $module_id, $name, $val, $arOption[1], $siteID );
	}
}

if( !function_exists('__AdmSettingsDrawRow_EX') ){
	function __AdmSettingsDrawRow_EX( $module_id, $Option, $siteID ){
		$arControllerOption = CControllerClient::GetInstalledOptions($module_id);
		if( !is_array($Option) ){?>
			<tr class="heading"><td colspan="2"><?=$Option?></td></tr>
		<?}elseif( isset($Option["note"]) ){?>
			<tr>
				<td colspan="2" align="center">
					<?echo BeginNote('align="center"');?>
					<?=$Option["note"]?>
					<?echo EndNote();?>
				</td>
			</tr>
		<?}else{
			$name  = substr($Option[0], 0, (strlen($Option[0])-strlen($siteID)-1));
			$val = COption::GetOptionString($module_id, $name, $Option[2], $siteID);
			$type = $Option[3];
			$disabled = array_key_exists(4, $Option) && $Option[4] == 'Y' ? ' disabled' : '';
			$sup_text = array_key_exists(5, $Option) ? $Option[5] : '';?>
			<tr>
				<td <?if( $type[0] == "multiselectbox" || $type[0] == "textarea" || $type[0] == "statictext" || $type[0] == "statichtml" ) echo ' class="adm-detail-valign-top"'?> width="50%">
					<?if( $type[0] == "checkbox" )
						echo "<label for='".htmlspecialcharsbx($Option[0])."'>".$Option[1]."</label>";
					else
						echo $Option[1];
					if( strlen($sup_text) > 0 ){?>
						<span class="required"><sup><?=$sup_text?></sup></span>
					<?}?>
				</td>
				<td width="50%">
					<?if( $type[0]=="checkbox" ){?>
						<input type="checkbox" <?if( isset($arControllerOption[$Option[0]]) ) echo ' disabled title="'.GetMessage("MAIN_ADMIN_SET_CONTROLLER_ALT").'"';?> id="<?echo htmlspecialcharsbx($Option[0])?>" name="<?echo htmlspecialcharsbx($Option[0])?>" value="Y"<?if($val=="Y")echo" checked";?><?=$disabled?><?if($type[2]<>'') echo " ".$type[2]?>>
					<?}elseif( $type[0] == "text" || $type[0] == "password" ){?>
						<input type="<?echo $type[0]?>" <?if( isset($arControllerOption[$Option[0]])) echo ' disabled title="'.GetMessage("MAIN_ADMIN_SET_CONTROLLER_ALT").'"';?> size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($Option[0])?>"<?=$disabled?><?=($type[0]=="password"? ' autocomplete="off"':'')?>>
					<?}elseif( $type[0] == "selectbox" ){
						$arr = $type[1];
						if(!is_array($arr))
							$arr = array();
						$arr_keys = array_keys( $arr );?>
						<select name="<?echo htmlspecialcharsbx($Option[0])?>" <?if(isset($arControllerOption[$Option[0]]))echo ' disabled title="'.GetMessage("MAIN_ADMIN_SET_CONTROLLER_ALT").'"';?> <?=$disabled?>>
							<?for( $j=0; $j<count($arr_keys); $j++ ){?>
								<option value="<?echo $arr_keys[$j]?>"<?if($val==$arr_keys[$j])echo" selected"?>><?echo htmlspecialcharsbx($arr[$arr_keys[$j]])?></option>
							<?}?>
						</select>
					<?}elseif( $type[0] == "multiselectbox" ){
						$arr = $type[1];
						if(!is_array($arr)) $arr = array();
						$arr_keys = array_keys($arr);
						$arr_val = explode(",",$val);?>
						<select size="5" <?if(isset($arControllerOption[$Option[0]]))echo ' disabled title="'.GetMessage("MAIN_ADMIN_SET_CONTROLLER_ALT").'"';?> multiple name="<?echo htmlspecialcharsbx($Option[0])?>[]"<?=$disabled?>>
							<?for( $j=0; $j<count($arr_keys); $j++ ){?>
								<option value="<?echo $arr_keys[$j]?>"<?if(in_array($arr_keys[$j],$arr_val)) echo " selected"?>><?echo htmlspecialcharsbx($arr[$arr_keys[$j]])?></option>
							<?}?>
						</select>
					<?}elseif( $type[0] == "textarea" ){?>
						<textarea <?if(isset($arControllerOption[$Option[0]]))echo ' disabled title="'.GetMessage("MAIN_ADMIN_SET_CONTROLLER_ALT").'"';?> rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($Option[0])?>"<?=$disabled?>><?echo htmlspecialcharsbx($val)?></textarea>
					<?}elseif( $type[0] == "statictext" ){
						echo htmlspecialcharsbx($val);
					}elseif( $type[0] == "statichtml" ){
						echo $val;
					}?>
				</td>
			</tr>
		<?}
	}
}

if( !function_exists('__AdmSettingsDrawCustomRow') ){
	function __AdmSettingsDrawCustomRow( $html ){
		echo '<tr><td colspan="2">'.$html.'</td></tr>';
	}
}

$RIGHT = $APPLICATION->GetGroupRight($module_id);

if( $RIGHT >="R" ){
	$by = "id";
	$sort = "asc";
	
	$arSites = array();
	$db_res = CSite::GetList($by , $sort ,array("ACTIVE"=>"Y"));
	while( $res = $db_res->Fetch() ){
		$arSites[] = $res;
	}
	
	foreach(CAllCorp::$arBaseColors as $colorCode => $arColor){
		$arColors[$colorCode] = $arColor["TITLE"];
	}

	$arWidth = array(
		"auto" => GetMessage("WIDTH_AUTO"),
		"wide" => GetMessage("WIDTH_WIDE"),
		"middle" => GetMessage("WIDTH_MIDDLE"),
		"narrow" => GetMessage("WIDTH_NARROW"),
	);

	$arMenu = array(
		"first" => GetMessage("MENU_FIRST"),
		"second" => GetMessage("MENU_SECOND"),
	);
	
	$arSideMenu = array(
		"left" => GetMessage("SIDEMENU_LEFT"),
		"right" => GetMessage("SIDEMENU_RIGHT"),
	);
	
	$arDateFormats = array(
		"dot" => GetMessage("DATE_FORMAT_DOT"),
		"hyphen" => GetMessage("DATE_FORMAT_HYPHEN"),
		"space" => GetMessage("DATE_FORMAT_SPACE"),
		"slash" => GetMessage("DATE_FORMAT_SLASH"),
		"colon" => GetMessage("DATE_FORMAT_COLON"),
	);
	
	$arYesNo = array(
		"Y" => GetMessage("YES"),
		"N" => GetMessage("NO"),
	);
	
	$arFilterView = array(
		'VERTICAL' => GetMessage('M_FILTER_VIEW_VERTICAL'),
		'HORIZONTAL' => GetMessage('M_FILTER_VIEW_HORIZONTAL'),
		'NONE' => GetMessage('M_FILTER_VIEW_NONE'),
	);

	$arMainOptions = array(
		array(
			"THEME_SWITCHER",
			GetMessage("THEME_SWITCHER"),
			"Y",
			array( "checkbox" )
		),
		array(
			"COLOR", 
			GetMessage("COLOR"), 
			"blue",
			array( "selectbox", $arColors )
		),
		array(
			"WIDTH",
			GetMessage("WIDTH"),
			"auto",
			array( "selectbox", $arWidth )
		),
		array(
			"MENU",
			GetMessage("MENU"),
			"first",
			array( "selectbox", $arMenu )
		),
		array(
			"SIDEMENU",
			GetMessage("SIDEMENU"),
			"left",
			array( "selectbox", $arSideMenu )
		),
		array(
			"PHONE_MASK",
			GetMessage("PHONE_MASK"),
			"+7 (999) 999-99-99",
			array( "text" )
		),
		array(
			"VALIDATE_PHONE_MASK",
			GetMessage("VALIDATE_PHONE_MASK"),
			"^[+][0-9] [(][0-9]{3}[)] [0-9]{3}[-][0-9]{2}[-][0-9]{2}$",
			array( "text" )
		),
		array(
			"DATE_FORMAT",
			GetMessage("DATE_FORMAT"),
			"dot",
			array( "selectbox", $arDateFormats )
		),
		array(
			"VALIDATE_FILE_EXT",
			GetMessage("VALIDATE_FILE_EXT"), 
			"png|jpe?g|gif|docx?|xlsx?|txt|pdf|odt|rtf",
			array( "text" )
		),
		array(
			"USE_CAPTCHA_FORM",
			GetMessage("USE_CAPTCHA_FORM"),
			"Y",
			array( "checkbox" )
		),
		array(
			"CATALOG_INDEX",
			GetMessage("CATALOG_INDEX"),
			"N",
			array( "selectbox", $arYesNo )
		),
		array(
			"SERVICES_INDEX",
			GetMessage("SERVICES_INDEX"),
			"Y",
			array( "selectbox", $arYesNo )
		),
		array(
			"FILTER_VIEW",
			GetMessage("M_FILTER_VIEW"),
			"NONE",
			array( "selectbox", $arFilterView )
		),
		array(
			"SOCIAL_VK",
			GetMessage("SOCIAL_VK"), 
			"http://vk.ru/aspro74",
			array("text")
		),
		array(
			"SOCIAL_FACEBOOK",
			GetMessage("SOCIAL_FACEBOOK"), 
			"http://www.facebook.com/aspro74",
			array("text")
		),
		array(
			"SOCIAL_TWITTER",
			GetMessage("SOCIAL_TWITTER"), 
			"http://twitter.com/aspro_ru",
			array("text")
		),
		array(
			"SOCIAL_ODNOKLASSNIKI",
			GetMessage("SOCIAL_ODNOKLASSNIKI"), 
			"http://www.odnoklassniki.ru/",
			array("text")
		),
		array(
			"SOCIAL_MAILRU",
			GetMessage("SOCIAL_MAILRU"), 
			"http://www.my.mail.ru/",
			array("text")
		),
		array(
			"SOCIAL_LIVEJOURNAL",
			GetMessage("SOCIAL_LIVEJOURNAL"),
			"http://www.livejournal.com/",
			array("text")
		),
		array(
			"SOCIAL_GOOGLE",
			GetMessage("SOCIAL_GOOGLE"),
			"https://plus.google.com/",
			array("text")
		),
	);

	$arTabs = array();
	foreach( $arSites as $key => $arSite ){
		$arTabs[] = array(
			"DIV" => "edit".($key+1), 
			"TAB" => GetMessage("MAIN_OPTIONS", array("#SITE_NAME#" => $arSite["NAME"], "#SITE_ID#" => $arSite["ID"])), 
			"ICON" => "settings", 
			"TITLE" => GetMessage("MAIN_OPTIONS_TITLE"),
			"PAGE_TYPE" => "site_settings",
			"SITE_ID" => $arSite["ID"],
			"OPTIONS" => $arMainOptions
		);	
	}

	$tabControl = new CAdminTabControl("tabControl", $arTabs);

	if( $REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults) > 0 && $RIGHT >= "W" && check_bitrix_sessid() ){
		global $APPLICATION;
		if( strlen($RestoreDefaults) > 0 ){
			COption::RemoveOption("aspro.allcorp");
			$APPLICATION->DelGroupRight("aspro.allcorp");
		}else{	
			COption::RemoveOption("aspro.allcorp", "sid");	
			foreach( $arTabs as $key => $arTab ){
				foreach( $arTab["OPTIONS"] as $arOption ){
					$arOption[0] = $arOption[0]."_".$arTab["SITE_ID"];
					__AdmSettingsSaveOption_EX( $module_id, $arOption );
				}
			}
		}

		COption::SetOptionString( $module_id, "COLOR_LIST", serialize( $arColors ) );
		COption::SetOptionString( $module_id, "WIDTH_LIST", serialize( $arWidth ) );
		COption::SetOptionString( $module_id, "MENU_LIST", serialize( $arMenu ) );
		COption::SetOptionString( $module_id, "SIDEMENU_LIST", serialize( $arSideMenu ) );
		COption::SetOptionString( $module_id, "CATALOG_INDEX_LIST", serialize( $arYesNo ) );
		COption::SetOptionString( $module_id, "SERVICES_INDEX_LIST", serialize( $arYesNo ) );
		COption::SetOptionString( $module_id, "FILTER_VIEW_LIST", serialize( $arFilterView ) );
		
		if(CAllCorp::IsCompositeEnabled()){
			$obCache = new CPHPCache();
			$obCache->CleanDir("", "html_pages");
			CAllCorp::EnableComposite();
		}

		$APPLICATION->RestartBuffer();
	}

	CJSCore::Init(array("jquery"));
	CAjax::Init();
	$tabControl->Begin();?>
	<form method="post" action="<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
		<?=bitrix_sessid_post();?>
		<?foreach( $arTabs as $key => $arTab ){
			$tabControl->BeginNextTab();
			if( $arTab["SITE_ID"] ){
				foreach( $arTab["OPTIONS"] as $arOption ){
					$arOption[0] =  $arOption[0]."_".$arTab["SITE_ID"];
					__AdmSettingsDrawRow_EX("aspro.allcorp", $arOption, $arTab["SITE_ID"]);
				}	
			}
		}?>


		<?if( $REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid() ){
			if( strlen($Update)>0 && strlen($_REQUEST["back_url_settings"]) > 0 )
				LocalRedirect($_REQUEST["back_url_settings"]);
			else
				LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());	
		}
		$tabControl->Buttons();?>
		<input <?if( $RIGHT < "W" ) echo "disabled" ?> type="submit" name="Apply" class="submit-btn" value="<?=GetMessage("MAIN_OPT_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">
		
		<?if( strlen($_REQUEST["back_url_settings"]) > 0 ){?>
			<input type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?=htmlspecialchars(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
			<input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
		<?}?>
		
		<?if(CAllCorp::IsCompositeEnabled()):?>
			<div class="adm-info-message"><?=GetMessage("WILL_CLEAR_HTML_CACHE_NOTE")?></div><div style="clear:both;"></div>
			<script type="text/javascript">
			$(document).ready(function() {
				$('input[name^="THEME_SWITCHER"]').change(function() {
					var ischecked = $(this).attr('checked');
					if(typeof(ischecked) != 'undefined'){
						if(!confirm("<?=GetMessage("NO_COMPOSITE_NOTE")?>")){
							$(this).removeAttr('checked');
						}
					}
				});
			});
			</script>
		<?endif;?>
	</form>
	<?$tabControl->End();?>
<?}else{?>
	<?=CAdminMessage::ShowMessage(GetMessage('NO_RIGHTS_FOR_VIEWING'));?>
<?}?>