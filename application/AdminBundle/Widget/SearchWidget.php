<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/9/8
 * Time: 19:06
 */

namespace Admin\Widget;


use Lib\Base\BaseWidget;

final class SearchWidget extends BaseWidget
{

    /**
     * @param null $params
     */
    public function perform($params)
    {
        list($fields, $searchField, $searchValue, $placeholder) = $params;
        $data =[];
        $data['fields'] = $fields;
        $data['searchField'] = $searchField;
        $data['searchValue'] = $searchValue;
        $data['placeholder'] = $placeholder;

        return $this->render("admin::widget/search.blade.php", $data);
    }
}