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

    public function getFirstAndLastName() {
        $query = mysqli_query($this->connection, "SELECT concat(first_name, ' ', last_name) as name FROM users WHERE username='{$this->username}'");
        $row = mysqli_fetch_array($query);

        return $row['name'];
    }

    public function getEmail() {
        $query = mysqli_query($this->connection, "SELECT email FROM users WHERE username='{$this->username}'");
        $row = mysqli_fetch_array($query);

        return $row['email'];
    }
}