<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\ManufacturerToStore;
use App\ErpIntegration\Processors\AbstractTreater;
use App\Entity\Manufacturer as ARManufacturerEntity;
use App\ErpIntegration\Processors\ProductProcessor;
use LHGroup\From1cToWeb\Item\Product\Manufacturer;

class BrandTreat extends AbstractTreater
{

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatManufacturer($item);
    }

    public function findManufacturerByIdErp(string $idErp): ?ARManufacturerEntity
    {
        return ARManufacturerEntity::first(array('conditions' => array('id_erp' => $idErp), 'limit' => 1));
    }

    protected function treatManufacturer(Manufacturer $manufacturer)
    {
        if ($entity = $this->findManufacturerByIdErp($manufacturer->getIdErp())) {
            return $this->updateManufacturer($manufacturer, $entity);
        }
        return $this->createManufacturer($manufacturer);
    }

    protected function createManufacturer(Manufacturer $manufacturer)
    {
        $entity = new ARManufacturerEntity();
        $storeId = ProductProcessor::OPENCART_STOREID;

        $entity::transaction(function () use ($entity, $manufacturer, $storeId) {
            $entity->name = $manufacturer->getName();
            $entity->image = '';
            $entity->id_erp = $manufacturer->getIdErp();
            $entity->save();
            $manufacturerToStore = new ManufacturerToStore();
            $manufacturerToStore->manufacturer_id = $entity->id;
            $manufacturerToStore->store_id = $storeId;
            $manufacturerToStore->save();
        });

    }

    protected function updateManufacturer(Manufacturer $manufacturer, ARManufacturerEntity $entity)
    {
        if ($entity->name === $manufacturer->getName()) {
            return;
        }

        $entity->name = $manufacturer->getName();
        $entity->save();
    }
}