<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/search/prolog.php");
IncludeModuleLangFile(__FILE__);
/** @global CMain $APPLICATION */
global $APPLICATION;
/** @var CAdminMessage $message */
//$searchDB = CDatabase::GetModuleConnection('search');

$module_id = "mibok.glaza";

$POST_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($POST_RIGHT=="D"){
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

function CheckFilter()
{
  global $FilterArr, $lAdmin;
  foreach ($FilterArr as $f) global $$f;
  return count($lAdmin->arFilterErrors)==0; 
}

$sTableID = "tbl_templ"; 
$oSort = new CAdminSorting($sTableID, "ID", "desc"); 
$lAdmin = new CAdminList($sTableID, $oSort); 


$FilterArr = Array(
  "find",
  //"find_type",
  "find_id",
  "find_active"
  );


$lAdmin->InitFilter($FilterArr);


if (CheckFilter())
{

  $arFilter = Array(
    "ID"    => ($find!="" && $find_type == "id"? $find:$find_id),
    "ACTIVE"  => $find_active
  );
}


if($lAdmin->EditAction() && $POST_RIGHT=="W")
{

  foreach($FIELDS as $ID=>$arFields)
  {
    if(!$lAdmin->IsUpdated($ID))
      continue;
    
   
    $DB->StartTransaction();
    $ID = IntVal($ID);
    $cData = new MibokSpecialExclusion;
    if(($rsData = $cData->GetByID($ID)) && ($arData = $rsData->Fetch()))
    {
      foreach($arFields as $key=>$value)
        $arData[$key]=$value;
      if(!$cData->Update($ID, $arData))
      {
        $lAdmin->AddGroupError(GetMessage("rub_save_error")." ".$cData->LAST_ERROR, $ID);
        $DB->Rollback();
      }
    }
    else
    {
      $lAdmin->AddGroupError(GetMessage("rub_save_error")." ".GetMessage("rub_no_rubric"), $ID);
      $DB->Rollback();
    }
    $DB->Commit();
  }
}


if(($arID = $lAdmin->GroupAction()) && $POST_RIGHT=="W")
{
 
  if($_REQUEST['action_target']=='selected')
  {
    $cData = new MibokSpecialExclusion;
    $rsData = $cData->GetList(array($by=>$order), $arFilter);
    while($arRes = $rsData->Fetch())
      $arID[] = $arRes['ID'];
  }

  
  foreach($arID as $ID)
  {
    if(strlen($ID)<=0)
      continue;
       $ID = IntVal($ID);
    
   
    switch($_REQUEST['action'])
    {
    
    case "delete":
      @set_time_limit(0);
      $DB->StartTransaction();
      if(!MibokSpecialExclusion::Delete($ID))
      {
        $DB->Rollback();
        $lAdmin->AddGroupError(GetMessage("rub_del_err"), $ID);
      }
      $DB->Commit();
      break;
    
   
    case "activate":
    case "deactivate":
      $cData = new MibokSpecialExclusion;
      if(($rsData = $cData->GetByID($ID)) && ($arFields = $rsData->Fetch()))
      {
        $arFields["ACTIVE"]=($_REQUEST['action']=="activate"?"Y":"N");
        if(!$cData->Update($ID, $arFields))
          $lAdmin->AddGroupError(GetMessage("rub_save_error").$cData->LAST_ERROR, $ID);
      }
      else
        $lAdmin->AddGroupError(GetMessage("rub_save_error")." ".GetMessage("rub_no_rubric"), $ID);
      break;
    }
  }
}


$cData = new MibokSpecialExclusion;
$rsData = $cData->GetList(array($by=>$order), $arFilter);


$rsData = new CAdminResult($rsData, $sTableID);


$rsData->NavStart();



$lAdmin->NavText($rsData->GetNavPrint(GetMessage("rub_nav")));



$lAdmin->AddHeaders(array(
  array(  "id"    =>"ID",
    "content"  =>"ID",
    "sort"    =>"id",
    "align"    =>"right",
    "default"  =>true,
  ),
  array(  "id"    =>"ACTIVE",
    "content"  =>GetMessage("POST_F_ACTIVE"),
    "sort"    =>"active",
    "default"  =>true,
  ),
  array(  "id"    =>"COMPONENT",
    "content"  =>GetMessage("POST_F_COMPONENT"),
    "sort"    => "component",
    "default"  => true,
  ),
  array(  "id"    =>"TEMPLATE",
    "content"  =>GetMessage("POST_F_TEMPLATE"),
    "sort"    => false,
    "default"  => true,
  ),
  array(  "id"    =>"MESSAGE",
    "content"  =>GetMessage("POST_F_MESSAGE"),
    "sort"    => false,
    "default"  => true,
  ),
));




while($arRes = $rsData->NavNext(true, "f_")):
	/*$rstempl = CEventMessage::GetList($by="id", $order="asc", array('ID' => $f_EVENT_MESSAGE_ID));
	if ($artempl = $rstempl->Fetch())
	{
		$f_EVENT_MESSAGE_NAME = "[".$artempl['ID']."] ".$artempl['SUBJECT'];
	}*/
	
	$row =& $lAdmin->AddRow($f_ID, $arRes); 

    

	//$row->AddViewField('EVENT_MESSAGE_ID', $f_EVENT_MESSAGE_NAME);
    if($arRes['DEFINED_VALUE'] == 'N')
    {
        $row->AddInputField("COMPONENT", array("size"=>20));
        $row->AddInputField("TEMPLATE", array("size"=>20));
        $sHTML = '<textarea rows="10" cols="20" name="FIELDS['.$f_ID.'][MESSAGE]">'.htmlspecialcharsex($f_MESSAGE).'</textarea>';
        $row->AddEditField("MESSAGE", $sHTML);
    }
	$row->AddCheckField("ACTIVE"); 


	
	$arActions = Array();

	
	$arActions[] = array(
	"ICON"=>"edit",
	"DEFAULT"=>true,
	"TEXT"=>GetMessage("EDIT"),
	"ACTION"=>$lAdmin->ActionRedirect("mibok.glaza_exclusion_edit.php?ID=".$f_ID)
	);

	
	if ($POST_RIGHT>="W" && $arRes['DEFINED_VALUE'] == 'N')
	$arActions[] = array(
	  "ICON"=>"delete",
	  "TEXT"=>GetMessage("DELETE"),
	  "ACTION"=>"if(confirm('".GetMessage('DELETE_CONF')."')) ".$lAdmin->ActionDoGroup($f_ID, "delete")
	);

	
	$arActions[] = array("SEPARATOR"=>true);


	
	if(is_set($arActions[count($arActions)-1], "SEPARATOR"))
	unset($arActions[count($arActions)-1]);

	
	$row->AddActions($arActions);

endwhile;


$lAdmin->AddFooter(
  array(
    array("title"=>GetMessage("MAIN_ADMIN_LIST_SELECTED"), "value"=>$rsData->SelectedRowsCount()), 
    array("counter"=>true, "title"=>GetMessage("MAIN_ADMIN_LIST_CHECKED"), "value"=>"0"), 
  )
);


$lAdmin->AddGroupActionTable(Array(
  /*"delete"=>GetMessage("MAIN_ADMIN_LIST_DELETE"), */
  "activate"=>GetMessage("MAIN_ADMIN_LIST_ACTIVATE"), 
  "deactivate"=>GetMessage("MAIN_ADMIN_LIST_DEACTIVATE"), 
  ));


  

$aContext = array(
  array(
    "TEXT"=>GetMessage("POST_ADD"),
    "LINK"=>"mibok.glaza_exclusion_edit.php?lang=".LANG,
    "TITLE"=>GetMessage("POST_ADD_TITLE"),
    "ICON"=>"btn_new",
  ),
);


$lAdmin->AddAdminContextMenu($aContext);




$lAdmin->CheckListMode();


$APPLICATION->SetTitle(GetMessage("SPECIAL_TITLE"));


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");




$oFilter = new CAdminFilter(
  $sTableID."_filter",
  array(
    "ID",
    GetMessage("rub_f_site"),
    GetMessage("rub_f_active"),
    GetMessage("rub_f_public"),
    GetMessage("rub_f_auto"),
  )
);

$lAdmin->DisplayList();
?>

<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>