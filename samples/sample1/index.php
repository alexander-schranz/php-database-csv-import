<?php
require_once( '../../src/Importer.php' );
require_once( '../../src/Config.php' );

$configfile = dirname(__FILE__) . '\test.xml';

$config = new CsvImporter_Config ($configfile);
// $config-> setDatabaseConnection ($server, $username, $password);
$importer = new CsvImporter(dirname(__FILE__), 'test.csv',  $config);

if ($importer->import()) {
    echo 'Imported';
} else {
    echo 'notimported';
}
