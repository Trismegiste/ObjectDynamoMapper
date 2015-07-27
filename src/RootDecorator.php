<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Canopy;

use Trismegiste\Alkahest\Transform\TransformerInterface;

/**
 * RootDecorator is a decorator for Transformer for the root entity special case
 */
class RootDecorator implements TransformerInterface
{

    protected $embed;

    public function __construct(TransformerInterface $transf)
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
