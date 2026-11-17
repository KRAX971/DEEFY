<?php
namespace  iutnc\deefy\repository;

use Exception;
use PDO;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class DeefyRepository{
    private PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf){
        $port = $conf['port'] ?? 1521;
        $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$conf['host']})(PORT={$port}))(CONNECT_DATA=(SID={$conf['database']})));charset=AL32UTF8";

        $this->pdo = new PDO($dsn, $conf['username'], $conf['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true,PDO::ATTR_CASE => PDO::CASE_LOWER]);
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
    public function findAllPlaylists(): array {
        $stmt = $this->pdo->query("SELECT id AS id, nom AS nom FROM playlist");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}