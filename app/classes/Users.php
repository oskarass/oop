<?php

namespace App;

class Users
{
    private $credentials;

    public function __construct($array)
    {
        $this->setCredentials($array);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }
}