<?php
namespace Wambo\Core\Service;

use Ramsey\Uuid\UuidInterface;

abstract class AbstractRepository
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    protected function getRawDataById(UuidInterface $uuid)
    {
        $table = get_called_class()::TABLE;
        $query = 'SELECT * FROM ' . $table . ' WHERE uuid = :uuid';
        $values = [ 'uuid' => $uuid->getBytes() ];

        return $this->database->getRow($query, $values);
    }
}
