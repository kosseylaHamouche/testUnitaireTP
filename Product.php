<?php

class Product {

    private $name;
    private $owner;

    public function __construct($name, $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    public function isValid() {
        return $this->owner->isValid()
            && !empty($this->owner)
            && !empty($this->name);
    }
}

?>