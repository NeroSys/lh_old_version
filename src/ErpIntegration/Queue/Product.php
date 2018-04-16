<?php

namespace App\ErpIntegration\Queue;

use LHGroup\From1cToWeb\Queue\Product as BasikProductQueue;
use Tymosh\ErpExchangeReader\Interfaces\ReaderInterface;
use \App\Overrides\Admin\Model\Catalog\CategoryModel;

class Product extends BasikProductQueue
{
    protected $cache;
    protected $categoryModel;

    public function __construct(ReaderInterface $reader, Cache $cache = null)
    {
        parent::__construct($reader);
        $this->cache = $cache;
        $this->categoryModel = new CategoryModel;
    }

    public function processMessage(string $xmlMessage, $notifier = null)
    {
        parent::processMessage($xmlMessage, $notifier);
        $this->cache->clear();
        $this->categoryModel->repairCategories(0);

    }

}