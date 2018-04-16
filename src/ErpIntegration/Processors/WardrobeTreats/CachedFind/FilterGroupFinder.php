<?php

namespace App\ErpIntegration\Processors\WardrobeTreats\CachedFind;

use ActiveRecord\Model;
use App\Entity\FilterGroup;
use App\ErpIntegration\Exception\ItemNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;

class FilterGroupFinder
{
    use SingletonTrait;

    protected $items;

    /**
     * @param string $idErp
     * @param string $source
     * @throws ItemNotFoundException
     * @return FilterGroup
     */
    public function findByIdErp(string $idErp, string $source): FilterGroup
    {
        if ($item = $this->items->get($idErp . $source)) {
            return $item;
        }
        $entity = $this->findOneInDb($idErp, $source);
        if (null === $entity) {
            throw new ItemNotFoundException("No item with id_erp $idErp $source in the database.");
        }
        $this->add($entity->id_erp, $entity->source, $entity);

        return $entity;
    }


    protected function add(string $idErp, string $source, FilterGroup $entity)
    {
        $this->items->set($idErp . $source, $entity);
    }

    protected function init()
    {
        $this->items = new ArrayCollection();
        foreach ($this->findAll() as $entity) {
            $this->add($entity->id_erp, $entity->source, $entity);
        }
    }

    protected function findAll(): ?array
    {
        return FilterGroup::all();
    }

    protected function findOneInDb(string $idErp, string $source): ?FilterGroup
    {
        return FilterGroup::first(array('conditions' => array('id_erp' => $idErp, 'source' => $source)));
    }
}