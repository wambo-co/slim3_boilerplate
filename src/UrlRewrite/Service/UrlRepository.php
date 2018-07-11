<?php
namespace Wambo\UrlRewrite\Service;

use Exception;
use Wambo\Core\Service\Database;

class UrlRepository
{
    const TABLE = 'rewrites';

    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getTarget(string $path)
    {
        $target = $this->database->getValue('SELECT `target` FROM `'.self::TABLE.'` WHERE `source` = ?', [$path]);
        if ($target == null) {
            throw new Exception('URL not found in rewrites');
        }

        return $target;
    }
}
