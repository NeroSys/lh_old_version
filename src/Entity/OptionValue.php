<?php

namespace App\Entity;

class OptionValue extends \ActiveRecord\Model
{
    static $has_one = array(
        array('option_value_description'),
        array('option')
    );
    static $table_name = DB_PREFIX . 'option_value';

    public function set_option_value_description(OptionValueDescription $optionValueDescription){
        $this->assign_attribute('option_value_description', $optionValueDescription);
    }
}