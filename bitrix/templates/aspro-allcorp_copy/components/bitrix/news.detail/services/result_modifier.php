<?
if($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["VALUE"]){
	foreach($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["VALUE"] as $img){
		$arResult["GALLERY"][] = array(
			"DETAIL" => CFile::GetFileArray($img),
			"PREVIEW" => CFile::ResizeImageGet($img, array("width" => 325, "height" => 230), BX_RESIZE_IMAGE_EXACT, true),
		);
	}
}
?>