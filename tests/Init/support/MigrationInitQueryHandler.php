<?php

use ItForFree\SimpleMigration\MigrationSQL;

class MigrationInitQueryHandler {
    protected $hasResult = false;
    
    
    protected function setResult(bool $result) 
    {
	$this->hasResult($result);
    }
    
    protected function getResult() 
    {
	$this->hasResult;
    }
    
    public function run($sql) {
	
	if ($sql === MigrationSQL::$checkMigrationTableExists) {
	    return 'your data here';
	} else if ($sql === MigrationSQL::$createMigratitionTable) {
	    $this->setResult(true);
	}
    }
}

