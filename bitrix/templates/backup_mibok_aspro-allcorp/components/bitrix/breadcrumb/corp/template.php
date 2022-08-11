<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));
//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<nav role="navigation">
						<ol id="breadcrumb" class="breadcrumb" aria-labelledby="breadcrumblabel">';
for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	if($index == 0){
		$strReturn .= '<li class="first" id="breadcrumblabel">'.GetMessage('HERE').'</li>';
        }

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "" &&  $index!=count($arResult)-1)
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	else
		$strReturn .= '<li><span tabindex="0">'.$title.'</span></li>';
}

$strReturn .= '</ol></nav>';
return $strReturn;
?>