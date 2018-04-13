<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\ErpIntegration\Exception\ItemNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractFinder
{
    /**
     * @var ArrayCollection
     */
    protected $items;

    public function findByIdErp(string $idErp):?Model{
        if ($item = $this->items->get($idErp)){
            return $item;
        }
        $entity = $this->findOneInDb($idErp);
        if(null === $entity){
            throw new ItemNotFoundException("No item with id_erp $idErp in the database.");
        }
        $this->add($entity->id_erp, $entity);

        return $entity;
    }


    public function add(string $idErp, Model $entity){
        $this->items->set($idErp, $entity);
    }

    /**
     * @return Model[]|null
     */
    abstract protected function findAll():?array;
    abstract protected function findOneInDb(string $idErp):?Model;

    protected function init(){
        $this->items = new ArrayCollection();
        foreach ($this->findAll() as $entity){
            $this->add($entity->id_erp, $entity);
        }
    }

}