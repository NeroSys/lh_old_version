<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;



use App\Entity\OcfilterOption as ARFilterOption;
use App\Entity\OcfilterOptionDescription;
use App\Entity\OcfilterOptionToStore;
use App\Entity\OcfilterOptionValue as ARFilterOptionValue;

use App\Entity\OcfilterOptionValueDescription;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OcFilterOptionFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\OcFilterOptionValueFinder;
use EasySlugger\Slugger;
use LHGroup\From1cToWeb\Item\ProductItem;

class OCFilterTreat extends AbstractTreater
{

    const SPECIFICATION_CHARACTERISTIC_ID_ERP_SOURCE = 'specification';
    const SPECIFICATION_CHARACTERISTIC_VALUE_ID_ERP_SOURCE = 'specification_value';
    const PROPERTY_ID_ERP_SOURCE = 'property';
    const PROPERTY_VALUE_ID_ERP_SOURCE = 'property_value';

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatFilter($item, $options);
    }

    protected function findFilterOption(string $idErp, string $source): ?ARFilterOption
    {
        try {
            return OcFilterOptionFinder::getInstance()->findByIdErp($idErp, $source);
        } catch (ItemNotFoundException $exception) {
            return null;
        }
    }

    protected function findFilterOptionValue(string $idErp, string $source): ?ARFilterOptionValue
    {
        try {
            return OcFilterOptionValueFinder::getInstance()->findByIdErp($idErp, $source);
        } catch (ItemNotFoundException $exception) {
            return null;
        }
    }

    protected function treatFilter(ProductItem $productItem)
    {
        /**
         * добавляем спецификации как фильтры
         */
        foreach ($productItem->getSpecifications() as $specification) {
            foreach ($specification->getCharacteristics() as $characteristic) {
                if ($entity = $this->findFilterOption(
                    $characteristic->getIdErp(), self::SPECIFICATION_CHARACTERISTIC_ID_ERP_SOURCE)
                ) {
                    $this->updateFilterOption($characteristic->getName(), $entity);
                } else {
                    $entity = $this->createFilterOption(
                        $characteristic->getName(),
                        $characteristic->getIdErp(),
                        self::SPECIFICATION_CHARACTERISTIC_ID_ERP_SOURCE
                    );
                }

                $this->treatFilterOptionValue(
                    $characteristic->getValue()->getName(),
                    $characteristic->getValue()->getIdErp(),
                    self::SPECIFICATION_CHARACTERISTIC_VALUE_ID_ERP_SOURCE,
                    $entity);
            }
        }

        /**
         * добавляем свойства как фильтры
         */
        foreach ($productItem->getProperties() as $property) {
            if ($entity = $this->findFilterOption(
                $property->getIdErp(), self::PROPERTY_ID_ERP_SOURCE
            )) {
                $this->updateFilterOption($property->getName(), $entity);
            } else {
                $entity = $this->createFilterOption(
                    $property->getName(),
                    $property->getIdErp(),
                    self::PROPERTY_ID_ERP_SOURCE
                );
            }

            $this->treatFilterOptionValue(
                $property->getValue()->getName(),
                $property->getValue()->getIdErp(),
                self::PROPERTY_VALUE_ID_ERP_SOURCE,
                $entity);
        }
    }

    protected function treatFilterOptionValue(string $name, string $idErp, string $source, ARFilterOption $filter)
    {
        if ($entity = $this->findFilterOptionValue($idErp, $source)) {
            $this->updateFilterOptionValue($name, $entity);
        } else {
            $this->createFilterOptionValue($name, $idErp, $source, $filter);
        }
    }


    protected function createFilterOptionValue(string $name, string $idErp, string $source, ARFilterOption $filter)
    {
        $entity = new ARFilterOptionValue();

        $entity::transaction(function () use ($entity, $filter, $name, $idErp, $source) {
            $entity->source = $source;
            $entity->id_erp = $idErp;
            $entity->option_id = $filter->id;

            $entity->save();

            $entity->keyword = Slugger::slugify($name.''.$entity->id);
            $entity->save();


            $entity->ocfilter_option_value_description = new OcfilterOptionValueDescription();
            $entity->ocfilter_option_value_description->value_id = $entity->id;
            $entity->ocfilter_option_value_description->option_id = $filter->id;
            $entity->ocfilter_option_value_description->name = $name;
            $entity->ocfilter_option_value_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->ocfilter_option_value_description->save();
        });
    }

    protected function updateFilterOptionValue(string $name, ARFilterOptionValue $filterEntity)
    {
        if ($filterEntity->ocfilter_option_value_description->name !== $name) {
            $filterEntity->ocfilter_option_value_description->name = $name;
            $filterEntity->ocfilter_option_value_description->save();
        }
    }


    protected function createFilterOption(string $name, string $idErp, string $source):ARFilterOption
    {
        $entity = new ARFilterOption();
        $storeId = ProductProcessor::OPENCART_STOREID;

        $entity::transaction(function () use ($entity, $name, $idErp, $source, $storeId) {
            $entity->type = "select";

            $entity->source = $source;
            $entity->id_erp = $idErp;
            $entity->save();

            $entity->keyword = Slugger::slugify($name . '-' . $entity->id);
            $entity->save();


            $entity->ocfilter_option_description = new OcfilterOptionDescription();
            $entity->ocfilter_option_description->option_id = $entity->id;
            $entity->ocfilter_option_description->name = $name;
            $entity->ocfilter_option_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->ocfilter_option_description->save();

            $optionToStore = new OcfilterOptionToStore();
            $optionToStore->option_id = $entity->id;
            $optionToStore->store_id = $storeId;
            $optionToStore->save();

        });

        return $entity;
    }

    protected function updateFilterOption(string $name, ARFilterOption $filterGroupEntity)
    {
        if ($filterGroupEntity->ocfilter_option_description->name !== $name) {
            $filterGroupEntity->ocfilter_option_description->name = $name;
            $filterGroupEntity->ocfilter_option_description->save();
        }
    }
}