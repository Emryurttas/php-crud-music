<?php

namespace Entity;

class Track
{
    private int $id;
    private int $albumId;
    private int $songId;
    private int $diskNumber;
    private int $number;
    private int $duration;
    private string $songName;

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    public function getSongId(): int
    {
        return $this->songId;
    }

    public function getDiskNumber(): int
    {
        return $this->diskNumber;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getSongName(): string
    {
        return $this->songName;
    }
}
