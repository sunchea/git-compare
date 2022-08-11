<?
IncludeModuleLangFile( __FILE__);

if(class_exists("webizi_purchase")) 
	return;

Class webizi_purchase extends CModule
{
	var $MODULE_ID = "webizi.purchase";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = "Y";

	function webizi_purchase() 
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)){
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}else{
			$this->MODULE_VERSION = TASKFROMEMAIL_MODULE_VERSION;
			$this->MODULE_VERSION_DATE = TASKFROMEMAIL_MODULE_VERSION_DATE;
		}

		$this->MODULE_NAME = GetMessage("WI_PUR_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("WI_PUR_MODULE_DESCRIPTION");

		$this->PARTNER_NAME = GetMessage("WI_PARTNER_NAME");
		$this->PARTNER_URI  = "http://webizi.ru/";
	}
	
	function InstallDB()
	{
		return true;
	}

	function UnInstallDB()
	{
		return true;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/webizi.purchase/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		RegisterModule("webizi.purchase");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementDelete", "webizi.purchase", "WIEvents", "ClearCache");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", "webizi.purchase", "WIEvents", "ClearCache");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "webizi.purchase", "WIEvents", "ClearCache");
		RegisterModuleDependences("iblock", "OnAfterIBlockPropertyUpdate", "webizi.purchase", "WIEvents", "ClearCache");
		RegisterModuleDependences("iblock", "OnIBlockPropertyDelete", "webizi.purchase", "WIEvents", "ClearCache");
		RegisterModuleDependences("iblock", "OnAfterIBlockPropertyAdd", "webizi.purchase", "WIEvents", "ClearCache");
		return true;
	}
	
	function UnInstallFiles()
	{	
		DeleteDirFilesEx("/bitrix/components/webizi/purchase.main");
		DeleteDirFilesEx("/local/components/webizi/purchase.main");
		DeleteDirFilesEx("/bitrix/cache/wi/cache/");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementDelete", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockPropertyUpdate", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModuleDependences("iblock", "OnIBlockPropertyDelete", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockPropertyAdd", "webizi.purchase", "WIEvents", "ClearCache");
		UnRegisterModule("webizi.purchase");
		return true;
	}

	function DoInstall()
	{
		if (!IsModuleInstalled("webizi.purchase"))
		{
			$this->InstallDB();
			$this->InstallFiles();
		}
		return true;
	}

	function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallFiles();
		return true;
	}
}
?>