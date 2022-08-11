<?
IncludeModuleLangFile(__FILE__);
use \Bitrix\Main\Type\Collection;

// initialize array themes colors
CAllCorp::$arBaseColors = array(
	"color1" => array("COLOR" => "#c21f13", "TITLE" => GetMessage("COLOR_NONAME1")),
	"color2" => array("COLOR" => "#b41818", "TITLE" => GetMessage("COLOR_NONAME2")),
	"color3" => array("COLOR" => "#bd1c3c", "TITLE" => GetMessage("COLOR_NONAME3")),
	"color4" => array("COLOR" => "#5f58ac", "TITLE" => GetMessage("COLOR_NONAME4")),
	"color5" => array("COLOR" => "#00569c", "TITLE" => GetMessage("COLOR_NONAME5")),
	"color6" => array("COLOR" => "#107bb1", "TITLE" => GetMessage("COLOR_NONAME6")),
	"color7" => array("COLOR" => "#0088cc", "TITLE" => GetMessage("COLOR_NONAME7")),
	"color8" => array("COLOR" => "#497c9d", "TITLE" => GetMessage("COLOR_NONAME8")),
	"color9" => array("COLOR" => "#0fa8ae", "TITLE" => GetMessage("COLOR_NONAME9")),
	"color10" => array("COLOR" => "#0d897f", "TITLE" => GetMessage("COLOR_NONAME10")),
	"color11" => array("COLOR" => "#1b9e77", "TITLE" => GetMessage("COLOR_NONAME11")),
	"color12" => array("COLOR" => "#188b30", "TITLE" => GetMessage("COLOR_NONAME12")),
	"color13" => array("COLOR" => "#48a216", "TITLE" => GetMessage("COLOR_NONAME13")),
);

// include common aspro functions
include_once __DIR__.'/php/CCache.php';
include_once __DIR__.'/php/functions.php';

class CAllCorp{
	const partnerName	= "aspro"; 
	const moduleID = "aspro.allcorp";
	const solutionName	= "allcorp"; 	
    const wizardID		= "aspro:allcorp";  
	
	static $arBaseColors = array();
	
	static function GetBaseColorHexByCode($colorCode){
		return (self::$arBaseColors[$colorCode] ? self::$arBaseColors[$colorCode]["COLOR"] : "#0088cc");
	}
	
