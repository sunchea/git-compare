<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/mibok.glaza/include.php");

class WelcomeStep extends CWizardStep
{
    function InitStep()
    {
        $this->SetTitle(GetMessage("WELCOME_STEP_TITLE"));
        $this->SetStepID("welcome_step");
        $this->SetNextStep("select_site");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
    }
    function ShowStep()
    {
        $this->content .= GetMessage("WELCOME_TEXT");        
    }    
}

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep()
	{
		parent::InitStep();                                
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "mibok:glaza";   
                $this->SetPrevStep("welcome_step");
                $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));
                $this->SetNextStep("select_template");
                $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
	}
        function ShowStep()
	{
                $arExcludeTemplate = array('special_mibok', 'special', 'null', 'mobile', 'learning', 'empty');
                $obMibokSite = new MibokSpecialSite('s1', $arExcludeTemplate);
    
		$wizard =& $this->GetWizard();

		$arSites = array(); 
		$arSitesSelect = array(); 
		$db_res = CSite::GetList($by="sort", $order="desc", array("ACTIVE" => "Y"));
		if ($db_res && $res = $db_res->GetNext())
		{
			do 
			{
				$arSites[$res["ID"]] = $res; 
				$arSitesSelect[$res["ID"]] = '['.$res["ID"].'] '.$res["NAME"];
			} while ($res = $db_res->GetNext()); 
		}
		
		$createSite = $wizard->GetVar("createSite"); 
		$createSite = ($createSite == "Y" ? "Y" : "N"); 
		
		
$this->content = 
'<script type="text/javascript">
function SelectCreateSite(element, solutionId)
{
	var container = document.getElementById("solutions-container");
	var nodes = container.childNodes;
	for (var i = 0; i < nodes.length; i++)
	{
		if (!nodes[i].className)
			continue;
		nodes[i].className = "solution-item";
	}
	element.className = "solution-item solution-item-selected";
	var check = document.getElementById("createSite" + solutionId);
	if (check)
		check.checked = true;
}
</script>';
		$this->content .= '<div id="solutions-container">';
			$this->content .= "<div onclick=\"SelectCreateSite(this, 'N');\" ";
				$this->content .= 'class="solution-item'.($createSite != "Y" ? " solution-item-selected" : "").'">'; 
				$this->content .= '<b class="r3"></b><b class="r1"></b><b class="r1"></b>'; 
				$this->content .= '<div class="solution-inner-item">'; 
					$this->content .= $this->ShowRadioField("createSite", "N", (array("id" => "createSiteN", "class" => "solution-radio") + 
						($createSite != "Y" ? array("checked" => "checked") : array()))); 
					$this->content .= '<h4>'.GetMessage("wiz_site_existing").'</h4>'; 
				if (count($arSites) < 2)
					$this->content .= '<p>'.GetMessage("wiz_site_existing_title").' '.implode("", $arSitesSelect).'</p>'; 
				else
				{
					$this->content .= '<p>'.GetMessage("wiz_site_existing_title");
					$this->content .= "<br />". $this->ShowSelectField("siteID", $arSitesSelect)."</p>";
				}
				$this->content .= '</div>'; 
				$this->content .= '<b class="r1"></b><b class="r1"></b><b class="r3"></b>'; 
			$this->content .= '</div>';		
		$this->content .= '</div>';
	}
}

