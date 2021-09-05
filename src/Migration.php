<?php
//namespace ItForFree\SimpleMigration;

class Migration
{
    public static $migrationBaseName = 'user settings';
    /**
     * @var string
     */
    public static $migrationsTable = 'iff_migrations';

    /**
     * @var PDO
     */
    public $pdo;
    /**
     * @var string
     */
    public $migrationsFolder;
    /**
     * @var DB
     */
    private $DB;

    /**
     * Migration constructor.
     * @param string $dbAuthString
     * @param string $dbLogin
     * @param string $dbPass
     * @param string $migrationsFolder
     */
    public function __construct(string $dbAuthString, string $dbLogin, string $dbPass, $migrationsFolder=false) {
        try {
            $this->pdo = new PDO($dbAuthString, $dbLogin, $dbPass);

            if ($migrationsFolder) {
                $this->migrationsFolder = $migrationsFolder;
            }

            $this->DB = new DB();
        } catch (Exception $e) {
            echo 'Ошибка: ',  $e->getMessage(), "\n";
        }
    }


    /**
     * @param string $request
     */
    public function init(string $request) {
        if (!$this->DB->isTableExists($this->pdo, self::$migrationsTable)) {
            $this->DB->executeSqlRequest($this->pdo, $request);
        }
    }

    /**
     * @param string $folder
     * @param string $fileName
     * @param string $sqlQuery
     */
    public function makeMigrationFile(string $folder, string $fileName, string $sqlQuery) {
        $file = $folder.'/'.$fileName;
        $stringFromQuery = (string)$sqlQuery;
        file_put_contents($file, $stringFromQuery);
    }


    /**
     * @param string $migrationDirName
     * @return false|string
     */
    public function getPathName(string $migrationDirName) {
        $folderUrl = explode('/', $migrationDirName);
        $patternFile = '/^\d{10,}_[a-z]{1,}[a-z_]{1,}$/';
        $folder = $folderUrl[count($folderUrl)-1];

        if (preg_match($patternFile, $folder, $matches)) {
            return $folderUrl[count($folderUrl)-1];
        } else {
            return false;
        }
    }


    /**
     * $migrationType: 'up' or 'down'
     * @param string $fileName
     * @param string $migrationType
     * @return bool
     */
    public function validateMigrationFile(string $fileName, string $migrationType) {
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


    /**
     * @param string $sourceName
     * @return bool
     */
    public function validateMigrationPath(string $sourceName) {
        $patternFile = '/^\d{10,}_[a-z]{1,}[a-z_]{1,}$/';
        return (preg_match($patternFile, $sourceName)) ? true : false;
    }


    /**
     * $migrationType: 'up' or 'down'
     * @param string $migrationDir
     * @param string $migrationType
     * @return mixed
     */
    public function getFileMigrationName(string $migrationDir, string $migrationType) {
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
    public function getMigrationDirName(string $baseName) {
        return $baseName;
    }

    /**
     * получение имени папки миграции в нужном формате
     * @param string $str
     * @return string
     */
    public function makePathName(string $str) {
        $pattern = '/\s{1,}/';
        $replacement = '_';
        $str = preg_replace($pattern, $replacement, $str);
        $str = time().'_'.$str;
        return $str;
    }

    /**
     * получение имени файла миграци наката в нужном формате
     * @param string $str
     * @return string
     */
    public function makeUpMigrationFile(string $str) {
        $pattern = '/\s{1,}/';
        $replacement = '_';
        $str = preg_replace($pattern, $replacement, $str);
        $str = $str.'.up.sql';
        return $str;
    }

    /**
     * получение имени файла миграци удаления в нужном формате
     * @param string $str
     * @return string
     */
    public function makeDownMigrationFile(string $str) {
        $pattern = '/\s{1,}/';
        $replacement = '_';
        $str = preg_replace($pattern, $replacement, $str);
        $str = $str.'.down.sql';
        return $str;
    }


}