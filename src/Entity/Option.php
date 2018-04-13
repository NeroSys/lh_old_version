<?php

namespace App\Entity;

class Option extends \ActiveRecord\Model
{
    static $has_one = array(
        array('option_description')
    );

    static $has_many = array(
        array('option_value'),
    );
    static $table_name = DB_PREFIX . 'option';


    public function set_option_description(OptionDescription $optionDescription){
        $this->assign_attribute('option_description', $optionDescription);
    }
}