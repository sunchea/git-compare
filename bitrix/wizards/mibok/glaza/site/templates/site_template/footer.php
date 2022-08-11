<?IncludeTemplateLangFile(__FILE__);?>	
</div>
                    </div>
                </div>
            </div>      
            <?if($APPLICATION->GetCurDir() == '/'){?>
                #special_mibok_complementary#            
            <?}?>
            <footer class="bs-docs-footer" role="contentinfo">
                <div class="container wcag">
                    <div class="panel-group">
                        <button type="button" class="btn btn-default go-top" tabindex="0" aria-label="<?=GetMessage('GO_TOP_BUTTON_TITLE')?>"><span class="glyphicon glyphicon-circle-arrow-up"></span>&nbsp;<?=GetMessage('GO_TOP_BUTTON_TITLE')?><span class="hover"></span></button>
                    </div>    
                    #special_mibok_bottom_menu#
					<?if(CModule::IncludeModule('advertising')):?>
                    #special_mibok_advertising#               
					<?endif;?>					
                    <div class="row">
                        <div class="col-md-12" tabindex="0">
                            <div class="address"><strong><?=GetMessage('SITE_ADDRESS')?>:</strong> <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."glaza_mibok_include/site_address.php", "MIBOK_SPECIAL_COMPARE" => "N"));?></div>
                            <div class="address"><strong><?=GetMessage('SITE_EMAIL')?>:</strong> <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."glaza_mibok_include/site_email.php", "MIBOK_SPECIAL_COMPARE" => "N"));?></div>
                            <div class="address"><strong><?=GetMessage('SITE_PHONE')?>:</strong> <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."glaza_mibok_include/site_phone.php", "MIBOK_SPECIAL_COMPARE" => "N"));?></div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="copy"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."glaza_mibok_include/site_copy.php", "MIBOK_SPECIAL_COMPARE" => "N"));?></div>
                        </div>
                    </div>
                </div>                 
            </footer>
        </div>        
		
		
		
		
        <script src="<?=SITE_TEMPLATE_PATH?>/js/libs/jquery.scrollTo-min.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/libs/jquery.form.min.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/toolbar.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/menu.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/app.js"></script>
        <?$APPLICATION->IncludeComponent("mibok:special_check_auth", "", array("MIBOK_SPECIAL_COMPARE" => "N"))?>
		
		<?
		if(COption::GetOptionString('mibok.glaza', 'voice')  == 'Y'){
			?>
            <audio id='start_sound' src='http://glaza.mibok.ru/voice/start_voice.mp3' preload data-process='<?=SITE_TEMPLATE_PATH.'/ajax/get_voice.php'?>'></audio>
			<script src='<?=SITE_TEMPLATE_PATH?>/js/voice.js' type='application/javascript'></script>
			<?
		}
		?>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/custom.js"></script>
    </body>
</html>
