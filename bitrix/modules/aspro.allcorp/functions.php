<?
CModule::IncludeModule("main");
CModule::IncludeModule("iblock");

set_time_limit(0);

if (!function_exists("wdebug")){
	function wdebug($what){
		$f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"a+t");
		if($f){ fwrite($f,$what.'<br/><br/>'); fclose($f); }
	}
}

if (!function_exists("wdebugAr")){ 
	function wdebugAr($what){
		$what = '<pre>'.print_r($what, true).'</pre>';
		$f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"a+t");
		if($f){ fwrite($f,$what.'<br/><br/>'); fclose($f); }
	}
}

if (!function_exists("wdebugClear")){
	function wdebugClear(){
		$f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"w");
		if($f){ fwrite($f,""); fclose($f); }
	}
}

if (!function_exists("removeDirectory")){
	function removeDirectory($dir){
		if($objs=glob($dir."/*")){
			foreach($objs as $obj){
				if (is_dir($obj)){removeDirectory($obj);}else{
					if(!@unlink($obj)) { if(@chmod($obj, 0777)) { @unlink($obj); } }
				}
			}
		}
		if(!@rmdir($dir)) { if(@chmod($dir, 0777)) { @rmdir($dir); } }
	}
}

if (!function_exists("CopyDirFiles")){
	function CopyDirFiles($path_from, $path_to, $ReWrite = True, $Recursive = False, $bDeleteAfterCopy = False, $strExclude = ""){
		if (strpos($path_to."/", $path_from."/")===0 || realpath($path_to) === realpath($path_from))
			return false;

		if (is_dir($path_from)){
			CheckDirPath($path_to."/");
		}
		elseif(is_file($path_from)){
			$p = bxstrrpos($path_to, "/");
			$path_to_dir = substr($path_to, 0, $p);
			CheckDirPath($path_to_dir."/");

			if (file_exists($path_to) && !$ReWrite)
				return False;

			@copy($path_from, $path_to);
			if(is_file($path_to))
				@chmod($path_to, BX_FILE_PERMISSIONS);

			if ($bDeleteAfterCopy)
				@unlink($path_from);

			return True;
		}
		else{
			return True;
		}

		if ($handle = @opendir($path_from)){
			while (($file = readdir($handle)) !== false){
				if ($file == "." || $file == "..")
					continue;

				if (strlen($strExclude)>0 && substr($file, 0, strlen($strExclude))==$strExclude)
					continue;

				if (is_dir($path_from."/".$file) && $Recursive){
					CopyDirFiles($path_from."/".$file, $path_to."/".$file, $ReWrite, $Recursive, $bDeleteAfterCopy, $strExclude);
					if ($bDeleteAfterCopy)
						@rmdir($path_from."/".$file);
				}
				elseif (is_file($path_from."/".$file)){
					if (file_exists($path_to."/".$file) && !$ReWrite)
						continue;

					@copy($path_from."/".$file, $path_to."/".$file);
					@chmod($path_to."/".$file, BX_FILE_PERMISSIONS);

					if($bDeleteAfterCopy)
						@unlink($path_from."/".$file);
				}
			}
			@closedir($handle);

			if ($bDeleteAfterCopy)
				@rmdir($path_from);

			return true;
		}

		return false;
	}
}

if (!function_exists("ClearAllSitesCacheComponents")){
	function ClearAllSitesCacheComponents($arComponentsNames){
		if($arComponentsNames && is_array($arComponentsNames)){
			global $CACHE_MANAGER;
			$arSites = array();
			$rsSites = CSite::GetList($by = "sort", $order = "desc", array("ACTIVE" => "Y"));
			while($arSite = $rsSites->Fetch()){
			  $arSites[] = $arSite;
			}
			foreach($arComponentsNames as $componentName){
				foreach($arSites as $arSite){
					CBitrixComponent::clearComponentCache($componentName, $arSite["ID"]);
				}
			}
		}
	}
}

if (!function_exists("ClearAllSitesCacheDirs")){
	function ClearAllSitesCacheDirs($arDirs){
		if($arDirs && is_array($arDirs)){
			foreach($arDirs as $dir){
				$obCache = new CPHPCache();
				$obCache->CleanDir("", $dir);
			}
		}
	}
}

if (!function_exists("GetIBlocks")){
	function GetIBlocks(){
		$arRes = array();
		$dbRes = CIBlock::GetList(array(), array("ACTIVE" => "Y"));
		while($item = $dbRes->Fetch()){
			$arRes[$item["LID"]][$item["IBLOCK_TYPE_ID"]][$item["CODE"]][] = $item["ID"];
		}
		return $arRes;
	}
}

if (!function_exists("GetSites")){
	function GetSites(){
		$arRes = array();
		$dbRes = CSite::GetList($by="sort", $order="desc", array("ACTIVE" => "Y"));
		while($item = $dbRes->Fetch()){
			$arRes[$item["LID"]] = $item;
		}
		return $arRes;
	}
}

if (!function_exists("GetCurVersion")){
	function GetCurVersion($versionFile){
		$ver = false;
		if(file_exists($versionFile)){
			$arModuleVersion = array();
			include($versionFile);
			$ver = trim($arModuleVersion["VERSION"]);
		}
		return $ver;
	}
}

