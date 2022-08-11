<?php

function checkDisplayType($arItem, $parent, $displayArrow, $position) {
    echo $key;
    switch ($arItem["display_type"]) {
        case "more":
        case "less":
        case "key": ?>
                <input data-display="<?= $arItem["display_type"] ?>" class="key" type="text" name="<?= $arItem['CODE'] ?>" value="" /> <?
            break;
        case "range":
            ?>
            <div class="bx_filter_parameters_box_container_block">
                <div class="bx_filter_input_container">
                    <input
                        class="min-price"
                        type="text"
                        name="<?= $arItem["CODE"] ?>_MIN"
                        value=""
                        size="5"
                        data-display="<?= $arItem["display_type"] ?>"
                        data-pair="<?= $arItem['CODE']?>"
                        data-start-value="<?= $arItem["VALUES"]["MIN"]["VALUE"]?>"
                        />
                </div>
            </div>

            <div class="bx_filter_parameters_box_container_block">
                <div class="bx_filter_input_container">
                <input
                    class="max-price"
                    type="text"
                    name="<?= $arItem["CODE"] ?>_MAX"
                    value=""
                    size="5"
                    data-display="<?= $arItem["display_type"] ?>"
                    data-pair="<?= $arItem['CODE']?>"
                    data-start-value="<?= $arItem["VALUES"]["MAX"]["VALUE"]?>"
                    />
                </div>
            </div>
            <?
            break;
        case "list":
            ?>
            <div class="select-outer" data-name="<?= $arItem["CODE"] ?>">
                <div class="select_open"> ЗНАЧЕНИЯ </div>

                <label class="checkbox-table-filter display_none">
                    <input type="checkbox" name="<?= $arItem["CODE"] ?>" value="all" data-display="<?= $arItem["display_type"] ?>" checked>
                    <span><?= $val ?></span>
                </label>

                <div class="items">         
                    <?php foreach($arItem['all_values'] as $id => $val): ?>
                        <label class="checkbox-table-filter">
                            <input type="checkbox" name="<?= $arItem["CODE"] ?>" value="<?=$id?>" data-display="<?= $arItem["display_type"] ?>" checked>
                            <span><?= $val ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?
            break;
        case "none":
            if(!$parent) :?>
                <div class="bx_filter_parameters_box_title">
                    <?=$arItem["NAME"]?>
                </div>
            <?php endif;
            break;
    }
}

?>

<div class="row_filter">
    <div class="reset_filter">
        
        <div class="show_count">
            Показано <span class="cur_count"></span> из <span class="all_count"></span> строк
        </div>

        <div class="reset">
            ВОССТАНОВИТЬ ТАБЛИЦУ
        </div>

    </div>
    <?php
    $filterItems = CustomPropForFilter::getValuesFilterRows($arParams["IBLOCK_ID"], $arResult['VARIABLES']['SECTION_ID'], true);
    ?>

    <div class="filter-catalog-main filter horizontal">
        <div class="bx_filter_section">
            <form class="filter_catalog">
                <?php $count = 0; ?>
                <?  foreach($filterItems as $key=>$arItem) {
                    $countCeil = count($arItem['CHILD']);
                    if($countCeil) {
                        $strChild = '';
                        $width = 0;
                        foreach ($arItem['CHILD'] as $child) {
                            $width += $child['WIDTH'];
                            $strChild .= $child['CODE']." ";
                        }
                        $width += $arItem['WIDTH'];
                        $strWidth = 'style="width: '.$width.'px"';
                        $classForContainer = 'childrenContainer';
                        $classForCeil = 'children';
                    } else {
                        $strChild = '';
                        $width = $arItem['WIDTH'];
                        $strWidth = 'style="width: '.$width.'px"';
                        $classForCeil = '';
                        $classForContainer = '';
                    }
                    ?>
                        <div <?= $strWidth ?> data-child='<?= $strChild ?>' data-prop-code="<?= $arItem['CODE'] ?>" data-display="<?= $arItem["DISPLAY_TYPE"] ?>" class="bx_filter_parameters_box <? if(!$count) echo 'box_filter_sticky'; ?> col-md-12">
                            <div class="bx_filter_parameters_box_title"><?=$arItem["NAME"]?> <?= ($arItem['show_sort'] == 'on') ? '<img data-prop-code="'.$arItem['CODE'].'" data-status-sort="none" data-number-sort="0" class="arrows_sort" src="/images/arrows.png">' : ''; ?> </div>
                            <div class="bx_filter_block <?=$classForContainer?>">
                                <div class="bx_filter_parameters_box_container <?=$classForCeil?>">
                                    <?php
                                        checkDisplayType($arItem, true);
                                    ?>
                                </div>

                                <?php
                                foreach ($arItem['CHILD'] as $key => $arChildren) { ?>
                                    <div class="bx_filter_parameters_box_container <?=$classForCeil?>">
                                        <?php
                                            checkDisplayType($arChildren, false);
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php $count++; ?>

                            <?php if ($count != 1):
                                if($arItem['btn_hide']):
                                    $hideCode = array();
                                    $hideCode[] = $arItem['CODE'];
                                    if($arItem['dep_prop']) {
                                        foreach ($arItem['dep_prop'] as $key) {
                                            $hideCode[] = $filterItems[$key]['CODE'];
                                        }
                                    }

                                    if($arItem['CHILD']) {
                                        foreach ($arItem['CHILD'] as $item) {
                                            $hideCode[] = $item['CODE'];
                                        }
                                    }

                                    $hideCode = json_encode($hideCode); ?>
                                    <div class="hide_element">
                                        <div class="btn_hide_element" data-code-hide='<?= $hideCode ?>'>
                                            СКРЫТЬ
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="btn_container">
                                    <div class="compare_row">
                                        <div class="compare">
                                            СРАВНИТЬ
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?
                    }
                    ?>
            </form>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>