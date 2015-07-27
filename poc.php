<?php

include __DIR__ . '/vendor/autoload.php';

$param = [
    "TableName" => "Music",
    "Item" => [
        "Artist" => ['S' => "Malmsteen"],
        "SongTitle" => ['S' => "Riot in dungeon"],
        "AlbumTitle" => ['S' => "Odyssey"],
        "Year" => ['N' => 1989],
        "Genre" => ['S' => "Shredder"]
    ]
];
$client = new \Aws\DynamoDb\DynamoDbClient([
    'endpoint' => 'http://localhost:8000',
    'version' => "2012-08-10",
    'profile' => 'default',
    'region' => 'us-west-2',
        ]);
$client->putItem($param);


