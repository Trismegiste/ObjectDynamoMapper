<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy;

use Trismegiste\Alkahest\Transform\Delegation\MappingBuilder;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapArray;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapObject;
use Trismegiste\Alkahest\Transform\Mediator\Mediator;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;
use Trismegiste\Canopy\Colleague\MapScalar;

/**
 * DynamoDbMappingBuilder is a ...
 */
class DynamoDbMappingBuilder implements MappingBuilder
{

    public function createBlackHole(TypeRegistry $algo)
    {

    }

    public function createChain()
    {
        return new Mediator();
    }

    public function createDbSpecific(TypeRegistry $algo)
    {

    }

    public function createNonObject(TypeRegistry $algo)
    {
        new MapScalar($algo);
        new MapArray($algo);
    }

    public function createObject(TypeRegistry $algo)
    {
        new MapObject($algo);
    }

}
