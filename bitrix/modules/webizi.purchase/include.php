<?
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

define("webizi.purchase_DEMO", "Y");

CModule::AddAutoloadClasses(
    'webizi.purchase',
    array(
        'WIEvents' => 'classes/wievents.php',
        )
);

class WIPurchase
{
	private $isLegal = 0;

	public function __construct()
	{
		$this->CheckModule();
		$this->jqueryEnable();
		$this->UikitEnable();
	}

	private function CheckModule()
	{
		Loc::loadMessages( __FILE__);
		if (!ModuleManager::isModuleInstalled("webizi.purchase")
			|| Loader::includeSharewareModule("webizi.purchase") === 0
			|| Loader::includeSharewareModule("webizi.purchase") == 3)
		{
			echo GetMessage("WI_MODULE_INCLUDE_ERROR");
			return false;
			die();
		} else {
			$this->isLegal = 1;
		}
	}

	public function GetPurchase($json, $page, $param)
	{
		if ($this->isLegal)
			return $this->GetAll($json, $page, $param);
		else
			return die();
	}

	private function UikitEnable()
	{
		if ($GLOBALS["arParams"]["USE_UIKIT"]) {
			$GLOBALS["APPLICATION"]->SetAdditionalCSS($GLOBALS["arResult"]["TEMPLATE_FOLDER"].'/uikit/uikit.min.css');
			$GLOBALS["APPLICATION"]->SetAdditionalCSS($GLOBALS["arResult"]["TEMPLATE_FOLDER"].'/uikit/datepicker.min.css');
			$GLOBALS["APPLICATION"]->AddHeadScript($GLOBALS["arResult"]["TEMPLATE_FOLDER"].'/uikit/uikit.min.js');
			$GLOBALS["APPLICATION"]->AddHeadScript($GLOBALS["arResult"]["TEMPLATE_FOLDER"].'/uikit/datepicker.min.js');
		}

		return true;
	}

	private function jqueryEnable()
	{
		if ($GLOBALS["arParams"]["USE_JQUERY"]) {
			$GLOBALS["APPLICATION"]->AddHeadScript($GLOBALS["arResult"]["TEMPLATE_FOLDER"].'/jquery/jquery-1.11.2.min.js');
		}

		return true;
	}

	private function GetAll($json, $page = 1, $param = "ALL")
	{
		if (!$this->isLegal)
			return;
		
		global $USER, $DB;
		$arResult = $GLOBALS["arResult"];
		$arParams = $GLOBALS["arParams"];
		$obCache = new CPHPCache;
		$cachePath = '/wi/cache/WIPurchase_GetAll';

		if (!is_array($json))
			$json = array();

		$cacheId = implode(',', $json).','.$arParams["PUR_COUNT"].$arResult["ID"].$page.$param.$USER->GetUserGroupString();
		
		if ($obCache->InitCache($arParams["TIME_CACHE"], $cacheId, $cachePath) && $arParams["USE_CACHE"])
		{
			$vars = $obCache->GetVars();
			return json_encode($vars["WIPurchase_GetAll"]);
		} else {
			$arPurchase = array();
			$arrFilter = array();

			foreach ($json as $key => $value) {
				if ($paramkey = array_search($key, $arResult["PARAM"])) {
					switch ($paramkey) {
						case 'NAME':
						case 'DETAIL_TEXT':
						$arrFilter[$key] = "%" . $value . "%";
						break;

						case 'START_DATE':
						$arrFilter[">=".$key] = date((stripos($key, 'PROPERTY_') === 0) ? "Y-m-d H:i:s" : $DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), strtotime($value . "00:00:00"));
						break;
						case 'END_DATE':
						$arrFilter["<=".$key] = date((stripos($key, 'PROPERTY_') === 0) ? "Y-m-d H:i:s" : $DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), strtotime($value . "23:59:59"));
						break;
					}
				} else {
					$arrFilter[$key] = $value;
				}
			}

			$obCache->StartDataCache($arParams["TIME_CACHE"], $cacheId, $cachePath);
			
			switch ($param)
			{
				case "ALL":
				$arPurchase['NOW'] = $this->Get($arrFilter, Array($arResult["PARAM"]["COMPLETED"] => false), $page);
				$arPurchase['OLD'] = $this->Get($arrFilter, Array("!".$arResult["PARAM"]["COMPLETED"] => false), $page);
				break;

				case "NOW":
				$arPurchase['NOW'] = $this->Get($arrFilter, Array($arResult["PARAM"]["COMPLETED"] => false), $page);
				break;

				case "OLD":
				$arPurchase['OLD'] = $this->Get($arrFilter, Array("!".$arResult["PARAM"]["COMPLETED"] => false), $page);
				break;
			}

			if ($arParams["USE_CACHE"])
				$obCache->EndDataCache(array("WIPurchase_GetAll" => $arPurchase));

