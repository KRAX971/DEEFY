<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\MyPlaylistsAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddUserAction;

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