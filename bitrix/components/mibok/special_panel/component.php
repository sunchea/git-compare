<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
session_start();
$arParams = array(
	'FONT_SIZE' => ($_SESSION['SPECIAL_PARAMS']['FONT_SIZE'] ? $_SESSION['SPECIAL_PARAMS']['FONT_SIZE'] : 'font-size-100'),
	'COLOR' => ($_SESSION['SPECIAL_PARAMS']['COLOR'] ? $_SESSION['SPECIAL_PARAMS']['COLOR'] : 'color-1'),
	'IMAGES' => ($_SESSION['SPECIAL_PARAMS']['IMAGES'] ? $_SESSION['SPECIAL_PARAMS']['IMAGES'] : 'images'),
	'MONO_IMAGES' => ($_SESSION['SPECIAL_PARAMS']['MONO_IMAGES'] ? $_SESSION['SPECIAL_PARAMS']['MONO_IMAGES'] : ''),
	'FLASH' => ($_SESSION['SPECIAL_PARAMS']['FLASH'] ? $_SESSION['SPECIAL_PARAMS']['FLASH'] : ''),
	'KERNING' => ($_SESSION['SPECIAL_PARAMS']['KERNING'] ? $_SESSION['SPECIAL_PARAMS']['KERNING'] : 'kerning-1'),
	'LINE' => ($_SESSION['SPECIAL_PARAMS']['LINE'] ? $_SESSION['SPECIAL_PARAMS']['LINE'] : 'line-1'),
	'GARNITURA' => ($_SESSION['SPECIAL_PARAMS']['GARNITURA'] ? $_SESSION['SPECIAL_PARAMS']['GARNITURA'] : 'garnitura-1'),	
	'VOICE' => ($_SESSION['SPECIAL_PARAMS']['VOICE'] ? $_SESSION['SPECIAL_PARAMS']['VOICE'] : 'voice-3'),
	'VOLUME' => ($_SESSION['SPECIAL_PARAMS']['VOLUME'] ? $_SESSION['SPECIAL_PARAMS']['VOLUME'] : 'volume-0.5')
);
$arParamsPanel = $arParams;
$arParamsPanel['KERNING'] = 'kerning-1';
$arParamsPanel['FONT_SIZE'] = 'font-size-100';

//get-parameters
$query = false;
if(!empty($_SERVER['QUERY_STRING']))
    $query = $_SERVER['QUERY_STRING'];
