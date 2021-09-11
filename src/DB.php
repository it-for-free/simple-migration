<?php
//namespace ItForFree\SimpleMigration;

class DB
{

    public static $host = 'localhost';
    public static $dbname = 'smvc';
    public static $login = 'root';
    public static $pass = 'rightway';

    /**
     * возвращает авторизационную строку для подключения к БД
     * @param $host
     * @param string $dbname
     * @return string
     */
    public static function getAuthString($host, string $dbname)
    {
        return $authString = "mysql:host=$host;dbname=$dbname";
    }

    /**
     * @param object $pdo
     * @param string $request
     * @return mixed
     */
    public function executeSqlRequest(object $pdo, string $request)
    {
        $stm = $pdo->prepare($request);
        $result = $stm->execute();
        return $result;
    }

    /**
     * @param object $pdo
     * @param string $table
     * @return bool
     */
    public function isTableExists(object $pdo, string $table)
    {
        try {
            $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }
        return $result !== FALSE;
    }

}