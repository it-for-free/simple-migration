<?php

namespace ItForFree\SimpleMigration;

class Migration
{
    protected static $migrationsTable = 'iff_migrations';

    public $sqlConnection;
    public $migrationsFolder;
    private $DB;

 
//    public function __construct($pdoObject, $migrationsFolder) {
//        $this->sqlConnection = $pdoObject;
//        $this->migrationsFolder = $migrationsFolder;
//        $this->DB = new DB();
//    }
    
    
    /**
     * @TODO - реализовать сигнатуру
     */
    public function __construct() {}


    public function init($request) {
        if (!$this->DB->isTableExists($this->sqlConnection, self::$migrationsTable)) {
            $this->DB->executeSqlRequest($this->sqlConnection, $request);
        }
    }

    public function makeMigrationFile($folder, $fileName, $sqlQuery) {
        $file = $folder.'/'.$fileName;
        $stringFromQuery = (string)$sqlQuery;
        file_put_contents($file, $stringFromQuery);
    }
   


    public function getPathName($migrationDirName) {
        $folderUrl = explode('/', $migrationDirName);
        $patternFile = '/^\d{10,}_[a-z]{1,}[a-z_]{1,}$/';
        $folder = $folderUrl[count($folderUrl)-1];

        if (preg_match($patternFile, $folder, $matches)) {
            return $folderUrl[count($folderUrl)-1];
        } else {
            return false;
        }
    }

    //$migrationType: 'up' or 'down'
    public function validateMigrationFile($fileName, $migrationType) {
        if ($migrationType == 'up') {
            $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.up\.sql$/';
        } else {
            $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.down\.sql$/';
        }

        if (preg_match($patternFile, $fileName, $matches)) {
            return true;
        } else {
            return false;
        }
    }


    public function validateMigrationPath($sourceName) {
        $patternFile = '/^\d{10,}_[a-z]{1,}[a-z_]{1,}$/';
        return (preg_match($patternFile, $sourceName)) ? true : false;
    }


    //$migrationType: 'up' or 'down'
    public function getFileMigrationName($migrationDir, $migrationType) {
        $files = scandir($migrationDir);
        //$migrationType = mb_strtolower($migrationType);

        foreach ($files as $file) {
            if ($migrationType == 'up') {
                $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.up\.sql$/';
            } else {
                $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.down\.sql$/';
            }

            if (preg_match($patternFile, $file, $matches)) {
                $migration = $matches[0];
            }
        }
        return $migration;
    }

    
    /**
     * 
     * @todo рализовать по задаче
     */
    public function getMigrationDirName($baseName) {
	return $baseName;
    }

}