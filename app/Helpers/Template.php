<?php
namespace App\Helpers;

use App\Models\CategoryProductModel;
use App\Models\CategoryArticleModel;
use Kalnoy\Nestedset\NodeTrait;

class Template {
    public static function showItemHistory ($by, $time) {
        $xhtml  = sprintf('<p><i class="fa fa-user"></i> %s</p>
                            <p><i class="fa fa-clock-o"></i> %s</p>', $by, date(config('return.format.long_time'), strtotime($time)));
        return $xhtml;
    }

    public static function showItemStatus ($controllerName, $id, $status) {
        $tmlStatus      = config('return.template.status');
        $statusValue    = array_key_exists($status, $tmlStatus) ? $status : 'default';
        $currentStatus  = $tmlStatus[$statusValue];
        $link           = route($controllerName . '/status', ['status' => $status, 'id' => $id]);

        $xhtml      = sprintf('<button data-url="%s" data-class="%s" type="button" class="btn btn-round %s ajax-status">%s</button>', $link, $currentStatus["class"], $currentStatus["class"], $currentStatus["name"]);
        return $xhtml;
    }
    
    public static function showItemOrdering ($controllerName, $orderingValue, $id) {
        $link           = route("$controllerName/ordering", ["ordering" => "value_new", "id" => $id]);
        $xhtml          = sprintf('<input type="number" class="form-control ordering" id="ordering-%s" value="%s" data-url="%s" style="width:60px">', $id, $orderingValue, $link);
        return $xhtml;
    }

    public static function showItemIsHome ($controllerName, $id, $isHome) {
        $tmlIsHome      = config('return.template.is_home');
        $isHomeValue    = array_key_exists($isHome, $tmlIsHome) ? $isHome : 'yes';
        $currentIsHome  = $tmlIsHome[$isHomeValue];
        $link           = route($controllerName . '/isHome', ['isHome' => $isHome, 'id' => $id]);

        $xhtml      = sprintf('<button data-url="%s" data-class="%s" type="button" class="btn btn-round %s ajax-is-home">%s</button>', $link, $currentIsHome["class"], $currentIsHome["class"], $currentIsHome["name"]);
        return $xhtml;
    }

    public static function showItemSelect ($controllerName, $id, $displayValue, $fieldName) {
        $tmlDisplay     = config('return.template.' . $fieldName);
        $link           = route($controllerName . '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
        $xhtml          = sprintf('<select name="select_change_attr" data-url="%s" class="form-control">', $link);
        foreach ($tmlDisplay as $key => $value) {
            $xhtmlSelected = '';
            if ($key == $displayValue) $xhtmlSelected = 'selected="selected"';
            $xhtml      .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml      .= '</select>';
        return $xhtml;
    }

    public static function showItemThumb ($controllerName, $thumbName, $thumbAlt) {
        $xhtml  = sprintf('<img src="%s" alt="%s" style="width:200px">', asset("image/$controllerName/$thumbName"), $thumbAlt);
        return $xhtml;
    }

    public static function showItemAvatar ($controllerName, $avatarItem, $thumbAlt) {
        $xhtml  = sprintf('<img src="%s" alt="%s" style="width:70px;height:70px;object-fit:cover;border-radius:40px">', asset("image/$controllerName/$avatarItem"), $thumbAlt);
        return $xhtml;
    }

    public static function showItemButton ($controllerName, $id) {
        $tmlButton      = config('return.template.button');
        $buttonInArea   = config('return.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButton     = $buttonInArea[$controllerName];

        $xhtml  = '<div class="zvn-box-btn-filter">';
        foreach ($listButton as $btn) {
            $currentButton  = $tmlButton[$btn];
            $link   = route($controllerName . $currentButton['route-name'], ['id' => $id]);
            $xhtml  .= sprintf('<a href="%s" type="button"
                                class="btn btn-icon %s" data-toggle="tooltip"
                                data-placement="top" data-original-title="%s">
                                <i class="fa %s"></i></a>', $link, $currentButton["class"], $currentButton["title"], $currentButton["icon"]);
        }
        $xhtml  .= '</div>';
        return $xhtml;
    }

    public static function showItemFilter ($controllerName, $countByStatus, $currentFilterStatus, $arrParamSearch) {
        $xhtml          = null;
        $tmlStatus      = config('return.template.status');
        if (count($countByStatus) > 0) {
            array_unshift($countByStatus, [
                'count'     => array_sum(array_column($countByStatus, 'count')),
                'status'    => 'all'
            ]);
            
            foreach ($countByStatus as $value) {
                $statusValue    = $value['status'];
                $statusValue    = array_key_exists($statusValue, $tmlStatus) ? $statusValue : 'default';

                $currentStatus  = $tmlStatus[$statusValue];

                $link           = route($controllerName) . '?filter_status=' . $statusValue;
                if ($arrParamSearch !== "") {
                    $link   .= "&search_field=" . $arrParamSearch['field'] . "&search_value=" . $arrParamSearch['value'];
                }
                $class          = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-success';

                $xhtml      .= sprintf('<a href="%s" type="button" class="btn %s">
                                %s <span class="badge bg-white">%s</span></a>', $link, $class, $currentStatus['name'], $value['count']);
            }
        }
        return $xhtml;
    }

    public static function showAreaSearch ($controllerName, $arrParamSearch) {
        $xhtml              = null;
        $tmlField           = config('return.template.search');
        $fieldInController  = config('return.config.search');

        $controllerName     = (array_key_exists($controllerName, $fieldInController) ? $controllerName : 'default');
        $xhtmlField         = null;
        foreach ($fieldInController[$controllerName] as $key => $value) {
            $xhtmlField     .= sprintf('<li><a href="#"
            class="select-field" data-field="%s">%s</a></li>', $value, $tmlField[$value]['name']);
        };

        $searchField        = (in_array($arrParamSearch['field'], $fieldInController[$controllerName])) ? $arrParamSearch['field'] : 'all';

        $xhtml      = sprintf('<div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button"
                                            class="btn btn-default dropdown-toggle btn-active-field"
                                            data-toggle="dropdown" aria-expanded="false">
                                            %s <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            %s
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control" name="search_value" value="%s">
                                    <span class="input-group-btn">
                                        <button id="btn-clear" type="button" class="btn btn-success"
                                            style="margin-right: 0px">Clear</button>
                                        <button id="btn-search" type="button" class="btn btn-primary">Search</button>
                                    </span>
                                    <input type="hidden" name="search_field" value="%s">
                                    </div>', $tmlField[$searchField]['name'], $xhtmlField, $arrParamSearch['value'], $searchField);
        return $xhtml;
    }

    public static function highlightWords ($input, $paramSearch, $field){
        if($paramSearch['value'] == "") return $input;
        if($paramSearch['field'] == "all"|| $paramSearch['field'] == $field) {
            return preg_replace("/" . preg_quote($paramSearch['value'], "/") . "/i", "<span class='highlight'>$0</span>", $input);
        }
    }

    public static function showContent($input, $length, $prefix = '...'){
        $prefix     = ($length == 0) ? '' : $prefix;
        $input      = str_replace(['<p>', '</p>'], '', $input);
        return preg_replace('/\s+?(\S+)?$/', '', substr($input, 0 , $length)) . $prefix;
    }

    public static function sortByPrice($controllerName, $displayValue) {
        $tmlSort        = config('return.template.sort');
        $link           = route($controllerName) . '?sort_by_price=';
        $xhtml          = sprintf('<select name="select_change_attr" data-url="%s">', $link);
        foreach ($tmlSort as $key => $value) {
            $xhtmlSelected = '';
            if ($key == $displayValue) $xhtmlSelected = 'selected="selected"';
            $link           = ".$key";
            $xhtml      .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml      .= '</select>';
        return $xhtml;
    }

    public static function showDatetimeFrontend ($dateTime) {
        return date_format(date_create($dateTime), config('return.format.short_day'));
    }

    public static function showNestedSetName ($name, $level) {
        $xhtml  = str_repeat('|-----', $level - 1);
        $xhtml  .= sprintf('<span class="badge badge-danger p-1">%s</span> <strong>%s</strong>', $level, $name);
        return $xhtml;
    }

    public static function showNestedSetUpDown($controllerName, $id) {
        $upButton   = sprintf('<a href="%s" type="button" class="btn btn-primary mb-0" data-toggle="tooltip" title="" data-original-title="Up">
                                    <i class="fa fa-long-arrow-up"></i>
                                </a>', route("$controllerName/ordering", ['id' => $id, 'type' => 'up']));
        $downButton = sprintf('<a href="%s" type="button" class="btn btn-primary mb-0" data-toggle="tooltip" title="" data-original-title="Down">
                                    <i class="fa fa-long-arrow-down"></i>
                                </a>', route("$controllerName/ordering", ['id' => $id, 'type' => 'down']));

        // $node  = CategoryProductModel::find('id');
        switch ($controllerName) {
            case 'categoryArticle':
                $node  = CategoryArticleModel::find('id');
                break;
            case 'categoryProduct':
                $node  = CategoryProductModel::find('id');
                break;
        }

        // if (empty($node->getPrevSibling()) || empty($node->getPrevSibling()->parent_id)) $upButton = '';
        // if (empty($node->getNextSibling())) $downButton = '';

        $xhtml = '
        <span style="width: 36px; display: inline-block">'.$upButton.'</span>
        <span style="width: 36px; display: inline-block">'.$downButton.'</span>
        ';
        return $xhtml;
    }

    public static function showNestedMenu($items, $xhtml) {
        foreach ($items as $item) {
            $link   = URL::linkCategoryArticle($item['id'], $item['name']);
            if (count($item['children'])) {
                $xhtml  .= '<li class="nav-item">';
                $xhtml  .= sprintf('<a href="%s" class="nav-link dropdown-item>%s <span class="fa fa-caret-right></span></a><ul
                                        class="submenu dropdown-menu">', $link, $item['name']);
                
                Template::showNestedMenu($item['children'], $xhtml);
                $xhtml  .= '</li></ul>';
            } else {
                $xhtml  .= sprintf('<li class="nav-link"><a class="nav-link dropdown-item" href="%s">%s</a></li>', $link, $item['name']);
            }
        }
    }
}