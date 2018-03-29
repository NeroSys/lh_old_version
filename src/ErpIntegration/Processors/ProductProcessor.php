<?php

namespace App\ErpIntegration\Processors;


use LHGroup\From1cToWeb\Item\ItemInterface;
use LHGroup\From1cToWeb\Item\ProductItem;
use LHGroup\From1cToWeb\Queue\ProcessorInterface;

class ProductProcessor implements ProcessorInterface
{

    public function process(ItemInterface $item)
    {
        $this->processProduct($item);
    }

    protected function processProduct(ProductItem $product){

    }
}