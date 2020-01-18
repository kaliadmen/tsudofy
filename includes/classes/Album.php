<?php
class Album {

    private $connection;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artwork_path;

    public function __construct($connection, $id){
        $this->connection = $connection;
        $this->id = $id;

        $query = mysqli_query($this->connection, "SELECT * FROM albums WHERE id='{$this->id}'");
        $album = mysqli_fetch_array($query);

        $this->title = $album['title'];
        $this->artistId = $album['artist'];
        $this->genre = $album['genre'];
        $this->artwork_path = $album['artwork_path'];
    }

    public function getTitle() {
        return $this->title;
    }

    public function getArtist() {
        return new Artist($this->connection, $this->artistId);
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getArtworkPath() {
        return $this->artwork_path;
    }

    public function getNumberOfSongs() {
        $query = mysqli_query($this->connection, "SELECT COUNT(*) FROM songs WHERE album='{$this->id}'");
        return mysqli_num_rows($query);
    }

    public function getSongIds() {
        $query = mysqli_query($this->connection, "SELECT id FROM songs WHERE album='{$this->id}' ORDER BY album_order ASC");
        $array = array();

        while($row = mysqli_fetch_array($query)){
            array_push($array, $row['id']);
        }

        return $array;
    }

}