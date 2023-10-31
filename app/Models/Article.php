<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $id;
    private string $title;
    private string $description;
    private Carbon $timeAdded;

    public function __construct(string $id, string $title, string $description, Carbon $timeAdded)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->timeAdded = $timeAdded;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTimeAdded(): Carbon
    {
        return $this->timeAdded;
    }
}
