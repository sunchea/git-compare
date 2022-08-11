<?define( "LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

//новая заявка
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', 'IBElementCreateAfterHandler');

function IBElementCreateAfterHandler(&$arFields) {
	  
	if($arFields['IBLOCK_ID'] == 28) {
		
		$EVENT_TYPE = 'ADD_IBLOCK_ORDER'; // тип почтового шаблона  
		$ValueProper1 = array();

		$arMailFields['ID'] = $arFields['ID']; 
		$arMailFields['IBLOCK_ID'] = $arFields['IBLOCK_ID']; 
		$arMailFields['NAME'] = $arFields['NAME'];

		foreach($arFields['PROPERTY_VALUES'] as $key => $value) {
			if(is_numeric($key)) {
				$res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], "sort", "asc", array("ID" => $key));                     
			} else {
				$res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], "sort", "asc", array("CODE" => $key));                    
			}

			while ($ob = $res->GetNext()) {
				$ValueProper1[] = $ob; 
			} 

			foreach($ValueProper1 as $key => $ValueProper) {

				if($ValueProper['PROPERTY_TYPE'] == 'E') {

					if(is_array($arFields['PROPERTY_VALUES'][$ValueProper['ID']])){
						$properElement = $arFields['PROPERTY_VALUES'][$ValueProper['ID']];   
					} else {
						$properElement = array($arFields['PROPERTY_VALUES'][$ValueProper['ID']]);       
					}

					$mailListElement = '';
					$arSelect = Array("ID", "NAME");
					$arFilter = Array("ID"=> $properElement);
					$respro = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
					while($arrproRes = $respro->Fetch()) {
						$mailListElement .= $arrproRes['NAME'].', ' ;
					}
					$arMailFields['PROPERTY_'.$ValueProper['CODE']] = $mailListElement;
					
				} elseif($ValueProper['PROPERTY_TYPE'] == 'S') {
					
					$result = array();
					if(!(in_array($ValueProper['VALUE'], $arMailFields['PROPERTY_'.$ValueProper['CODE']]))){
						$arMailFields['PROPERTY_'.$ValueProper['CODE']][] = $ValueProper['VALUE'];
					}

				} else {

					$arMailFields[$ValueProper['CODE']] = $ValueProper['VALUE'];
					if(!empty($ValueProper['VALUE_ENUM'])) {
						$arMailFields['PROPERTY_'.$ValueProper['CODE']] = $ValueProper['VALUE_ENUM'];
					}
					
				}
			}
		}
		
		$resFiles = CIBlockElement::GetList(array(), array("ID" => $arFields["ID"]), false, false, array("ID", "IBLOCK_ID", "PROPERTY_PASPORT_FILE", "PROPERTY_DOVERENNOST", "PROPERTY_PLAN_RASPOLOZHENIA", "PROPERTY_ODNOLIN_SCHEMA", "PROPERTY_DOK_SOBSTVENNOSTI")) -> Fetch();
		foreach ($resFiles as $key => $val) {
			if ($val && strpos($key, "PROPERTY") !== false && strpos($key, "ID") === false)
				$arFiles[] = $val;
		}
		
		$filter = Array("ACTIVE" => "Y", "GROUPS_ID"=> Array(5));
		$arSelect = array( "NAME", "EMAIL" );
		$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter, array("FIELDS"=>$arSelect, "SELECT"=>array()));
		
		while($arItem = $rsUsers->GetNext()) {
			$arMailFields['EMAIL_TO'] = $arItem["EMAIL"];
		}
		
		//AddMessage2Log('$arMailFields = '.print_r($arMailFields, true),'');
		//AddMessage2Log('$arFiles = '.print_r($arFiles, true),'');
		CEvent::Send($EVENT_TYPE, "s1", $arMailFields, "N", 18, $arFiles);
		
	}     

}

// изменение статуса заявки
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MyClass", "OnAfterIBlockElementUpdateHandler"));

class MyClass {
	
	function OnAfterIBlockElementUpdateHandler(&$arFields) {
		
		if($arFields['IBLOCK_ID'] == 28) {
			
			if($arFields["RESULT"]) {
				global $USER;
				$EVENT_TYPE = 'ADD_IBLOCK_ORDER';
				
				$arMailFields['ID'] = $arFields['ID']; 

				$arFilter = Array("IBLOCK_ID" => $arFields['IBLOCK_ID'], "ID" => $arFields['ID']);
				$arSelect = Array("CREATED_BY");
				$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
				while($row = $res->GetNext()) {
					$filter = Array("ID" => $row['CREATED_BY'],	"ACTIVE" => "Y");
					$arSell = array("ID", "EMAIL");
					$rsUsers = CUser::GetList(($by="timestamp_x"), ($order="desc"), $filter, array("FIELDS" => $arSell)) -> Fetch();
					$arMailFields['EMAIL_TO'] = $rsUsers['EMAIL'];
				}
				
				foreach ($GLOBALS["ORDER_STAGES"] as $val) {
					$arCode[] = $val["COMPLETION_PROPERTY_CODE"];
				}
				$res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], "sort", "asc", array("CODE" => $arCode));
				while ($arProp = $res->GetNext()) {
					if (in_array($arProp['CODE'], $arCode) && $arProp["VALUE"])
						$arMailFields['STATUS'] = $arProp['NAME'];
				}
				
				if (!empty($arMailFields['STATUS'])) {
					AddMessage2Log('$arMailFields = '.print_r($arMailFields, true),'');
					CEvent::SendImmediate($EVENT_TYPE, "s1", $arMailFields, "N", 19);
				}
			}
			
		} else {
			
			AddMessage2Log("Ошибка изменения записи ".$arFields["ID"]." (".$arFields["RESULT_MESSAGE"].").");
			
		}
		
	}
	
}
?>