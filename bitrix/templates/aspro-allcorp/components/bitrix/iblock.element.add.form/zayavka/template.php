<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);?>

<pre style="display:none"><?print_r($arResult["ELEMENT_PROPERTIES"])?></pre>

<div class="row zayavka">

	<?if ($_GET["fiz"] == "Y"):?>
		<div class="title">Заявка физического лица</div>
	<?else:?>
		<div class="title">Заявка юридического лица</div>
	<?endif;?>

	<?if (!empty($arResult["ERRORS"])):
		ShowError(implode("<br />", $arResult["ERRORS"]));
	endif;
	if (strlen($arResult["MESSAGE"]) > 0):
		ShowNote($arResult["MESSAGE"]);
	endif;?>

	<form class="first_form" name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
	
		<?=bitrix_sessid_post()?>
	
		<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
		
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
		
			<?if ($_GET["fiz"] == "Y"):?>
				
				<select class="hidden" name="PROPERTY[142]">
					<option value="102" selected="selected">Физическое лицо</option>
				</select>
				
				<div class="field">
					<label for="PROPERTY[NAME][0]" class="name_field">Ф.И.О.</label>
					<input type="text" name="PROPERTY[NAME][0]" id="PROPERTY[NAME][0]" value="<?=$arResult["ELEMENT"]["NAME"]?>" />
				</div>
				<div class="field">
					<label for="PROPERTY[135][0]" class="name_field">Паспортные данные (Серия, номер, кем и когда выдан)</label>
					<input type="text" name="PROPERTY[135][0]" id="PROPERTY[135][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][135][0]["VALUE"]?>" />
				</div>
				<div class="field">
					<label class="name_field">Паспорт</label>
					<div class="double_field">
						<input type="text" name="PROPERTY[138][0]" id="PROPERTY[138][0]" value="" placeholder="Ссылка на файл" />
						<input type="hidden" name="PROPERTY[136][0]" value="">
						<label>
							<span class="btn btn-primary btn-min">Прикрепить</span>
							<input type="file" name="PROPERTY_FILE_136_0">
						</label>
					</div>
				</div>
				<div class="field">
					<label for="PROPERTY[137][0]" class="name_field">Адрес прописки</label>
					<input type="text" name="PROPERTY[137][0]" id="PROPERTY[137][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][137][0]["VALUE"]?>" />
				</div>
				
				<?//элементы юрлица с прочерком?>
				<input type="hidden" name="PROPERTY[122][0]" value="-" />
				<input type="hidden" name="PROPERTY[123][0]" value="-" />
				<input type="hidden" name="PROPERTY[124][0]" value="-" />
				
			<?else:?>
			
				<select class="hidden" name="PROPERTY[142]">
					<option value="103" selected="selected">Юридическое лицо</option>
				</select>
				<div class="field">
					<label for="PROPERTY[NAME][0]" class="name_field">Полное наименование заявителя – юридического лица, Ф.И.О. – ИП</label>
					<input type="text" name="PROPERTY[NAME][0]" id="PROPERTY[NAME][0]" value="<?=$arResult["ELEMENT"]["NAME"]?>" />
				</div>
				<div class="field">
					<label for="PROPERTY[122][0]" class="name_field">Номер записи в Едином государственном реестре юридических лиц и дата ее внесения</label>
					<input type="text" name="PROPERTY[122][0]" id="PROPERTY[122][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][122][0]["VALUE"]?>" />
				</div>
				<div class="field">
					<label class="name_field">Место нахождения заявителя, в том числе фактический адрес</label>
					<div class="double_field">
						<input type="text" name="PROPERTY[123][0]" id="PROPERTY[123][0]" value="" placeholder="Юридический адрес (Зарегистрирован)" />
						<input type="text" name="PROPERTY[124][0]" id="PROPERTY[124][0]" value="" placeholder="Фактический адрес проживания" />
					</div>
				</div>
				
				<?//элементы физлица с прочерком?>
				<input type="hidden" name="PROPERTY[135][0]" value="-" />
				<input type="hidden" name="PROPERTY[137][0]" value="-" />
				<input type="hidden" name="PROPERTY[138][0]" value="-" />
				
			<?endif;?>
			
			<?//общие элементы?>
			<div class="field">
				<label class="name_field">Доверенность или иные документы, подтверждающие полномочия представителя заявителя, подающего и получающего документы, в случае если заявка подается в сетевую организацию представителем заявителя </label>
				<div class="double_field">
					<input type="text" name="PROPERTY[139][0]" id="PROPERTY[139][0]" value="" placeholder="Ссылка на файл" />
					<input type="hidden" name="PROPERTY[125][0]" value="">
					<label>
						<span class="btn btn-primary btn-min">Прикрепить</span>
						<input type="file" name="PROPERTY_FILE_125_0">
					</label>
				</div>
			</div>
			<div class="field">
				<label for="PROPERTY[126][0]" class="name_field">Наименование энергопринимающих устройств для присоединения, например, административное здание, многоквартирный жилой дом, производственная база, торговый комплекс, индивидуальный жилой дом, садовый дом, гараж, баня и др</label>
				<input type="text" name="PROPERTY[126][0]" id="PROPERTY[126][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][126][0]["VALUE"]?>" />
			</div>
			<div class="field">
				<label class="name_field">План расположения энергопринимающих устройств, которые необходимо присоединить к электрическим сетям сетевой организации (с обозначением энергопринимающих устройств относительно объективных территориальных ориентиров, позволяющих определить его местоположение) </label>
				<div class="double_field">
					<input type="text" name="PROPERTY[140][0]" id="PROPERTY[140][0]" value="" placeholder="Ссылка на файл" />
					<input type="hidden" name="PROPERTY[127][0]" value="">
					<label>
						<span class="btn btn-primary btn-min">Прикрепить</span>
						<input type="file" name="PROPERTY_FILE_127_0">
					</label>
				</div>
			</div>
			<div class="field">
				<label class="name_field">Однолинейная схема электрических сетей заявителя</label>
				<div class="double_field">
					<input type="text" name="PROPERTY[141][0]" id="PROPERTY[141][0]" value="" placeholder="Ссылка на файл" />
					<input type="hidden" name="PROPERTY[128][0]" value="">
					<label>
						<span class="btn btn-primary btn-min">Прикрепить</span>
						<input type="file" name="PROPERTY_FILE_128_0">
					</label>
				</div>
			</div>
			<div class="field tochki">
				<label for="PROPERTY[129][0]" class="name_field">Количество точек присоединения</label>
				<select name="PROPERTY[129]">
					<option value="108" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 108) echo 'selected="selected"';?> >1</option>
					<option value="109" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 109) echo 'selected="selected"';?> >2</option>
					<option value="110" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 110) echo 'selected="selected"';?> >3</option>
					<option value="111" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 111) echo 'selected="selected"';?> >4</option>
					<option value="112" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 112) echo 'selected="selected"';?> >5</option>
					<option value="113" <?if ($arResult["ELEMENT_PROPERTIES"][129][0]["VALUE"] == 113) echo 'selected="selected"';?> >6</option>
				</select>
			</div>
			<div class="field tochki_input">
				<label class="name_field">Максимальная мощность присоединяемых энергопринимающих устройств по каждой точке подключения</label>
				<input type="text" name="PROPERTY[130][0]" placeholder="Точка подключения 1" value="<?=$arResult["ELEMENT_PROPERTIES"][130][0]["VALUE"]?>" />
				<input type="text" name="PROPERTY[130][1]" placeholder="Точка подключения 2" value="<?=$arResult["ELEMENT_PROPERTIES"][130][1]["VALUE"]?>" />
				<input type="text" name="PROPERTY[130][2]" placeholder="Точка подключения 3" value="<?=$arResult["ELEMENT_PROPERTIES"][130][2]["VALUE"]?>" />
				<input type="text" name="PROPERTY[130][3]" placeholder="Точка подключения 4" value="<?=$arResult["ELEMENT_PROPERTIES"][130][3]["VALUE"]?>" />
				<input type="text" name="PROPERTY[130][4]" placeholder="Точка подключения 5" value="<?=$arResult["ELEMENT_PROPERTIES"][130][4]["VALUE"]?>" />
				<input type="text" name="PROPERTY[130][5]" placeholder="Точка подключения 6" value="<?=$arResult["ELEMENT_PROPERTIES"][130][5]["VALUE"]?>" />
			</div>
			<div class="field">
				<label class="name_field">Заявляемая категория надежности</label>
				<div class="radio-box">
					<input id="property_100" type="radio" name="PROPERTY[131]" value="100" checked="checked" /><label for="property_100">2</label>
					<input id="property_101" type="radio" name="PROPERTY[131]" value="101" /><label for="property_101">3</label>
				</div>
			</div>
			<div class="field">
				<label for="PROPERTY[132][0]" class="name_field">Характер нагрузки (вид экономической деятельности заявителя) (промышленное предприятие, сельскохозяйственное предприятие, электрифицированный транспорт, потребление электрической энергии населением и приравненными к нему категориями, коммунально-бытовая, и т.д.)</label>
				<input type="text" name="PROPERTY[132][0]" id="PROPERTY[132][0]" value="<?=$arResult["ELEMENT_PROPERTIES"][132][0]["VALUE"]?>" />
			</div>
			<div class="field">
				<label class="name_field">Копия документа, подтверждающего право собственности или иное предусмотренное законом основание на объект капитального строительства (нежилое помещение в таком объекте капитального строительства) и (или) земельный участок, на котором расположены (будут располагаться) объекты заявителя, либо право собственности или иное предусмотренное законом основание на энергопринимающие устройства (для заявителей, планирующих осуществить технологическое присоединение энергопринимающих устройств потребителей, расположенных в нежилых помещениях многоквартирных домов или иных объектах капитального строительства, - копия документа, подтверждающего право собственности или иное предусмотренное законом основание на нежилое помещение в таком многоквартирном доме или ином объекте капитального строительства)</label>
				<div class="double_field">
					<input type="text" name="PROPERTY[147][0]" id="PROPERTY[147][0]" value="" placeholder="Ссылка на файл" />
					<input type="hidden" name="PROPERTY[133][0]" value="">
					<label>
						<span class="btn btn-primary btn-min">Прикрепить</span>
						<input type="file" name="PROPERTY_FILE_133_0">
					</label>
				</div>
			</div>
			
			<input type="submit" name="iblock_submit" class="btn btn-primary" value="Отправить" />
		
		<?endif?>
		
	</form>

</div>