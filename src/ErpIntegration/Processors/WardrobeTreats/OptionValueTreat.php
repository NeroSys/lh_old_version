<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\OptionValue;
use App\Entity\OptionValueDescription;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\Entity\OptionValue as AROptionValueEntity;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OptionValueFinder;
use LHGroup\From1cToWeb\Item\Product\CharacteristicValue;

class OptionValueTreat extends AbstractTreater
{
    protected $optionId;

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatOptionValue($item, $options['option_id']);
    }

    protected function findOptionValueByIdErp(string $idErp): ?AROptionValueEntity
    {
        try { return OptionValueFinder::getInstance()->findByIdErp($idErp); }
        catch (ItemNotFoundException $exception){
            return null;
        }
    }

    protected function treatOptionValue(CharacteristicValue $characteristicValue, int $optionId)
    {
        if ($entity = $this->findOptionValueByIdErp($characteristicValue->getIdErp())) {
            return $this->updateOptionValue($characteristicValue, $entity);
        }
        return $this->createOptionValue($characteristicValue, $optionId);
    }

    protected function createOptionValue(CharacteristicValue $characteristicValue, int $optionId)
    {
        $entity = new AROptionValueEntity();


        $entity::transaction(function() use ($entity, $characteristicValue, $optionId) {
            $entity->option_id = $optionId;
            $entity->id_erp = $characteristicValue->getIdErp();
            $entity->save();
            $entity->option_value_description = new OptionValueDescription();
            $entity->option_value_description->option_value_id = $entity->id;
            $entity->option_value_description->option_id = $optionId;
            $entity->option_value_description->name = $characteristicValue->getName();
            $entity->option_value_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->option_value_description->save();
        });

    }

    protected function updateOptionValue(CharacteristicValue $characteristicValue, AROptionValueEntity $entity)
    {
        if ($entity->option_value_description->name === $characteristicValue->getName()) {
            return;
        }

        $entity->option_value_description->name = $characteristicValue->getName();
        $entity->option_value_description->save();
    }
}