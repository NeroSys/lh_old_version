<?php

namespace App\Entity;
class Order extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX.'order';

    static $has_many = array(
        array('order_product', 'foreign_key' => 'order_id'),
    );
}