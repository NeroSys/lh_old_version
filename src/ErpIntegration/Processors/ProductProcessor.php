<?php

namespace App\ErpIntegration\Processors;


use App\ErpIntegration\Processors\WardrobeTreats\BrandTreat;
use App\ErpIntegration\Processors\WardrobeTreats\CategoryTreat;
use LHGroup\From1cToWeb\Item\ItemInterface;
use LHGroup\From1cToWeb\Item\ProductItem;
use LHGroup\From1cToWeb\Queue\ProcessorInterface;

class ProductProcessor implements ProcessorInterface
{
    const OPENCART_STOREID = 0;
    const OPENCART_LANGUAGE_ID = 2;

    public function __construct()
    {
    }

    public function process(ItemInterface $item)
    {
        $this->processProduct($item);
    }

    protected function processProduct(ProductItem $product){
        $wardrobeCategoryTreater = new CategoryTreat();

        foreach ($product->getCategories() as $category){
            $wardrobeCategoryTreater->treat($category, self::OPENCART_STOREID);
        }

        $wardrobeBrandTreater = new BrandTreat();
        $wardrobeBrandTreater->treat($product->getManufacturer(), self::OPENCART_STOREID);


    }
}