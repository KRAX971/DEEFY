<?php
declare(strict_types=1);

require_once 'src/classes/src/loader/Psr4Loader.php';

use loader\Psr4Loader;
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\action\MyPlaylistsAction;

$loader = new Psr4Loader('iutnc\\deefy\\', __DIR__ . '/src/classes/src');
$loader->register();

session_start();

DeefyRepository::setConfig(__DIR__ . '/config/config.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('playlists', MyPlaylistsAction::class);
$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('playlist', DisplayPlaylistAction::class);
$dispatcher->addRoute('add-playlist', AddPlaylistAction::class);
$dispatcher->addRoute('add-track', AddPodcastTrackAction::class);
$dispatcher->addRoute('add-user', AddUserAction::class);
$dispatcher->run();
