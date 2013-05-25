<?php 
/**
 * version 0.0.1a
 */

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/converter.php');
require_once(dirname(__FILE__) . '/database.php');

class CsvImporter {
    protected $converter;
    protected $config;
    protected $database = null;
    
    protected $path;
    protected $file;
    protected $csv;
    
    protected $importedData;
    
    function __construct( $path, $file, $config, $csv = '')
    {
        $this->path = $path;
        $this->file = $file;
        $this->config = $config;
        $this->csv = $csv;
    }
    
    public function import() 
    {
        $this->converter = new CsvImporter_Converter( $this->path, $this->file, $this->config, $this->csv = '');
        
        $this->importedData = $this->converter->convert();
        
        return $this->getDatabase()->insert($this->config->getTable(), $this->importedData);
    }
    
    protected function getDatabase()
    {
        if ( $this->database == null) {
            $this->database = new CsvImporter_Database($this->config->getDatabaseServer(), $this->config->getDatabaseUsername(), $this->config->getDatabasePassword(), $this->config->getDatabase());
        }
        return $this->database;
    }
    
    public function getImportedData()
    {
        return $this->importedData;
    }
    
    public function getConverter()
    {
        return $this->converter;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}