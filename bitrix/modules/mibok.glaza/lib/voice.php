<?php
if(function_exists('opcache_reset'))
	opcache_reset();
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

IncludeModuleLangFile(__FILE__);


class MibokSpecialVoice
{
    /**
     * Directory for temporary files
     * @var string
     */
    public $tmp_dir = '';
    public $tmp_dir_parent = '';
    public $public_dir = '/upload/mibok.glaza/voice';
    public $public_parent = '/upload/mibok.glaza';

    private $mibok_url = '';
    private $mibok_file = '';
	private $clear_text = '';
	private $bite = 1048576;
    private $sizeProp = '';
    private $module_id = "mibok.glaza";
    private $bigFile = 'http://glaza.mibok.ru/voice/error1_bigQuery.mp3';
    private $emptyFile = 'http://glaza.mibok.ru/voice/error2_emptyText.mp3';
    private $longFile = 'http://glaza.mibok.ru/voice/start_voice_long.mp3';
    private $shortFile = 'http://glaza.mibok.ru/voice/start_voice.mp3';
    private $typeConnect = 'curl';

    public function __construct()
    {
        // Check exist curl
        if (!function_exists('curl_init')) {
            //exit(GetMessage('CURL_NOT_INSTALLED'));
            $this->typeConnect = 'file';
        }

        // Checks temporary directory
        $tmp_dir = $_SERVER['DOCUMENT_ROOT'] . $this->public_dir;
        $tmp_dir_parent = $_SERVER['DOCUMENT_ROOT'] . $this->public_parent;
        /*if (!is_dir($tmp_dir)) {
            if (!mkdir($tmp_dir, 0777)) {
                exit(GetMessage('TMP_DIR_NOT_EXISTS'));
            }
        }*/
		if (!is_dir($tmp_dir)) 
		{
            if (!mkdir($tmp_dir_parent, 0777)) 
			{
                exit(GetMessage('TMP_DIR_NOT_EXISTS'));
            }
			else
			{
				if (!mkdir($tmp_dir, 0777)) 
				{
					exit(GetMessage('TMP_DIR_NOT_EXISTS'));
				}
			}
        }
		
        $this->tmp_dir = $tmp_dir . DIRECTORY_SEPARATOR;
        $this->sizeProp = COption::GetOptionString($this->module_id, 'size_synthes');
        //$this->cleanTmpDir();
        $this->cleanDir();
    }


