<?
class MibokSpecialSiteComponentTemplates{
    
    protected $id;
    protected $arParams;
    protected $arCopyParams;
    protected $bSpecialComponents;
    
    function __construct($component_template_id){        
        if($arComponentTemplate = MibokSpecialSiteComponentTemplates::GetByID($component_template_id)){
            $this->id = $component_template_id;
            $this->arParams = $arComponentTemplate;
            if(in_array($this->arParams['COMPONENTS_NAME'], MibokSpecialSiteComponentTemplates::GetSpecialComponents())){
                $this->bSpecialComponents = true;
            }
        }
    }
    function CopyPrepare($prefix){
        $new_template = $prefix.'_'.$this->arParams['TEMPLATE'];        
        $arCopyParams = MibokSpecialSiteTemplates::GetPath($new_template, false, $this->arParams['TEMPLATE']);
        $arCopyParams['TEMPLATE'] = $new_template;
        $this->arCopyParams = array_merge($this->arParams, $arCopyParams);   
    }
    function MakeTemplateDir(){       
        MibokSpecialUtil::MakeDir($this->arCopyParams['COMPONENTS_PATH'].'/'.$this->arCopyParams['COMPONENTS_SPACE'].'/'.$this->arCopyParams['COMPONENTS_NAME'].'/'.$this->arCopyParams['COMPONENTS_TEMPLATE_NAME']);        
    }
    function CopySpecialTemplate(){
        $master_path = MIBOK_SPECIAL_MASTER_TEMPLATE_PATH.'/components';
        $from = $master_path.'/'.$this->arParams['COMPONENTS_SPACE'].'/'.$this->arCopyParams['COMPONENTS_NAME'].'/.default';
        $to = $this->arCopyParams['COMPONENTS_PATH'].'/'.$this->arCopyParams['COMPONENTS_SPACE'].'/'.$this->arCopyParams['COMPONENTS_NAME'].'/'.$this->arCopyParams['COMPONENTS_TEMPLATE_NAME'];        
        if(file_exists($from) && file_exists($to)){
            MibokSpecialUtil::CopyDir($from, $to);
        }
    }
    function CopyStandartTemplate(){        
        $from = $this->arParams['COMPONENTS_PATH'].'/'.$this->arParams['COMPONENTS_SPACE'].'/'.$this->arParams['COMPONENTS_NAME'].'/'.$this->arParams['COMPONENTS_TEMPLATE_NAME'];
        $to = $this->arCopyParams['COMPONENTS_PATH'].'/'.$this->arCopyParams['COMPONENTS_SPACE'].'/'.$this->arCopyParams['COMPONENTS_NAME'].'/'.$this->arCopyParams['COMPONENTS_TEMPLATE_NAME'];        
        if(file_exists($from) && file_exists($to)){
            MibokSpecialUtil::CopyDir($from, $to);
            if(file_exists($to.'/style.css'))
                rename ($to.'/style.css', $to.'/_style.css');
        }
    }
    function Copy($prefix){    
        $this->CopyPrepare($prefix);    
        if($this->bSpecialComponents){
            $this->MakeTemplateDir();
            $this->CopySpecialTemplate();
        }else{
            $this->MakeTemplateDir();
            $this->CopyStandartTemplate();
        }
    }    
    static function GetList($template_id = false){
        if(!$template_id){
            $arTemplateIDs = array_keys(MibokSpecialSiteTemplates::GetList());
        }else if(is_array($template_id)){
            $arTemplateIDs = $template_id;
        }else{
            $arTemplateIDs = array($template_id);
        }        
        $arResult = array();      
        foreach($arTemplateIDs as $arTemplateID){            
            if($arTemplate = MibokSpecialSiteTemplates::GetByID($arTemplateID)){                  
                $arComponetnsTemplateIDs = MibokSpecialSiteComponentTemplates::ReadComponentDir($arTemplate['COMPONENTS_PATH']);
                foreach($arComponetnsTemplateIDs as $arComponetnsTemplateID){
                    $arResult[$arComponetnsTemplateID] = $arTemplate;
                    $arResult[$arComponetnsTemplateID]['ID'] = $arComponetnsTemplateID;
                    $arComponetnsTemplateIDExp = explode('/', $arComponetnsTemplateID);
                    $arResult[$arComponetnsTemplateID]['COMPONENTS_TEMPLATE_NAME'] = $arComponetnsTemplateIDExp[count($arComponetnsTemplateIDExp)-1];
                    $arResult[$arComponetnsTemplateID]['COMPONENTS_NAME'] = $arComponetnsTemplateIDExp[count($arComponetnsTemplateIDExp)-2];
                    $arResult[$arComponetnsTemplateID]['COMPONENTS_SPACE'] = $arComponetnsTemplateIDExp[count($arComponetnsTemplateIDExp)-3];
                }
            }   
        }
        return $arResult;
    }
    static function GetByID($component_template_id){        
        $arComponentTemplate = MibokSpecialSiteComponentTemplates::GetList();
        if(is_array($arComponentTemplate[$component_template_id])){
            return $arComponentTemplate[$component_template_id];
        }
        return false;
    }
    static function ReadComponentDir($dir){
        $arComponentNameDir = array();
        $arComponentTemplateDir = array();
        $arSpaceComponentDir = MibokSpecialUtil::ReadDir($dir);
        foreach($arSpaceComponentDir as $arSpaceComponentDirItem){
            $arComponentNameDir = array_merge($arComponentNameDir, MibokSpecialUtil::ReadDir($arSpaceComponentDirItem));
        }
        foreach($arComponentNameDir as $arComponentNameDirItem){
            $arComponentTemplateDir = array_merge($arComponentTemplateDir, MibokSpecialUtil::ReadDir($arComponentNameDirItem));
        }
        return $arComponentTemplateDir;        
    }
    static function GetSpecialComponents(){
        return array(
            'advertising.banner',
            'breadcrumb',
            'form.result.new',
            'iblock.tv',
            'menu',
            'news',
            'news.list',
            'photogallery',
            'photogallery.detail',
            'photogallery.detail.list',
            'photogallery.detail.list.ex',
            'photogallery.gallery.list',
            'photogallery.section',
            'photogallery.section.list',
            'search.page',
            'system.pagenavigation',
            'voting.form',
            'voting.list',
            'voting.result'
        );
    }
}
?>