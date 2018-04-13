<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\Category as ARCategoryEntity;

class CategoryFinder extends AbstractFinder
{
    use SingletonTrait;

    protected function findAll():?array{
        return ARCategoryEntity::all();
    }

    protected function findOneInDb(string $idErp):?Model{
        return ARCategoryEntity::first(array('conditions' => array('id_erp' => $idErp)));
    }
}