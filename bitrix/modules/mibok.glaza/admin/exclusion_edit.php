<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); 
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/search/prolog.php");
IncludeModuleLangFile(__FILE__);
/** @global CMain $APPLICATION */
global $APPLICATION;
/** @var CAdminMessage $message */
//$searchDB = CDatabase::GetModuleConnection('search');

$module_id = "mibok.glaza";

$POST_RIGHT = $APPLICATION->GetGroupRight(ADMIN_MODULE_NAME);

if ($POST_RIGHT == "D")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));


$aTabs = array(
  array("DIV" => "edit1", "TAB" => GetMessage("POST_F_PARAM"), "ICON"=>"main_user_edit", "TITLE"=>GetMessage("POST_F_PARAM_TITLE"))
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$ID = intval($ID);		
$message = null;		
$bVarsFromForm = false; 


 //MibokSpecialExclusion::ExclusionTemplate('gosportal', 'informers', '.default');



if(
	$REQUEST_METHOD == "POST" 
	&&
	($save!="" || $apply!="") 
	&&
	$POST_RIGHT=="W"         
	&&
	check_bitrix_sessid()    
)
{
  $templateComp = new MibokSpecialExclusion();

  $arFields = Array(
    "ACTIVE"  => ($ACTIVE <> "Y"? "N":"Y"),
    "COMPONENT" => $COMPONENT,
    "TEMPLATE" => $TEMPLATE,
    "MESSAGE" => $MESSAGE
  );

     
  if($ID > 0)
  {
    $res = $templateComp->Update($ID, $arFields);
  }
  else
  {
    
    $ID = $templateComp->Add($arFields);
    $res = ($ID > 0);
  }
  if($res)
  {
    
    if($arFields['ACTIVE'] == 'Y')
    {

        if(empty($arFields['COMPONENT']) && empty($arFields['TEMPLATE']) && $ID > 0)
        {
            $templateComp = MibokSpecialExclusion::GetByID($ID);
            if($templateComp->ExtractFields("str_"))
            {
                $tempComp = explode(':', $str_COMPONENT);
                MibokSpecialExclusion::ExclusionTemplate($tempComp[0], $tempComp[1], $str_TEMPLATE);
            }

        }
        else
        {
            $tempComp = explode(':', $arFields["COMPONENT"]);
            MibokSpecialExclusion::ExclusionTemplate($tempComp[0], $tempComp[1], $arFields["TEMPLATE"]);
        }
    }
    else
    {
        if(empty($arFields['COMPONENT']) && empty($arFields['TEMPLATE']) && $ID > 0)
        {
            $templateComp = MibokSpecialExclusion::GetByID($ID);
            if($templateComp->ExtractFields("str_"))
            {
                $tempComp = explode(':', $str_COMPONENT);
                MibokSpecialExclusion::UnExclusionTemplate($tempComp[0], $tempComp[1], $str_TEMPLATE);
            }

        }
        else
        {
            $tempComp = explode(':', $arFields["COMPONENT"]);
            MibokSpecialExclusion::UnExclusionTemplate($tempComp[0], $tempComp[1], $arFields["TEMPLATE"]);
        }
    }
    if ($apply != "")
        LocalRedirect("/bitrix/admin/mibok.glaza_exclusion_edit.php?ID=".$ID."&mess=ok&lang=".LANG."&".$tabControl->ActiveTabParam());
    else
        LocalRedirect("/bitrix/admin/mibok.glaza_exclusion.php?lang=".LANG);

  }
  else
  {
   
    if($e = $APPLICATION->GetException())
      $message = new CAdminMessage(GetMessage("rub_save_error"), $e);
    $bVarsFromForm = true;
  }
}
ClearVars();

$str_ACTIVE        = "Y";
$str_TEMPLATE = $TEMPLATE;
$str_COMPONENT = $COMPONENT;
$str_MESSAGE = $MESSAGE;



if($ID>0)
{
	$templateComp = MibokSpecialExclusion::GetByID($ID);
	if(!$templateComp->ExtractFields("str_"))
		$ID = 0;
}

$bEvTpl = false;



/*if($ID>0)
{
	$em = CEventMessage::GetByID($str_TEMPLATE);
	if(!$em->ExtractEditFields("evTpl_"))
	{
		$evTpl_MESSAGE = GetMessage('ERROR_COMPONENT_TEMPL');
		$bEvTpl = true;
	}
}*/


if (!empty($_REQUEST['COMPONENT']))
		$COMPONENT = $_REQUEST['COMPONENT'];
else
	$COMPONENT = $str_COMPONENT;
	
if(!empty($_REQUEST['COMPONENT_TEMPL']))
	$TEMPLATE_ID = $_REQUEST['COMPONENT_TEMPL'];
else
	$TEMPLATE_ID = $str_TEMPLATE;



$event_type_ref = array();
$arEventType = array();

$rsType = CEventType::GetList(array("LID"=>LANGUAGE_ID), array("id"=>"asc"));
while ($arType = $rsType->Fetch())
{
	$arType["NAME"] = $arType["NAME"]." [".$arType["COMPONENT"]."]";
	$event_type_ref[$arType["COMPONENT"]] = $arType;
	$arEventType[] = $arType;
}


if(empty($COMPONENT))
	$COMPONENT = $arEventType[0]['COMPONENT'];


$event_templ_ref = array();
$arEventTempl = array();
$rstempl = CEventMessage::GetList($by="id", $order="asc", array('TYPE_ID' => $COMPONENT, 'ACTIVE' => 'Y'));
while ($artempl = $rstempl->Fetch())
{
	$artempl["NAME"] = "[".$artempl['ID']."] ".$artempl['SUBJECT'];
	$event_templ_ref[$artempl['ID']] = $artempl;
	$arEventTempl[] = $artempl;
}


if(empty($TEMPLATE_ID))
	$TEMPLATE_ID = $arEventTempl[0]['ID'];


if($bVarsFromForm)
  $DB->InitTableVarsForEdit("mibok_glaza_exclusion", "", "str_");


$APPLICATION->SetTitle(($ID>0? GetMessage("TITLE_EDIT") : GetMessage("TITLE_ADD")));


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");


$aMenu = array(
  array(
    "TEXT"=>GetMessage("BACK_LIST"),
    "TITLE"=>GetMessage("BACK_LIST_EDIT"),
    "LINK"=>"mibok.glaza_exclusion.php?lang=".LANG,
    "ICON"=>"btn_list",
  )
);

if($ID>0)
{
  $aMenu[] = array("SEPARATOR"=>"Y");
  $aMenu[] = array(
    "TEXT"=>GetMessage("BTN_ADD"),
    "TITLE"=>GetMessage("BTN_ADD"),
    "LINK"=>"mibok.glaza_exclusion_edit.php?lang=".LANG,
    "ICON"=>"btn_new",
  );
  if($str_DEFINED_VALUE == 'N')
  {
    $aMenu[] = array(
      "TEXT"=>GetMessage("BTN_DEL"),
      "TITLE"=>GetMessage("BTN_DEL_TILE"),
      "LINK"=>"javascript:if(confirm('".GetMessage("rubric_mnu_del_conf")."'))window.location='mibok.glaza_exclusion.php?ID=".$ID."&action=delete&lang=".LANG."&".bitrix_sessid_get()."';",
      "ICON"=>"btn_delete",
    );
  }
}


$context = new CAdminContextMenu($aMenu);


$context->Show();
?>

<?

if($_REQUEST["mess"] == "ok" && $ID>0)
  CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("rub_saved"), "TYPE"=>"OK"));

