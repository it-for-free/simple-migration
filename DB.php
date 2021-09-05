<?php

class DB
{
    public function makeDatabaseConnection($authString, $login, $pass) {
        try {
            $pdo = new PDO($authString, $login, $pass);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $pdo;
    }

    public function executeSqlRequest($pdo, $request) {
        $stm = $pdo->prepare($request);
        $result = $stm->execute();
        return $result;
    }

    public function isTableExists($pdo, $table) {
        try {
            $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }
        return $result !== FALSE;
    }

}