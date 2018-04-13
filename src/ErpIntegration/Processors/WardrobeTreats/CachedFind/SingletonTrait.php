<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use Doctrine\Common\Collections\ArrayCollection;

trait SingletonTrait
{
    protected static $instance;

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function __clone() {}

    private function __construct() {
        $this->init();
    }
}