if (!function_exists("CreateBakFile")){
	function CreateBakFile($file, $curVersion = CURRENT_VERSION){
		$file = trim($file);
		if(file_exists($file)){
			$arPath = pathinfo($file);
			$backFile = $arPath['dirname'].'/_'.$arPath['basename'].'.back'.$curVersion;
			if(!file_exists($backFile)){
				@copy($file, $backFile);
			}
		}
	}
}

if (!function_exists("RemoveFileFromModuleWizard")){
	function RemoveFileFromModuleWizard($file){
		@unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.MODULE_NAME.'/install/wizards/'.PARTNER_NAME.'/'.MODULE_NAME_SHORT.$file);
		@unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/wizards/'.PARTNER_NAME.'/'.MODULE_NAME_SHORT.$file);
	}
}

if (!function_exists("RemoveFileFromTemplate")){
	function RemoveFileFromTemplate($file, $bModule = true){
		@unlink($_SERVER['DOCUMENT_ROOT'].TEMPLATE_PATH.$file);
		if($bModule){
			RemoveFileFromModuleWizard('/site/templates/'.TEMPLATE_NAME.$file);
		}
	}
}

if(!function_exists('SearchFilesInPublicRecursive')){
	function SearchFilesInPublicRecursive($dir, $pattern, $flags = 0){
		$arDirExclude = array('bitrix', 'upload');
		$pattern = str_replace('//', '/', str_replace('//', '/', $dir.'/').$pattern);
		$files = glob($pattern, $flags);
		foreach(glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir){
			if(!in_array(basename($dir), $arDirExclude)){
				$files = array_merge($files, SearchFilesInPublicRecursive($dir, basename($pattern), $flags));
			}
		}
		return $files;
	}
}

if (!function_exists("GetDBcharset")){
	function GetDBcharset(){
		if($result = @mysql_query('SHOW VARIABLES LIKE "character_set_database";')){
			$arResult = mysql_fetch_row($result);
			return $arResult[1];
		}
		return false;
	}
}

if (!function_exists("GetMes")){
	function GetMes($str){
		static $isUTF8;
		if($isUTF8 === NULL){
			$isUTF8 = GetDBcharset() == 'utf8';
		}
		return ($isUTF8 ? iconv('CP1251', 'UTF-8', $str) : $str);
	}
}

if (!function_exists("UpdaterLog")){
	function UpdaterLog($str){
		static $fLOG;
		if($bFirst = !$fLOG){
			$fLOG = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.MODULE_NAME.'/updaterlog.txt';
		}
		if(is_array($str)){
			$str = print_r($str, 1);
		}
		@file_put_contents($fLOG, ($bFirst ? PHP_EOL : '').date("d.m.Y H:i:s", time()).' '.$str.PHP_EOL, FILE_APPEND);
	}
}

if (!function_exists("InitComposite")){
	function InitComposite($arSites){
		if(class_exists("CHTMLPagesCache")){
			if(method_exists("CHTMLPagesCache", "GetOptions")){
				if($arHTMLCacheOptions = CHTMLPagesCache::GetOptions()){
					if($arHTMLCacheOptions["COMPOSITE"] !== "Y"){
						$arDomains = array();						
						if($arSites){
							foreach($arSites as $arSite){
								if(strlen($serverName = trim($arSite["SERVER_NAME"], " \t\n\r"))){
									$arDomains[$serverName] = $serverName;
								}
								if(strlen($arSite["DOMAINS"])){
									foreach(explode("\n", $arSite["DOMAINS"]) as $domain){
										if(strlen($domain = trim($domain, " \t\n\r"))){
											$arDomains[$domain] = $domain;
										}
									}
								}
							}
						}
						
						if(!$arDomains){
							$arDomains[$_SERVER["SERVER_NAME"]] = $_SERVER["SERVER_NAME"];
						}
						
						if(!$arHTMLCacheOptions["GROUPS"]){
							$arHTMLCacheOptions["GROUPS"] = array();
						}
						$rsGroups = CGroup::GetList(($by="id"), ($order="asc"), array());
						while($arGroup = $rsGroups->Fetch()){
							if($arGroup["ID"] > 2){
								if(in_array($arGroup["STRING_ID"], array("RATING_VOTE_AUTHORITY", "RATING_VOTE")) && !in_array($arGroup["ID"], $arHTMLCacheOptions["GROUPS"])){
									$arHTMLCacheOptions["GROUPS"][] = $arGroup["ID"];
								}
							}
						}
						
						$arHTMLCacheOptions["COMPOSITE"] = "Y";
						$arHTMLCacheOptions["DOMAINS"] = array_merge((array)$arHTMLCacheOptions["DOMAINS"], (array)$arDomains);
						CHTMLPagesCache::SetEnabled(true);
						CHTMLPagesCache::SetOptions($arHTMLCacheOptions);
						bx_accelerator_reset();
					}
				}
			}
		}
	}
}

if (!function_exists("IsCompositeEnabled")){
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
}
	
if (!function_exists("EnableComposite")){
	function EnableComposite(){
		if(class_exists("CHTMLPagesCache")){
			if(method_exists("CHTMLPagesCache", "GetOptions")){
				if($arHTMLCacheOptions = CHTMLPagesCache::GetOptions()){
					$arHTMLCacheOptions["COMPOSITE"] = "Y";
					CHTMLPagesCache::SetEnabled(true);
					CHTMLPagesCache::SetOptions($arHTMLCacheOptions);
					bx_accelerator_reset();
				}
			}
		}
	}
}
?>