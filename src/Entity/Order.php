<?php

namespace App\Entity;
class Order extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX.'order';
}