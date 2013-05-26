<?php
require_once( '../../src/classloader.php' );

$configfile = dirname(__FILE__) . '/test.xml';

$config = new CsvImporter_Config ($configfile);
$databaseAdapter = new CsvImporter_Database_MySqli($config->getDatabaseServer(), $config->getDatabaseUsername(), $config->getDatabasePassword(), $config->getDatabase());
$importer = new CsvImporter( $config, $databaseAdapter, dirname(__FILE__), 'test.csv' );

if ($importer->import(false, true, dirname(__FILE__) . '/backups')) {
    echo 'Imported and CSV Backuped';
} else {
    echo 'Notimported';
}