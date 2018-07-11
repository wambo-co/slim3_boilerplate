<?php

namespace Wambo\Cms\Domain;

use Ramsey\Uuid\UuidInterface;

class Page
{
    private $uuid;
    private $title;
    private $content;

    public function __construct(UuidInterface $uuid, string $title, string $content)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->content = $content;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }
}