	function GenerateThemes(){
		if(!class_exists('lessc')){
			include_once __DIR__."/less/lessc.inc.php";
		}
		$less = new lessc;
		try{
			foreach(CAllCorp::$arBaseColors as $colorCode => $arColor){
				$less->setVariables(array("bcolor" => $arColor["COLOR"]));
				$output = $less->compileFile(__DIR__."/less/style.less", $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/aspro-allcorp/themes/".$colorCode."/style.css" );
			}
		}catch(exception $e){
			echo "fatal error: ".$e->getMessage(); die();
		}
	}
	
	
	function Start($siteID){	
		return true;
	}
	
	function ShowPanel(){
		if($GLOBALS["USER"]->IsAdmin() && COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "allcorp"){
			$GLOBALS["APPLICATION"]->SetAdditionalCSS("/bitrix/wizards/aspro/allcorp/css/panel.css"); 
			
			$arMenu = array(
				array(
					"ACTION" => "jsUtils.Redirect([], '".CUtil::JSEscape("/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardSiteID=".SITE_ID."&wizardName=aspro:allcorp&".bitrix_sessid_get())."')",
					"ICON" => "bx-popup-item-wizard-icon",
					"TITLE" => GetMessage("STOM_BUTTON_TITLE_W1"),
					"TEXT" => GetMessage("STOM_BUTTON_NAME_W1"),
				),
			);

			$GLOBALS["APPLICATION"]->AddPanelButton(array(
				"HREF" => "/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardName=aspro:allcorp&wizardSiteID=".SITE_ID."&".bitrix_sessid_get(),
				"ID" => "allcorp_wizard",
				"ICON" => "bx-panel-site-wizard-icon",
				"MAIN_SORT" => 2500,
				"TYPE" => "BIG",
				"SORT" => 10,	
				"ALT" => GetMessage("SCOM_BUTTON_DESCRIPTION"),
				"TEXT" => GetMessage("SCOM_BUTTON_NAME"),
				"MENU" => $arMenu,
			));
		}
	}
	
	function removeDirectory($dir){
		if($objs = glob($dir."/*")){
			foreach($objs as $obj){
				if(is_dir($obj)){
					CAllCorp::removeDirectory($obj);
				}
				else{
					if(!unlink($obj)){
						if(chmod($obj, 0777)){
							unlink($obj);
						}
					}
				}
			}
		}
		if(!rmdir($dir)){
			if(chmod($dir, 0777)){
				rmdir($dir);
			}
		}
	}
	
	function correctInstall(){
		if(COption::GetOptionString("aspro.allcorp", "WIZARD_DEMO_INSTALLED") == "Y"){
			if(CModule::IncludeModule("main")){
				require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/classes/general/wizard.php");
				@set_time_limit(0);
				if(!CWizardUtil::DeleteWizard("aspro:allcorp")){
					if(!DeleteDirFilesEx($_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/aspro/allcorp/")){
						CAllCorp::removeDirectory($_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/aspro/allcorp/");
					}
				}
				UnRegisterModuleDependences("main", "OnBeforeProlog", "aspro.allcorp", "CAllCorp", "correctInstall"); 
				COption::SetOptionString("aspro.allcorp", "WIZARD_DEMO_INSTALLED", "N");
			}
		}  
	}
	
	function newAction($action = "unknown") {
		$socket = fsockopen('bi.aspro.ru', 80, $errno, $errstr, 10);
		if($socket){
			if(CModule::IncludeModule("main")){
				global $APPLICATION;
				require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_client.php");
				$errorMessage = "";
				$serverIP = $_SERVER["HTTP_X_REAL_IP"] ? $_SERVER["HTTP_X_REAL_IP"] : $_SERVER["SERVER_ADDR"];
				$arUpdateList = CUpdateClient::GetUpdatesList($errorMessage, "ru", "Y");
				if(array_key_exists("CLIENT", $arUpdateList) && $arUpdateList["CLIENT"][0]["@"]["LICENSE"]){
					$edition = $arUpdateList["CLIENT"][0]["@"]["LICENSE"];
				}
				else{
					$edition = "UNKNOWN";
				}
				$data = json_encode(array(
					"client" => "aspro",
					"install_date" => date("Y-m-d H:i:s"),
					"solution_code" => "aspro.allcorp",
					"ip" => $serverIP,
					"http_host" => $_SERVER["HTTP_HOST"],
					"bitrix_version" => SM_VERSION,
					"bitrix_edition" => $APPLICATION->ConvertCharset($edition, SITE_CHARSET, "utf-8"),
					"bitrix_key_hash" => md5(CUpdateClient::GetLicenseKey()),
					"site_name" => $APPLICATION->ConvertCharset(COption::GetOptionString("main", "site_name"), SITE_CHARSET, "utf-8"),
					"site_url" => $APPLICATION->ConvertCharset(COption::GetOptionString("main", "server_name"), SITE_CHARSET, "utf-8"),
					"email_default" => $APPLICATION->ConvertCharset(COption::GetOptionString("main", "email_from"), SITE_CHARSET, "utf-8"),
					"action" => $action)
				);						
				fwrite($socket, "POST /rest/bitrix/installs HTTP/1.1\r\n");
				fwrite($socket, "Host: bi.aspro.ru\r\n");
				fwrite($socket,"Content-type: application/x-www-form-urlencoded\r\n");
				fwrite($socket,"Content-length:".strlen($data)."\r\n");
				fwrite($socket,"Accept:*/*\r\n");
				fwrite($socket,"User-agent:Bitrix Installer\r\n");
				fwrite($socket,"Connection:Close\r\n");
				fwrite($socket,"\r\n");
				fwrite($socket,"$data\r\n");
				fwrite($socket,"\r\n");
				$answer = '';
				while(!feof($socket)){$answer.= fgets($socket, 4096);}
				fclose($socket);
			}
		}
	}
	
	function SetJSOptions(){
		$THEME_SWITCHER = trim(COption::GetOptionString("aspro.allcorp", "THEME_SWITCHER", "Y", SITE_ID));
		$COLOR = trim(COption::GetOptionString("aspro.allcorp", "COLOR", "blue", SITE_ID));
		$WIDTH = trim(COption::GetOptionString("aspro.allcorp", "WIDTH", "auto", SITE_ID));
		$MENU = trim(COption::GetOptionString("aspro.allcorp", "MENU", "first", SITE_ID));
		$SIDEMENU = trim(COption::GetOptionString("aspro.allcorp", "SIDEMENU", "left", SITE_ID));
		$PHONE_MASK = trim(COption::GetOptionString("aspro.allcorp", "PHONE_MASK", "+7 (999) 999-99-99", SITE_ID));
		$VALIDATE_PHONE_MASK = trim(COption::GetOptionString("aspro.allcorp", "VALIDATE_PHONE_MASK", "^[+][0-9] [(][0-9]{3}[)] [0-9]{3}[-][0-9]{2}[-][0-9]{2}$", SITE_ID));
		$tmp = trim(COption::GetOptionString("aspro.allcorp", "DATE_FORMAT", "dot", SITE_ID));
		$DATE_MASK = ($tmp == 'DOT' ? 'd.m.y' : ($tmp == 'HYPHEN' ? 'd-m-y' : ($tmp == 'SPACE' ? 'd m y' : ($tmp == 'SLASH' ? 'd/m/y' : 'd:m:y'))));
		$VALIDATE_DATE_MASK = ($tmp == 'DOT' ? '^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$' : ($tmp == 'HYPHEN' ? '^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}$' : ($tmp == 'SPACE' ? '^[0-9]{1,2} [0-9]{1,2} [0-9]{4}$' : ($tmp == 'SLASH' ? '^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$' : '^[0-9]{1,2}\:[0-9]{1,2}\:[0-9]{4}$'))));
		$DATE_PLACEHOLDER = ($tmp == 'DOT' ? GetMessage('DATE_FORMAT_DOT') : ($tmp == 'HYPHEN' ? GetMessage('DATE_FORMAT_HYPHEN') : ($tmp == 'SPACE' ? GetMessage('DATE_FORMAT_SPACE') : ($tmp == 'SLASH' ? GetMessage('DATE_FORMAT_SLASH') : GetMessage('DATE_FORMAT_COLON')))));
		$VALIDATE_FILE_EXT = trim(COption::GetOptionString("aspro.allcorp", "VALIDATE_FILE_EXT", "png|jpe?g|gif|docx?|xlsx?|txt|pdf|odt|rtf", SITE_ID));
		$USE_CAPTCHA_FORM = trim(COption::GetOptionString("aspro.allcorp", "USE_CAPTCHA_FORM", "Y", SITE_ID));
		$CATALOG_INDEX = trim(COption::GetOptionString("aspro.allcorp", "CATALOG_INDEX", "N", SITE_ID));
		$SERVICES_INDEX = trim(COption::GetOptionString("aspro.allcorp", "SERVICES_INDEX", "Y", SITE_ID));
		?>
		<script type="text/javascript">
		var arAllcorpOptions = ({
			"SITE_DIR" : "<?=SITE_DIR?>",
			"SITE_ID" : "<?=SITE_ID?>",
			"SITE_TEMPLATE_PATH" : "<?=SITE_TEMPLATE_PATH?>",
			"THEME" : ({
				"THEME_SWITCHER" : "<?=$THEME_SWITCHER?>",
				"COLOR" : "<?=$COLOR?>",
				"WIDTH" : "<?=$WIDTH?>",
				"MENU" : "<?=$MENU?>",
				"SIDEMENU" : "<?=$SIDEMENU?>",
				"PHONE_MASK" : "<?=$PHONE_MASK?>",
				"VALIDATE_PHONE_MASK" : "<?=$VALIDATE_PHONE_MASK?>",
				"DATE_MASK" : "<?=$DATE_MASK?>",
				"DATE_PLACEHOLDER" : "<?=$DATE_PLACEHOLDER?>",
				"VALIDATE_DATE_MASK" : "<?=($VALIDATE_DATE_MASK)?>",
				"VALIDATE_FILE_EXT" : "<?=$VALIDATE_FILE_EXT?>",
				"USE_CAPTCHA_FORM" : "<?=$USE_CAPTCHA_FORM?>",
				"CATALOG_INDEX" : "<?=$CATALOG_INDEX?>",
				"SERVICES_INDEX" : "<?=$SERVICES_INDEX?>"
			})
		});
		</script>
		<?
	}
	
	function IsCompositeEnabled(){
		if(class_exists("CHTMLPagesCache")){
			if(method_exists("CHTMLPagesCache", "GetOptions")){
				if($arHTMLCacheOptions = CHTMLPagesCache::GetOptions()){
					if($arHTMLCacheOptions["COMPOSITE"] == "Y"){
						return true;
					}
				}
			}
		}
		return false;
	}
	
	function EnableComposite(){
		if(class_exists("CHTMLPagesCache")){
			if(method_exists("CHTMLPagesCache", "GetOptions")){
				if($arHTMLCacheOptions = CHTMLPagesCache::GetOptions()){
					$arHTMLCacheOptions["COMPOSITE"] = "Y";
					$arHTMLCacheOptions["DOMAINS"] = array_merge((array)$arHTMLCacheOptions["DOMAINS"], (array)$arDomains);
					CHTMLPagesCache::SetEnabled(true);
					CHTMLPagesCache::SetOptions($arHTMLCacheOptions);
					bx_accelerator_reset();
				}
			}
		}
	}
	
	function GetMaxWidthStyle($themewidth){
        $style = "";
        
        if($themewidth == "wide"){
            $style = ".maxwidth-theme{max-width: 1480px;}";
        }
        elseif($themewidth == "middle"){
            $style = ".maxwidth-theme{max-width: 1280px;}";
        }
        elseif($themewidth == "narrow"){
            $style = ".maxwidth-theme{max-width: 1140px; padding: 0 15px;}";
            $style .= ".top-slider .container{max-width: 1140px;margin: 0 0 0 -15px;}";
        }
        else{
            $style = ".maxwidth-theme{max-width: auto;}";
        }
        
        return "<style>".$style."</style>";
    }
	
	function GetCurrentElementFilter(&$arVariables, &$arParams){
        $arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'INCLUDE_SUBSECTIONS' => 'Y');
        if($arParams['CHECK_DATES'] == 'Y'){
            $arFilter = array_merge($arFilter, array('ACTIVE' => 'Y', 'SECTION_GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'));
        }
        if($arVariables['ELEMENT_ID']){
            $arFilter['ID'] = $arVariables['ELEMENT_ID'];
        }
        elseif(strlen($arVariables['ELEMENT_CODE'])){
            $arFilter['CODE'] = $arVariables['ELEMENT_CODE'];
        }
		if($arVariables['SECTION_ID']){
			$arFilter['SECTION_ID'] = ($arVariables['SECTION_ID'] ? $arVariables['SECTION_ID'] : false);
		}
		if($arVariables['SECTION_CODE']){
			$arFilter['SECTION_CODE'] = ($arVariables['SECTION_CODE'] ? $arVariables['SECTION_CODE'] : false);
		}
        if(!$arFilter['SECTION_ID'] && !$arFilter['SECTION_CODE']){
            unset($arFilter['SECTION_GLOBAL_ACTIVE']);
        }
        return $arFilter;
    }
	
	function GetCurrentSectionFilter(&$arVariables, &$arParams){
		$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		if($arParams['CHECK_DATES'] == 'Y'){
			$arFilter = array_merge($arFilter, array('ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'));
		}
		if($arVariables['SECTION_ID']){
			$arFilter['ID'] = $arVariables['SECTION_ID'];
		}
		if(strlen($arVariables['SECTION_CODE'])){
			$arFilter['CODE'] = $arVariables['SECTION_CODE'];
		}
		if(!$arVariables['SECTION_ID'] && !strlen($arFilter['CODE'])){
			$arFilter['ID'] = 0; // if section not found
		}
		return $arFilter;
	}
	
	function GetCurrentSectionElementFilter(&$arVariables, &$arParams, $CurrentSectionID = false){
		$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'INCLUDE_SUBSECTIONS' => 'N');
		if($arParams['CHECK_DATES'] == 'Y'){
			$arFilter = array_merge($arFilter, array('ACTIVE' => 'Y', 'SECTION_GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'));
		}
		if(!$arFilter['SECTION_ID'] = ($CurrentSectionID !== false ? $CurrentSectionID : ($arVariables['SECTION_ID'] ? $arVariables['SECTION_ID'] : false))){
			unset($arFilter['SECTION_GLOBAL_ACTIVE']);
		}
		return $arFilter;
	}
	
	function GetCurrentSectionSubSectionFilter(&$arVariables, &$arParams, $CurrentSectionID = false){
		$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		if($arParams['CHECK_DATES'] == 'Y'){
			$arFilter = array_merge($arFilter, array('ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'));
		}
		if(!$arFilter['SECTION_ID'] = ($CurrentSectionID !== false ? $CurrentSectionID : ($arVariables['SECTION_ID'] ? $arVariables['SECTION_ID'] : false))){
			$arFilter['INCLUDE_SUBSECTIONS'] = 'N';array_merge($arFilter, array('INCLUDE_SUBSECTIONS' => 'N', 'DEPTH_LEVEL' => '1'));
			$arFilter['DEPTH_LEVEL'] = '1';
			unset($arFilter['GLOBAL_ACTIVE']);
		}
		return $arFilter;
	}
	
	function GetIBlockAllElementsFilter(&$arParams){
		$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "INCLUDE_SUBSECTIONS" => "Y");
		if($arParams["CHECK_DATES"] == "Y"){
			$arFilter = array_merge($arFilter, array("ACTIVE" => "Y", "ACTIVE_DATE" => "Y"));
		}
		return $arFilter;
	}
	
