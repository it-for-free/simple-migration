<?php
use Codeception\Util\Locator;
$initMigrationPage = $_SERVER['DOCUMENT_ROOT'].'/initMigrations.php';


$I = new AcceptanceTester($scenario);
$I->wantTo('Check what migration folder have created');

$I->amOnPage($initMigrationPage);

//проверка создана ли папка миграции
$I->seeElement('#migration-folder');

//проверка созданы ли файлы миграций
$I->wantTo('Check what migration UP file have created');
$I->seeElement('#migration-up');

$I->wantTo('Check what migration DOWN file have created');
$I->seeElement('#migration-down');

