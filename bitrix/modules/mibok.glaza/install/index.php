<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class mibok_glaza extends CModule
{
	var $MODULE_ID = "mibok.glaza";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function mibok_glaza()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("SCOM_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("SCOM_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("SPER_PARTNER");
		$this->PARTNER_URI = GetMessage("PARTNER_URI");
	}


	function InstallDB($install_wizard = true)
	{
		global $DB, $DBType, $APPLICATION;
        
        $this->errors = false;
		
		$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mibok.glaza/install/db/".$DBType."/install.sql");

		if($this->errors !== false){
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else
		{
			RegisterModule("mibok.glaza");
            RegisterModuleDependences("main", "OnBeforeProlog", "mibok.glaza", "MKSpecial", "ShowPanel");
            RegisterModuleDependences("main", "OnBuildGlobalMenu", "mibok.glaza", "MKSpecial", "OnBuildGlobalMenu");
            RegisterModuleDependences("main", "OnBeforeProlog", "mibok.glaza", "MKSpecial", "OnBeforeProlog");
		}
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		global $DB, $DBType, $APPLICATION;
        
		$this->errors = false;
		
		$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mibok.glaza/install/db/".$DBType."/uninstall.sql");
			$strSql = "SELECT ID FROM b_file WHERE MODULE_ID='mibok.glaza'";
			$rsFile = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
			while($arFile = $rsFile->Fetch()){
				CFile::Delete($arFile["ID"]);
			}
		
		UnRegisterModuleDependences("main", "OnBeforeProlog", "mibok.glaza", "MKSpecial", "ShowPanel"); 
		UnRegisterModuleDependences("main", "OnBuildGlobalMenu", "mibok.glaza", "MKSpecial", "OnBuildGlobalMenu");
		UnRegisterModuleDependences("main", "OnBeforeProlog", "mibok.glaza", "MKSpecial", "OnBeforeProlog");
		MibokSpecialSiteTemplates::DeleteTemplateSpecial();
		UnRegisterModule("mibok.glaza");

		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mibok.glaza/install/components/mibok", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/mibok", true, true);			
		return true;
	}

	function InstallPublic()
	{
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/wizards/mibok/glaza");
        //удаляем все созданные шаблоны
        $skip = array('.', '..');
        $dirTmpl = '/bitrix/templates/';
        $files = scandir($_SERVER['DOCUMENT_ROOT'].$dirTmpl);
        foreach($files as $file) {
            if(!in_array($file, $skip))
            {
                $pos = strpos($file, 'special_mibok');
                if($pos !== false)
                    DeleteDirFilesEx($dirTmpl.$file.'/');
            }
        }
		$dbSite = CSite::GetList($by="sort", $order="desc", Array("ID" => $site_id));
        while($arSite = $dbSite->Fetch())
		{     
			$skip = array('.', '..');
			$dirTmpl = $arSite['ABS_DOC_ROOT'].$arSite['DIR'];
			$files = scandir($dirTmpl);
			foreach($files as $file) {
				if(!in_array($file, $skip))
				{
					if(strpos($file, 'glaza_mibok') !== false )
						DeleteDirFilesEx($arSite['DIR'].$file.'/');
					if(strpos($file, 'glazamibok.menu') !== false)
						unlink($dirTmpl.$file);
				}
			}
			
			
        } 
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;

		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();

		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mibok.glaza/install/step.php");
	}

	function DoUninstall()
	{
		global $APPLICATION, $step;
		
        CAdminNotify::DeleteByModule("mibok.glaza");
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mibok.glaza/install/unstep.php");
	}
}
?>