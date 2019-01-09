<?php

require_once 'Models/Favorite.php';
require_once 'Models/User.php';

class UserController
{
    private $m;
    private $g;
    private $l;

    function __construct(LogController $logController)
    {
        $this->m = new User;
        $this->g = new UserGateway;

        $this->l = $logController;
    }

    public function getUser() : User
    {
        return $this->m;
    }

    public function checkAuth()
    {
        $this->checkAuthBySession();

        if (! $this->m->isLogged()) {
            $this->checkAuthByCookie();
        }

        if (! $this->m->isLogged()) {
            $this->checkAuthByForm();
        }
        
        if (isset($_POST['logout']))
        {
            if ($this->m->isLogged()) {
                $this->g->resetTokenByID($this->m->getID());
            }
            
            $this->clearCookiesAndSession();
            $this->m->setLogged(false);
            $this->l->log($this->m->getID(), 'Logged out');
        }
    }

    public function checkAuthBySession()
    {
        if (! empty($_SESSION['user_id'])) {

            $user = $this->g->getUserByID($_SESSION['user_id']);

            if ($user->isValid()) {
                $user->setLogged();
            } else {
                $this->clearCookiesAndSession();
            }

            $this->m = $user;
        }
    }

    public function checkAuthByCookie()
    {
        if (
            ! empty($_COOKIE['user_id']) &&
            ! empty($_COOKIE['token'])
        ) {
            $id = filter_var($_COOKIE['user_id'], FILTER_SANITIZE_NUMBER_INT);
            $token = filter_var($_COOKIE['token'], FILTER_SANITIZE_STRING);

            $user = $this->g->getUserByID($_COOKIE['user_id']);

            if ($user->isValid()) {
                $isTokenValid = $this->g->verifyTokenByID($id, $token);

                if ($isTokenValid) {
                    $_SESSION['user_id'] = $id;
                    $user->setLogged();

                    $this->m = $user;

                    $this->l->log($user->getID(), 'Authenticated (cookie)');
                    return;
                }
            }
        }

        $this->clearCookiesAndSession();
    }

    public function checkAuthByForm()
    {
        global $cookieExpirationTime;

        if (! empty($_POST['action']) && ! empty($_POST['password-hash'])) {

            $action = Validation::sanitizeString($_POST['action']);
            $password = Validation::sanitizeString($_POST['password-hash']);

            if ($action != 'save' && $action != 'load') {
                $this->l->log($this->m->getID(), 'Failed to log in (invalid action)', 'error');
                throw new Exception('Une erreur s\'est produite. Veuillez réessayer.');
            }

            if ($password == 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855') {
                $this->l->log($this->m->getID(), 'Failed to log in (blank password)', 'error');
                throw new Exception('Un mot de passe vide n\'est pas un mot de passe.');
            }

            if (! Validation::validatePassword($password)) {
                $this->l->log($this->m->getID(), 'Failed to log in (invalid password)', 'error');
                throw new Exception('Ce mot de passe ne peut pas être utilisé.');
            }

            $user = $this->g->getUserByPassword($password);

            if ($action == 'save')
            {
                if (! $user->isValid()) {
                    $token = bin2hex(random_bytes(16));
                    $tokenHash = password_hash($token, PASSWORD_DEFAULT);
        
                    $expiryDate = date('Y-m-d H:i:s', $cookieExpirationTime);

                    $user = $this->g->addUser($password, $tokenHash, $expiryDate);

                    $_SESSION['user_id'] = $user->getID();
                    setcookie('user_id', $user->getID(), $cookieExpirationTime, null, null, false, true);
                    setcookie('token', $token, $cookieExpirationTime, null, null, false, true);

                    $user->setLogged();

                    $this->l->log($user->getID(), 'Created account');
                    $this->m = $user;
                }
                else {
                    $this->l->log($user->getID(), 'Failed to log in (password already used)', 'error');
                    throw new Exception('Mot de passe déjà utilisé.');
                }
            }
            else // $action == 'load'
            {
                if ($user->isValid())
                {
                    $token = bin2hex(random_bytes(16));
                    $tokenHash = password_hash($token, PASSWORD_DEFAULT);
        
                    $expiryDate = date('Y-m-d H:i:s', $cookieExpirationTime);
        
                    $this->g->updateTokenByID($user->getID(), $tokenHash, $expiryDate);

                    $_SESSION['user_id'] = $user->getID();
                    setcookie('user_id', $user->getID(), $cookieExpirationTime, null, null, false, true);
                    setcookie('token', $token, $cookieExpirationTime, null, null, false, true);

                    $user->setLogged();

                    $this->l->log($user->getID(), 'Authenticated (form)');
                    $this->m = $user;
                }
                else {
                    $this->l->log($user->getID(), 'Failed to log in (unknown password)', 'error');
                    throw new Exception('Mot de passe inconnu.');
                }
            }
        }
    }

    public function clearCookiesAndSession()
    {
        setcookie('token', '');
        unset($_SESSION['user_id']);
    }

    public function getFavorites() : array
    {
        return $this->m->getFavorites();
    }

    public function addFavorite(string $name, string $stop, string $direction)
    {
        return $this->m->addFavorite(new Favorite($name, $stop, $direction));
    }

    public function removeFavorite(string $name)
    {
        return $this->m->removeFavorite($name);
    }
}
