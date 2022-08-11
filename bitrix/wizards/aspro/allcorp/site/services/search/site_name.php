<?
// site name - it`s need!!!
if($wizard->GetVar('siteNameSet', true)){
	$siteName = $wizard->GetVar("siteName");
	COption::SetOptionString("main", "site_name", $siteName);	
	$obSite = new CSite;
	$arFields = array("NAME" => $siteName, "SITE_NAME" => $siteName);			
	$siteRes = $obSite->Update(WIZARD_SITE_ID, $arFields);
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_NAME" => $siteName));
}
?>