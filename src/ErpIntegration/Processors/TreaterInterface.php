<?php
namespace App\ErpIntegration\Processors;


Interface TreaterInterface
{
    public function treat($item, int $storeId);
}