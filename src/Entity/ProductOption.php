<?php

namespace App\Entity;

class ProductOption extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('option')
    );

    static $has_many = array(
        array('option_values', 'through' => 'product_option_values'),
    );

    static $table_name = DB_PREFIX . 'product_options';
}