<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;


use App\Entity\FilterDescription;
use App\Entity\FilterGroup as ARFilterGroup;
use App\Entity\Filter as ARFilterEntity;

use App\Entity\FilterGroupDescription;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\FilterGroupFinder;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\FilterValueFinder;
use LHGroup\From1cToWeb\Item\ProductItem;

class FilterTreat extends AbstractTreater
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

    protected function findFilterGroupByIdErp(string $idErp, string $source): ?ARFilterGroup
    {
        try { return FilterGroupFinder::getInstance()->findByIdErp($idErp, $source); }
        catch (ItemNotFoundException $exception){
            return null;
        }
    }

    protected function findFilterByIdErp(string $idErp, string $source): ?ARFilterEntity
    {
        try { return FilterValueFinder::getInstance()->findByIdErp($idErp, $source); }
        catch (ItemNotFoundException $exception){
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
                if ($entity = $this->findFilterGroupByIdErp(
                    $characteristic->getIdErp(), self::SPECIFICATION_CHARACTERISTIC_ID_ERP_SOURCE)
                ) {
                    $this->updateFilterGroup($characteristic->getName(), $entity);
                } else {
                    $entity = $this->createFilterGroup(
                        $characteristic->getName(),
                        $characteristic->getIdErp(),
                        self::SPECIFICATION_CHARACTERISTIC_ID_ERP_SOURCE
                    );
                }

                $this->treatFilterValue(
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
            if ($entity = $this->findFilterGroupByIdErp(
                $property->getIdErp(), self::PROPERTY_ID_ERP_SOURCE
            )) {
                $this->updateFilterGroup($property->getName(), $entity);
            } else {
                $entity = $this->createFilterGroup(
                    $property->getName(),
                    $property->getIdErp(),
                    self::PROPERTY_ID_ERP_SOURCE
                );
            }

            $this->treatFilterValue(
                $property->getValue()->getName(),
                $property->getValue()->getIdErp(),
                self::PROPERTY_VALUE_ID_ERP_SOURCE,
                $entity);
        }
    }

    protected function treatFilterValue(string $name, string $idErp, string $source, ARFilterGroup $filter)
    {
        if ($entity = $this->findFilterByIdErp($idErp, $source)) {
            $this->updateFilterValue($name, $entity);
        } else {
            $this->createFilterValue($name, $idErp, $source, $filter);
        }
    }


    protected function createFilterValue(string $name, string $idErp, string $source, ARFilterGroup $filter)
    {
        $entity = new ARFilterEntity();

        $entity::transaction(function () use ($entity, $filter, $name, $idErp, $source) {
            $entity->source = $source;
            $entity->id_erp = $idErp;
            $entity->filter_group_id = $filter->id;
            $entity->save();

            $entity->filter_description = new FilterDescription();
            $entity->filter_description->filter_id = $entity->id;
            $entity->filter_description->filter_group_id = $filter->id;
            $entity->filter_description->name = $name;
            $entity->filter_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->filter_description->save();
        });
    }

    protected function updateFilterValue(string $name, ARFilterEntity $filterEntity)
    {
        if ($filterEntity->filter_description->name !== $name) {
            $filterEntity->filter_description->name = $name;
            $filterEntity->filter_description->save();
        }
    }


    protected function createFilterGroup(string $name, string $idErp, string $source)
    {
        $entity = new ARFilterGroup();

        $entity::transaction(function () use ($entity, $name, $idErp, $source) {
            $entity->source = $source;
            $entity->id_erp = $idErp;
            $entity->save();

            $entity->filter_group_description = new FilterGroupDescription();
            $entity->filter_group_description->filter_group_id = $entity->id;
            $entity->filter_group_description->name = $name;
            $entity->filter_group_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->filter_group_description->save();
        });

        return $entity;
    }

    protected function updateFilterGroup(string $name, ARFilterGroup $filterGroupEntity)
    {
        if ($filterGroupEntity->filter_group_description->name !== $name) {
            $filterGroupEntity->filter_group_description->name = $name;
            $filterGroupEntity->filter_group_description->save();
        }
    }
}