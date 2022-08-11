<?
$last = true; //устанавливаем флаг того, что это последний этап
$days_from_start = 0; //количество дней, прошедших с начала действия заявки
$ORDER_STAGES = $GLOBALS["ORDER_STAGES"]; //этапы работы над заявкой

$date_start = new DateTime($arResult["DATE_ACTIVE_FROM"]); //дата начала активности заявки
$date_now = new DateTime(); //текущая дата

foreach($ORDER_STAGES as &$stage){
	
	if($arResult["PROPERTIES"][$stage["COMPLETION_PROPERTY_CODE"]]["VALUE"] || ($stage["AUTO_FINISH"] && ($diff >= $stage["DAYS_TOTAL"]))){
		if(!empty($arResult["PROPERTIES"][$stage["COMPLETION_PROPERTY_CODE"]."_DATE"]["VALUE"])){ //если задана вручную дата завершения этапа
			$diff_of_stage = date_diff($date_start, $date_of_stage)->format("%a") - $days_from_start; //количество дней, потребовавшихся на этап
			$stage["DAYS_PASSED"] = $diff_of_stage;
			$stage["DAYS_PASSED"] =  $diff > $stage["DAYS_TOTAL"] ? $stage["DAYS_TOTAL"] : $diff;
		}
		$days_from_start += $stage["DAYS_PASSED"]; //добавляем к количеству дней - дни текущего этапа
		if($diff >= $stage["DAYS_PASSED"]){ //если это не последний этап (ещё остались дни в запасе до текущей даты), то активируем следующий этап
			$last = true;
		}else{

	if(!$stage["COMPLETE"] && $last){ //если этап не завершён, но установлен флаг его активности, то он считается текущим
		$stage["DAYS_PASSED"] = $diff;
		$last = false; //следующий этап ещё не наступил
	//вычисляем десятичную дробь для ползунка
	if($stage["COMPLETE"]){ //если этап завершён, то ползунок занимает всё пространство, независимо от количества дней
		$stage["FRACTION"] = ($stage["DAYS_PASSED"] / $stage["DAYS_TOTAL"] < 1) ? ($stage["DAYS_PASSED"] / $stage["DAYS_TOTAL"]) : 1;
	}
}
?>