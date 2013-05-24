<?php 
/**
 * version 0.0.1a
 */

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/converter.php');

class CsvImporter {
    protected $converter;
    protected $config;
    
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
        
        // TODO insert Array into Table
        echo '<pre>';
        var_dump ($this->importedData);
        exit();
        
        return false;
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