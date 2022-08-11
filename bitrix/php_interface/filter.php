<?php

AddEventHandler('main', 'OnAdminIBlockSectionEdit', function () {
    $tabset = new CustomPropForFilter();
    return [
        'TABSET'  => 'some_tabset_name',
        'Check'   => [$tabset, 'check'],
        'Action'  => [$tabset, 'action'],
        'GetTabs' => [$tabset, 'getTabList'],
        'ShowTab' => [$tabset, 'showTabContent'],
    ];
});

 
class CustomPropForFilter
{

    static $valuesCeilHeader = array(
                                        'Название',
                                        'Тип отображения',
                                        'Зависимые свойства',
                                        'Объединять под одной шапкой',
                                        'Кнопка "скрыть"',
                                        'Сортировка',
                                        'Ширина(px)',
                                        'Центрирование',
                                        'Выводить сортировку',
                                    );

    static $valuesDisplayType = array(
                                    'none' => 'Без фильтра',
                                    'range' => 'Диапазон',
                                    'list' => 'Список',
                                    'key' => 'Ключ',
                                    'more' => 'Меньше значения',
                                    'less' => 'Больше значения',
                                );

    static $valuesTextCentering = array(
                                'center'  => 'По центру',
                                'left'  => 'По левому краю',
                                'right' => 'По правому краю',
                            );

    static $valuesCountOnPage = array(
                            '20'  => '20',
                            '50'  => '50',
                            'all' => 'Все',
                        );

    static $defaultChars = array(
                            "display_type" => "none",
                            "sort" => "500",
                            "show_sort" => "off",
                            "btn_hide" => "off",
                            "general_head" => "off",
                            "width" => "133",
                            "text_centering" => "center"
                        );

    public function getTabList($elementInfo)
    {
        return [
            [
                "DIV"   => 'tab_filter',
                "SORT"  => PHP_INT_MAX,
                "TAB"   => 'Фильтр',
                "TITLE" => 'Фильтр',
            ],
        ];
    }
 
    public function showTabContent($div, $elementInfo, $formData)
    {
        $filterCheck = self::checkFilter($IBLOCK_ID = 11, $elementInfo['ID']);

        if($filterCheck) {
            $valuesFilterRows = self::getValuesFilterRows($IBLOCK_ID, $elementInfo['ID']);
            self::updateCharsNewRows($IBLOCK_ID, $elementInfo['ID']);

            $count_on_page = self::getCountPage($IBLOCK_ID, $elementInfo['ID']);

            self::renderHtml($valuesFilterRows, $count_on_page);
        }

        return true;
    }

    protected function renderHtml($valuesFilterRows, $count_on_page)
    {   
        global $APPLICATION;
        $APPLICATION->SetAdditionalCss("/bitrix/templates/aspro-allcorp/css/admin_styles.css");

        echo "<div class='option-table'>";
        echo "<label>Количество выводимых элементов на одной странице: </label>";
            echo "<select name='count_on_page'>";
            foreach (self::$valuesCountOnPage as $key => $value) {
                if($key == $count_on_page) {
                    $attr = 'selected';
                } else {
                    $attr = '';
                }
                echo "<option value='{$key}' {$attr} >{$value}</option>";
            }
            echo "</select>";
        echo "</div>";


        echo "<div class='table-filter-admin'>";

        echo "<div class='row head'>";

        foreach(self::$valuesCeilHeader as $value) {
            echo "<div class='ceil'>";
            echo $value;
            echo "</div>";
        }

        echo "</div>";

        foreach ($valuesFilterRows as $row) {
            $id_prop = $row['id_prop'];

            echo "<div class='row'>";

            echo "<div class='ceil'>";
            echo $row['NAME'];
            echo "</div>";

            echo "<div class='ceil'>";
            echo "<select name='prop[{$id_prop}][display_type]'>";
            foreach (self::$valuesDisplayType as $key => $value) {
                if($key == $row['display_type']) {
                    $attr = 'selected';
                } else {
                    $attr = '';
                }
                echo "<option value='{$key}' {$attr} >{$value}</option>";
            }
            echo "</select>";
            echo "</div>";

            echo "<div class='ceil'>";
            echo "<select name='prop[{$id_prop}][dep_prop][]' multiple>";
            foreach ($valuesFilterRows as $id => $prop) {
                if( in_array($prop['CODE'], $row['dep_prop']) ) {
                    $attr = 'selected';
                } else {
                    $attr = '';
                }
                echo "<option value='{$prop['CODE']}' {$attr} >{$prop['NAME']}</option>";
            }
            echo "</select>";
            echo "</div>";

            echo "<div class='ceil'>";
            if($row['general_head'] == 'on') {
                echo "<input type='checkbox' name='prop[{$id_prop}][general_head]' checked>";
            } else {
                echo "<input type='checkbox' name='prop[{$id_prop}][general_head]'>";
            }
            echo "</div>";


            echo "<div class='ceil'>";
            if($row['btn_hide'] == 'on') {
                echo "<input type='checkbox' name='prop[{$id_prop}][btn_hide]' checked>";
            } else {
                echo "<input type='checkbox' name='prop[{$id_prop}][btn_hide]'>";
            }
            echo "</div>";

            echo "<div class='ceil'>";
            if($row['SORT']) {
                echo "<input type='text' name='prop[{$id_prop}][sort]' value='{$row['SORT']}'>";
            } else {
                echo "<input type='text' name='prop[{$id_prop}][sort]' value='500'>";
            }
            echo "</div>";

            echo "<div class='ceil'>";
            if($row['WIDTH']) {
                echo "<input type='text' name='prop[{$id_prop}][width]' value='{$row['WIDTH']}'>";
            } else {
                echo "<input type='text' name='prop[{$id_prop}][width]' value='133'>";
            }
            echo "</div>";

            
            echo "<div class='ceil'>";
            echo "<select name='prop[{$id_prop}][text_centering]'>";
            foreach (self::$valuesTextCentering as $key => $value) {
                if($key == $row['text_centering']) {
                    $attr = 'selected';
                } else {
                    $attr = '';
                }
                echo "<option value='{$key}' {$attr} >{$value}</option>";
            }
            echo "</select>";
            echo "</div>";


            echo "<div class='ceil'>";
            if($row['show_sort'] == 'on') {
                echo "<input type='checkbox' name='prop[{$id_prop}][show_sort]' checked>";
            } else {
                echo "<input type='checkbox' name='prop[{$id_prop}][show_sort]'>";
            }
            echo "</div>";


            echo "</div>";
        }

        echo "</div>";


    }

