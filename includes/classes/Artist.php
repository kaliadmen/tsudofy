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

    public function getSongIds() {
        $query = mysqli_query($this->connection, "SELECT id FROM songs WHERE artist='{$this->id}' ORDER BY play_count ASC");
        $array = array();

        while($row = mysqli_fetch_array($query)){
            array_push($array, $row['id']);
        }

        return $array;
    }

}