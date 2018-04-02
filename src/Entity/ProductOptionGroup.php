<?php

namespace App\Entity;

class ProductOptionGroup extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('product')
    );

    static $has_many = array(
        array('options', 'through' => 'product_option'),
    );

    static $table_name = DB_PREFIX . 'product_option_group';
}