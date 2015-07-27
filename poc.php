<?php

use Aws\DynamoDb\DynamoDbClient;
use Trismegiste\Alkahest\Transform\Delegation\MappingDirector;
use Trismegiste\Alkahest\Transform\Transformer;
use Trismegiste\Itaipu\DynamoDbMappingBuilder;
use Trismegiste\Itaipu\RootDecorator;

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
    public $medium;

}

class Medium
{

    protected $label;

    public function __construct($str)
    {
        $this->label = $str;
    }

}

$pk = 'a' . rand();
$sample = new Music();
$sample->albumTitle = 'Wardenclyffe tower';
$sample->Artist = "Holdsworth";
$sample->SongTitle = $pk;
$sample->genre = ["Futuristic", 'Jazz'];
$sample->year = 1986;
$sample->medium = new Medium('CD');

$director = new MappingDirector();
$mappingChain = $director->create(new DynamoDbMappingBuilder());
$transform = new RootDecorator(new Transformer($mappingChain));

$flat = $transform->desegregate($sample);
print_r($flat);

$param = [
    "TableName" => "Music",
    "Item" => $flat
];
$client = new DynamoDbClient([
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
