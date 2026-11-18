<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

class AddUserAction extends Action {

    public function execute(): string {

        if ($this->http_method === 'GET') {
            return <<<HTML
<form method="post" action="?action=add-user">
    <input type="text" name="nom" placeholder="Nom">
    <input type="email" name="email" placeholder="Email">
    <input type="number" name="age" placeholder="Âge">
    <button type="submit">Connexion</button>
</form>
HTML;
        }

        $nom   = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $age   = filter_var($_POST['age'] ?? '', FILTER_SANITIZE_NUMBER_INT);

        setcookie('user_name', $nom, time()+(30*24*3600),'/');

        return "Nom:$nom, Email:$email, Age:$age ans";
    }
}