<?php
require_once( '../../src/classloader.php' );

$configfile = dirname(__FILE__) . '/test.xml';

$config = new CsvImporter_Config ($configfile);
$databaseAdapter = new CsvImporter_Database_MySqli($config->getDatabaseServer(), $config->getDatabaseUsername(), $config->getDatabasePassword(), $config->getDatabase());
$importer = new CsvImporter( $config, $databaseAdapter, dirname(__FILE__), 'test.csv' );

if ($importer->import(true, true, dirname(__FILE__) . '/backups')) {
    echo 'Imported, Backuped and Deleted';
} else {
    echo 'Notimported';
}

// Copy File Back from Backup To Run this Example Twice
if ($handle = opendir('backups')) {
    $backupFile = '';
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry, '.csv') !== false) {
            $backupFile = $entry;
        }
    }
    if ($backupFile != '') {
        copy('./backups/' . $backupFile, 'test.csv');
        echo '<br/>Copy File('.$backupFile.') From Backup';
    }
    closedir($handle);
}