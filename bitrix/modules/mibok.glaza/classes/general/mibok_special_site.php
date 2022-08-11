<?
class MibokSpecialSite{
    
    protected $id;
    protected $arParams;
    protected $obSiteTemplates;
    protected $obSiteComponentTemplates;
    protected $prefix;    
    protected $arExcludeTemplate;
            
    function __construct($site_id, $arExcludeTemplate){   
        $this->arExcludeTemplate = array();
        if(is_array($arExcludeTemplate)){
            $this->arExcludeTemplate = $arExcludeTemplate;
        }
        $this->prefix = MIBOK_SPECIAL_PREFIX;        
        $this->arParams = array();        
        $dbSite = CSite::GetList($by="sort", $order="desc", Array("ID" => $site_id));
        if($arSite = $dbSite->Fetch()){
            $this->id = $arSite['ID'];
            $this->arParams = $arSite;            
        }              
       $this->ConstructSiteTemplates();
       $this->ConstructSiteComponentTemplates();
    }
    function ConstructSiteTemplates(){
        $this->obSiteTemplates = array();
        $arSiteTemplates = MibokSpecialSiteTemplates::GetList($this->id, $this->arExcludeTemplate);
        foreach($arSiteTemplates as $template_id=>$arSiteTemplatesItem){
            $this->obSiteTemplates[$template_id] = new MibokSpecialSiteTemplates($template_id);
        }
    }
    function ConstructSiteComponentTemplates(){
        $this->obSiteComponentTemplates = array();
        $arSiteTemplates = MibokSpecialSiteTemplates::GetList($this->id, $this->arExcludeTemplate);
        $arSiteComponentTemplates = array();
        foreach($arSiteTemplates as $template_id=>$arSiteTemplatesItem){
            $arSiteComponentTemplates = MibokSpecialSiteComponentTemplates::GetList($template_id);  
            foreach($arSiteComponentTemplates as $component_template_id=>$arSiteComponentTemplatesItem){                
                $this->obSiteComponentTemplates[$component_template_id] = new MibokSpecialSiteComponentTemplates($component_template_id);
            }
        }            
    }       
    function CopySiteTemplates(){
        foreach($this->obSiteTemplates as $key=>$obSiteTemplates){
            $obSiteTemplates->Copy($this->prefix);
        }
        $this->UpdateCondition();
    }
    function CopySiteComponentTemplates(){
        foreach($this->obSiteComponentTemplates as $key=>$obSiteComponentTemplates){
           $obSiteComponentTemplates->Copy($this->prefix);
        }        
    }    
    function UpdateCondition(){
        $rsTemplates = CSite::GetTemplateList($this->id);
        while($arTemplate = $rsTemplates->Fetch()){
           $arResultTemplate[]  = array('CONDITION' => $arTemplate['CONDITION'], 'SORT' => $arTemplate['SORT'], 'TEMPLATE' => $arTemplate['TEMPLATE']);
        }
        foreach($this->obSiteTemplates as $obSiteTemplate){
            $arResultTemplate[] = array('CONDITION' => $obSiteTemplate->GetCopyConditionValue(), 'SORT' => $obSiteTemplate->GetCopySortValue(), 'TEMPLATE' => $obSiteTemplate->GetCopyTemplateValue());
        }       
        $obSite = new CSite();
        $obSite->Update($this->id, array('ACTIVE' => "Y", 'TEMPLATE'=>$arResultTemplate));
    }
    static function GetList(){
        $arSites = array();
        $dbSite = CSite::GetList($by="sort", $order="desc", Array("ACTIVE" => "Y"));
        while($arSite = $dbSite->Fetch()){
            $arSites[$arSite['ID']] = $arSite;
        }
        return $arSites;
    }    
	
	function Update($id, $arTemplate)
	{
		$obSite = new CSite();
		$res = $obSite->Update($id, array('TEMPLATE' => $arTemplate));
	}
}
?>