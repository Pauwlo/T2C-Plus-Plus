<?php

require_once 'Utils/Connection.php';
require_once 'Utils/Endpoint.php';
require_once 'Utils/Request.php';
require_once 'Utils/Validation.php';

require_once 'UserController.php';
require_once 'LogController.php';

class Controller
{
    private $errors;
    private $logController;
    private $userController;

    function __construct()
    {
        $this->errors = [];

        session_start();

        if (isset($_GET['action'])) {
            $action = Validation::sanitizeString($_GET['action']);
        } else {
            $action = 'home';
        }

        try {
            
            $this->logController = new LogController;
            $this->userController = new UserController($this->logController);

            try {
                $this->userController->checkAuth();
            } catch (Exception $e) {
                $this->errors[] = $e->getMessage();
            }
            
            switch ($action) {

                case 'home':
                    $this->home();
                    break;

                case 'settings':
                    $this->settings();
                    break;

                case 'api/addFavorite':
                    $this->addFavorite();
                    break;

                case 'api/removeFavorite':
                    $this->removeFavorite();
                    break;

                case 'api/getNextArrival':
                    $this->getNextArrival();
                    break;

                case 'api/setSetting':
                    $this->setSetting();
                    break;
                
                default:
                    $this->error(404, $action);
            }

        } catch (Exception $e) {
            $this->error(500, $e->getMessage());
        }
    }

    private function isUserLogged() : bool
    {
        return $this->userController->getUser()->isLogged();
    }

    private function log($action, $type = 'info')
    {
        $user = $this->userController->getUser();

        if ($user->isLogged()) {
            $userID = $user->getID();
            $this->logController->log($userID, $action, $type);
        }
    }
    
    private function dieAsJson(string $message, int $code = 200)
    {
        if ($code != 200) {
            $this->log("Error $code: [API] $message", 'error');
        }

        http_response_code($code);
        header('Content-Type: application/json');
        die('{"code":' . $code . ',"message":"' . $message . '"}');
    }

    public function error(int $code, string $message)
    {
        $this->log("Error $code: $message", 'error');
        $dayMode = $user->getSetting('dayMode');
        http_response_code($code);
        require "Views/errors/$code.php";
    }

    // Navigation

    public function home()
    {
        $user = $this->userController->getUser();
        $isLogged = $this->isUserLogged();
        $showBtnAdd = $user->getSetting('showBtnAdd');
        $dayMode = $user->getSetting('dayMode');
        
        if ($isLogged) {
            $userID = $user->getID();
            $favorites = $user->getFavorites();
        }

        if (! empty($this->errors)) {
            $errors = $this->errors;
        }

        require 'Views/home.php';
    }

    public function settings()
    {
        $user = $this->userController->getUser();
        $isLogged = $this->isUserLogged();
        $showBtnAdd = $user->getSetting('showBtnAdd');
        $dayMode = $user->getSetting('dayMode');

        if ($isLogged) {
            $favorites = $user->getFavorites();
        }

        if (! empty($this->errors)) {
            $errors = $this->errors;
        }

        require 'Views/settings.php';
    }

    // API

    public function addFavorite()
    {
        $isLogged = $this->isUserLogged();

        if (! $isLogged) {
            $this->dieAsJson('Unauthorized.', 401);
        }
            
        if (! isset($_POST['name']) || ! isset($_POST['stop']) || ! isset($_POST['direction'])) {
            $this->dieAsJson('Bad request.', 400);
        }

        $name = Validation::sanitizeString($_POST['name']);
        $stop = Validation::sanitizeString($_POST['stop']);
        $direction = Validation::sanitizeString($_POST['direction']);

        if (empty($name)) {
            $this->dieAsJson('Bad Request.', 400);
        }

        if (! Validation::validateStop($stop)) {
            $this->dieAsJson('Unknown stop.', 400);
        }
    
        if (! Validation::validateDirection($direction)) {
            $this->dieAsJson('Unknown direction.', 400);
        }

        $this->log("Added favorite ($name)");
        $this->userController->addFavorite($name, $stop, $direction);
        $this->dieAsJson('OK');
    }

    public function removeFavorite()
    {
        $isLogged = $this->isUserLogged();

        if (! $isLogged) {
            $this->dieAsJson('Unauthorized.', 401);
        }
            
        if (! isset($_POST['name'])) {
            $this->dieAsJson('Bad request.', 400);
        }

        $name = Validation::sanitizeString($_POST['name']);

        if (empty($name)) {
            $this->dieAsJson('Bad Request.', 400);
        }

        try {
            $this->userController->removeFavorite($name);
            $this->log("Removed favorite ($name)");
        } catch (Exception $e) {
            $this->dieAsJson($e->getMessage(), 404);
        }
        $this->dieAsJson('OK');
    }

    public function getNextArrival()
    {
        if (! isset($_GET['stop']) || ! isset($_GET['direction'])) {
            $this->dieAsJson('Bad request.', 400);
        }

        $stop = Validation::sanitizeString($_GET['stop']);
        $direction = Validation::sanitizeString($_GET['direction']);

        if (isset($_GET['format'])) {
            $format = Validation::sanitizeString($_GET['format']);
        } else {
            $format = 'default';
        }

        if (! Validation::validateStop($stop)) {
            $this->dieAsJson('Unknown stop: ' . $stop, 400);
        }

        if (! Validation::validateDirection($direction)) {
            $this->dieAsJson('Unknown direction: ' . $direction, 400);
        }

        if ($stop == $direction) {
            $this->dieAsJson('Stop and direction must be different.', 400);
        }

        if (! Validation::validateFormat($format)) {
            $this->dieAsJson('Unknown format: ' . $format, 400);
        }

        $url = Endpoint::getEndpoint($stop, $direction);
        $data = Request::get($url);

        $data = new SimpleXMLElement($data);
        $time = $data->journey[0]['waiting_time'];

        switch ($format) {
            case 'french':
                $regex = '/^([0-9]{2}):([0-9]{2}):([0-9]{2})/';
                preg_match_all($regex, $time, $groups);
                
                $hours = intval($groups[1][0]);
                $minutes = intval($groups[2][0]);
                $seconds = intval($groups[3][0]);

                $output = '';

                if ($hours > 0) {
                    $output .= $hours . ' heure' . (($hours > 1) ? 's' : '') . ', ';
                }

                if ($hours > 0 || $minutes > 0) {
                    $output .= "$minutes minute" . (($minutes > 1) ? 's' : '') . ' et ';
                }

                $output .= "$seconds seconde" . (($seconds > 1) ? 's' : '');
                
                die($output);
                break;
            
            default:
                die($time);
                break;
        }
    }

    public function setSetting()
    {
        $isLogged = $this->isUserLogged();

        if (! $isLogged) {
            $this->dieAsJson('Unauthorized.', 401);
        }

        if (! isset($_POST['name']) || ! isset($_POST['value'])) {
            $this->dieAsJson('Bad request.', 400);
        }

        $name = Validation::sanitizeString($_POST['name']);
        $value = Validation::sanitizeString($_POST['value']);

        switch ($name) {
            case 'showBtnAdd':
                if (! Validation::validateBooleanAsString($value)) {
                    $this->dieAsJson('Boolean setting, value must be true or false.', 400);
                }
                break;
            
            case 'dayMode':
                if (! Validation::validateBooleanAsString($value)) {
                    $this->dieAsJson('Boolean setting, value must be true or false.', 400);
                }
                break;
            
            default:
                $this->dieAsJson("Unknown setting: $name", 400);
        }

        $this->userController->getUser()->setSetting($name, $value);

        $this->dieAsJson('OK');
    }
}
