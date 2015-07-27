<?php

/*
 * ObjectDynamoDbMapper
 */

namespace Trismegiste\Itaipu\Persistence;

/**
 * RepositoryInterface is a contract for a repository against DynamoDb
 */
interface RepositoryInterface
{

    public function putItem(Persistable $obj);

    /**
     *
     * @param array $key
     *
     * @return Persistable
     */
    public function getItem(array $key);

    //public function deleteItem(array $key);
}
