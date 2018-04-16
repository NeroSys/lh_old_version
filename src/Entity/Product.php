<?php

namespace App\Entity;

class Product extends \ActiveRecord\Model
{
    static $has_one = array(
        array('product_description')
    );
    static $has_many = array(
        array('product_attribute'),
        array('product_image'),
        array('categories', 'through' => 'product_to_category'),
        array('product_option_group')
    );
    static $table_name = DB_PREFIX . 'product';

    public function set_product_description(ProductDescription $productDescription){
        $this->assign_attribute('product_description',$productDescription);
    }
}