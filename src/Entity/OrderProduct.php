<?php

namespace App\Entity;
class OrderProduct extends \ActiveRecord\Model
{
    static $belongs_to = array(
        array('order')
   );
    static $table_name = DB_PREFIX.'order_product';
}