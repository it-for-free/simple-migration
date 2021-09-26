<?php

require_once './support/MigrationInitQueryHandler';

use ItForFree\SimpleMigration\Migration;
use ItForFree\SimpleMigration\DB;
use \Codeception\Stub\Expected;

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

  
    public function testPDO() {
        $host = 'localhost';
        $dbname = 'smvc';

        $authString = "mysql:host=$host;dbname=$dbname";
        $login = 'root';
        $pass = 'rightway';


//        $mockPDO = $this->construct('\PDO', [
//            'dsn' => $authString,
//            'username' => $login,
//            'password' => $pass
//            ]
//        );
	
	$queryHandler = new MigrationInitQueryHandler();
	
	$this->makeEmpty('\PDO', ['query' => 
	    function (string $sql) use ($queryHandler) {
		$queryHandler->run($sql);
	    }
	]);

        // создаешь объект миграции и запускаешь инициаллизацию
	
        $this->assertTrue($queryHandler->getResult());

    }
}