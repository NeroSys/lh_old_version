<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\Manufacturer;
use App\Entity\OcfilterOptionValueToProduct;
use App\Entity\ProductAttribute;
use App\Entity\ProductDescription;
use App\Entity\ProductFilter;
use App\Entity\ProductOption;
use App\Entity\ProductOptionGroup;
use App\Entity\ProductOptionValue;
use App\Entity\ProductToCategory;
use App\Entity\ProductToLayout;
use App\Entity\ProductToStore;
use App\Entity\UrlAlias;
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
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OcFilterOptionValueFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OptionFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OptionValueFinder;

use LHGroup\From1cToWeb\Item\Product\Specification;
use LHGroup\From1cToWeb\Item\ProductItem;
use EasySlugger\Slugger;
use App\Entity\OcfilterOptionValue as ARFilterOptionEntity;

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

    protected function createProduct(ProductItem $productItem)
    {
        $entity = new ARProductEntity();
        $this->updateProductRelations($entity, $productItem);
        $seoUrl = new UrlAlias;
        $seoUrl->query = 'product_id='.$entity->id;
        $seoUrl->keyword = Slugger::slugify($productItem->getName().'-'.$entity->id);
        $seoUrl->save();
    }

    protected function updateProduct(ProductItem $productItem, ARProductEntity $entity)
    {
        $this->updateProductRelations($entity, $productItem);
    }

    protected function updateProductRelations(ARProductEntity $entity, ProductItem $productItem)
    {
        $entity->model = $productItem->getIdErp();
        $entity->sku = $productItem->getIdErp();
        $entity->manufacturer_id = $this->findManufacturerByIdErp(
            $productItem->getManufacturer()->getIdErp()
        )->manufacturer_id;

        $entity->weight = $productItem->getWeight();
        $entity->height = $productItem->getHeight();
        $entity->width = $productItem->getWidth();
        $entity->length = $productItem->getDepth();


        $entity->status = self::DEFAULT_PRODUCT_STATUS;
        $entity->price = $this->getProductDefaultPrice($productItem);
        $entity->quantity = $this->getTotalProductQuantity($productItem);
        $entity->id_erp = $productItem->getIdErp();
        $entity->image = '';
        if($mainImage = $productItem->getImages()->first()){
            $entity->image = 'catalog/products/'.$mainImage->getPath();
        }


        $storeId = ProductProcessor::OPENCART_STOREID;

        $entity::transaction(function () use ($entity, $productItem, $storeId) {
            $entity->save();

            if(null === $entity->product_description){ $entity->product_description = new ProductDescription(); }
            $entity->product_description->product_id = $entity->id;
            $entity->product_description->name = $productItem->getName();
            $entity->product_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->product_description->save();

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
            $this->updateProductFilters($entity->id, $productItem);
        });
    }

    protected function updateProductFilters(int $productId, ProductItem $productItem)
    {
        OcfilterOptionValueToProduct::delete_all(array('conditions' => array('product_id = ?', $productId)));

        foreach ($productItem->getProperties() as $property) {
            $filter = $this->findFilterValueByIdErp(
                $property->getValue()->getIdErp(),
                OCFilterTreat::PROPERTY_VALUE_ID_ERP_SOURCE
            );
            $productToFilter = new OcfilterOptionValueToProduct();
            $productToFilter->product_id = $productId;
            $productToFilter->option_id = $filter->option_id;
            $productToFilter->value_id = $filter->value_id;
            $productToFilter->save();
        }

        $alreadyInserted = [];
        foreach ($productItem->getSpecifications() as $specification) {

            foreach ($specification->getCharacteristics() as $characteristic) {
                $filter = $this->findFilterValueByIdErp(
                            $characteristic->getValue()->getIdErp(),
                    FilterTreat::SPECIFICATION_CHARACTERISTIC_VALUE_ID_ERP_SOURCE
                    );
                //уже была характеристика с таким товаром, товар уже привязан к этой характеристике
                if(!empty($alreadyInserted[$productId.$filter->value_id])){ continue; }
                $productToFilter = new OcfilterOptionValueToProduct();
                $productToFilter->product_id = $productId;
                $productToFilter->option_id = $filter->option_id;
                $productToFilter->value_id = $filter->value_id;
                $productToFilter->save();
                $alreadyInserted[$productId.$filter->value_id] = 1;
            }
        }
    }

    protected function updateProductProperties(int $productId, ProductItem $productItem)
    {
        ProductAttribute::delete_all(array('conditions' => array('product_id = ?', $productId)));
        foreach ($productItem->getProperties() as $property) {
            $attribute = $this->findAttributeByIdErp($property->getIdErp());
            $productToAttribute = new ProductAttribute();
            $productToAttribute->product_id = $productId;
            $productToAttribute->attribute_id = $attribute->id;
            $productToAttribute->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $productToAttribute->text = $property->getValue()->getName();
            $productToAttribute->save();
        }
    }

    protected function updateProductSpecification(int $productId, ProductItem $productItem)
    {

        ProductOptionGroup::delete_all(array('conditions' => array('product_id = ?', $productId)));
        foreach ($productItem->getSpecifications() as $specification) {
            $productToOptionGroup = new ProductOptionGroup();
            $productToOptionGroup->price_base = $specification->getPriceBase();
            $productToOptionGroup->price_discount = $specification->getPriceDiscount();
            $productToOptionGroup->id_erp = $specification->getIdErp();
            $productToOptionGroup->quantity = $this->getTotalSpecificationQuantity($specification);
            $productToOptionGroup->product_id = $productId;
            $productToOptionGroup->ean = $specification->getEan();
            $productToOptionGroup->availability = serialize(
                $specification->getPrices()
            );
            $productToOptionGroup->save();

            foreach ($specification->getCharacteristics() as $characteristic) {
                $option = $this->findOptionByIdErp($characteristic->getIdErp());
                $productToOption = new ProductOption();
                $productToOption->product_id = $productId;
                $productToOption->option_id = $option->option_id;
                $productToOption->product_option_group = $productToOptionGroup->id;
                $productToOption->save();

                $optionValue = $this->findOptionValueByIdErp($characteristic->getValue()->getIdErp());
                $productToOptionValue = new ProductOptionValue();
                $productToOptionValue->product_id = $productId;
                $productToOptionValue->product_option_id = $productToOption->id;
                $productToOptionValue->option_id = $option->option_id;
                $productToOptionValue->option_value_id = $optionValue->option_value_id;
                $productToOptionValue->quantity = $this->getTotalSpecificationQuantity($specification);
                $productToOptionValue->product_option_group = $productToOptionGroup->id;
                $productToOptionValue->save();
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

    protected function findFilterValueByIdErp(string $idErp, string $source): ARFilterOptionEntity
    {
        return OcFilterOptionValueFinder::getInstance()->findByIdErp($idErp, $source);
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
        foreach ($specification->getPrices() as $price) {
            $total += $price->getQuantity();
        }
        return $total;
    }

    public function getProductDefaultPrice(ProductItem $productItem) {
        if($specification = $productItem->getSpecifications()->first()){
            return $specification->getPriceBase();
        }
        return 0;
    }
}