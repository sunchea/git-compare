<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/search/prolog.php");
IncludeModuleLangFile(__FILE__);
/** @global CMain $APPLICATION */
global $APPLICATION;
/** @var CAdminMessage $message */

$module_id = "mibok.glaza";

$POST_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($POST_RIGHT=="D"){
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

$res=false;
if($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["Reindex"]=="Y"){
	CUtil::JSPostUnescape();
        
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");        
        
        $arError = array();
        if($Full = 'N'){
            $arError['template_id'] = GetMessage("NO_TEMPLATE");
            if(is_array($templates_id)){
                if(count($templates_id)){
                    unset($arError['template_id']);
                }
            }
            $arError['site_id'] = GetMessage("NO_SITE");
            if($site_id){            
                unset($arError['site_id']);            
            }
            
            if(count($arError) == 0){
                
                $arNeedReindex = MibokSpecialParseCompare::GetNeedReindex();
                $res = array_sum($arNeedReindex);

                $arSiteTemplates = MibokSpecialSiteTemplates::GetList($site_id);   
                $arExcludeTemplate = array();        
                foreach($arSiteTemplates as $arSiteTemplatesItem){            
                    if(strpos($arSiteTemplatesItem['TEMPLATE'], 'special_mibok') !== false || !in_array($arSiteTemplatesItem['TEMPLATE'], $templates_id)){
                        $arExcludeTemplate[] = $arSiteTemplatesItem['TEMPLATE'];  	
                    }
					//бекапирование старого шаблона special_mibok_...
					if(strpos($arSiteTemplatesItem['TEMPLATE'], 'special_mibok') !== false)
					{
						$new_name = $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.str_replace( 'special_mibok','backup_mibok',$arSiteTemplatesItem['TEMPLATE']);
						MibokSpecialUtil::CopyDir($arSiteTemplatesItem['PATH'], $new_name);
						$descr_name = $new_name.'/lang/ru/description.php';
						$descr = file_get_contents($descr_name);
						$descr = str_replace(GetMessage('REDESCRIPTION'),GetMessage('REDESCRIPTION').' ('.date('d.m.Y').')',$descr);
						file_put_contents($descr_name, $descr, FILE_APPEND | LOCK_EX);
					}

                }            
               
				global $arTypeMenu;
				$arTypeMenu = array();
                $obMibokSpecialSite = new MibokSpecialSite($site_id, $arExcludeTemplate);
                $obMibokSpecialSite->CopySiteTemplates();
                //$obMibokSpecialSite->CopySiteComponentTemplates();
				//MibokSpecialExclusion::GenerateExlusion();
				$arTypeMenu = array();
				
                $arNeedReindex = MibokSpecialParseCompare::GetNeedReindex();
                $res = $res - array_sum($arNeedReindex);  
                
                if($res>=0){
                    CAdminMessage::ShowMessage(array(
                            "MESSAGE"=>GetMessage("SEARCH_REINDEX_COMPLETE"),
                            "DETAILS"=>GetMessage("SEARCH_REINDEX_TOTAL")." <b>".$res."</b>",
                            "HTML"=>true,
                            "TYPE"=>"OK",
                    )); 
                    CAdminNotify::DeleteByTag("MIBOK_SPECIAL_NEED_REINDEX");
                }else{
                    CAdminMessage::ShowMessage(array(
                            "MESSAGE"=>GetMessage("NO_SEARCH_REINDEX_COMPLETE"),
                            "DETAILS"=>GetMessage("NO_SEARCH_REINDEX_COMPLETE_DETAIL"),
                            "HTML"=>true,
                            "TYPE"=>"ERROR",
                    ));
                }
            }
        }
        if(count($arError)){
            CAdminMessage::ShowMessage(array(
                    "MESSAGE"=>GetMessage("ERROR_PARAMETR"),
                    "DETAILS"=>implode('<br />', $arError),
                    "HTML"=>true,
                    "TYPE"=>"ERROR",
            ));
        }
	?>
        <script>
                CloseWaitWindow();
                EndReindex();
                var search_message = BX('search_message');
                if (search_message)
                        search_message.style.display = 'none';
        </script>
	<?
	require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin_js.php");
}else{
    $APPLICATION->SetTitle(GetMessage("SEARCH_REINDEX_TITLE"));
    $aTabs = array(
            array("DIV" => "edit1", "TAB" => GetMessage("SEARCH_REINDEX_TAB"), "ICON"=>"main_user_edit", "TITLE"=>GetMessage("SEARCH_REINDEX_TAB_TITLE")),
    );
    $tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

    $arNeedReindex = MibokSpecialParseCompare::GetNeedReindex();       
    $arCompareError = array();
    $res = array_sum($arNeedReindex);
    foreach($arNeedReindex as $template_key=>$arNeedReindexCount){        
        $arCompareError[] = "<li>".$template_key.": <b>".$arNeedReindexCount."</b></li>";
    }           
    if((count($arCompareError))){
        echo '<div id="search_message">';
        CAdminMessage::ShowMessage(array(
                "MESSAGE"=>GetMessage("SEARCH_REINDEX_NEED"),
                "DETAILS"=>GetMessage("SEARCH_REINDEX_NEED_TOTAL")." <b>".$res."</b><br /><ul>".implode('', $arCompareError).'</ul>',
                "HTML"=>true,
                "TYPE"=>"ERROR",
        )); 
        echo '</div>';
    }	
    ?>
    <script language="JavaScript">
    var stop;
    function StartReindex(){
        stop=false;
        document.getElementById('reindex_result_div').innerHTML='';	
        document.getElementById('start_button').disabled=true;
        DoNext();
    }
    function DoNext(){
        var queryString = 'Reindex=Y'
                + '&lang=<?echo htmlspecialcharsbx(LANG)?>';

        site_id = document.getElementById('LID').value;		    
        queryString += '&site_id=' + site_id;
        
        templates_id = document.getElementById('site_templates_'+site_id);
        for(i=0;i<templates_id.options.length;i++){
            if(templates_id.options[i].selected){
                //console.log(templates_id.options[i].value);
                queryString += '&templates_id['+templates_id.options[i].value+']='+templates_id.options[i].value;
            }
        }                
        
        if(document.getElementById('Full').checked){
            queryString += '&Full=N';
        }else{
            queryString+='&Full=Y';
        }	                
        
        if(!stop){
                ShowWaitWindow();
                BX.ajax.post(
                        'mibok.glaza_reindex.php?'+queryString,
                        false,
                        function(result){
                                document.getElementById('reindex_result_div').innerHTML = result;				
                                CloseWaitWindow();
                                StopReindex();				
                        }
                );
        }
        return false;
    }
    function StopReindex(){
        stop=true;	
        document.getElementById('start_button').disabled=false;	
    }
    function EndReindex(){
        stop=true;
        document.getElementById('start_button').disabled=false;	
    }
    </script>

    <div id="reindex_result_div" style="margin:0px"></div>

    <form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?lang=<?echo htmlspecialcharsbx(LANG)?>" name="fs1">
        <?
        $tabControl->Begin();
        $tabControl->BeginNextTab();
        ?>
        <tr style="display:none;">
                <td width="40%"><?echo GetMessage("SEARCH_REINDEX_REINDEX_CHANGED")?></td>
                <td width="60%"><input type="checkbox" name="Full" id="Full" value="N" checked></td>
        </tr>
        <tr>
                <td><?=GetMessage("SEARCH_REINDEX_SITE")?></td>
                <td><?echo CLang::SelectBox("LID", $str_LID, '', "", "id=\"LID\" onchange=\"SelectSite(this.value)\"");?></td>
        </tr>	
        <?        
        $arSiteTemplates = MibokSpecialSiteTemplates::GetList($site_id);   
        $arTemplatesBySites = array();
        $arSpecialTemplates = array();
        foreach($arSiteTemplates as $arSiteTemplatesItem){            
            if(strpos($arSiteTemplatesItem['TEMPLATE'], 'special_mibok') === false){
                $arTemplatesBySites[$arSiteTemplatesItem['SITE_ID']][$arSiteTemplatesItem['ID']] = $arSiteTemplatesItem;
                $arSites[$arSiteTemplatesItem['SITE_ID']] = $arSiteTemplatesItem['SITE_ID'];

            }else{
                $arSpecialTemplates[] = $arSiteTemplatesItem['TEMPLATE'];
            }
        }      

        ?>
        <script>
        function SelectSite(id){
                <?foreach($arSites as $arSitesItem){?>
                    BX('site_templates_<?=$arSitesItem?>').style.display='none';
                    BX('site_templates_<?=$arSitesItem?>').disabled=true;
                <?}?>                
                BX('site_templates_'+id).style.display='';
                BX('site_templates_'+id).disabled=false;
        }
        </script>
        <tr id="site_templates">
            <td width="40%"><?echo GetMessage("SEARCH_REINDEX_CLEAR_SUGGEST")?></td>
            <td width="60%">
                <?$i=0;?>
                <?foreach($arTemplatesBySites as $key=>$arTemplatesBySitesItem){?>
                <select id="site_templates_<?=$key?>" size="5" multiple="" name="templates[<?=$key?>]" <?=($i ? 'disabled = "disabled" style="display:none;"' : NULL )?>>                    
                <?
                foreach($arTemplatesBySitesItem as $arTemplate){
                    if(in_array('special_mibok_'.$arTemplate['TEMPLATE'], $arSpecialTemplates)){
                        ?><option value="<?echo $arTemplate['TEMPLATE']?>" selected="selected"><?echo $arTemplate['TEMPLATE']?></option><?
                    }
                }
                ?>
                <?$i+=1;?>
                </select>
                <?}?>
            </td>
        </tr>            

        <?$tabControl->Buttons();?>
        <input type="button" id="start_button" value="<?echo GetMessage("SEARCH_REINDEX_REINDEX_BUTTON")?>" OnClick="StartReindex();" class="adm-btn-save">	
        <?$tabControl->End();?>
    </form>
    <?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
}
?>
