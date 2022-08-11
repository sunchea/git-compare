<?
class MibokSpecialUtil{
    static function ReadDir($dir){
        $arDir = array();
        if(is_dir($dir)){
            if($dh = opendir($dir)){
                while(false !== ($file = readdir($dh))){
                    if($file != "." && $file != ".."){
                        $arDir[] = $dir.'/'.$file;
                    }
                }
                closedir($dh);
            }
        }
        return $arDir;
    }
    static function MakeDir($dir){
        $arDir = explode('/', $dir);
        $point = 0;
		// print_r($_SERVER['DOCUMENT_ROOT']);echo "<br>";
        for($i=count($arDir);$i>=0;$i--){
            $filename = implode('/', array_slice($arDir, 0, $i));           
            //print_r($filename);echo "<br>";
			if($filename == $_SERVER['DOCUMENT_ROOT'])
				break;
            if(file_exists($filename) && !$point){
                $point = $i+1;
            }
        }
		//echo $point;
        for($i=$point;$i<=count($arDir);$i++){
            $filename = implode('/', array_slice($arDir, 0, $i));
            mkdir($filename, 0777, true);
        }
    }
    static function CopyDir($from, $to){
        //p(array($from, $to));
        CopyDirFiles($from, $to, true, true);
    }
    static function RemoveDir($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) 
        {
            (is_dir("$dir/$file")) ? self::RemoveDir("$dir/$file") : unlink("$dir/$file");
        }
         return rmdir($dir); 
    }
}
?>