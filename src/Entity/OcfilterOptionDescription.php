<?php

namespace App\Entity;

class OcfilterOptionDescription extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX . 'ocfilter_option_description';

    static $belongs_to = array(
        array('ocfilter_option', 'foreign_key' => 'option_id', 'class'=>'OcfilterOption')
    );
}