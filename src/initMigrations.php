<?php
//подключение классов
require_once ($_SERVER['DOCUMENT_ROOT'].'/DB.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/SimpleMigration.php');
$DB = new DB();

require_once ($_SERVER['DOCUMENT_ROOT'].'/db_config.php');

$pdoConnection = $DB->makeDatabaseConnection($authString, $login, $pass);
$MIGRATIONS = new SimpleMigration($pdoConnection, $migrationsBasePath);


$createMigrationTable = "CREATE TABLE iffmigrations (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(30) NOT NULL)";

$MIGRATIONS->init($createMigrationTable);


//СОЗДАНИЕ МИГРАЦИЙ

//папка миграций
$timestamp = time();
$migrationPath = $timestamp."_user_settings";
$migrationFullPath= $migrationsBasePath.$migrationPath;

//файлы миграций
$upFile = 'user_settings.up.sql';
$downFile = 'user_settings.down.sql';

//SQL миграции
$queryUp = "INSERT INTO Customers (CustomerName, ContactName, Address, City, PostalCode, Country)
            VALUES ('Cardinal', 'Tom B. Erichsen', 'Skagen 21', 'Stavanger', '4006', 'Norway');";

$queryDown = "DELETE FROM Customers WHERE CustomerName='Alfreds Futterkiste';";


if ($MIGRATIONS->validateMigrationPath($migrationPath)) {
    if (mkdir($migrationFullPath) ) {
        if ($MIGRATIONS->validateMigrationFile($upFile, 'up')) {
            $MIGRATIONS->makeMigrationFile($migrationFullPath, $upFile, $queryUp);
        }

        if ($MIGRATIONS->validateMigrationFile($downFile, 'down')) {
            $MIGRATIONS->makeMigrationFile($migrationFullPath, $downFile, $queryDown);
        }
    }
}
?>

<?php
//получение созданной директории миграции
$currentMigrationName = $MIGRATIONS->getPathName($migrationFullPath);
$currentMigrationFullPath = $migrationsBasePath.$currentMigrationName;

//получение созданных файлов миграции
$migrationFileUp = $MIGRATIONS->getFileMigrationName($currentMigrationFullPath, 'up');
$migrationFileDown = $MIGRATIONS->getFileMigrationName($currentMigrationFullPath, 'down');
?>


<?php if ($currentMigrationName): ?>
    <div id="migration-folder"><b><?=$currentMigrationName?></b> have successful created!</div>
<?php endif; ?>
<br>
<?php if ($migrationFileUp): ?>
    <div id="migration-up"><b><?=$migrationFileUp?></b> UP SQL file have successful created!</div>
<?php endif; ?>

<?php if ($migrationFileDown): ?>
    <div id="migration-down"><b><?=$migrationFileDown?></b> DOWN SQL file have successful created!</div>
<?php endif; ?>




