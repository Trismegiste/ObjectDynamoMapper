<?php

use Trismegiste\Itaipu\Facade\RepositoryFactory;
use Trismegiste\Itaipu\Persistence\Persistable;

include __DIR__ . '/vendor/autoload.php';

class Music implements Persistable
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

$fac = new RepositoryFactory();
$dynamoDb = $fac->create();

$dynamoDb->putItem($sample);

var_dump($dynamoDb->getItem([
            "Artist" => "Holdsworth",
            "SongTitle" => $pk
]));
