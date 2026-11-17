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
        $stmt = $this->pdo->query("SELECT id, nom FROM playlist");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findPlaylistById(int $id): ?Playlist{
        $stmt = $this->pdo->prepare("SELECT id, nom FROM playlist WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $playlist = new Playlist($row['nom']);
        $playlist->setId($row['id']);
        $stmtTracks=$this->pdo->prepare("SELECT t.id AS id, t.titre AS titre, t.genre AS genre, t.duree AS duree, 
                   t.filename AS filename, t.type AS type, t.artiste_album AS artiste_album, 
                   t.titre_album AS titre_album, t.annee_album AS annee_album, 
                   t.numero_album AS numero_album, t.auteur_podcast AS auteur_podcast, 
                   t.date_posdcast AS date_posdcast
                    FROM track t
                    JOIN playlist2track p2t ON t.id = p2t.id_track
                    WHERE p2t.id_pl = :id_pl
                    ORDER BY p2t.no_piste_dans_liste ASC
        ");
        $stmtTracks->execute(['id_pl' => $id]);
        $pistes=[];
        while ($rowTrack = $stmtTracks->fetch(PDO::FETCH_ASSOC)) {
            if($rowTrack['type']==='A'){
                $piste=new AlbumTrack($rowTrack['titre'],$rowTrack['filename']);
                $piste->setGenre($rowTrack['genre']);
                $piste->setDuree((int) $rowTrack['duree']);
                $piste->setArtiste($rowTrack['artiste_album']);
                $piste->setTitreAlbum($rowTrack['titre_album']);
                $piste->setAnneeAlbum((int) $rowTrack['annee_album']);
                $piste->setNumeroAlbum((int) $rowTrack['numero_album']);
            }else{
                $piste=new PodcastTrack($rowTrack['titre'],$rowTrack['filename']);
                $piste->setGenre($rowTrack['genre']);
                $piste->setDuree((int)$rowTrack['duree']);
                $piste->setAuteur($rowTrack['auteur_podcast']);
            }
            $pistes[] = $piste;
        }
        $playlist->ajouterPistes($pistes);
        return $playlist;
    }
}