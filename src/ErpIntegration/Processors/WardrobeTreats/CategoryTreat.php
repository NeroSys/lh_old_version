<?php
namespace App\ErpIntegration\Processors\WardrobeTreats;

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

   public function treat($item, array $options = [])
   {
       $this->treatCategory($item, $options);
   }

    protected function findCategoryByIdErp(string $idErp):?ARCategoryEntity{
        return ARCategoryEntity::first(array('conditions' => array('id_erp' => $idErp), 'limit' => 1));
    }

   protected function treatCategory(Category $category){
       if($entity = $this->findCategoryByIdErp($category->id_erp)){
           return $this->updateCategory($category, $entity);
       }
       return $this->createCategory($category);
   }

   protected function createCategory(Category $category){
       $entity = new ARCategoryEntity();

       $storeId = ProductProcessor::OPENCART_STOREID;

       $entity::transaction(function() use ($entity, $category, $storeId) {
           $entity->image = '';
           $entity->parent_id = 0;
           $entity->id_erp = $category->getIdErp();
           $entity->date_added = ActiveRecord::currentDatetimeCreate();
           $entity->top = self::OPENCART_TOP;
           $entity->save();
           $entity->category_description = new CategoryDescription();
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

   protected function updateCategory(Category $category, ARCategoryEntity $entity){
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