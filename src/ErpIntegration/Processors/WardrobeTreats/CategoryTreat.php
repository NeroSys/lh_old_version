<?php
namespace App\ErpIntegration\Processors\WardrobeTreats;

use ActiveRecord\ConnectionManager;
use App\Entity\CategoryDescription;
use App\Entity\CategoryToStore;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\Helper\ActiveRecord;
use LHGroup\From1cToWeb\Item\Product\Category;
use App\Entity\Category as ARCategoryEntity;

class CategoryTreat extends AbstractTreater
{
    const OPENCART_TOP = 1;

   public function treat($item, int $storeId)
   {
       $this->treatCategory($item, $storeId);
   }

    public function findCategoryByIdErp(string $idErp):?ARCategoryEntity{
        return ARCategoryEntity::first(array('conditions' => array('id_erp' => $idErp), 'limit' => 1));
    }

   protected function treatCategory(Category $category, $storeId){
       if($entity = $this->findCategoryByIdErp($category->id_erp)){
           return $this->updateCategory($category, $entity, $storeId);
       }
       return $this->createCategory($category, $storeId);
   }

   protected function createCategory(Category $category, int $storeId){
       $entity = new ARCategoryEntity();
       $entity->category_description = new CategoryDescription();

       $entity::transaction(function() use ($entity, $category, $storeId) {
           $entity->image = '';
           $entity->parent_id = 0;
           $entity->date_added = ActiveRecord::currentDatetimeCreate();
           $entity->top = self::OPENCART_TOP;
           $entity->save();
           $entity->category_description->category_id = $entity->id;
           $entity->category_description->name = $category->name;
           $entity->category_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
           $entity->category_description->save();
           $categoryToStore = new CategoryToStore();
           $categoryToStore->category_id = $entity->id;
           $categoryToStore->store_id = $storeId;
           $categoryToStore->save();
       });

   }

   protected function updateCategory(Category $category, ARCategoryEntity $entity, int $storeId){
       if($entity->category_description->name === $category->name){
           return;
       }
       $entity->category_description->name = $category->name;
       $entity->date_modified = ActiveRecord::currentDatetimeCreate();
       $entity::transaction(function() use ($entity) {
           $entity->save();
           $entity->category_description->save();
       });
   }
}