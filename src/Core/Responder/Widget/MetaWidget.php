<?php
namespace Wambo\Core\Responder\Widget;

class MetaWidget
{
    private $title;
    private $stylesheets = ['/css/style.css'];


    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getStylesheets() : array
    {
        return $this->stylesheets;
    }
}