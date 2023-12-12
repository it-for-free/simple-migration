<?php

use PHPUnit\Framework\TestCase;

class Migration {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function up() {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL
        )";
        $this->pdo->exec($sql);
    }

    public function down() {
        $sql = "DROP TABLE users";
        $this->pdo->exec($sql);
    }
}

class MigrationTest extends TestCase {
    public function testRollbackMigration() {
        $pdoMock = $this->getMockBuilder(PDO::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $migrationMock = $this->getMockBuilder(Migration::class)
                             ->setConstructorArgs([$pdoMock])
                             ->onlyMethods(['up', 'down'])
                             ->getMock();

        $migrationMock->expects($this->once())
                      ->method('down');

        $migrationMock->down();
    }
}