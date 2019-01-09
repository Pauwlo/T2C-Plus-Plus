<?php

require_once 'Gateways/FavoriteGateway.php';

class Favorite
{
    private $g;
    
    private $name;
    private $stop;
    private $direction;

    function __construct(string $name, string $stop, string $direction)
    {
        $this->g = new FavoriteGateway;
        
        $this->name = $name;
        $this->stop = $stop;
        $this->direction = $direction;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getStop() : string {
        return $this->stop;
    }

    public function getDirection() : string {
        return $this->direction;
    }
}
