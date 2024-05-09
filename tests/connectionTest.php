<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testDatabaseConnection(): void
    {
        $database = new mysqli("localhost", "root", "", "edoc");

        $this->assertInstanceOf(mysqli::class, $database);
        $this->assertNull($database->connect_error);
    }
}