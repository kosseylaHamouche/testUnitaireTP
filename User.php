<?php

class User {
    private $firstName;
    private $lastName;
    private $email;
    private $age;


    public function __construct($firstName,$lastName, $email, $age)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->age = $age;
    }

    public function isValid() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->firstName)
            && !empty($this->lastName)
            && is_int($this->age)
            && $this->age >= 13;
    }
}

?>