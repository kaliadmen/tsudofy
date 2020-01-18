<?php
class Song {

    private $connection;
    private $id;
    private $mainQueryData;
    private $title;
    private $artistId;
    private $albumId;
    private $genre;
    private $duration;
    private $path;


    public function __construct($connection, $id){
        $this->connection = $connection;
        $this->id = $id;

        $query = mysqli_query($this->connection, "SELECT * FROM songs WHERE id='{$this->id}'");
        $this->mainQueryData = mysqli_fetch_array($query);

        $this->title = $this->mainQueryData['title'];
        $this->artistId = $this->mainQueryData['artist'];
        $this->albumId = $this->mainQueryData['album'];
        $this->genre = $this->mainQueryData['genre'];
        $this->duration = $this->mainQueryData['duration'];
        $this->path = $this->mainQueryData['path'];
    }

    public function getTitle() {
        return $this->title;
    }

    public function getArtist() {
        return new Artist($this->connection, $this->artistId);
    }

    public function getAlbum() {
        return new Album($this->connection, $this->albumId);
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getPath() {
        return $this->path;
    }

    public function getMainQueryData(): ?array {
        return $this->mainQueryData;
    }
}