	function SetSeoMetaTitle(){
		global $APPLICATION, $arSite;
		if(!CSite::inDir(SITE_DIR."index.php")){
			$PageH1 = $APPLICATION->GetTitle();
			if(!strlen($PageMetaTitleBrowser = $APPLICATION->GetPageProperty("title"))){
				if(!strlen($DirMetaTitleBrowser = $APPLICATION->GetDirProperty('title'))){
					$APPLICATION->SetPageProperty("title", $PageH1.((strlen($PageH1) && strlen($arSite['SITE_NAME'])) ? ' - ' : '' ).$arSite['SITE_NAME']);
				}
			}
		}
		else{
			if(!strlen($PageMetaTitleBrowser = $APPLICATION->GetPageProperty("title"))){
				if(!strlen($DirMetaTitleBrowser = $APPLICATION->GetDirProperty('title'))){
					$PageH1 = $APPLICATION->GetTitle();
					$APPLICATION->SetPageProperty("title", $arSite['SITE_NAME'].((strlen($arSite['SITE_NAME']) && strlen($PageH1)) ? ' - ' : '' ).$PageH1);
				}
			}
		}
	}
	
	function CheckAdditionalChainInMultiLevel(&$arResult, &$arParams, &$arElement){
		global $APPLICATION;
		$APPLICATION->arAdditionalChain = false;
		if($arParams["INCLUDE_IBLOCK_INTO_CHAIN"] == "Y" && isset(CCache::$arIBlocksInfo[$arParams["IBLOCK_ID"]]["NAME"])){
			$APPLICATION->AddChainItem(CCache::$arIBlocksInfo[$arParams["IBLOCK_ID"]]["NAME"], $arElement["~LIST_PAGE_URL"]);
		}
		if($arParams["ADD_SECTIONS_CHAIN"] == "Y"){
			if($arSection = CCache::CIBlockSection_GetList(array("CACHE" => array("TAG" => CCache::GetIBlockCacheTag($arElement["IBLOCK_ID"]), "MULTI" => "N")), self::GetCurrentSectionFilter($arResult["VARIABLES"], $arParams), false, array("ID", "NAME"))){
				$rsPath = CIBlockSection::GetNavChain($arParams["IBLOCK_ID"], $arSection["ID"]);
				$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
				while($arPath = $rsPath->GetNext()){
					$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arPath["ID"]);
					$arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
					$arSection["PATH"][] = $arPath;
					$arSection["SECTION_URL"] = $arPath["~SECTION_PAGE_URL"];
				}
			
				foreach($arSection["PATH"] as $arPath){
					if($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""){
						$APPLICATION->AddChainItem($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"], $arPath["~SECTION_PAGE_URL"]);
					}
					else{
						$APPLICATION->AddChainItem($arPath["NAME"], $arPath["~SECTION_PAGE_URL"]);
					}
				}
			}
		}
		if($arParams["ADD_ELEMENT_CHAIN"] == "Y"){
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arParams["IBLOCK_ID"], $arElement["ID"]);
			$arElement["IPROPERTY_VALUES"] = $ipropValues->getValues();
			if($arElement["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ""){
				$APPLICATION->AddChainItem($arElement["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]);
			}
			else{
				$APPLICATION->AddChainItem($arElement["NAME"]);
			}
		}
	}
	
	function CheckDetailPageUrlInMultilevel(&$arResult){
		if($arResult["ITEMS"]){
			$arItemsIDs = $arItems = array();
			$CurrentSectionID = false;
			foreach($arResult["ITEMS"] as $arItem){
				$arItemsIDs[] = $arItem["ID"];
			}
			$arItems = CCache::CIBLockElement_GetList(array("CACHE" => array("TAG" => CCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "GROUP" => array("ID"), "MULTI" => "N")), array("ID" => $arItemsIDs), false, false, array("ID", "IBLOCK_SECTION_ID", "DETAIL_PAGE_URL"));			
			if($arResult["SECTION"]["PATH"]){
				for($i = count($arResult["SECTION"]["PATH"]) - 1; $i >= 0; --$i){
					if(CSite::InDir($arResult["SECTION"]["PATH"][$i]["SECTION_PAGE_URL"])){
						$CurrentSectionID = $arResult["SECTION"]["PATH"][$i]["ID"];
						break;
					}
				}
			}
			foreach($arResult["ITEMS"] as $i => $arItem){
				if(is_array($arItems[$arItem["ID"]]["DETAIL_PAGE_URL"])){
					if($arItems[$arItem["ID"]]["DETAIL_PAGE_URL"][$CurrentSectionID]){
						$arResult["ITEMS"][$i]["DETAIL_PAGE_URL"] = $arItems[$arItem["ID"]]["DETAIL_PAGE_URL"][$CurrentSectionID];
					}
				}
				if(is_array($arItems[$arItem["ID"]]["IBLOCK_SECTION_ID"])){
					$arResult["ITEMS"][$i]["IBLOCK_SECTION_ID"] = $CurrentSectionID;
				}
			}
		}
	}
	
	function GetDirMenuParametrs($dir){
		if(strlen($dir)){
			$file = str_replace('//', '/', $dir.'/.section.php');
			if(file_exists($file)){
				@include($file);
				return $arDirProperties;
			}
		}
		
		return false;
	}
	
	function goto404Page(){
		global $APPLICATION;
			
		if($_SESSION['SESS_INCLUDE_AREAS']){
			echo '</div>';
		}
		echo '</div>';
		$APPLICATION->IncludeFile(SITE_DIR.'404.php', array(), array('MODE' => 'html'));
		die();
	}
	
	function linkShareImage($previewPictureID = false, $detailPictureID = false){
		global $APPLICATION;
		
		if($linkSaherImageID = ($detailPictureID ? $detailPictureID : ($previewPictureID ? $previewPictureID : false))){
			$APPLICATION->AddHeadString('<link rel="image_src" href="'.CFile::GetPath($linkSaherImageID).'"  />', true);
		}
	}
	
	function checkRestartBuffer(){
		global $APPLICATION;
		static $bRestarted;
		
		if($bRestarted){
			die();
		}
		
		if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y')){
			$APPLICATION->RestartBuffer();
			$bRestarted = true;
		}
	}
}

// kill this in release
//CAllCorp::GenerateThemes();

// event handlers for component aspro:form.allcorp
if(!function_exists("UpdateFormEvent")){
	AddEventHandler("iblock", "OnAfterIBlockPropertyUpdate", "UpdateFormEvent");
	AddEventHandler("iblock", "OnAfterIBlockPropertyAdd", "UpdateFormEvent");
	
	function UpdateFormEvent(&$arFields){
		if($arFields["ID"] && $arFields["IBLOCK_ID"]){		
			// find aspro form event for this iblock
			$arEventIDs = array("ASPRO_SEND_FORM_".$arFields["IBLOCK_ID"], "ASPRO_SEND_FORM_ADMIN_".$arFields["IBLOCK_ID"]);
			$arLangIDs = array("ru", "en");
			static $arEvents;
			if($arEvents == NULL){
				foreach($arEventIDs as $EVENT_ID){
					foreach($arLangIDs as $LANG_ID){
						$resEvents = CEventType::GetByID($EVENT_ID, $LANG_ID);
						$arEvents[$EVENT_ID][$LANG_ID] = $resEvents->Fetch();
					}
				}
			}
			if($arEventIDs){
				foreach($arEventIDs as $EVENT_ID){
					foreach($arLangIDs as $LANG_ID){
						if($arEvent = &$arEvents[$EVENT_ID][$LANG_ID]){
							if(strpos($arEvent["DESCRIPTION"], $arFields["NAME"].": #".$arFields["CODE"]."#") === false){
								$arEvent["DESCRIPTION"] = str_replace("#".$arFields["CODE"]."#", "-", $arEvent["DESCRIPTION"]);
								$arEvent["DESCRIPTION"] .= $arFields["NAME"].": #".$arFields["CODE"]."#\n";
								CEventType::Update(array("ID" => $arEvent["ID"]), $arEvent);
							}
						}
					}
				}
			}
		}
	}
}
?>