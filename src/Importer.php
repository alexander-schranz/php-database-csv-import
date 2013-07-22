<?php 

class CsvImporter {
    protected $converter;
    protected $config;
    protected $database;
    
    protected $path;
    protected $file;
    protected $csv;
    
    protected $importedData;
    
    function __construct(  $config, $database, $path, $file, $csv = '')
    {
        $this->config = $config;
        $this->database = $database;
        $this->path = $path;
        $this->file = $file;
        $this->csv = $csv;
    }
    
    public function import($deleteFile = false, $backupFile = false, $backupFolder = '') 
    {
        $this->converter = new CsvImporter_Converter( $this->path, $this->file, $this->config, $this->csv);
        
        $this->importedData = $this->converter->convert();
        
        $return = $this->getDatabase()->insert($this->config->getTable(), $this->importedData);
        
        if ($return) {
            // backUpFile
            $this->backupFile($backupFile, $backupFolder);
            // deleteFile
            $this->deleteFile($deleteFile);
        }
        
        return $return;
    }
    
    protected function backupFile ($backupFile, $backupFolder) {
        // backupFile
        if ($backupFile) {
            if ($backupFolder == '') {
                $backupFolder = dirname(__FILE__) . '/backups';
            }
            copy ($this->path . '/' . $this->file, $backupFolder . '/'. date('Ymd-His') . '.backup.csv');
        }
    }
    
    protected function deleteFile ($deleteFile) {
        if ($deleteFile) {
            unlink ($this->path . '/' . $this->file);
        }
    }
    
    protected function getDatabase()
    {
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