class SelectTemplateStep extends CSelectTemplateWizardStep
{
	function InitStep()
	{
                $this->SetStepID("select_template");
                $this->SetTitle(GetMessage("SELECT_TEMPLATE_TITLE"));
		$this->SetSubTitle(GetMessage("SELECT_TEMPLATE_SUBTITLE"));
		$this->SetPrevStep("select_site");
		$this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));
                $this->SetNextStep("site_settings");
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
	}
        function ShowStep()
	{                
		$wizard =& $this->GetWizard();
                
                $arTemplatesBitr = array();
                $arTemplatesLocal = array();
                if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'))
                {
                    $templatesPath = WizardServices::GetTemplatesPath('/bitrix');            
                    $arTemplatesBitr = WizardServices::GetTemplates($templatesPath);
                }
                if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'))
                {
                    $templatesPath = WizardServices::GetTemplatesPath('/local');            
                    $arTemplatesLocal = WizardServices::GetTemplates($templatesPath);
                }
                $arTemplatesAll = array_merge($arTemplatesBitr, $arTemplatesLocal);
                
                $arSiteTemplates = MibokSpecialSiteTemplates::GetList($wizard->GetVar('siteID'));
                

//                p('$arSiteTemplates');
//                p($arSiteTemplates);
                
                
                foreach($arSiteTemplates as $arSiteTemplatesItem){
                    $arSiteTemplatesName[] = $arSiteTemplatesItem['TEMPLATE'];
                }
                foreach($arTemplatesAll as $template_name=>$arTemplatesAllItem){
                    if(in_array($template_name, $arSiteTemplatesName)){
                        $arTemplates[$template_name] = $arTemplatesAllItem;
                    }
                }                                
                
		if (empty($arTemplates))
			return;

		$templateID = $wizard->GetVar("templateID");
		if(isset($templateID) && array_key_exists($templateID, $arTemplates)){
		
			$defaultTemplateID = $templateID;
			$wizard->SetDefaultVar("templateID", $templateID);
			
		} else {
		
			$defaultTemplateID = COption::GetOptionString("main", "wizard_template_id", "", $wizard->GetVar("siteID")); 
			if (!(strlen($defaultTemplateID) > 0 && array_key_exists($defaultTemplateID, $arTemplates)))
			{
				if (strlen($defaultTemplateID) > 0 && array_key_exists($defaultTemplateID, $arTemplates))
					$wizard->SetDefaultVar("templateID", $defaultTemplateID);
				else
					$defaultTemplateID = "";
			}
		}

		global $SHOWIMAGEFIRST;
		$SHOWIMAGEFIRST = true;
		
		$this->content .= '<div id="solutions-container" class="inst-template-list-block">';
		foreach ($arTemplates as $templateID => $arTemplate)
		{
			if ($defaultTemplateID == "")
			{
				$defaultTemplateID = $templateID;
				$wizard->SetDefaultVar("templateID", $defaultTemplateID);
			}

			$this->content .= '<div class="inst-template-description">';
			$this->content .= $this->ShowCheckboxField("templateID[]", $templateID, Array("id" => $templateID, "class" => "inst-template-list-inp"));
			if ($arTemplate["SCREENSHOT"] && $arTemplate["PREVIEW"])
				$this->content .= CFile::Show2Images($arTemplate["PREVIEW"], $arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"');
			else
				$this->content .= CFile::ShowImage($arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"', "", true);

			$this->content .= '<label for="'.$templateID.'" class="inst-template-list-label">'.$arTemplate["NAME"].'<p>'.$arTemplate["DESCRIPTION"].'</p></label>';
			$this->content .= "</div>";

		}
		
		$this->content .= '</div>'; 
	}
        
        function OnPostForm()
	{
		$wizard =& $this->GetWizard();
                               
		if ($wizard->IsNextButtonClick())
		{              
                        $arTemplatesBitr = array();
                        $arTemplatesLocal = array();
                        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'))
                        {
                            $templatesPath = WizardServices::GetTemplatesPath('/bitrix');            
                            $arTemplatesBitr = WizardServices::GetTemplates($templatesPath);
                        }
                        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/templates/'))
                        {
                            $templatesPath = WizardServices::GetTemplatesPath('/local');            
                            $arTemplatesLocal = WizardServices::GetTemplates($templatesPath);
                        }
                        $arTemplatesAll = array_merge($arTemplatesBitr, $arTemplatesLocal);
                        
                        
                        $arSiteTemplates = MibokSpecialSiteTemplates::GetList($wizard->GetVar('siteID'));
                        foreach($arSiteTemplates as $arSiteTemplatesItem){
                            $arSiteTemplatesName[] = $arSiteTemplatesItem['TEMPLATE'];
                        }
                        foreach($arTemplatesAll as $template_name=>$arTemplatesAllItem){
                            if(in_array($template_name, $arSiteTemplatesName)){
                                $arTemplates[$template_name] = $arTemplatesAllItem;
                            }
                        }
			$templateID = $wizard->GetVar("templateID");                       
                        $bCheckedTemplate = false;
                        foreach($templateID as $templateIDItem){
                            if (array_key_exists($templateIDItem, $arTemplates)){
                                $bCheckedTemplate = true;
                            }
                        }
                        
			if (!$bCheckedTemplate)
				$this->SetError(GetMessage("wiz_template"));
		}
	}
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "mibok:glaza";
		parent::InitStep();
                
                $this->SetNextStep("data_install");
		$this->SetPrevStep("select_template");
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
		$this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));

		$templateID = $wizard->GetVar("templateID");
		$themeID = $wizard->GetVar($templateID."_themeID");
		$wizard->SetDefaultVars(
			Array(
				"siteSlogan" => GetMessage("WIZ_COMPANY_SLOGAN_DEF"),
                                "siteAddress" => GetMessage("WIZ_COMPANY_ADDRESS_DEF"),
                                "siteEmail" => GetMessage("WIZ_COMPANY_EMAIL_DEF"),
                                "sitePhone" => GetMessage("WIZ_COMPANY_PHONE_DEF"),
				"siteCopy" => GetMessage("WIZ_COMPANY_COPY_DEF"),
			)
		);	
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();							
		
		$this->content .= '<table width="100%" cellspacing="0" cellpadding="0">';
                
                $this->content .= '<tr><td>';
		$this->content .= '<label for="site-slogan">'.GetMessage("WIZ_COMPANY_SLOGAN").'</label><br />';
		$this->content .= $this->ShowInputField("text", "siteSlogan", Array("id" => "site-slogan", "style" => "width:100%"));
		$this->content .= '</tr></td>';
                
                $this->content .= '<tr><td><br /></td></tr>';
		
		$this->content .= '<tr><td>';
		$this->content .= '<label for="site-address">'.GetMessage("WIZ_COMPANY_ADDRESS").'</label><br />';
		$this->content .= $this->ShowInputField("text", "siteAddress", Array("id" => "site-address", "style" => "width:100%"));
		$this->content .= '</tr></td>';
                
                $this->content .= '<tr><td><br /></td></tr>';
                
                $this->content .= '<tr><td>';
		$this->content .= '<label for="site-email">'.GetMessage("WIZ_COMPANY_EMAIL").'</label><br />';
		$this->content .= $this->ShowInputField("text", "siteEmail", Array("id" => "site-email", "style" => "width:100%"));
		$this->content .= '</tr></td>';
                
                $this->content .= '<tr><td><br /></td></tr>';
                
                $this->content .= '<tr><td>';
		$this->content .= '<label for="site-phone">'.GetMessage("WIZ_COMPANY_PHONE").'</label><br />';
		$this->content .= $this->ShowInputField("text", "sitePhone", Array("id" => "site-phone", "style" => "width:100%"));
		$this->content .= '</tr></td>';

		$this->content .= '<tr><td><br /></td></tr>';
		
		$this->content .= '<tr><td>';
		$this->content .= '<label for="site-copy">'.GetMessage("WIZ_COMPANY_COPY").'</label><br />';
		$this->content .= $this->ShowInputField("text", "siteCopy", Array("id" => "site-copy", "style" => "width:100%"));
		$this->content .= '</tr></td>';

		$this->content .= '<tr><td><br /></td></tr>';

		$this->content .= '</table>';
                
                //$this->content .= "<pre>".print_r($wizard->GetVars(), true)."</pre>";

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}

	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
		//$res = $this->SaveFile("siteLogo", Array("extensions" => "gif,jpg,jpeg,png", "max_height" => 210, "max_width" => 60, "make_preview" => "Y"));
//		COption::SetOptionString("main", "wizard_site_logo", $res, "", $wizard->GetVar("siteID")); 
	}
}

	





class DataInstallStep extends CDataInstallWizardStep
{
	function CorrectServices(&$arServices)
	{
		$wizard =& $this->GetWizard();
		if($wizard->GetVar("installDemoData") != "Y")
		{
		}
	}
}

class FinishStep extends CFinishWizardStep
{
    function CreateNewIndex()
    {

    }
    
    function ShowStep()
	{
		$wizard =& $this->GetWizard();
		
		$siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
		$rsSites = CSite::GetByID($siteID);
		$siteDir = "/"; 
		if ($arSite = $rsSites->Fetch())
			$siteDir = $arSite["DIR"]; 

		$wizard->SetFormActionScript(str_replace("//", "/", $siteDir."/?special_version=Y"));

		$this->CreateNewIndex();
		
		COption::SetOptionString("main", "wizard_solution", $wizard->solutionName, false, $siteID); 
		
		$this->content .= GetMessage("FINISH_STEP_CONTENT");
		
		if ($wizard->GetVar("installDemoData") == "Y")
			$this->content .= GetMessage("FINISH_STEP_REINDEX");		
		
	}
}
?>