<?
	class WIEvents
	{
		public static function ClearCache()
		{
			$cacheDir = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/cache/wi/cache/';
			\Bitrix\Main\IO\Directory::deleteDirectory($cacheDir);
		}
	}
?>