<?php
namespace  iutnc\deefy\repository;

use Exception;
use PDO;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class DeefyRepository{
    private PDO $PDO;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf)
    {
        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['dbname']};charset=utf8";
        $this->PDO = new PDO($dsn, $conf['username'], $conf['password'],[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function setConfig(string $file):void{
        $conf = parse_ini_file($file);
        if($conf===false){
            throw new Exception("erreur de lecture fichier config: $file");
        }
        self::$config = $conf;
    }

    public static function getInstance(): DeefyRepository {
        if (self::$instance === null) {
            if (empty(self::$config)) {
                throw new Exception("initialisé avec setConfig()");
            }
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
}
}