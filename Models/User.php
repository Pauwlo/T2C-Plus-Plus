<?php

require_once 'Gateways/FavoriteGateway.php';
require_once 'Gateways/UserGateway.php';

class User
{
    private $g;
    private $fg;

    private $id;
    private $isLogged;
    private $settings;
    private $favorites;

    function __construct(int $id = -1, bool $showBtnAdd = true, bool $dayMode = false)
    {
        $this->g = new UserGateway;
        $this->fg = new FavoriteGateway;

        $this->id = $id;
        $this->isLogged = false;
        $this->settings = [];
        $this->favorites = [];

        $this->settings['showBtnAdd'] = $showBtnAdd;
        $this->settings['dayMode'] = $dayMode;
        $this->favorites = $this->fg->getFavoritesByID($this->getID());
    }

    public function getID() : string {
        return $this->id;
    }

    public function isValid() : bool {
        return $this->id != -1;
    }

    public function isLogged() : bool {
        return $this->isLogged;
    }

    public function setLogged(bool $isLogged = true) {
        $this->isLogged = $isLogged;
    }

    public function getSetting(string $key) {
        return $this->settings[$key];
    }

    public function setSetting(string $name, string $value)
    {
        $this->settings[$name] = $value;

        switch ($name) {

            case 'showBtnAdd':
                $name = 'show_btn_add';
                $value = $value == 'true' ? '1' : '0';
                break;
            
            case 'dayMode':
                $name = 'day_mode';
                $value = $value == 'true' ? '1' : '0';
                break;

            default:
                break;
        }

        $this->g->updateSettingByID($this->getID(), $name, $value);
    }

    public function getFavorites() {
        return $this->favorites;
    }

    public function addFavorite(Favorite $f)
    {
        $this->favorites[] = $f;
        $this->fg->addFavoriteByID($this->getID(), $f);
    }

    public function removeFavorite(string $name)
    {
        foreach ($this->favorites as $key => $f) {
            if ($f->getName() == $name) {
                unset($this->favorites[$key]);
                $this->fg->removeFavoriteByID($this->getID(), $f);
                return;
            }
        }

        throw new Exception('Favorite not found');
    }
}
