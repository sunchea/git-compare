<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001660208246';
$dateexpire = '001660211846';
$ser_content = 'a:2:{s:7:"CONTENT";s:0:"";s:4:"VARS";a:1:{s:6:"query1";s:139:"$res = CAdminNotify::GetList(array(\'ID\' => \'DESC\'), array());
$arRes = $res->Fetch();
var_dump($arRes);
CAdminNotify::Delete($arRes["ID"]);";}}';
return true;
?>