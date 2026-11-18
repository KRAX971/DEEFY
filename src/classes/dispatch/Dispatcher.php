<?php

namespace iutnc\deefy\dispatch;

class Dispatcher {
    private string $action;
    private array $routes = [];

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function addRoute(string $action, string $class): self {
        $this->routes[$action] = $class;
        return $this;
    }

    public function run(): void {
        $class = $this->routes[$this->action] ?? $this->routes['default'];
        $actionObj = new $class();
        $this->renderPage($actionObj->execute());
    }

    private function renderPage(string $html): void {
        echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Deefy</title></head>
<body>
    <h1>DeefyApp</h1>
    <nav>
        <a href="?action=default">Accueil</a> |
        <a href="?action=playlist">Ma playlist</a> |
        <a href="?action=playlists">Mes playlists</a> |
        <a href="?action=add-playlist">Créer playlist</a> |
        <a href="?action=add-track">Ajouter piste</a>
        <a href="?action=add-user">Inscription</a> |
    </nav>
    <hr>
    $html
</body>
</html>
HTML;
    }
}