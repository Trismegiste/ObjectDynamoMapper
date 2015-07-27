<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Itaipu\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\AbstractMapper;

/**
 * MapScalar is a map for scalars
 */
class MapScalar extends AbstractMapper
{

    protected $scalarType = array('boolean', 'integer', 'double', 'string', 'NULL');

    public function isResponsibleFromDb($var)
    {
        return ( is_array($var) &&
                (count($var) === 1) &&
                (isset($var['N']) || isset($var['S']) || isset($var['BOOL']) || isset($var['NULL']))
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
            case 'N': return preg_match('#^-?[0-9]+$#', $var['N']) ? (int) $var['N'] : (double) $var['N'];
            case 'S': return $var['S'];
            case 'BOOL': return (bool) $var['BOOL'];
            case 'NULL': return null;
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
            case 'NULL': return ['NULL' => true];
        }
    }

}
