<?php
require_once( '../../src/classloader.php' );

$configfile = dirname(__FILE__) . '\test.xml';

$config = new CsvImporter_Config ($configfile);
// $config-> setDatabaseConnection ($server, $username, $password);
$databaseAdapter = new CsvImporter_Database_MySqli($config->getDatabaseServer(), $config->getDatabaseUsername(), $config->getDatabasePassword(), $config->getDatabase());
$importer = new CsvImporter( $config, $databaseAdapter, dirname(__FILE__), 'test.csv' );

if ($importer->import()) {
    echo 'Imported';
} else {
    echo 'notimported';
}
