<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\Manufacturer as ARManufacturerEntity;

class ManufacturerFinder extends AbstractFinder
{
    use SingletonTrait;

    protected function findAll():?array{
        return ARManufacturerEntity::all();
    }

    protected function findOneInDb(string $idErp):?Model{
        return ARManufacturerEntity::first(array('conditions' => array('id_erp' => $idErp)));
    }
}