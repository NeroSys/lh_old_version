<?php

namespace App\Entity;

class OcfilterOptionValueDescription extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX . 'ocfilter_option_value_description';

    static $belongs_to = array(
        array('ocfilter_option_value', 'foreign_key' => 'value_id')
    );
}