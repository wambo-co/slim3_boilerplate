<?php
namespace Wambo\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Wambo\Core\Service\Database;

class DatabaseTest extends TestCase
{
    protected $database;

    public function setUp()
    {
        $databaseCredentials = $this->getDatabaseCredentials();
        $this->database = new Database(
            'mysql',
            $databaseCredentials['host'],
            $databaseCredentials['database'],
            $databaseCredentials['user'],
            $databaseCredentials['password']
        );
    }

    public function test_create_database_instance()
    {
        $this->assertInstanceOf(Database::class, $this->database);
    }

    private function getDatabaseCredentials()
    {
        return [
            'host' => 'mysql',
            'database' => 'app',
            'user' => 'root',
            'password' => 'pw'
        ];
    }
}