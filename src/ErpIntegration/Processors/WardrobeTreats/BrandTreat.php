<?php
namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\ManufacturerToStore;
use App\ErpIntegration\Processors\AbstractTreater;
use App\Entity\Manufacturer as ARManufacturerEntity;
use LHGroup\From1cToWeb\Item\Product\Manufacturer;

class BrandTreat extends AbstractTreater
{

   public function treat($item, int $storeId)
   {
       parent::treat($item, $storeId);
       $this->treatManufacturer($item, $storeId);
   }

    public function findManufacturerByIdErp(string $idErp):?ARCategoryEntity{
        return ARManufacturerEntity::first(array('conditions' => array('id_erp' => $idErp), 'limit' => 1));
    }

   protected function treatManufacturer(Manufacturer $manufacturer, $storeId){
       if($entity = $this->findManufacturerByIdErp($manufacturer->getIdErp())){
           return $this->updateManufacturer($manufacturer, $entity, $storeId);
       }
       return $this->createManufacturer($manufacturer, $storeId);
   }

   protected function createManufacturer(Manufacturer $manufacturer, int $storeId){
       $entity = new ARManufacturerEntity();

       $entity::transaction(function() use ($entity, $manufacturer, $storeId) {
           $entity->name = $manufacturer->getName();
           $entity->image = '';
           $entity->save();
           $manufacturerToStore = new ManufacturerToStore();
           $manufacturerToStore->manufacturer_id = $entity->id;
           $manufacturerToStore->store_id = $storeId;
           $manufacturerToStore->save();
       });

   }

   protected function updateManufacturer(Manufacturer $manufacturer, ARManufacturerEntity $entity, int $storeId){
       $entity->name = $manufacturer->getName();
       $entity->save();
   }
}