<?php

namespace App\ErpIntegration\Processors;


use App\ErpIntegration\Processors\WardrobeTreats\AttributeTreat;
use App\ErpIntegration\Processors\WardrobeTreats\BrandTreat;
use App\ErpIntegration\Processors\WardrobeTreats\CategoryTreat;
use App\ErpIntegration\Processors\WardrobeTreats\FilterTreat;
use App\ErpIntegration\Processors\WardrobeTreats\ManufacturerTreat;
use App\ErpIntegration\Processors\WardrobeTreats\OptionTreat;
use App\ErpIntegration\Processors\WardrobeTreats\ProductTreat;
use LHGroup\From1cToWeb\Item\ItemInterface;
use LHGroup\From1cToWeb\Item\ProductItem;
use LHGroup\From1cToWeb\Queue\ProcessorInterface;

class ProductProcessor implements ProcessorInterface
{
    const OPENCART_STOREID = 0;
    const OPENCART_LANGUAGE_ID = 2;


    public function process(ItemInterface $item)
    {
        $this->processProduct($item);
    }

    protected function processProduct(ProductItem $product)
    {
        $wardrobeCategoryTreater = new CategoryTreat();

        foreach ($product->getCategories() as $category) {
            $wardrobeCategoryTreater->treat($category);
        }

        $wardrobeBrandTreater = new ManufacturerTreat();
        $wardrobeBrandTreater->treat($product->getManufacturer());

        $wardrobeCharacteristicOptionTreater = new OptionTreat();
        foreach ($product->getSpecifications() as $specification) {
            foreach ($specification->getCharacteristics() as $specificationCharacteristic) {
                $wardrobeCharacteristicOptionTreater->treat($specificationCharacteristic);
            }
        }

        $wardrobeAttributeTreater = new AttributeTreat();
        foreach ($product->getProperties() as $property) {
            $wardrobeAttributeTreater->treat($property);
        }

        $wardrobeFilterTreater = new FilterTreat();
        $wardrobeFilterTreater->treat($product);

        $productTreat = new ProductTreat();
        $productTreat->treat($product);
    }
}