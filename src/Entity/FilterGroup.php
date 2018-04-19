<?php

namespace App\Entity;

class FilterGroup extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX . 'filter_group';

    static $has_one = array(
        array('filter_group_description')
    );
    static $has_many = array(
        array('filter'),
    );

    public function set_filter_group_description(FilterGroupDescription $filterDescr){
        $this->assign_attribute('filter_group_description',$filterDescr);
    }
}