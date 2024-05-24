<?php

declare(strict_types=1);

namespace Entity;

class Album
{
    private int $id;
    private string $name;
    private int $year;
    private int $artistId;
    private int $genreId;
    private int $coverId;

    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string name
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return int year
     */
    public function getYear(): int
    {
        return $this->year;
    }
    /**
     * @return int artistId
     */
    public function getArtistId(): int
    {
        return $this->artistId;
    }
    /**
     * @return int GenreId
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }
    /**
     * @return int coverId
     */
    public function getCoverId(): int
    {
        return $this->coverId;
    }
}
