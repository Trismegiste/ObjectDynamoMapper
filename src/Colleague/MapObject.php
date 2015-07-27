<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy\Colleague;

use Trismegiste\Alkahest\Transform\Mediator\Colleague\ObjectMapperTemplate;

/**
 * MapObject is a mapper to and from an object
 * Must be responsible before MapArray (when in mapFromDb)
 *
 * @author florent
 */
class MapObject extends ObjectMapperTemplate
{

    const FQCN_KEY = '-fqcn';

    /**
     * {@inheritDoc}
     */
    protected function extractFqcn(array &$param)
    {
        $fqcn = $param[self::FQCN_KEY]['S'];
        if (!class_exists($fqcn)) {
            throw new \DomainException("Cannot restore a '$fqcn' : class does not exist");
        }
        unset($param[self::FQCN_KEY]);

        return $fqcn;
    }

    /**
     * {@inheritDoc}
     */
    protected function prepareDump(\ReflectionObject $reflector)
    {
        $dump = array();
        $dump[self::FQCN_KEY] = ['S' => $reflector->getName()];

        return $dump;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return (gettype($var) == 'array') &&
                (count($var) === 1) &&
                isset($var['M']) &&
                array_key_exists(self::FQCN_KEY, $var['M']);
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return gettype($var) == 'object';
    }

    public function mapFromDb($param)
    {
        return parent::mapFromDb($param['M']);
    }

    public function mapToDb($obj)
    {
        return ['M' => parent::mapToDb($obj)];
    }

}
