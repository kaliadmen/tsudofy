<?php
class User {

    private $username;
    private $connection;

    public function __construct($connection, $username){

        $this->connection = $connection;
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

}