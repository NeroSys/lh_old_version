<?php
namespace App\ErpIntegration\Processors;


Interface TreaterInterface
{
    public function treat($item, array $options = []);
}