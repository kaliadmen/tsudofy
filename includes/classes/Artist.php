<?php
class Artist {

    private $connection;
    private $id;
    private $name;

    public function __construct($connection, $id){
        $this->connection = $connection;
        $this->id = $id;

        $query = mysqli_query($this->connection, "SELECT * FROM artists WHERE id='{$this->id}'");
        $artist = mysqli_fetch_array($query);

        $this->name = $artist['name'];

    }

    public function getName() {
        return $this->name;
    }

}