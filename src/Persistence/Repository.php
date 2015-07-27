<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Itaipu\Persistence;

use Aws\AwsClientInterface;
use Trismegiste\Alkahest\Transform\Mediator\Mediator;
use Trismegiste\Alkahest\Transform\TransformerInterface;
use Trismegiste\Itaipu\Transform\Colleague\MapMapType;
use Trismegiste\Itaipu\Transform\Colleague\MapScalar;

/**
 * Repository is a repository against DynamoDb
 */
class Repository implements RepositoryInterface
{

    protected $dbClient;
    protected $transfo;
    protected $tableName;
    protected $keyHelper;

    public function __construct(AwsClientInterface $client, TransformerInterface $transfomer, $tableName)
    {
        $this->dbClient = $client;
        $this->transfo = $transfomer;
        $this->tableName = $tableName;
        $this->keyHelper = new Mediator();
        new MapScalar($this->keyHelper);
        new MapMapType($this->keyHelper);
    }

    public function getItem(array $key)
    {
        $typedKeys = $this->keyHelper->recursivDesegregate($key)['M'];

        $res = $this->dbClient->getItem([
            "TableName" => $this->tableName,
            'Key' => $typedKeys
        ]);

        return $this->transfo->create($res->get('Item'));
    }

    public function putItem(Persistable $obj)
    {
        $payload = [
            "TableName" => $this->tableName,
            "Item" => $this->transfo->desegregate($obj)
        ];

        $this->dbClient->putItem($payload);
    }

}
