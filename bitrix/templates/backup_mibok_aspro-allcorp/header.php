<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile(__FILE__);
?>
<?
if($_GET['special_version'] == 'Y'){
    session_start();
    $_SESSION['special_version'] = true;
}
if($_GET['special_version'] == 'N'){
    $query = '';
	if(!empty($_SERVER['QUERY_STRING']))
		$query = $_SERVER['QUERY_STRING'];
    $query = str_replace(array('&special_version=N', '?special_version=N', 'special_version=N'), '', $query);
    session_start();
    $_SESSION['special_version'] = false;
    if(!empty($query))
        header('Location: '.$APPLICATION->GetCurPage().'?'.$query);
    else
        header('Location: '.$APPLICATION->GetCurPage());
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <title>
            <?if($APPLICATION->GetCurDir() != '/'){?>
                <?$APPLICATION->ShowTitle()?> -
            <?}else{?>
                <?=GetMessage('INDEX_PAGE')?> -
            <?}?>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW"	=> "file", "PATH" => SITE_DIR."glaza_mibok_include/site_slogan.php", "MIBOK_SPECIAL_COMPARE" => "N"));?>
        </title>
        <link href="<?=SITE_TEMPLATE_PATH?>/css/libs/bootstrap.css" rel="stylesheet" type="text/css"/>        
        <link href="<?=SITE_TEMPLATE_PATH?>/css/style.css" rel="stylesheet" type="text/css"/>       
        <link rel="icon" href="/favicon.ico">
        <script src="<?=SITE_TEMPLATE_PATH?>/js/libs/jquery.min.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/libs/bootstrap.min.js"></script>
        <link href="<?=SITE_TEMPLATE_PATH?>/css/custom.css" rel="stylesheet" type="text/css"/> 
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->
        <?$APPLICATION->ShowHead();?>
    </head>	
    <body>
        <?$arComponentsParams = $APPLICATION->IncludeComponent("mibok:special_panel", "", array("MIBOK_SPECIAL_COMPARE" => "N"))?>
        <div id="content" class="<?=implode(' ', $arComponentsParams)?> <?if(COption::GetOptionString("mibok.glaza", "bootstrap_adaptive") == 'Y'):?>changebtstrp<?endif;?>" <?if(COption::GetOptionString("mibok.glaza", "voice") == 'Y'):?>data-volume="<?=(float)(str_replace('volume-', '', $arComponentsParams['VOLUME']))?>"<?endif;?>>
            <header>
                <div class="bs-docs-header" role="banner">
                    <div class="container wcag">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="template"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW"	=> "file", "PATH" => SITE_DIR."glaza_mibok_include/site_slogan.php", "MIBOK_SPECIAL_COMPARE" => "N"));?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="container wcag">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", ".default", Array("ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COUNT_ITEM" => "6",
		"COMPONENT_TEMPLATE" => "top",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"MIBOK_SPECIAL_KEY" => "b3fa0ba592f04089743b9b01674111d7"));?>                                                                                                                                    
                        <?$APPLICATION->IncludeComponent("bitrix:menu", ".default", array(
                                "ROOT_MENU_TYPE" => "glazamibok",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "0",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "N",
                                "MIBOK_SPECIAL_COMPARE" => "N"
                                ),
                                false
                        );?>
                    </div>    
                </div>
            </header>
            <div class="container bs-docs-container wcag">
                <div class="row">
                    <div class="col-md-12">                           
                        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array(
                                "START_FROM" => "0",
                                "PATH" => "",
                                "SITE_ID" => SITE_ID,
                                "MIBOK_SPECIAL_COMPARE" => "N"
                                ),
                                false
                        );?>
                    </div>
                </div>
            </div>            
            <div class="container bs-docs-container wcag">
                <div class="row">
                    <div class="col-md-12" role="main" id="main_content">
                        <?if($APPLICATION->GetCurDir() != '/' && COption::GetOptionString("mibok.glaza", "view_h1") == 'Y'){?>
                            <h1 class="page-header"><?$APPLICATION->ShowTitle(false);?></h1>
                        <?}?>   
                        <?$APPLICATION->IncludeComponent("bitrix:menu", ".default", Array("ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "subleft",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"MIBOK_SPECIAL_KEY" => "52f353b721dfe5678ba638cd26d47df5"));?>                      
						
						<div class="page_body">
