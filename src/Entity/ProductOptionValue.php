<?php

namespace App\Entity;

class ProductOptionValue extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('option_value')
    );

    static $table_name = DB_PREFIX . 'product_option_value';
}