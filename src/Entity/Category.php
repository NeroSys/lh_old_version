<?php

namespace App\Entity;

class Category extends \ActiveRecord\Model
{
    static $has_one = array(
        array('category_description')
    );

    static $has_many = array(
         array('product_to_category')
    );

    static $table_name = DB_PREFIX . 'category';
}