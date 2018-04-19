<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\Option;

class OptionFinder extends AbstractFinder
{
    use SingletonTrait;

    protected function findAll():?array{
        return Option::all();
    }

    protected function findOneInDb(string $idErp):?Model{
        return Option::first(array('conditions' => array('id_erp' => $idErp)));
    }
}