<?php

namespace App\Entity;

class Filter extends \ActiveRecord\Model
{
    static $has_one = array(
        array('filter_description')
    );
    static $table_name = DB_PREFIX . 'filter';

    public function set_filter_description(FilterDescription $filterDescr){
        $this->assign_attribute('filter_description',$filterDescr);
    }
}