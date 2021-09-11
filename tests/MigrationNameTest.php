<?php
require_once './src/Migration.php';
require_once './src/DB.php';

//use ItForFree\SimpleMigration;

class MigrationNameTest extends \Codeception\Test\Unit
{
    /**
     *
     * @var ItForFree\SimpleMigration\Migration
     */
    protected $migration;
    protected $migrationBaseName;
    
    protected function _before()
    {
        $host = DB::$host;
        $dbname = DB::$dbname;
        $authString = DB::getAuthString($host, $dbname);
        $login = DB::$login;
        $pass = DB::$pass;

        $this->migration = new Migration($authString, $login, $pass);
        $this->migrationBaseName = Migration::$migrationBaseName;
    }

    protected function _after()
    {
    }

    // tests
/*    public function testMigrationDirNameGenaration()
    {  
	$baseName = 'user settings';
	$expectedName = '34523546547_user_settings'; 
	$expectedNameEndPart = '_user_settings'; 
	$name =  $this->migration->getMigrationDirName($baseName); 
	$this->assertTrue(str_ends_with( $name, $expectedNameEndPart)); //  доделать
	// + проверить что первая часть строки является таймстэмпом 

    }*/

    public function testMigrationFolder()
    {

        $folder = $this->migration->makePathName($this->migrationBaseName);

        $patternFile = '/^\d{10,}_[a-z]{1,}[a-z_]{1,}$/';
        $testingFolder = boolval(preg_match($patternFile, $folder, $matches));

        //проверка правильности названия папки
        $this->assertTrue($testingFolder);
        //  доделать
        // + проверить что первая часть строки является таймстэмпом
    }

    public function testMigrationFileUp()
    {
        $upFile = $this->migration->makeUpMigrationFile($this->migrationBaseName);

        $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.(up|down)\.sql$/';
        $testingFile = boolval(preg_match($patternFile, $upFile, $matches));

        //проверка правильности названия папки
        $this->assertTrue($testingFile);
    }

    public function testMigrationFileDown()
    {
        $downFile = $this->migration->makeUpMigrationFile($this->migrationBaseName);
        $patternFile = '/^[a-z]{3,}[a-z_]{1,}\.(up|down)\.sql$/';
        $testingFile = boolval(preg_match($patternFile, $downFile, $matches));

        //проверка правильности названия файла миграции
        $this->assertTrue($testingFile);
    }

}