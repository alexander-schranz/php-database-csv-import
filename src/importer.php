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
        
        $importData = $this->converter->convert();
        
        echo '<pre>';
        var_dump ($importData);
        exit();
        
        return false;
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