<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy;

use Mother;

/**
 * RootDecorator is a ...
 */
class RootDecorator implements \Trismegiste\Alkahest\Transform\TransformerInterface
{

    protected $embed;

    public function __construct(\Trismegiste\Alkahest\Transform\TransformerInterface $transf)
    {
        $this->embed = $transf;
    }

    public function create(array $dump)
    {
        return $this->embed->create(['M' => $dump]);
    }

    public function desegregate($obj)
    {
        return $this->embed->desegregate($obj)['M'];
    }

}
