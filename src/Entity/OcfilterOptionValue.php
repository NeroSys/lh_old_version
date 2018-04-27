<?php

namespace App\Entity;

class OcfilterOptionValue extends \ActiveRecord\Model
{
    static $has_one = array(
        array('ocfilter_option_value_description', 'foreign_key'=>'value_id')
    );

    static $belongs_to = array(
      array('ocfilter_option', 'foreign_key'=>'option_id')
    );

    static $table_name = DB_PREFIX . 'ocfilter_option_value';

    public function set_ocfilter_option_value_description(OcfilterOptionValueDescription $filterDescr){
        $this->assign_attribute('ocfilter_option_value_description',$filterDescr);
    }
}