<?php

namespace App\Entity;

class Attribute extends \ActiveRecord\Model
{
    static $has_one = array(
        array('attribute_description')
    );
    static $table_name = DB_PREFIX . 'attribute';

    public function set_attribute_description(AttributeDescription $attributeDescription){
        $this->assign_attribute('attribute_description',$attributeDescription);
    }
}