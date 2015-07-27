<?php

include __DIR__ . '/vendor/autoload.php';

$param = [
    "TableName" => "Music",
    "Item" => [
        "Artist" => ['S' => "Malmsteen"],
        "SongTitle" => ['S' => "Odyssey"],
        "AlbumTitle" => ['S' => "Odyssey"],
        "Year" => ['N' => rand(1980, 2000)],
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


$res = $client->getItem([
            "TableName" => "Music",
            'Key' => [
                "Artist" => ['S' => "Malmsteen"],
                "SongTitle" => ['S' => "Odyssey"]
            ]
]);

print_r($res->get('Item'));
