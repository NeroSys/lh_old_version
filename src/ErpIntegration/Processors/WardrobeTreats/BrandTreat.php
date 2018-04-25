<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\ManufacturerToStore;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\Entity\Manufacturer as ARManufacturerEntity;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\ManufacturerFinder;
use LHGroup\From1cToWeb\Item\Product\Brand;

class BrandTreat extends AbstractTreater
{

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatManufacturer($item);
    }

    public function findManufacturerByIdErp(string $idErp): ?ARManufacturerEntity
    {
        try { return ManufacturerFinder::getInstance()->findByIdErp($idErp); }
        catch (ItemNotFoundException $exception){
            return null;
        }

    }

    protected function treatManufacturer(Brand $manufacturer)
    {
        if ($entity = $this->findManufacturerByIdErp($manufacturer->getIdErp())) {
            return $this->updateManufacturer($manufacturer, $entity);
        }
        return $this->createManufacturer($manufacturer);
    }

    protected function createManufacturer(Brand $manufacturer)
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

    protected function updateManufacturer(Brand $manufacturer, ARManufacturerEntity $entity)
    {
        if ($entity->name === $manufacturer->getName()) {
            return;
        }

        $entity->name = $manufacturer->getName();
        $entity->save();
    }
}