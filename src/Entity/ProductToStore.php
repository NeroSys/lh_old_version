<?php

namespace App\Entity;

class ProductToStore extends \ActiveRecord\Model
{
    static $table_name = DB_PREFIX . 'product_to_store';
}