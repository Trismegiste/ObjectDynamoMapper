<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Itaipu\Facade;

use Aws\DynamoDb\DynamoDbClient;
use Trismegiste\Alkahest\Transform\Delegation\MappingDirector;
use Trismegiste\Alkahest\Transform\Transformer;
use Trismegiste\Itaipu\Persistence\Repository;
use Trismegiste\Itaipu\Persistence\RepositoryInterface;
use Trismegiste\Itaipu\Transform\DynamoDbMappingBuilder;
use Trismegiste\Itaipu\Transform\RootDecorator;

/**
 * RepositoryFactory creates a Repository
 */
class RepositoryFactory
{

    /**
     * @return RepositoryInterface
     */
    public function create()
    {
        $director = new MappingDirector();
        $mappingChain = $director->create(new DynamoDbMappingBuilder());
        $transform = new RootDecorator(new Transformer($mappingChain));

        $client = new DynamoDbClient([
            'endpoint' => 'http://localhost:8000',
            'version' => "2012-08-10",
            'profile' => 'default',
            'region' => 'us-west-2',
        ]);

        return new Repository($client, $transform, 'Music');
    }

}
