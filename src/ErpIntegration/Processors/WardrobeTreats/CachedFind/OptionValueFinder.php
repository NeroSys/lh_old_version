<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\OptionValue;

class OptionValueFinder extends AbstractFinder
{
    use SingletonTrait;

    protected function findAll():?array{
        return OptionValue::all();
    }

    protected function findOneInDb(string $idErp):?Model{
        return OptionValue::first(array('conditions' => array('id_erp' => $idErp)));
    }
}