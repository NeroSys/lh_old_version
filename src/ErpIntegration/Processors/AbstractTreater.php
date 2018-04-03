<?php
namespace App\ErpIntegration\Processors;


abstract class AbstractTreater implements TreaterInterface
{
   public function treat($item, int $storeId)
   {
       if(null === $item){
           return;
       }
   }
}