<?php
namespace App\ErpIntegration\Processors;


abstract class AbstractTreater implements TreaterInterface
{
    public function treat($item, array $options = [])
    {
        if(null === $item){
            return;
        }
    }
}