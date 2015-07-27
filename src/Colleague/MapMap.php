<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapArray is a ...
 */
class MapArray extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($param)
    {
        return array_map(array($this->mediator, 'recursivCreate'), $param);
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($arr)
    {
        return array_map(array($this->mediator, 'recursivDesegregate'), $arr);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return 'array' == gettype($var);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return 'array' == gettype($var);
    }

}
