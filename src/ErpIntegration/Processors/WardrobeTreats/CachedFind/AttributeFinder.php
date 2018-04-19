<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\Attribute;

class AttributeFinder extends AbstractFinder
{
    use SingletonTrait;

    protected function findAll():?array {
        return Attribute::all();
    }

    protected function findOneInDb(string $idErp):?Model{
        return Attribute::first(array('conditions' => array('id_erp' => $idErp)));
    }
}