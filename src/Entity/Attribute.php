<?php

namespace App\Entity;

class Attribute extends \ActiveRecord\Model
{
    static $has_one = array(
        array('attribute_description')
    );
    static $table_name = DB_PREFIX . 'attribute';
}