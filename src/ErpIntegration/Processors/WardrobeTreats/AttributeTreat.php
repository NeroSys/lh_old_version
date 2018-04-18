<?php

namespace App\ErpIntegration\Processors\WardrobeTreats;

use App\Entity\AttributeDescription;
use App\ErpIntegration\Exception\ItemNotFoundException;
use App\ErpIntegration\Processors\AbstractTreater;
use App\ErpIntegration\Processors\ProductProcessor;
use App\ErpIntegration\Processors\WardrobeTreats\CachedFind\AttributeFinder;
use LHGroup\From1cToWeb\Item\Product\Property;
use App\Entity\Attribute as ARAttributeEntity;

class AttributeTreat extends AbstractTreater
{
    const DEFAULT_ATTRIBUTE_GROUP_ID = 7;

    public function treat($item, array $options = [])
    {
        parent::treat($item, $options);
        $this->treatAttribute($item);
    }

    protected function findAttributeByIdErp(string $idErp): ?ARAttributeEntity
    {
        try { return AttributeFinder::getInstance()->findByIdErp($idErp); }
        catch (ItemNotFoundException $exception){
            return null;
        }
    }

    protected function treatAttribute(Property $property)
    {
        if ($entity = $this->findAttributeByIdErp($property->getIdErp())) {
            $this->updateAttribute($property, $entity);
        } else {
            $this->createAttribute($property);
        }
    }

    protected function createAttribute(Property $property)
    {
        $entity = new ARAttributeEntity();

        $entity::transaction(function () use ($entity, $property) {
            $entity->id_erp = $property->getIdErp();
            $entity->attribute_group_id = self::DEFAULT_ATTRIBUTE_GROUP_ID;
            $entity->save();
            $entity->attribute_description = new AttributeDescription();
            $entity->attribute_description->attribute_id = $entity->id;
            $entity->attribute_description->name = $property->getName();
            $entity->attribute_description->language_id = ProductProcessor::OPENCART_LANGUAGE_ID;
            $entity->attribute_description->save();
        });
    }

    protected function updateAttribute(Property $property, ARAttributeEntity $entity)
    {
        if ($entity->attribute_description->name === $property->getName()) {
            return;
        }

        $entity->attribute_description->name = $property->getName();
        $entity->attribute_description->save();
    }
}