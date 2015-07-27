<?php

include __DIR__ . '/vendor/autoload.php';

class Music
{

    public $Artist;
    public $SongTitle;
    public $albumTitle;
    public $year;
    public $genre;
    public $owned = false;
    public $duration = ['Zarabeth' => 123, 'Oneiric' => 456];
    public $empty = null;

}

$pk = 'a' . rand();
$sample = new Music();
$sample->albumTitle = 'Wardenclyffe tower';
$sample->Artist = "Holdsworth";
$sample->SongTitle = $pk;
$sample->genre = ["Futuristic", 'Jazz'];
$sample->year = 1986;

$director = new Trismegiste\Alkahest\Transform\Delegation\MappingDirector();
$mappingChain = $director->create(new Trismegiste\Canopy\DynamoDbMappingBuilder());
$transform = new Trismegiste\Alkahest\Transform\Transformer($mappingChain);

$flat = $transform->desegregate($sample);
print_r($flat);

$param = [
    "TableName" => "Music",
    "Item" => $flat
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
        "Artist" => ['S' => "Holdsworth"],
        "SongTitle" => ['S' => $pk]
    ]
        ]);

print_r($res->get('Item'));

$invert = $transform->create($res->get('Item'));
var_dump($invert);