    protected function updateCharsNewRows($IBLOCK_ID, $idSection)
    {
        $defaultChars       = self::$defaultChars;
        $filterOptionsValue = self::getFilterOptionsValue($IBLOCK_ID, $idSection);

        foreach(CIBlockSectionPropertyLink::GetArray($IBLOCK_ID, $idSection) as $PID => $arLink)  {
            if($arLink["SMART_FILTER"] === "Y" && !$filterOptionsValue[$arLink['PROPERTY_ID']] ) {
                foreach (self::$defaultChars as $code => $value) {
                    $filterOptionsValue[$arLink['PROPERTY_ID']][$code] = $value;
                }
            }
        }

        $bs       = new CIBlockSection;
        $arFields = array(
                        'UF_INFO_FILTER'    => serialize($filterOptionsValue),
                    );
        $res = $bs->Update($idSection, $arFields);
    }

    protected function getPropById($id)
    {
        $properties = CIBlockProperty::GetList(Array(), Array("ID"=>$id));
        if ($prop_fields = $properties->GetNext()) {
            return $prop_fields;
        }
    }

    public function getValuesFilterRows($IBLOCK_ID, $idSection, $isPublic=false)
    {
        $filterOptionsValue = self::getFilterOptionsValue($IBLOCK_ID, $idSection);

        foreach(CIBlockSectionPropertyLink::GetArray($IBLOCK_ID, $idSection) as $PID => $arLink)  {
            if($arLink["SMART_FILTER"] === "Y") {
                $prop = self::getPropById($arLink['PROPERTY_ID']);
                $arProp[$arLink['PROPERTY_ID']]['NAME']           = $prop['NAME'];
                $arProp[$arLink['PROPERTY_ID']]['display_type']   = $filterOptionsValue[$arLink['PROPERTY_ID']]['display_type'];
                $arProp[$arLink['PROPERTY_ID']]['SORT']           = $filterOptionsValue[$arLink['PROPERTY_ID']]['sort'];
                $arProp[$arLink['PROPERTY_ID']]['show_sort']      = $filterOptionsValue[$arLink['PROPERTY_ID']]['show_sort'];
                $arProp[$arLink['PROPERTY_ID']]['btn_hide']       = $filterOptionsValue[$arLink['PROPERTY_ID']]['btn_hide'];
                $arProp[$arLink['PROPERTY_ID']]['dep_prop']       = $filterOptionsValue[$arLink['PROPERTY_ID']]['dep_prop'];
                $arProp[$arLink['PROPERTY_ID']]['id_prop']        = $arLink['PROPERTY_ID'];
                $arProp[$arLink['PROPERTY_ID']]['general_head']   = $filterOptionsValue[$arLink['PROPERTY_ID']]['general_head'];
                $arProp[$arLink['PROPERTY_ID']]['WIDTH']          = $filterOptionsValue[$arLink['PROPERTY_ID']]['width'];
                $arProp[$arLink['PROPERTY_ID']]['text_centering'] = $filterOptionsValue[$arLink['PROPERTY_ID']]['text_centering'];
                $arProp[$arLink['PROPERTY_ID']]['CODE']           = $prop['CODE'];

                if($isPublic) {
                    if($arProp[$arLink['PROPERTY_ID']]['display_type'] == 'list') {
                        $arAvVal = self::getAllAvailableValuesForList($IBLOCK_ID, $idSection, $prop['CODE']);
                        $arProp[$arLink['PROPERTY_ID']]['all_values'] = $arAvVal;
                    }
                }
            }
        }

        $arProp = self::sortArray($arProp);

        if($isPublic) {
            $arTemp = $arProp;
            foreach ($arTemp as $key => $prop) {
                if($prop['general_head']) {
                    foreach ($prop['dep_prop'] as $dep_prop) {
                        foreach ($arTemp as $keyEnd => $propEnd) {
                            if($propEnd['CODE'] == $dep_prop) {
                                $arProp[$key]['CHILD'][] = $propEnd;
                                unset($arProp[$keyEnd]);
                            }
                        }
                    }
                }
            }
        }

        return $arProp;
    }