    /**
     * This method checks and deletes old files
     */
    private function cleanTmpDir()
    {
        $expire_time = 600;
        $dir_files = scandir($this->tmp_dir);
        foreach ($dir_files as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                $time_sec = time();
                $time_file = filemtime($this->tmp_dir . $value);
                $time = $time_sec - $time_file;
                if ($time > $expire_time) {
                    unlink($this->tmp_dir . $value);
                }
            }
        }
    }
	
	private function cleanDir()
    {

		$disk_space_opt = COption::GetOptionString("mibok.glaza", "disk_space") * $this->bite;

		$this->deleteOldFile($this->tmp_dir, $disk_space_opt);

    }

	private function sizeDir($path)
	{
		$fileSize = 0;
		$dir = scandir($path);
		
		foreach($dir as $file)
		{
			if (($file!='.') && ($file!='..'))
				if(is_dir($path . '/' . $file))
					$fileSize += getFilesSize($path.'/'.$file);
				else
					$fileSize += filesize($path . '/' . $file);
		}
		
		return $fileSize;
	}
	
	private function deleteOldFile($path, $sizeDir)
	{
		$fileSize = 0;
		$dir = scandir($path);
		
		foreach($dir as $file)
		{
			if (($file!='.') && ($file!='..'))
			{
				if(is_dir($path . '/' . $file))
					continue;
				else
				{
					$fSize = filesize($path . '/' . $file);
					$fileSize += $fSize;
					$tmp = filemtime($this->tmp_dir . $file);
				 	$arFile[$tmp][] = array('NAME' => $file, 'SIZE' => $fSize, 'DATE' => date('d.m.Y H:i:s', $tmp));
					$arKey[] = $tmp;
					//echo date('d.m.Y H:i:s', $tmp); echo "<br>";
					
				}
			}
			
		}
		if($fileSize > $sizeDir)
		{

			sort($arKey);
			foreach($arKey as $key)
			{
				if($fileSize > $sizeDir)
				{
					foreach($arFile[$key] as $f_value)
					{
						unlink($this->tmp_dir . $f_value['NAME']);
						$fileSize -= $f_value['SIZE'];
					}
				}
				else				
					break;
			}
		}

	}
    
    /* Set preload mp3 */
    
    public function getPreload($text)
    {
        $this->clearText($text);
        $sizeText = $this->weightText($text, true);
        $bExist = false;
        $check_sum = md5($this->clear_text);
        $file_name = $check_sum . '.mp3';
        if(file_exists($this->tmp_dir . $file_name))
           $bExist = true;
        $loop = 'n';
        
        /*if($sizeText == 0)
            $this->mibok_url = $this->bigFile;
        else*/if($sizeText == -1)
            $this->mibok_url = $this->emptyFile;
        elseif($sizeText > 2 && !$bExist)
        {
            $this->mibok_url = $this->longFile;
            $loop = 'y';
        }
        else
            $this->mibok_url = $this->shortFile;
        
        return array('url' => $this->mibok_url, 'loop' => $loop);
            
    }

    /**
     * Sends request to voice server and get sound file
     * @param $text
     */
    public function textToVoice($text, $referer)
    {
		$this->clearText($text);
        if($this->weightText($text) == 0)
            $this->mibok_url = $this->bigFile;
        elseif($this->weightText($text) == -1)
            $this->mibok_url = $this->emptyFile;
        else
        {
            $check_sum = md5($this->clear_text);
            $file_name = $check_sum . '.mp3';
            if(file_exists($this->tmp_dir . $file_name))
            {
                $this->mibok_file = $file_name;
            }
            else
            {
                if($this->typeConnect == 'curl')
                {
                    $curl = curl_init();
                    if ($curl && !empty($this->clear_text)) {
                        curl_setopt($curl, CURLOPT_URL, 'http://voice.glaza.mibok.ru/cgi-bin/script.cgi');
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        if(!empty($referer))
                            curl_setopt($curl, CURLOPT_REFERER, $referer);
                        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, "txt=" . $this->clear_text."&d=".$_SERVER['HTTP_HOST']."&key=".$this->GetLicenseKey()."&check=".$check_sum);
                        $out = curl_exec($curl);
                        $info = curl_getinfo($curl);
                        curl_close($curl);

                        $url = trim($out);


                        if (isset($info['http_code']) && $info['http_code'] == '200' && !empty($url) &&
                            filter_var($url, FILTER_VALIDATE_URL)
                        ) {
                            $this->mibok_url = $url;
                        }
                    }
                }
                elseif($this->typeConnect == 'file')
                {
                    $postdata = http_build_query(
                        array(
                            'txt' => $this->clear_text,
                            'd' => $_SERVER['HTTP_HOST'],
                            'key' => $this->GetLicenseKey(),
                            'check' => $check_sum
                        )
                    );
                    $opts = array('http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $postdata
                        )
                    );
                    $context  = stream_context_create($opts);
                    $url = file_get_contents('http://voice.glaza.mibok.ru/cgi-bin/script.cgi', false, $context);
                    if (!empty($url)) 
                    {
                        $this->mibok_url = $url;
                    }
                }
            }
        }
    }

	private function GetLicenseKey()
	{
		if (defined("US_LICENSE_KEY"))
			return md5("BITRIX".US_LICENSE_KEY."LICENCE");
		if (defined("LICENSE_KEY"))
			return md5("BITRIX".LICENSE_KEY."LICENCE");
		
		$LICENSE_KEY = "demo";
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/license_key.php"))
			include($_SERVER["DOCUMENT_ROOT"]."/bitrix/license_key.php");
		return md5("BITRIX".$LICENSE_KEY."LICENCE");
	}
	
	
	
    /**
     * Saves file and returns url
     * @return bool|string
     */
    public function getVoiceUrl($referer, $repeat = false)
    {
		$checkError = array();
		$checkError = explode('_', basename($this->mibok_url));
		if(strpos($checkError[0], 'error') !== false)
			return	$this->mibok_url;
		
		if(!empty($this->mibok_file))
		{
			return $this->public_dir . DIRECTORY_SEPARATOR . $this->mibok_file;
		}
		elseif (empty($this->mibok_url)) {
            return false;
        }
		else
		{

			//$file_name = md5($this->mibok_url) . '.mp3';
			$file_name = md5($this->clear_text) . '.mp3';

			$file_source = basename($this->mibok_url);
			//if (copy($this->mibok_url, $this->tmp_dir . $file_source)) 
			if ($this->downloadRemoteFile($this->mibok_url, $this->tmp_dir . $file_source)) 
			{
				
				$md5_end = md5_file($this->tmp_dir . $file_source);
				$md5_source = explode('_', $file_source);
				if (strcmp($md5_source[1], $md5_end.'.mp3') !== 0 && !$repeat)
				{
					$this->textToVoice($this->clear_text, $referer);
					$this->getVoiceUrl($referer, true);
				}
				elseif(strcmp($md5_source[1], $md5_end.'.mp3') === 0 )
				{
					rename($this->tmp_dir . $file_source,  $this->tmp_dir . $file_name);
					return  $this->public_dir . DIRECTORY_SEPARATOR . $file_name;
				}
				else
					return false;
			} 
			else 
			{
				return false;
			}


		}
    }
	
	protected function clearText($text)
	{
		$text = str_replace(array("\r\n", "\r", "\n", "\tr"), '.', $text);
		$text = str_replace(array("\t", '  ', '    ', '    '), ' ', $text);
		$text = preg_replace ('|\s+|', ' ',  $text) ;
		$text = preg_replace ('/[\.\s+]{2,}/', '. ',  $text) ;
		$text = trim($text) ;
		


		$this->clear_text = $text;
		//print_r($text); exit();
	}
	
	protected function downloadRemoteFile($file_url, $save_to)
	{
        if($this->typeConnect == 'curl')
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch,CURLOPT_URL,$file_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $file_content = curl_exec($ch);
            curl_close($ch);
        }
        elseif($this->typeConnect == 'file')
        {
            $file_content = file_get_contents($file_url, false);
        }
		$downloaded_file = fopen($save_to, 'w');
		fwrite($downloaded_file, $file_content);
		fclose($downloaded_file);

		return true;
	}

    private function weightText($text, $bPreload = false)
    {
        $size = strlen($text) / 1024;
        $textTemp = preg_replace ('|\s+|', '',  $text) ;
        if(strlen($textTemp) == 0)
            return -1;  //empty text
        if($size > $this->sizeProp)
            return 0;   //big text
        if($bPreload)
            return $size;
        return 1;
    }
    
}
