<?php

class Product {

    private $name;
    private $user;

    public function __construct($name, $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function isValid() {
        return $this->user->isValid()
            && !isset($this->user)
            && !empty($this->name);
    }
}