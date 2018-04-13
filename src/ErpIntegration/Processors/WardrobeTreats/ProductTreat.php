<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\Manufacturer;
use App\Entity\ProductAttribute;
use App\Entity\ProductDescription;
use App\Entity\ProductOption;
use App\Entity\ProductOptionGroup;
use App\Entity\ProductOptionValues;
use App\Entity\ProductToCategory;
use App\Entity\ProductToStore;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\Entity\Product as ARProductEntity;
use App\Entity\Category as ARCategoryEntity;
use App\Entity\Attribute as ARAttributeEntity;
use App\Entity\Option as AROptionEntity;
use App\Entity\OptionValue as AROptionValueEntity;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\AttributeFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\CategoryFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\ManufacturerFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OptionFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OptionValueFinder;
use Doctrine\Common\Collections\ArrayCollection;
use LHGroup\From1cToWeb\Item\Product\Specification;
use LHGroup\From1cToWeb\Item\ProductItem;

class ProductTreat extends AbstractTreater
{
    const DEFAULT_PRODUCT_STATUS = 1;


    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatProduct($item);
    }

    protected function findProductByIdErp(string $idErp): ?ARProductEntity
    {
        return ARProductEntity::first(array('conditions' => array('id_erp' => $idErp)));
    }

    protected function treatProduct(ProductItem $productItem)
    {
        if ($entity = $this->findProductByIdErp($productItem->getIdErp())) {
            $this->updateProduct($productItem, $entity);
        } else {
            $this->createProduct($productItem);
        }
    }

    protected function createProduct(ProductItem $productItem, int $storeId)
    {
        $entity = new ARProductEntity();
        $entity->product_description = new ProductDescription();
        $entity->product_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;

        $this->updateProductRelations($entity, $productItem, $storeId);

    }

    protected function updateProduct(ProductItem $productItem, ARProductEntity $entity)
    {
        $this->updateProductRelations($entity, $productItem);
    }

    protected function updateProductRelations(ARProductEntity $entity, ProductItem $productItem){
        $entity->model = $productItem->getIdErp();
        $entity->sku = $productItem->getIdErp();
        $entity->manufacturer_id = $this->findManufacturerByIdErp($productItem->getManufacturer()->getIdErp())->manucaturer_id;

        $entity->weight = $productItem->getWeight();
        $entity->height = $productItem->getHeight();
        $entity->width = $productItem->getWidth();
        $entity->length = $productItem->getDepth();


        $entity->status = self::DEFAULT_PRODUCT_STATUS;

        $entity->quantity = $this->getTotalProductQuantity();
        $entity->id_erp = $productItem->getIdErp();

        $entity->product_description->name = $productItem->getName();

        $storeId = ProductProcessor::OPENCART_STOREID;

        $entity::transaction(function () use ($entity, $productItem, $storeId) {
            $entity->save();

            ProductToCategory::delete_all(array('conditions' => array('product_id = ?', $entity->id)));
            foreach ($productItem->getCategories() as $category) {
                $productToCategory = new ProductToCategory();
                $productToCategory->product_id = $entity->id;
                $productToCategory->category_id = $this->findCategoryByIdErp($category->getIdErp())->category_id;
                $productToCategory->save();
            }


            ProductToStore::delete_all(array('conditions' => array('product_id = ?', $entity->id)));
            $productToStore = new ProductToStore();
            $productToStore->store_id = $storeId;
            $productToStore->product_id = $entity->id;
            $productToStore->save();


            ProductToLayout::delete_all(array('conditions' => array('product_id = ?', $entity->id)));
            $productToStore = new ProductToLayout();
            $productToStore->store_id = $storeId;
            $productToStore->product_id = $entity->id;
            $productToStore->layout_id = 0;
            $productToStore->save();
            
            $this->updateProductProperties($entity->id, $productItem);
            $this->updateProductSpecification($entity->id, $productItem);


        });
    }

    protected function updateProductProperties(int $productId, ProductItem $productItem){
        ProductAttribute::delete_all(array('conditions' => array('product_id = ?', $productId)));
        foreach ( $productItem->getProperties() as $property){
            $attribute = $this->findAttributeByIdErp($property->getIdErp());
            $productToAttribute = new ProductAttribute();
            $productToAttribute->product_id = $productId;
            $productToAttribute->attribute_id = $attribute->id;
            $productToAttribute->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $productToAttribute->text = $property->getValue()->getName();
            $productToAttribute->save();
        }
    }

    protected function updateProductSpecification(int $productId, ProductItem $productItem){

        ProductOptionGroup::delete_all(array('conditions' => array('product_id = ?', $productId)));
        foreach ($productItem->getSpecifications() as $specification){
            $productToOptionGroup = new ProductOptionGroup();
            $productToOptionGroup->price_base = $specification->getPriceBase();
            $productToOptionGroup->price_discount = $specification->getPriceDiscount();
            $productToOptionGroup->id_erp = $specification->getIdErp();
            $productToOptionGroup->quantity = $this->getTotalSpecificationQuantity($specification);
            $productToOptionGroup->product_id = $productId;
            $productToOptionGroup->save();

            foreach ($specification->getCharacteristics() as $characteristic) {
                $productToOption = new ProductOption();
                $productToOption->product_id = $productId;
                $productToOption->option_id = $this->findOptionByIdErp($characteristic->getIdErp());
                $productToOption->product_option_group = $productToOptionGroup->id;
                $productToOption->save();

                $productToOptionValue = new ProductOptionValues();
                $productToOptionValue->product_id = $productId;
                $productToOption->option_id = $this->findOptionByIdErp($characteristic->getIdErp());
                $productToOption->option_value_id = $this->findOptionValueByIdErp($characteristic->getValue()->getIdErp());
                $productToOption->quantity = $this->getTotalSpecificationQuantity($specification);
                $productToOption->product_option_group = $productToOptionGroup->id;
                $productToOption->save();
            }

        }
    }

    protected function findManufacturerByIdErp(string $idErp): Manufacturer
    {
        return ManufacturerFinder::getInstance()->findByIdErp($idErp);
    }

    protected function findCategoryByIdErp(string $idErp): ARCategoryEntity
    {
        return CategoryFinder::getInstance()->findByIdErp($idErp);
    }

    protected function findAttributeByIdErp(string $idErp): ARAttributeEntity
    {
        return AttributeFinder::getInstance()->findByIdErp($idErp);
    }

    protected function findOptionByIdErp(string $idErp): AROptionEntity
    {
        return OptionFinder::getInstance()->findByIdErp($idErp);
    }

    protected function findOptionValueByIdErp(string $idErp): AROptionValueEntity
    {
        return OptionValueFinder::getInstance()->findByIdErp($idErp);
    }

    protected function getTotalProductQuantity(ProductItem $productItem): int
    {
        $total = 0;
        foreach ($productItem->getSpecifications() as $specification) {
            foreach ($specification->getPrices() as $price) {
                $total += $price->getQuantity();
            }
        }
        return $total;
    }

    protected function getTotalSpecificationQuantity(Specification $specification): int
    {
        $total = 0;
        foreach ($specification->getPrices() as $price){
            $total += $price->getQuantity();
        }
        return $total;
    }
}