$query = str_replace(array('&special_version=Y', '?special_version=Y', 'special_version=Y'), '', $query);
$query = ltrim($query, "&");
?>
<div class="bs-docs-panel <?=implode(' ', $arParamsPanel)?>" id="c_panel_special">
    <div class="container wcag">
        <div class="panel panel-default panel-access">
            <div class="panel-body">
                <div class="btn-toolbar access-toolbar" id="access_toolbar" role="toolbar" data-path-params="<?=SITE_DIR?>glaza_mibok_include/special_params.php" aria-label="<?=GetMessage('LABEL_TOOLBAR')?>">   
                    <div class="container-fluid">
                        <div class='pull-left p-content'>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" tabindex="0" data-choice="content" aria-label="<?=GetMessage('LABEL_CONTENT_ADV')?>"><span class="glyphicon glyphicon-circle-arrow-down"></span>&nbsp;<?=GetMessage('LABEL_CONTENT')?><span class="hover"></span></button>
                            </div>
                        </div>
                        <div class='pull-left p-font'>
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_FONT_SIZE')?></div>
                            <div class="btn-group btn-group-font-size" role="group">                                               
                                <button type="button" class="btn btn-default btn-font-size-100 <?=($arParams['FONT_SIZE'] == 'font-size-100' ? 'checked' : NULL)?>" tabindex="-1" data-choice="font-size-100" aria-checked="<?=($arParams['FONT_SIZE'] == 'font-size-100' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_FONT_SIZE_100')?>"><span class="value"><?=GetMessage('LABEL_FONT_SIZE')?></span><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-font-size-150 <?=($arParams['FONT_SIZE'] == 'font-size-150' ? 'checked' : NULL)?>" tabindex="-1" data-choice="font-size-150" aria-checked="<?=($arParams['FONT_SIZE'] == 'font-size-100' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_FONT_SIZE_150')?>"><span class="value"><?=GetMessage('LABEL_FONT_SIZE')?></span><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-font-size-200 <?=($arParams['FONT_SIZE'] == 'font-size-200' ? 'checked' : NULL)?>" tabindex="-1" data-choice="font-size-200" aria-checked="<?=($arParams['FONT_SIZE'] == 'font-size-100' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_FONT_SIZE_200')?>"><span class="value"><?=GetMessage('LABEL_FONT_SIZE')?></span><span class="hover"></span></button>
                            </div>
                        </div>
                        <div class='pull-left p-color'>
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_COLOR')?></div>
                            <div class="btn-group btn-group-color" role="group">
                                <button type="button" class="btn btn-default btn-color-1 <?=($arParams['COLOR'] == 'color-1' ? 'checked' : NULL)?>" tabindex="-1" data-choice="color-1" aria-checked="<?=($arParams['COLOR'] == 'color-1' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_COLOR_1')?>"><?=GetMessage('LABEL_COLOR')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-color-2 <?=($arParams['COLOR'] == 'color-2' ? 'checked' : NULL)?>" tabindex="-1" data-choice="color-2" aria-checked="<?=($arParams['COLOR'] == 'color-2' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_COLOR_2')?>"><?=GetMessage('LABEL_COLOR')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-color-3 <?=($arParams['COLOR'] == 'color-3' ? 'checked' : NULL)?>" tabindex="-1" data-choice="color-3" aria-checked="<?=($arParams['COLOR'] == 'color-3' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_COLOR_3')?>"><?=GetMessage('LABEL_COLOR')?><span class="hover"></span></button>
								<button type="button" class="btn btn-default btn-color-4 <?=($arParams['COLOR'] == 'color-4' ? 'checked' : NULL)?>" tabindex="-1" data-choice="color-4" aria-checked="<?=($arParams['COLOR'] == 'color-4' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_COLOR_4')?>"><?=GetMessage('LABEL_COLOR')?><span class="hover"></span></button>
								<button type="button" class="btn btn-default btn-color-5 <?=($arParams['COLOR'] == 'color-5' ? 'checked' : NULL)?>" tabindex="-1" data-choice="color-5" aria-checked="<?=($arParams['COLOR'] == 'color-5' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_COLOR_5')?>"><?=GetMessage('LABEL_COLOR')?><span class="hover"></span></button>
                            </div>   
                        </div>
                        <div class='pull-right p-setting'>

								<div class="btn-group" >
									<a class="btn btn-default" href="<?if(!empty($query)) echo '?'.$query.'&special_version=N'; else echo '?special_version=N';?>" tabindex="-1"  aria-label="<?=GetMessage('LABEL_ADVANCED_SETTINGS_ADV')?>" title="<?=GetMessage('LABEL_HOME')?>"><span class="glyphicon glyphicon-eye-close"></span><span class="hover"></span></a>
								</div>

                            <div class="btn-group btn-group-setting" role="group">
								
                                <button type="button" class="btn btn-default" tabindex="-1" data-choice="setting" aria-label="<?=GetMessage('LABEL_ADVANCED_SETTINGS_ADV')?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;<?=GetMessage('LABEL_ADVANCED_SETTINGS')?><span class="hover"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-subsetting" aria-hidden="true">
                        <div class="container-fluid">
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_IMAGE')?></div>
                            <div class="btn-group btn-group-images" role="group">
                                <button type="button" class="btn btn-default btn-images <?=($arParams['IMAGES'] == 'images' ? 'checked' : NULL)?>" tabindex="-1" data-choice="images" aria-checked="<?=($arParams['IMAGES'] == 'images' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_IMAGE_ON')?>"><?=GetMessage('LABEL_IMAGE_ON')?><span class="hover"></span></button>
								<button type="button" class="btn btn-default btn-images <?=($arParams['IMAGES'] == 'not-images' ? 'checked' : NULL)?>" tabindex="-1" data-choice="not-images" aria-checked="<?=($arParams['IMAGES'] == 'not-images' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_IMAGE')?>"><?=GetMessage('LABEL_IMAGE')?><span class="hover"></span></button>
                            </div>                                  
                            <div class="btn-group btn-group-mono" role="group">
                                <button type="button" class="btn btn-default btn-mono <?=($arParams['IMAGES'] == 'not-images' ? 'disabled' : '')?> <?=($arParams['MONO_IMAGES'] == 'mono' ? 'checked' : NULL)?>" tabindex="-1" data-choice="mono" aria-checked="<?=($arParams['MONO_IMAGES'] == 'mono' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_MONO_IMAGE')?>"><?=GetMessage('LABEL_MONO_IMAGE')?><span class="hover"></span></button>
                            </div>                                  
                            <div class="btn-group btn-group-flash" role="group">
                                <button type="button" class="btn btn-default btn-flash <?=($arParams['FLASH'] == 'not-flash' ? 'checked' : NULL)?>" tabindex="-1" data-choice="flash" aria-checked="<?=($arParams['FLASH'] == 'not-flash' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_FLASH')?>"><?=GetMessage('LABEL_FLASH')?><span class="hover"></span></button>
                            </div>                                  
                        </div>
                        <div class="container-fluid">
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_KERNING')?></div>
                            <div class="btn-group btn-group-kerning" role="group">
                                <button type="button" class="btn btn-default btn-kerning-1 <?=($arParams['KERNING'] == 'kerning-1' ? 'checked' : NULL)?>" tabindex="-1" data-choice="kerning-1" aria-checked="<?=($arParams['KERNING'] == 'kerning-1' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_KERNING_1')?>"><?=GetMessage('LABEL_KERNING_1')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-kerning-2 <?=($arParams['KERNING'] == 'kerning-2' ? 'checked' : NULL)?>" tabindex="-1" data-choice="kerning-2" aria-checked="<?=($arParams['KERNING'] == 'kerning-2' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_KERNING_2')?>"><?=GetMessage('LABEL_KERNING_2')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-kerning-3 <?=($arParams['KERNING'] == 'kerning-3' ? 'checked' : NULL)?>" tabindex="-1" data-choice="kerning-3" aria-checked="<?=($arParams['KERNING'] == 'kerning-3' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_KERNING_3')?>"><?=GetMessage('LABEL_KERNING_3')?><span class="hover"></span></button>
                            </div>                                                                      
                        </div>
						<div class="container-fluid">
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_LINE')?></div>
                            <div class="btn-group btn-group-kerning" role="group">
                                <button type="button" class="btn btn-default btn-line-1 <?=($arParams['LINE'] == 'line-1' ? 'checked' : NULL)?>" tabindex="-1" data-choice="line-1" aria-checked="<?=($arParams['LINE'] == 'line-1' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_LINE_1')?>"><?=GetMessage('LABEL_LINE_1')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-line-2 <?=($arParams['LINE'] == 'line-2' ? 'checked' : NULL)?>" tabindex="-1" data-choice="line-2" aria-checked="<?=($arParams['LINE'] == 'line-2' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_LINE_2')?>"><?=GetMessage('LABEL_LINE_2')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-line-3 <?=($arParams['LINE'] == 'line-3' ? 'checked' : NULL)?>" tabindex="-1" data-choice="line-3" aria-checked="<?=($arParams['LINE'] == 'line-3' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_LINE_3')?>"><?=GetMessage('LABEL_LINE_3')?><span class="hover"></span></button>
                            </div>                                                                      
                        </div>
                        <div class="container-fluid">
                            <div class="btn-title"><?=GetMessage('LABEL_GROUP_GARNITURA')?></div>
                            <div class="btn-group btn-group-garnitura" role="group">
                                <button type="button" class="btn btn-default btn-garnitura-1 <?=($arParams['GARNITURA'] == 'garnitura-1' ? 'checked' : NULL)?>" tabindex="-1" data-choice="garnitura-1" aria-checked="<?=($arParams['GARNITURA'] == 'garnitura-1' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_GARNITURA_1')?>"><?=GetMessage('LABEL_GARNITURA_1')?><span class="hover"></span></button>
                                <button type="button" class="btn btn-default btn-garnitura-2 <?=($arParams['GARNITURA'] == 'garnitura-2' ? 'checked' : NULL)?>" tabindex="-1" data-choice="garnitura-2" aria-checked="<?=($arParams['GARNITURA'] == 'garnitura-2' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_GARNITURA_2')?>"><?=GetMessage('LABEL_GARNITURA_2')?><span class="hover"></span></button>
                            </div> 
                        </div>
						<?if(COption::GetOptionString("mibok.glaza", "voice") == 'Y'):?>
							<div class="container-fluid">
								<div class="btn-title"><?=GetMessage('LABEL_GROUP_VOICE')?></div>
								<div class="btn-group btn-group-voice" role="group">
									<button type="button" class="btn btn-default btn-voice-1 <?=($arParams['VOICE'] == 'voice-1' ? 'checked' : NULL)?>" tabindex="-1" data-choice="voice-1" aria-checked="<?=($arParams['voice'] == 'voice-1' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_VOICE_1')?>"><span class="glyphicon glyphicon-volume-off"></span>&nbsp;<?=GetMessage('LABEL_VOICE_1')?><span class="hover"></span></button>
									<button type="button" class="btn btn-default btn-voice-2 <?=($arParams['VOICE'] == 'voice-2' ? 'checked' : NULL)?>" tabindex="-1" data-choice="voice-2" aria-checked="<?=($arParams['voice'] == 'voice-2' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_VOICE_2')?>"><span class="glyphicon glyphicon glyphicon-minus-sign"></span>&nbsp;<?=GetMessage('LABEL_VOICE_2')?><span class="hover"></span></button>
									<button type="button" class="btn btn-default btn-voice-3 <?=($arParams['VOICE'] == 'voice-3' ? 'checked' : NULL)?>" tabindex="-1" data-choice="voice-3" aria-checked="<?=($arParams['voice'] == 'voice-3' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_VOICE_3')?>"><span class="glyphicon glyphicon-volume-up"></span>&nbsp;<?=GetMessage('LABEL_VOICE_3')?><span class="hover"></span></button>
									<button type="button" class="btn btn-default btn-voice-4 <?=($arParams['VOICE'] == 'voice-4' ? 'checked' : NULL)?>" tabindex="-1" data-choice="voice-4" aria-checked="<?=($arParams['voice'] == 'voice-4' ? 'true' : 'false')?>" aria-label="<?=GetMessage('LABEL_VOICE_4')?>"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;<?=GetMessage('LABEL_VOICE_4')?><span class="hover"></span></button>
								</div> 
								<div class='pull-right p-loud'>
										<?=GetMessage('LABEL_LOUDNESS')?><span id='current-volume'><?=((float)(str_replace('volume-', '', $arParams['VOLUME'])) * 100)?></span>
								</div>
							</div>  
						<?endif;?>
                        <div class="panel-reset">
                            <div class="container-fluid">
                                <div class="btn-group btn-group-reset" role="group">
                                    <button type="button" class="btn btn-default btn-reset" tabindex="-1" data-choice="reset" aria-label="<?=GetMessage('LABEL_SET_DEFAULT_SETTINGS')?>"><span class="glyphicon glyphicon glyphicon-refresh"></span>&nbsp;<?=GetMessage('LABEL_SET_DEFAULT_SETTINGS')?><span class="hover"></span></button>
                                </div>   
                                <div class="btn-group btn-group-home" role="group">
                                    <a class="btn btn-default" href="<?if(!empty($query)) echo '?'.$query.'&special_version=N'; else echo '?special_version=N';?>" tabindex="-1"  aria-label="<?=GetMessage('LABEL_HOME')?>" title="<?=GetMessage('LABEL_HOME')?>"><span class="glyphicon glyphicon-eye-close"></span>&nbsp;<?=GetMessage('LABEL_HOME')?><span class="hover"></span></a>
                                </div>
                                <div class="btn-group btn-group-close" role="group">
                                    <button type="button" class="btn btn-default btn-close" tabindex="-1" data-choice="setting" aria-label="<?=GetMessage('LABEL_CLOSE_ADVANCED_SETTINGS')?>"><span class="glyphicon glyphicon glyphicon-menu-up"></span>&nbsp;<?=GetMessage('LABEL_CLOSE_ADVANCED_SETTINGS')?><span class="hover"></span></button>
                                </div>  
                            </div>
                        </div>
                        <?//if(COption::GetOptionString("mibok.glaza", "copyright") == 'Y'):?>
                            <div class="author-mibok">
                                <a href="http://glaza.mibok.ru/" target="_blank"><?=GetMessage('LABEL_COPYRIGHT')?></a>
                            </div>
                        <?//endif;?>
                    </div>
                    <?$APPLICATION->IncludeComponent("mibok:special_auth_panel", '')?>  
                    
                </div>        
                
            </div>    
        </div>
    </div>
</div>
<?
return $arParams;
?>

