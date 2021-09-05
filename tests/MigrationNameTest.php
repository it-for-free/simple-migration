<?php

use ItForFree\SimpleMigration\Migration; 

class MigrationNameTest extends \Codeception\Test\Unit
{

    /**
     *
     * @var \ItForFree\SimpleMigration\Migration
     */
    protected $migration;
    
    protected function _before()
    {
	$this->migration = new Migration();
    }

    protected function _after()
    {
    }

    // tests
    public function testMigrationDirNameGenaration()
    {  
	$baseName = 'user settings';
	$expectedName = '34523546547_user_settings'; 
	$expectedNameEndPart = '_user_settings'; 
	$name =  $this->migration->getMigrationDirName($baseName); 
	$this->assertTrue(str_ends_with( $name, $expectedNameEndPart)); //  доделать
	// + проверить что первая часть строки является таймстэмпом 

    }
}