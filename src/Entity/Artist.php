<?php

declare(strict_types=1);

namespace Entity;

class Artist
{
    private int $id;
    private string $name;
    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

}
