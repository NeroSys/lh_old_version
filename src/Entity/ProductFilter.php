<?php

namespace App\Entity;

class ProductFilter extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('filter'),
        array('product')
    );


    static $table_name = DB_PREFIX . 'product_filter';
}