<?
IncludeModuleLangFile(__FILE__);
class MibokSpecialExclusion
{
	var $LAST_ERROR = "";
	
	function GetList($aSort=Array(), $arFilter=Array())
	{
		$err_mess = "<br>Class: MibokSpecialExclusion<br>File: ".__FILE__."<br>Function: GetList<br>Line: ";
		global $DB, $USER;
		$arSqlSearch = Array();
		$strSqlSearch = "";
		$bIsLang = false;
		
		
			foreach($arFilter as $key=>$val)
			{
				if (!is_array($val) && (strlen($val)<=0 || $val=="NOT_REF"))
					continue;
				switch(strtoupper($key))
				{
					case "ACTIVE":
						$arSqlSearch[] = ($val=="Y") ? "T.ACTIVE = 'Y'" : "T.ACTIVE = 'N'";
						break;
					case "ID":
						$match = ($arFilter[$key."_EXACT_MATCH"]=="N" && $match_value_set) ? "Y" : "N";
						$arSqlSearch[] = GetFilterQuery("T.ID", $val, $match);
						break;
					case "COMPONENT":
						$arSqlSearch[] = "T.COMPONENT = '".$val."'";
						break;
					case "TEMPLATE":
						$arSqlSearch[] = "T.TEMPLATE = '".$val."'";
						break;
				}
			}
			
			$arOrder = array();
			foreach($aSort as $key => $ord)
			{
				$key = strtoupper($key);
				$ord = (strtoupper($ord) <> "ASC"? "DESC": "ASC");
				switch($key)
				{
					case "ID":		$arOrder[$key] = "T.ID ".$ord; break;
					//case "COMPONENT":	$arOrder[$key] = "T.TIMESTAMP_CREATE_X ".$ord; break;
					//case "TEMPLATE":	$arOrder[$key] = "T.TIMESTAMP_CHANGE_X ".$ord; break;
					case "ACTIVE":	$arOrder[$key] = "T.ACTIVE ".$ord; break;
				}
			}
			if(count($arOrder) <= 0)
			{
				$arOrder["ID"] = "T.ID DESC";
			}
			$strSqlOrder = " ORDER BY ".implode(", ", $arOrder);

			$strSqlSearch = GetFilterSqlSearch($arSqlSearch);
			
			$strSql =
				"SELECT T.ID, T.ACTIVE,  T.COMPONENT,  T.TEMPLATE, T.MESSAGE, T.DEFINED_VALUE FROM mibok_special_exclusion T ".
				"WHERE ".
				$strSqlSearch.
				$strSqlOrder;

			$res = $DB->Query($strSql, false, $err_mess.__LINE__);
			$res->is_filtered = (IsFiltered($strSqlSearch));
			return $res;
	}
    
    function GetByID($ID)
	{
		global $DB;
		$ID = intval($ID);

		$strSql =
			"SELECT T.ID, T.ACTIVE,  T.COMPONENT,  T.TEMPLATE, T.MESSAGE, T.DEFINED_VALUE FROM mibok_special_exclusion T ".
			"WHERE T.ID = ".$ID."
		";

		return $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
	}
    
