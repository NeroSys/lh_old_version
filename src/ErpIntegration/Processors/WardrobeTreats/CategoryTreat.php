<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\CategoryDescription;
use App\Entity\CategoryPath;
use App\Entity\CategoryToLayout;
use App\Entity\CategoryToStore;
use App\Entity\UrlAlias;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\CategoryFinder;
use App\Helper\ActiveRecord;
use EasySlugger\Slugger;
use LHGroup\From1cToWeb\Item\Product\Category;
use App\Entity\Category as ARCategoryEntity;

class CategoryTreat extends AbstractTreater
{
    const OPENCART_TOP = 1;

    public function treat($item, array $options = [])
    {
        $this->treatCategory($item, $options);
    }

    protected function findCategoryByIdErp(string $idErp): ?ARCategoryEntity
    {
        try { return CategoryFinder::getInstance()->findByIdErp($idErp); }
        catch (ItemNotFoundException $exception){
            return null;
        }

    }

    protected function treatCategory(Category $category)
    {
        if ($entity = $this->findCategoryByIdErp($category->id_erp)) {
            return $this->updateCategory($category, $entity);
        }
        return $this->createCategory($category);
    }

    protected function createCategory(Category $category)
    {
        $entity = new ARCategoryEntity();

        $storeId = ProductProcessor::OPENCART_STOREID;

        $entity::transaction(function () use ($entity, $category, $storeId) {
            $parentId = 0;
            if (null !== $category->getParent() && 0 !== (int) $category->getParent()) {
                $parentCategory = $this->findCategoryByIdErp($category->getParent());
                if (!$parentCategory) {
                    throw new \Exception("No parent category with id_erp " . $category->getParent() . " were found :(");
                }
                $parentId = $parentCategory->category_id;
            }

            $entity->parent_id = $parentId;
            $entity->image = '';
            $entity->status = 1;
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

            $categoryToLayout = new CategoryToLayout();
            $categoryToLayout->category_id = $entity->id;
            $categoryToLayout->store_id = $storeId;
            $categoryToLayout->layout_id = 0;
            $categoryToLayout->save();


            $seoUrl = new UrlAlias();
            $seoUrl->query = 'category_id='.$entity->id;
            $seoUrl->keyword = Slugger::slugify($category->getName().'-'.$entity->id);
            $seoUrl->save();

        });

    }

    protected function updateCategory(Category $category, ARCategoryEntity $entity)
    {
        $parentCategoryId = $entity->parent_id;
        if (!empty($category->getParent())) {
            $parentCategory = $this->findCategoryByIdErp($category->getParent());
            $parentCategoryId = (int)$parentCategory->category_id;
        }

        if ($entity->parent_id !== $parentCategoryId) {

        } elseif ($entity->category_description->name !== $category->name) {

        } else {
            return;
        }

        $entity->parent_id = $parentCategoryId;
        $entity->category_description->name = $category->name;
        $entity->date_modified = ActiveRecord::currentDatetimeCreate();
        $entity::transaction(function () use ($entity) {
            $entity->category_description->save();
            $entity->save();

        });
    }
}