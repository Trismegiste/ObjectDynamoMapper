<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapMapType is a ...
 */
class MapMapType extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($param)
    {
        return array_map(array($this->mediator, 'recursivCreate'), $param['M']);
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($arr)
    {
        return ['M' => array_map(array($this->mediator, 'recursivDesegregate'), $arr)];
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return is_array($var) &&
                (count($var) === 1) &&
                isset($var['M']);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return is_array($var);
    }

}
