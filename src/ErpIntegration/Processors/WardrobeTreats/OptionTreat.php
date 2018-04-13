<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;


use App\Entity\Option;
use App\Entity\OptionDescription;

use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use LHGroup\From1cToWeb\Item\Product\Characteristic;
use LHGroup\From1cToWeb\Item\Product\CharacteristicValue;

class OptionTreat extends AbstractTreater
{
    const DEFAULT_OPTION_TYPE = 'select';

    /**
     * @var OptionValueTreat
     */
    protected $optionValueTreater;

    public function __construct()
    {
        $this->optionValueTreater = new OptionValueTreat();
    }

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatOption($item, $options);
    }

    protected function findOptionByIdErp(string $idErp): ?Option
    {
        return Option::first(array('conditions' => array('id_erp' => $idErp), 'limit' => 1));
    }

    protected function treatOption(Characteristic $characteristic)
    {
        if ($entity = $this->findOptionByIdErp($characteristic->getIdErp())) {
             $this->updateOption($characteristic, $entity);
        }
        else{ $entity = $this->createOption($characteristic); }


        $this->treatOptionValue($characteristic->getValue(), $entity);

    }

    protected function treatOptionValue(CharacteristicValue $characteristicOptionValue, Option $option){
        $this->optionValueTreater->treat($characteristicOptionValue, ['option_id'=>$option->id]);
    }

    protected function createOption(Characteristic $characteristic):Option
    {
        $entity = new Option();

        $entity::transaction(function() use ($entity, $characteristic) {
            $entity->type = self::DEFAULT_OPTION_TYPE;
            $entity->id_erp = $characteristic->getIdErp();
            $entity->save();
            $entity->option_description = new OptionDescription();
            $entity->option_description->option_id = $entity->id;
            $entity->option_description->name = $characteristic->getName();
            $entity->option_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->option_description->save();
        });
        return $entity;
    }

    protected function updateOption(Characteristic $characteristic, Option $entity)
    {
        if ($entity->option_description->name === $characteristic->getName()) {
            return;
        }

        $entity->option_description->name = $characteristic->getName();
        $entity->option_description->save();
    }
}