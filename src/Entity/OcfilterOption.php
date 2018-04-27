<?php

namespace App\Entity;

class OcfilterOption extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX . 'ocfilter_option';

    static $has_one = array(
        array('ocfilter_option_description', 'foreign_key' => 'option_id')
    );
    static $has_many = array(
        array('ocfilter_option_value', 'foreign_key' => 'option_id'),
    );

    public function set_ocfilter_option_description(OcfilterOptionDescription $filterDescr){
        $this->assign_attribute('ocfilter_option_description',$filterDescr);
    }
}