<?
$GLOBALS["ORDER_STAGES"] = array(
	0 => array(
		"NAME" => "Рассмотрение заявки",
		"CURRENT" => false,
		"COMPLETE" => false,
		"FRACTION" => 0,
		"DAYS_PASSED" => 0,
		"DAYS_TOTAL" => 7,
		"COMPLETION_PROPERTY_CODE" => "STATUS_ORDER_REVISION",
		"AUTO_FINISH" => true,
		"POPUP_COMMENT" => "",
	),
	1 => array(
		"NAME" => "Заключение договора",
		"CURRENT" => false,
		"COMPLETE" => false,
		"FRACTION" => 0,
		"DAYS_PASSED" => 0,
		"DAYS_TOTAL" => 5,
		"COMPLETION_PROPERTY_CODE" => "STATUS_CONTRACT_CONCLUSION",
		"AUTO_FINISH" => false,
		"POPUP_COMMENT" => "Максимальный срок - 5 дней при условии возврата подписанного заявителем договора в сетевую организацию в указанный срок",
	),
	2 => array(
		"NAME" => "Выполнение мероприятий по присоединению",
		"CURRENT" => false,
		"COMPLETE" => false,
		"FRACTION" => 0,
		"DAYS_PASSED" => 0,
		"DAYS_TOTAL" => 30,
		"COMPLETION_PROPERTY_CODE" => "STATUS_JOINING_ACTIVITIES",
		"AUTO_FINISH" => false,
		"POPUP_COMMENT" => "Максимальный срок - 30 дней в случае отсутствия необходимости реконструкции существующих сетей, капитального строительства и необходимости землеотвода",
	),
	3 => array(
		"NAME" => "Составления акта о технологическом присоединении и разграничение балансовой принадлежности",
		"CURRENT" => false,
		"COMPLETE" => false,
		"FRACTION" => 0,
		"DAYS_PASSED" => 0,
		"DAYS_TOTAL" => 10,
		"COMPLETION_PROPERTY_CODE" => "STATUS_JOINING_ACT",
		"AUTO_FINISH" => true,
		"POPUP_COMMENT" => "",
	),
);
$GLOBALS["JOINING_TARRIFS"] = array(
	0 => array(
		"voltage" => "0.4кВ",
		"power_levels" => array(
			"<=15"		=> 2296.80,
			"<=150"		=> 284.45,
			"<=670"		=> 60.25,
			">670"	    => 8.34
			
		),
	),
	1 => array(
		"voltages" => "6кВ - 10кВ",
		"power_levels" => array(
			"<=15"		=> 2296.80,
			"<=150"		=> 284.45,
			"<=670"		=> 60.25,
			">670"	    => 8.34
			
		),
	)
);
?>