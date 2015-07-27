<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapScalar is a map for scalars
 */
class MapScalar extends AbstractMapper
{

    protected $scalarType = array('boolean', 'integer', 'double', 'string');

    public function isResponsibleFromDb($var)
    {
        return ( is_array($var) &&
                (count($var) === 1) &&
                (isset($var['N']) || isset($var['S']) || isset($var['BOOL']))
                );
    }

    public function isResponsibleToDb($var)
    {
        return in_array(gettype($var), $this->scalarType);
    }

    public function mapFromDb($var)
    {
        $type = array_keys($var)[0];
        switch ($type) {
            case 'N': return (double) $var['N'];
            case 'S': return $var['S'];
            case 'BOOL': return (bool) $var['BOOL'];
        }
    }

    public function mapToDb($var)
    {
        switch (gettype($var)) {
            case 'integer':
            case 'double':
                return ['N' => $var];
            case 'string': return ['S' => $var];
            case 'boolean': return ['BOOL' => $var];
        }
    }

}
