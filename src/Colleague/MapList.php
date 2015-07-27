<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapList is a ...
 */
class MapList extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($param)
    {
        return array_map(array($this->mediator, 'recursivCreate'), $param['L']);
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($arr)
    {
        return ['L' => array_map(array($this->mediator, 'recursivDesegregate'), $arr)];
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return is_array($var) &&
                (count($var) === 1) &&
                isset($var['L']);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return is_array($var) &&
                isset($var[0]) &&
                isset($var[count($var) - 1]);
    }

}
