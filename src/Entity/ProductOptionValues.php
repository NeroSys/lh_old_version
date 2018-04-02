<?php

namespace App\Entity;

class ProductOptionValues extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('option_value')
    );

    static $table_name = DB_PREFIX . 'product_option_values';
}