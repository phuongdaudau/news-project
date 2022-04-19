<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class Template
{
    public static function showButtonFilter($prefix, $itemsStatusCount, $currentFilterStatus, $paramsSearch)
    {
        $xhtml = null;
        $templateStatus = Config::get('phon.template.status');

        if (count($itemsStatusCount) > 0) {
            array_unshift($itemsStatusCount, [
                'count' => array_sum(array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);
            foreach ($itemsStatusCount as $item) { //count, status
                $statusValue = $item['status']; // active, inactive, block
                $statusValue = array_key_exists($statusValue, $templateStatus) ? $statusValue : 'default';
                $link = route($prefix) . "?filter_status=" . $statusValue;

                if ($paramsSearch['value'] !== "") {
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" . $paramsSearch['value'];
                }

                $class = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-info';

                $currentTemplateStatus = $templateStatus[$statusValue]; // ['name'=> 'Kích hoạt', 'class' => 'btn-success'],
                $xhtml .= sprintf('
                                <a href="%s" type="button" class="btn %s"> %s <span class="badge bg-white">%s</span> </a>', $link, $class, $currentTemplateStatus['name'], $item['count']);
            }
        }
        return $xhtml;
    }

    public static function showAreaSearch($prefix, $paramsSearch)
    {
        $xhtml = null;
        $templateSearch = Config::get('phon.template.search');
        $fieldInController = Config::get('phon.config.search');
        $prefix = (array_key_exists($prefix, $fieldInController) ? $prefix : 'default');
 
        $xhtmlField = null;
        foreach ($fieldInController[$prefix] as $field) { // all,id, name
            $xhtmlField .= sprintf('<li><a href="#" class="select-field" data-field="%s"> %s</a></li>', $field, $templateSearch[$field]['name']);
        }
        $searchField = (in_array($paramsSearch['field'], $fieldInController[$prefix])) ? $paramsSearch['field'] : "all";
        $xhtml = sprintf('<div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                                    %s <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    %s
                                </ul> 
                            </div>
                            
                            <input type="text" name="search_value" value="%s" class="form-control" >
                            <input type="hidden" name="search_field" value="%s">
                            <span class="input-group-btn">
                                <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                                <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                            </span>     
                        </div>', $templateSearch[$searchField]['name'], $xhtmlField, $paramsSearch['value'], $searchField);
        return $xhtml;
    }

    public static function showItemHistory($time, $by)
    {
        $xhtml = sprintf('
            <p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>', date(Config::get('phon.format.long_time'), strtotime($time)), $by);
        return $xhtml;
    }

    public static function showItemStatus($prefix, $id, $statusValue)
    {
        $templateStatus = Config::get('phon.template.status');
        $statusValue = array_key_exists($statusValue, $templateStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $templateStatus[$statusValue];
        $link          = route($prefix . '/status', ['status' => $statusValue, 'id' => $id]);
        $xhtml         = sprintf('
                       <button data-url ="%s" type="button" data-class ="%s" class="btn btn-round %s status-ajax">%s</button>', $link, $currentTemplateStatus['class'], $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    public static function showItemIsHome($prefix, $id, $isHomeValue)
    {
        $templateIsHome = Config::get('phon.template.is_home');
        $isHomeValue = array_key_exists($isHomeValue, $templateIsHome) ? $isHomeValue : '1';
        $currentTemplateIsHome = $templateIsHome[$isHomeValue];
        $link          = route($prefix . '/isHome', ['isHome' => $isHomeValue, 'id' => $id]);
        $xhtml         = sprintf(' <button data-url="%s" type="button" data-class="%s" class="btn btn-round %s is-home-ajax">%s</a>', $link, $currentTemplateIsHome['class'], $currentTemplateIsHome['class'], $currentTemplateIsHome['name']);
        return $xhtml;
    }

    public static function showItemSelect($prefix, $id, $displayValue, $fieldName)
    {
        $link = route($prefix . '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
        $templateDisplay = Config::get('phon.template.' . $fieldName);
        $xhtml = sprintf('<select name="select_change_attr" data-url = "%s" class="form-control">', $link);

        foreach ($templateDisplay  as $key => $value) {
            $xhtmlSelected = '';
            if ($key == $displayValue) $xhtmlSelected = 'selected="selected"';
            $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml .= '</select>';
        return $xhtml;
    }

    public static function showItemThumb($prefix, $thumbName, $thumbAlt)
    {
        $xhtml = sprintf('<img src="%s" alt="%s" class="zvn-thumb">', asset('news/images/' . $prefix . '/' . $thumbName),  $thumbAlt);
        return $xhtml;
    }

    public static function showButtonAction($prefix, $id)
    {
        $tmpButton = Config::get('phon.template.button');
        $buttonInArea = Config::get('phon.config.button');
        $prefix = (array_key_exists($prefix, $buttonInArea)) ? $prefix : "default";
        $listButtons = $buttonInArea[$prefix];

        $xhtml = '<div class="zvn-box-btn-filter">';
        foreach ($listButtons as $btn) // edit. delete
        {
            $currentButton = $tmpButton[$btn];
            $link = route($prefix . $currentButton['route-name'], ['id' => $id]);
            $xhtml .= sprintf('
                <a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                <i class="fa %s"></i></a>', $link,  $currentButton['class'], $currentButton['title'], $currentButton['icon']);
        }
        $xhtml .= '</div>';
        return $xhtml;
    }

    public static function showDatetimeFrontend($dataTime)
    {
        return date_format(date_create($dataTime), Config::get('phon.format.short_time'));
    }

    public static function showContent($content, $length, $prefix = '...')
    {
        $prefix = ($length == 0) ? '' : $prefix;
        $content = str_replace(['<p>', '</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/', '', substr($content, 0, $length)) . $prefix;
    }
}