    public function getFilterOptionsValue($IBLOCK_ID, $idSection)
    {
        $arFilter = array('IBLOCK_ID'=> $IBLOCK_ID, 'ID' => $idSection);
        $arSelect = array('UF_INFO_FILTER');
        $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
        while ($arSection = $res->Fetch()) {
            $filterOptionsValue = unserialize($arSection['UF_INFO_FILTER']);
        }

        return $filterOptionsValue;
    }

    public function getCountPage($IBLOCK_ID, $idSection)
    {
        $arFilter = array('IBLOCK_ID'=> $IBLOCK_ID, 'ID' => $idSection);
        $arSelect = array('UF_COUNT_ON_PAGE');
        $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
        while ($arSection = $res->Fetch()) {
            $filterOptionsValue = $arSection['UF_COUNT_ON_PAGE'];
        }

        return $filterOptionsValue;
    }

    public function sortArray($array)
    {
        $array = array_values($array);

        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array[$i]['SORT'] > $array[$j]['SORT']) {
                    $temp = $array[$j];
                    $array[$j] = $array[$i];
                    $array[$i] = $temp;
                }
            }
        }

        return $array;
    }

    public function sortPropsForList($array, $IBLOCK_ID, $idSection)
    {
        $filterOptionsValue = self::getFilterOptionsValue($IBLOCK_ID, $idSection);

        foreach ($filterOptionsValue as $key => $item) {
            foreach ($array as $key2 => $item2) {
               if($item2['ID'] == $key && $item['sort'] != $item2['SORT']) {
                    $array[$key2]['SORT'] = $item['sort'];
               }
            }
        }

        $array = self::sortArray($array);
        return $array;
    }

    public function getAllAvailableValuesForList($IBLOCK_ID, $idSection, $PROPERTY_CODE)
    {
        $arSelect = Array();
        $arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "IBLOCK_SECTION_ID" => $idSection);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNextElement()) {
            $arProps = $ob->GetProperties();
            if($arProps[$PROPERTY_CODE]['VALUE']) {
                $arAvail[$arProps[$PROPERTY_CODE]['VALUE_ENUM_ID']] = $arProps[$PROPERTY_CODE]['VALUE'];
            }
        }

        return $arAvail;
    }

    protected function checkFilter($IBLOCK_ID, $idSection)
    {
        $arFilter = array('IBLOCK_ID'=> $IBLOCK_ID , '=UF_DISPLAY_FILTER' => '1', 'ID' => $idSection);
        $arSelect = array('UF_DISPLAY_FILTER'); 
        $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
        $filter = false;
        while ($arSection = $res->Fetch()) {
            $filter = true;
        }

        return $filter;
    }
 
    public function check()
    {
        return true;
    }
 
    public function action()
    {   
        $props         = serialize($_REQUEST['prop']);
        $count_on_page = $_REQUEST['count_on_page'];

        $bs       = new CIBlockSection;
        $arFields = array(
                        'UF_INFO_FILTER'    => $props,
                        'UF_COUNT_ON_PAGE' => $count_on_page,
                    );
        $res = $bs->Update($_REQUEST['ID'], $arFields);

        return true;
    }

    public function getfilterItems()
    {
        return $result;
    }
}


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler");

function OnBeforeIBlockElementUpdateHandler(&$arFields) {
    if($arFields["IBLOCK_ID"] == 11) {
        $tmpAr = $arFields['PROPERTY_VALUES'];
        foreach ($tmpAr as $idProp => $prop) {
            $res = CIBlockProperty::GetByID($idProp);
            if($ar_res = $res->GetNext()) {
                if($ar_res['PROPERTY_TYPE'] == "N") {
                    foreach ($prop as $unknow_key => $value) {
                        $arFields['PROPERTY_VALUES'][$idProp][$unknow_key]['VALUE'] = str_replace(',', '.', $value['VALUE']);
                    }
                }
            }
        }
    }
}