    function CheckFields($arFields, $ID = 0)
	{
		global $DB;
		$this->LAST_ERROR = "";
		$aMsg = array();
        
        if($ID > 0 && $arFields['DEFINED_VALUE'] == 'Y')
        {    
            if(array_key_exists("COMPONENT", $arFields))
            {
                if(strlen($arFields["COMPONENT"])<=0)
                    $aMsg[] = array("id"=>"COMPONENT", "text"=>GetMessage("CLASS_ERROR_COMPONENT"));
                $tempComp = explode(':', $arFields["COMPONENT"]);
                if(count($tempComp) < 2)
                    $aMsg[] = array("id"=>"COMPONENT", "text"=>GetMessage("CLASS_ERROR_COMPONENT_WRITE"));
                else
                {
                    if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$tempComp[0]))
                        $aMsg[] = array("id"=>"COMPONENT", "text"=>GetMessage("CLASS_ERROR_COMPONENT_NAMESPACE"));
                    elseif(!is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$tempComp[0].'/'.$tempComp[1]))
                        $aMsg[] = array("id"=>"COMPONENT", "text"=>GetMessage("CLASS_ERROR_COMPONENT_NAME"));
                }
            }
            if(array_key_exists("TEMPLATE", $arFields))
            {
                if(strlen($arFields["TEMPLATE"])<=0)
                    $aMsg[] = array("id"=>"TEMPLATE", "text"=>GetMessage("CLASS_ERROR_TEMPLATE"));
            }
        }
		if(!empty($aMsg))
		{
			$e = new CAdminException($aMsg);
			$GLOBALS["APPLICATION"]->ThrowException($e);
			$this->LAST_ERROR = $e->GetString();
			return false;
		}

		return true;
	}
    
    function Update($ID, $arFields)
	{
		global $DB, $USER;
		$ID = intval($ID);
		
		if(!$this->CheckFields($arFields, $ID))
			return false;
		$strUpdate = $DB->PrepareUpdate("mibok_special_exclusion", $arFields);
		if($strUpdate!="")
		{
			$strSql = "UPDATE mibok_special_exclusion SET ".$strUpdate." WHERE ID=".$ID;
			$arBinds = array("MESSAGE" => $arFields["MESSAGE"]);
			if(!$DB->QueryBind($strSql, $arBinds))
				return false;
		}
		return true;
	}
	
	function Add($arFields)
	{
		global $DB;

		if(!$this->CheckFields($arFields))
			return false;

		$ID = $DB->Add("mibok_special_exclusion", $arFields, Array("MESSAGE"));
		return $ID;
	}
	
	function Delete($ID)
	{
		global $DB;

		if (!empty($ID))
		{
			return $DB->Query("DELETE FROM mibok_special_exclusion WHERE ID = ".$ID, true);
		}
		return false;
	}
    
    function ExclusionTemplate($namespace, $component, $template)
    {
        $arTemplate = MibokSpecialSiteTemplates::GetList();
        foreach($arTemplate as $arSiteTemplatesItem)
        {
            if(MKSpecial::CheckSpecialTemplate($arSiteTemplatesItem['TEMPLATE']))
            {
                if(isset($arSiteTemplatesItem['COMPONENTS_PATH']) && !empty($arSiteTemplatesItem['COMPONENTS_PATH']))
                {
                    if(!is_dir($arSiteTemplatesItem['COMPONENTS_PATH']))
                        mkdir($arSiteTemplatesItem['COMPONENTS_PATH'], 0777, true);
                }
                if(!is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace))
                    mkdir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace, 0777, true);
                if(!is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component))
                    mkdir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component, 0777, true);
                if(!is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template))
                {
                    //mkdir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component, 0777, true);
                    MibokSpecialUtil::CopyDir($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/mibok.glaza/install/templates/component/.default', $arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template);
                }
                else
                {
                    if (is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template.'_exclusion'))
                        MibokSpecialUtil::RemoveDir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template.'_exclusion');
                    rename($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template, $arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template.'_exclusion');
                    MibokSpecialUtil::CopyDir($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/mibok.glaza/install/templates/component/.default', $arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template);
                }
            }
        }
    }
    
    function UnExclusionTemplate($namespace, $component, $template)
    {
        $arTemplate = MibokSpecialSiteTemplates::GetList();
        foreach($arTemplate as $arSiteTemplatesItem)
        {
            if(MKSpecial::CheckSpecialTemplate($arSiteTemplatesItem['TEMPLATE']))
            {
                if(isset($arSiteTemplatesItem['COMPONENTS_PATH']) && !empty($arSiteTemplatesItem['COMPONENTS_PATH']))
                {
                    /*if(is_dir($arSiteTemplatesItem['COMPONENTS_PATH']) 
                        &&  is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace)
                        &&  is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component)
                        &&  is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template)*/
                    if(is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template.'_exclusion'))
                    {
                        if(is_dir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template))  
                            MibokSpecialUtil::RemoveDir($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template);
                        rename($arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template.'_exclusion', $arSiteTemplatesItem['COMPONENTS_PATH'].'/'.$namespace.'/'.$component.'/'.$template);
                    }
                }

            }
        }
    }
    
    function GenerateExlusion()
    {
        
        $dbRes = self::GetList(array('ID' => 'asc'));
        while($arRes = $dbRes->Fetch())
        {
            $tempComp = explode(':', $arRes["COMPONENT"]);
            self::ExclusionTemplate($tempComp[0], $tempComp[1], $arRes["TEMPLATE"]);
        }
    }
    
    /*function CheckDir($name)
    {
        if(is_dir($name)
            return true;
        return false;
    }*/
}
?>