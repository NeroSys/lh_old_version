<?php

namespace App\Entity;

class ProductToCategory extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('category'),
        array('product')
    );
    static $table_name = DB_PREFIX . 'product_to_category';
}