if($message)
  echo $message->Show();
elseif($templateComp->LAST_ERROR!="")
  CAdminMessage::ShowMessage($templateComp->LAST_ERROR);
?>

<?

?>
<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">

<?// проверка идентификатора сессии ?>
<?echo bitrix_sessid_post();?>
<input type="hidden" name="lang" value="<?echo LANG?>" />
<input type="hidden" name="ID" value="<?echo $ID?>" />
<input type="hidden" name="COPY_ID" value="<?echo $COPY_ID?>" />
<input type="hidden" name="type" value="<?echo htmlspecialcharsbx($_REQUEST["type"])?>" />


<?

$tabControl->Begin();
?>
<?

$tabControl->BeginNextTab();
?>
    <tr>
        <td width="40%"><?echo GetMessage("POST_F_ACTIVE")?></td>
        <td width="60%"><input type="checkbox" name="ACTIVE" value="Y"<?if($str_ACTIVE == "Y") echo " checked"?>></td>
    </tr>
    <?if($str_DEFINED_VALUE == 'Y' && isset($str_DEFINED_VALUE)):?>
        <tr class="heading">
            <td colspan="2"><?=GetMessage("MSG_DEFINED_VALUE")?></td>
        </tr>
        <tr>
            <td><?echo GetMessage("POST_F_COMPONENT")?></td>
            <td><?=$str_COMPONENT?></td>
        </tr>
        <tr>
            <td><?echo GetMessage("POST_F_TEMPLATE")?></td>
            <td><?=$str_TEMPLATE?></td>
        </tr>
        <tr>
            <td><?echo GetMessage("POST_F_MESSAGE")?></td>
            <td><?=$str_MESSAGE?></td>
        </tr>
    <?else:?>
        <tr>
            <td><span class="required">*</span><?echo GetMessage("POST_F_COMPONENT")?></td>
            <td><input type="text" name="COMPONENT" value="<?=$str_COMPONENT?>" onfocus="t=this" style="width:470px"></td>
        </tr>
        <tr>
            <td><span class="required">*</span><?echo GetMessage("POST_F_TEMPLATE")?></td>
            <td><input type="text" name="TEMPLATE" value="<?=$str_TEMPLATE?>" onfocus="t=this" style="width:470px"></td>
        </tr>
        <tr>
            <td><?echo GetMessage("POST_F_MESSAGE")?></td>
            <td><textarea style='width:95%;resize:vertical;' rows="5" name="MESSAGE"><?=$str_MESSAGE?></textarea></td>
        </tr>
    <?endif;?>
<?

$tabControl->Buttons(
  array(
    "disabled"=>($POST_RIGHT<"W"),
    "back_url"=>"mibok.glaza_exclusion.php?lang=".LANG,
    
  )
);
?>
<input type="hidden" name="lang" value="<?=LANG?>">
<?if($ID>0 && !$bCopy):?>
  <input type="hidden" name="ID" value="<?=$ID?>">
  <input type="hidden" name="DEFINED_VALUE" value="<?=$str_DEFINED_VALUE?>">
<?endif;?>
<?

$tabControl->End();
?>

<?

$tabControl->ShowWarnings("post_form", $message);
?>


<?

echo BeginNote();?>
<span class="required">*</span><?echo GetMessage("REQUIRED_FIELDS")?>
<?echo EndNote();?>

<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
