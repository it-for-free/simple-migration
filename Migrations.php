<?php


class Migrations
{
    private $sqlConnection;

    public function __construct(PDO $pdo) {
        $this->sqlConnection= $pdo;
    }

    public function init() {
            //проверка наличия таблицы
            $isTableExist = $this->sqlConnection->query("SELECT 1 FROM  iifmigration LIMIT 1");

            //если таблицы iifmigration нет в базе, то создаем ее
            if (!$isTableExist) {
                $migrationTable= "CREATE TABLE iifmigration (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(30) NOT NULL)";
                $this->sqlConnection->exec($migrationTable);
            }
    }

}