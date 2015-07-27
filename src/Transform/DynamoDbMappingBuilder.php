<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Itaipu\Transform;

use Trismegiste\Alkahest\Transform\Delegation\MappingBuilder;
use Trismegiste\Alkahest\Transform\Mediator\Mediator;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;
use Trismegiste\Itaipu\Transform\Colleague\MapList;
use Trismegiste\Itaipu\Transform\Colleague\MapMapType;
use Trismegiste\Itaipu\Transform\Colleague\MapObject;
use Trismegiste\Itaipu\Transform\Colleague\MapScalar;

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
        new MapList($algo);
        new MapMapType($algo);
    }

    public function createObject(TypeRegistry $algo)
    {
        new MapObject($algo);
    }

}