			return json_encode($arPurchase);			
		}
	}

	private function Get($arrFilter, $dateParam, $page)
	{
		if (!$this->isLegal)
			return;

		$arResult = $GLOBALS["arResult"];
		$arParams = $GLOBALS["arParams"];

		if (!is_array($arrFilter))
			$arrFilter = Array();

		if (!is_array($dateParam))
			$dateParam = Array();

		if (gettype($page) === 'NULL')
			$page = 1;

		if (gettype($dateParam) === 'NULL')
			$dateParam = Array();

		$arPurchase = Array();

		$arSelect = Array(
			"ID",
			"NAME",
			);

		$arFilter = Array("IBLOCK_ID" => $arResult["ID"], "ACTIVE" => "Y");
		$result = CIBlockElement::GetList(
			Array($arResult["PARAM"]["START_DATE"] => "desc"),
			Array_merge($arFilter, $arrFilter, $dateParam),
			false,
			Array("nPageSize" => $arParams["PUR_COUNT"],"iNumPage" => $page),
			array_unique(array_merge($arSelect, array_values($arResult["PARAM"])))
			);
		$elemCount = CIBlockElement::GetList(
			Array(),
			Array_merge($arFilter, $arrFilter, $dateParam),
			Array()
			);

		$arPurchase["COUNT"] = $elemCount;

		if (!$arPurchase["COUNT"])
			return $arPurchase;

		$arFileTemp = Array();

		while($arElement = $result->GetNextElement(false, false))
		{
			$arTemp = Array();
			$arFields = $arElement->GetFields();
			$arFiles = $arFields[$arResult["PARAM"]["ATTACHMENTS"] . "_VALUE"];
			$arTemp["ID"] = $arFields["ID"];

			$arTemp["NAME"] = (stripos($arResult["PARAM"]["NAME"], 'PROPERTY_') === 0)
			? $arFields[$arResult["PARAM"]["NAME"] . "_VALUE"]
			: $arFields[$arResult["PARAM"]["NAME"]];

			$arTemp["TEXT"] = (stripos($arResult["PARAM"]["DETAIL_TEXT"], 'PROPERTY_') === 0)
			? $arFields[$arResult["PARAM"]["DETAIL_TEXT"] . "_VALUE"]
			: $arFields[$arResult["PARAM"]["DETAIL_TEXT"]];

			$arTemp["DFROM"] = (stripos($arResult["PARAM"]["START_DATE"], 'PROPERTY_') === 0)
			? $arFields[$arResult["PARAM"]["START_DATE"] . "_VALUE"]
			: $arFields[$arResult["PARAM"]["START_DATE"]];

			$arTemp["DTO"] = (stripos($arResult["PARAM"]["END_DATE"], 'PROPERTY_') === 0)
			? $arFields[$arResult["PARAM"]["END_DATE"] . "_VALUE"]
			: $arFields[$arResult["PARAM"]["END_DATE"]];

			$arTemp["PUBL_DATE"] = $arFields["DATE_ACTIVE_FROM"];

			$arTemp["PURCHASE_DATE"] = (stripos($arResult["PARAM"]["PURCHASE_DATE"], 'PROPERTY_') === 0)
			? $arFields[$arResult["PARAM"]["PURCHASE_DATE"] . "_VALUE"]
			: $arFields[$arResult["PARAM"]["PURCHASE_DATE"]];

			if (is_array($arFiles) && count($arFiles) > 0) {
				foreach ($arFiles as $value) {
					$arFileTemp[$arFields["ID"]][] = $value;
				}
			} elseif (!is_array($arFiles) && $arFiles != "") {
				$arFileTemp[$arFields["ID"]][] = $arFiles;
			}

			if ($arPurchase["ELEM"][count($arPurchase["ELEM"])-1]["ID"] != $arTemp["ID"])
				$arPurchase["ELEM"][] = $arTemp;
			
		}

		foreach ($arPurchase["ELEM"] as $elemKey => $rsElem) {
			if (isset($arFileTemp[$rsElem["ID"]])) {
				$arPurchase["ELEM"][$elemKey]["ATTACH"] = $this->GetAttach($arFileTemp[$rsElem["ID"]]);
			} else {
				$arPurchase["ELEM"][$elemKey]["ATTACH"] = array();
			}
		}

		return $arPurchase;
	}

	private function GetAttach($FILES)
	{
		$arFilesResult = CFile::GetList(Array(), Array("@ID" => implode(',', $FILES)), Array());

		while ($arFile = $arFilesResult->GetNext(false, false)) {
			$fileTemp = Array();				
			$fileTemp["NAME"] = ($arFile["DESCRIPTION"] != "") ? $arFile["DESCRIPTION"] : $arFile["ORIGINAL_NAME"];
			$fileTemp["SIZE"] = round($arFile["FILE_SIZE"] / 1048576, 2);
			$fileTemp["URL"] = '/upload/' . $arFile["SUBDIR"] . '/' . $arFile["FILE_NAME"];
			$fileTemp["IMG"] = $this->GetExtension($arFile["ORIGINAL_NAME"]);
			$arFileTemp[] = $fileTemp;
		}

		return $arFileTemp;
	}
	
	private function GetExtension($FILE_NAME)
	{
		if (!$this->isLegal)
			return;
		
		$arResult = $GLOBALS["arResult"];

		$file = $arResult["TEMPLATE_FOLDER"] . "/images/purchase_";
		if (strripos($FILE_NAME, '.') !== false) {
			if (file_exists($_SERVER["DOCUMENT_ROOT"] . $file . substr($FILE_NAME, strripos($FILE_NAME, '.') + 1) . ".png")) {
				return $file . substr($FILE_NAME, strripos($FILE_NAME, '.') + 1) . ".png";
			} else {
				return $file . "all.png";
			}
		}
	}
}
?>